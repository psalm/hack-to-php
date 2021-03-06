<?php
/*
 *  Copyright (c) 2017-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace Facebook\HHAST\__Private\StrP;

use HH\Lib\Str;
function upper_camel(string $in) : string
{
    return \preg_replace_callback('/(^|_)([a-z])/', function ($matches) {
        return Str\uppercase($matches[2]);
    }, $in);
}
function underscored(string $in) : string
{
    return Str\strip_prefix(\preg_replace_callback('/[A-Z][a-z]+/', function ($matches) {
        return '_' . Str\lowercase($matches[0]);
    }, $in), '_');
}

