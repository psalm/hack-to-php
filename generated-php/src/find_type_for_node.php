<?php
/*
 *  Copyright (c) 2017-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace Facebook\HHAST\__Private;

use Facebook\TypeAssert;
use Facebook\HHAST;
use Facebook\HHAST\Node;

/**
 * @return \Amp\Promise<null|string>
 */
function find_type_for_node_async(Node $root, Node $node, string $path) : \Amp\Promise
{
    return \Amp\call(
        /** @return \Generator<int, mixed, void, null|string> */
        function () use($root, $node, $path) : \Generator {
            list($line, $offset) = HHAST\find_position($root, $node);
            $path = \realpath($path);
            $lines = (yield execute_async('hh_client', '--json', '--from', 'hhast', '--type-at-pos', $path . ':' . $line . ':' . ($offset + 1), \dirname($path)));
            $untyped_data = null;
            foreach ($lines as $maybe_json) {
                $untyped_data = \json_decode(
                    $maybe_json,
                    /* assoc = */
                    true,
                    /* depth = */
                    512
                );
                if ($untyped_data !== null) {
                    break;
                }
            }
            $data = TypeAssert\matches_type_structure(type_alias_structure(TTypeAtPosOutput::class), $untyped_data);
            if (($data['full_type']['kind'] ?? null) === 'primitive') {
                return $data['full_type']['name'] ?? null;
            }
            return $data['full_type']['kind'] ?? null;
        }
    );
}

