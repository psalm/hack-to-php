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

use Facebook\HHAST\{CompoundStatement, Node, FunctionDeclaration, IFunctionishDeclaration, MethodishDeclaration, ParameterDeclaration, SemicolonToken, VariableToken};
use HH\Lib\{C, Str};
/**
 * @template-extends AutoFixingASTLinter<ParameterDeclaration>
 */
final class UnusedParameterLinter extends AutoFixingASTLinter
{
    /**
     * @return class-string<ParameterDeclaration>
     */
    protected static function getTargetType()
    {
        return ParameterDeclaration::class;
    }
    /**
     * @param array<int, Node> $parents
     *
     * @return ASTLintError<ParameterDeclaration>|null
     */
    public function getLintErrorForNode(ParameterDeclaration $node, array $parents)
    {
        if ($node->getVisibility() !== null) {
            // Constructor parameter promotion
            return null;
        }
        $name = $node->getName();
        if (!$name instanceof VariableToken) {
            return null;
        }
        if (Str\starts_with($name->getText(), '$_')) {
            return null;
        }
        $functionish = C\find($parents, function ($p) {
            return $p instanceof IFunctionishDeclaration;
        });
        if ($functionish instanceof FunctionDeclaration) {
            $body = $functionish->getBody();
        } else {
            if ($functionish instanceof MethodishDeclaration) {
                $body = $functionish->getFunctionBody();
            } else {
                invariant_violation("Couldn't find functionish for parameter declaration");
            }
        }
        if ($body === null || $body instanceof SemicolonToken) {
            // Don't require `$_` for abstract or interface methods
            return null;
        }
        $statements = ($body instanceof CompoundStatement ? $body : (function () {
            throw new \TypeError('Failed assertion');
        })())->getStatements();
        if ($statements !== null) {
            $match = C\find($statements->getDescendantsOfType(VariableToken::class), function ($x) use($name) {
                return $x->getText() === $name->getText();
            });
            if ($match !== null) {
                return null;
            }
        }
        return new ASTLintError($this, "Parameter is unused", $node);
    }
    /**
     * @return ParameterDeclaration
     */
    public function getFixedNode(ParameterDeclaration $node)
    {
        $name = $node->getName();
        if (!$name instanceof VariableToken) {
            return $node;
        }
        return $node->withName($name->withText('$_' . Str\strip_prefix($name->getText(), '$')));
    }
    /**
     * @param ASTLintError<ParameterDeclaration> $err
     *
     * @return string
     */
    public function getTitleForFix(ASTLintError $err)
    {
        $name = $err->getBlameNode()->getName();
        invariant($name instanceof VariableToken, 'unhandled type');
        $new_name = '$_' . Str\strip_prefix($name->getText(), '$');
        return Str\format('Rename to `%s`', $new_name);
    }
}

