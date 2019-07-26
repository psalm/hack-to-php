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

use Facebook\HHAST\{ClassishDeclaration, Node, FinalToken, AbstractToken, ClassToken};
use Facebook\HHAST\Linters\{ASTLinter, ASTLintError};
/*
 * This linter ensures we always qualify classes as final or abstract
 */
/**
 * @template-extends ASTLinter<ClassishDeclaration>
 */
final class FinalOrAbstractClassLinter extends ASTLinter
{
    /**
     * @return class-string<ClassishDeclaration>
     */
    protected static function getTargetType()
    {
        return ClassishDeclaration::class;
    }
    /**
     * @param array<int, Node> $_parents
     *
     * @return ASTLintError<ClassishDeclaration>|null
     */
    public function getLintErrorForNode(ClassishDeclaration $node, array $_parents)
    {
        // ensure we are looking at a class declaration
        if (!$node->getKeyword() instanceof ClassToken) {
            return null;
        }
        // check if the ClassishDeclaration has modifiers
        $modifiers = $node->getModifiers();
        $found = false;
        if ($modifiers !== null) {
            foreach ($modifiers->traverse() as $mod) {
                if ($mod instanceof FinalToken || $mod instanceof AbstractToken) {
                    return null;
                }
            }
        }
        return new ASTLintError($this, 'Class should always be declared abstract or final', $node);
    }
}

