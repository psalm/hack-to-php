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

use HH\Lib\{C as C, Math as Math, Str as Str, Vec as Vec};
final class NewlineAtEndOfFileLinter extends BaseLinter implements AutoFixingLinter
{
    use AutoFixingLinterTrait;
    /**
     * @return \Sabre\Event\Promise<array<int, LintError>>
     */
    public function getLintErrorsAsync()
    {
        return \Sabre\Event\coroutine(
            /** @return \Generator<int, mixed, void, array<int, LintError>> */
            function () : \Generator {
                $contents = $this->getFile()->getContents();
                $fixed = $this->getFixedFile(array())->getContents();
                if ($contents === $fixed) {
                    return array();
                }
                $trimmed = Str\trim_right($contents);
                $trailing = Str\slice($contents, \strlen($trimmed));
                $blame = \implode('
', Vec\slice(\explode('
', $trimmed), Math\maxva(0, \count(\explode('
', $trimmed)) - 3))) . $trailing;
                $lines = \count(\explode('
', $contents));
                return array((new BuiltLintError($this, 'Files should end with a single trailing newline'))->withPosition($lines, 0)->withBlameCode($blame));
            }
        );
    }
    /**
     * @return string
     */
    protected function getTitleForFix(LintError $_)
    {
        $contents = $this->getFile()->getContents();
        if (Str\ends_with($contents, '
')) {
            return 'Remove extra trailing whitespace';
        }
        if (Str\trim_right($contents) === $contents) {
            return 'Add trailing newline';
        }
        return 'Replace trailng whitespace with newline';
    }
    /**
     * @param iterable<mixed, LintError> $_
     *
     * @return File
     */
    public function getFixedFile(iterable $_)
    {
        return $this->getFile()->withContents(Str\trim_right($this->getFile()->getContents()) . '
');
    }
}

