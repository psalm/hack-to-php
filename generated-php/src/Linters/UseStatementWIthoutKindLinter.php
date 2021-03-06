<?php
/*
 *  Copyright (c) 2017-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace Facebook\HHAST\Linters;

use Facebook\HHAST\{Node, INamespaceUseDeclaration, NamespaceToken, NameToken, TypeToken, QualifiedName};
use Facebook\HHAST;
use HH\Lib\{C, Keyset};
/**
 * @template-extends AutoFixingASTLinter<INamespaceUseDeclaration>
 */
final class UseStatementWithoutKindLinter extends AutoFixingASTLinter
{
    /**
     * @return class-string<INamespaceUseDeclaration>
     */
    protected static function getTargetType()
    {
        return INamespaceUseDeclaration::class;
    }
    /**
     * @param array<int, Node> $_context
     *
     * @return ASTLintError<INamespaceUseDeclaration>|null
     */
    public function getLintErrorForNode(INamespaceUseDeclaration $node, array $_context)
    {
        if ($node->hasKind()) {
            return null;
        }
        return new ASTLintError($this, "Use `use type` or `use namespace`", $node);
    }
    /**
     * @param ASTLintError<INamespaceUseDeclaration> $e
     *
     * @return string
     */
    protected function getTitleForFix(ASTLintError $e)
    {
        $fixed = $this->getFixedNode($e->getBlameNode());
        invariant($fixed !== null, "Shouldn't be asked to provide a fix title when there is no fix");
        return 'Switch to `use ' . $fixed->getKindx()->getText() . '`';
    }
    /**
     * @return null|INamespaceUseDeclaration
     */
    public function getFixedNode(INamespaceUseDeclaration $node)
    {
        // Figure out what names are imported
        $names = Keyset\map($node->getClauses()->getItems(), function ($clause) use($name) {
            if ($clause->hasAs()) {
                return $clause->getAsx()->getText();
            }
            $name = $clause->getName();
            if ($name instanceof QualifiedName) {
                return C\lastx($name->getParts()->getItemsOfType(NameToken::class))->getText();
            }
            invariant($name instanceof NameToken, "Expected a Qualified or NameToken, got %s", \get_class($name));
            return $name->getText();
        });
        // We need to look at the full file to figure out if this should be a
        // `use type`, or `use namespace`
        $used = $this->getUnresolvedReferencedNames();
        $used_as_ns = C\any($names, function ($name) use($used) {
            return C\contains($used['namespaces'], $name);
        });
        $used_as_type = C\any($names, function ($name) use($used) {
            return C\contains($used['types'], $name);
        });
        $leading = $node->getClauses()->getFirstTokenx()->getLeadingWhitespace();
        $trailing = $node->getKeywordx()->getTrailingWhitespace();
        if ($used_as_type && !$used_as_ns) {
            return $node->withKind(new TypeToken($leading, $trailing));
        }
        if ($used_as_ns && !$used_as_type) {
            return $node->withKind(new NamespaceToken($leading, $trailing));
        }
        // Unused, or ambiguous
        return null;
    }
    /**
     * @return array{namespaces:array<string, string>, types:array<string, string>, functions:array<string, string>}
     */
    private function getUnresolvedReferencedNames()
    {
        return HHAST\get_unresolved_referenced_names($this->getAST());
    }
}

