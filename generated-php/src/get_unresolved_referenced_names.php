<?php
/*
 *  Copyright (c) 2017-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace Facebook\HHAST;

use HH\Lib\C as C;
/** Given a tree, provide a list of names that are referenced by the code.
 *
 * These are not resolved to fully-qualified names; for example, `use`
 * and `namespace` statements to not affect the return value.
 */
/**
 * @return array{namespaces:array<string, string>, types:array<string, string>, functions:array<string, string>}
 */
function get_unresolved_referenced_names(EditableNode $root)
{
    $ret = array('namespaces' => array(), 'types' => array(), 'functions' => array());
    foreach ($root->traverse() as $node) {
        if ($node instanceof QualifiedName) {
            $name = C\firstx($node->getParts()->getItems());
            if ($name instanceof NameToken) {
                $ret['namespaces'][] = $name->getText();
            }
            continue;
        }
        if ($node instanceof SimpleTypeSpecifier) {
            $name = $node->getSpecifierx();
            if ($name instanceof NameToken) {
                $ret['types'][] = $name->getText();
            }
            continue;
        }
        if ($node instanceof GenericTypeSpecifier) {
            $name = $node->getClassType();
            if ($name instanceof NameToken) {
                $ret['types'][] = $name->getText();
            }
        }
        if ($node instanceof ScopeResolutionExpression) {
            $name = $node->getQualifier();
            if ($name instanceof NameToken) {
                $ret['types'][] = $name->getText();
            }
            continue;
        }
        if ($node instanceof InstanceofExpression) {
            $name = $node->getRightOperand();
            if ($name instanceof NameToken) {
                $ret['types'][] = $name->getText();
            }
            continue;
        }
        if ($node instanceof FunctionCallExpression) {
            $name = $node->getReceiver();
            if ($name instanceof NameToken) {
                $ret['functions'][] = $name->getText();
            }
            continue;
        }
        if ($node instanceof ConstructorCall) {
            $name = $node->getType() instanceof \Facebook\HHAST\NameToken ? $node->getType() : null;
            if ($name !== null) {
                $ret['types'][] = $name->getText();
            }
        }
    }
    return $ret;
}

