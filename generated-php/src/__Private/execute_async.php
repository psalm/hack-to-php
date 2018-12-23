<?php
namespace Facebook\HHAST\__Private;

use HH\Lib\{Str as Str, Vec as Vec};
// A wrapper around the built-in exec with a nicer signature.
// * returns a result rather than filling an out-parameter
// * throws on error
/**
 * @return \Sabre\Event\Promise<array<int, string>>
 */
function execute_async(string ...$args)
{
    return \Sabre\Event\coroutine(
        /** @return \Generator<int, mixed, void, array<int, string>> */
        function () use($args) : \Generator {
            $command = \implode(' ', \array_map(function ($arg) {
                return \escapeshellarg($arg);
            }, $args));
            $spec = array(0 => array('pipe', 'r'), 1 => array('pipe', 'w'), 2 => array('pipe', 'w'));
            $pipes = array();
            $proc = \proc_open($command, $spec, $pipes);
            list($stdin, $stdout, $stderr) = $pipes;
            \fclose($stdin);
            $exit_code = -2;
            $output = '';
            while (true) {
                $chunk = \stream_get_contents($stdout);
                $output .= $chunk;
                $status = \proc_get_status($proc);
                if ($status['pid'] && !$status['running']) {
                    $exit_code = $status['exitcode'];
                    break;
                }
                (yield \stream_await($stdout, \STREAM_AWAIT_READ | \STREAM_AWAIT_ERROR));
            }
            $output .= \stream_get_contents($stdout);
            \fclose($stdout);
            \fclose($stderr);
            \proc_close($proc);
            if ($exit_code !== 0) {
                throw new SubprocessException((array) $args, $exit_code);
            }
            return \explode('
', $output);
        }
    );
}
