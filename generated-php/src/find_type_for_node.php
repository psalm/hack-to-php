<?php
namespace Facebook\HHAST\__Private;

use Facebook\TypeAssert as TypeAssert;
use Facebook\HHAST as HHAST;
use Facebook\HHAST\EditableNode as EditableNode;

/**
 * @return \Sabre\Event\Promise<null|string>
 */
function find_type_for_node_async(EditableNode $root, EditableNode $node, string $path)
{
    return \Sabre\Event\coroutine(
        /** @return \Generator<int, mixed, void, null|string> */
        function () use($root, $node, $path) : \Generator {
            list($line, $offset) = HHAST\find_position($root, $node);
            $path = \realpath($path);
            $lines = (yield execute_async('hh_client', '--json', '--from', 'hhast', '--type-at-pos', $path . ':' . $line . ':' . ($offset + 1), \dirname($path)));
            $untyped_data = null;
            foreach ($lines as $maybe_json) {
                $untyped_data = \json_decode($maybe_json, true, 512);
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
