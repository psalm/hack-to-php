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

use Facebook\HHAST\{EditableList, EditableNode, EndOfLine, MarkupSuffix, SingleLineComment, WhiteSpace};
class StrictModeOnlyLinter extends AutoFixingASTLinter
{
    /**
     * @return MarkupSuffix::class
     */
    protected static function getTargetType()
    {
        return MarkupSuffix::class;
    }
    /**
     * @param array<int, EditableNode> $_1
     *
     * @return ASTLintError<MarkupSuffix>|null
     */
    public function getLintErrorForNode(MarkupSuffix $node, array $_1)
    {
        $name = $node->getName();
        if ($name === null) {
            // '<?'
            return null;
        }
        if ($name->getText() !== 'hh') {
            return null;
        }
        if ($name->getTrailing()->getCode() === " // strict\n") {
            return null;
        }
        return new ASTLintError($this, 'Use `<?hh // strict`', $node);
    }
    /**
     * @return string
     */
    protected function getTitleForFix(LintError $_0)
    {
        return 'Use `<?hh // strict`';
    }
    /**
     * @return MarkupSuffix
     */
    public function getFixedNode(MarkupSuffix $node)
    {
        $name = $node->getName();
        invariant($name !== null, "Shouldn't be asked to fix a `<?hh`'");
        return $node->withName($name->withTrailing(EditableList::createNonEmptyListOrMissing([new WhiteSpace(' '), new SingleLineComment('// strict'), new EndOfLine("\n")])));
    }
}

