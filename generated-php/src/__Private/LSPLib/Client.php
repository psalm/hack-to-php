<?php
/*
 *  Copyright (c) 2017-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace Facebook\HHAST\__Private\LSPLib;

use Facebook\HHAST\__Private\LSP;
abstract class Client
{
    /**
     * @return \Amp\Promise<void>
     */
    protected abstract function sendMessageAsync(LSP\Message $message);
    /**
     * @return \Amp\Promise<void>
     */
    public final function sendRequestMessageAsync(LSP\RequestMessage $message)
    {
        return \Amp\call(
            /** @return \Generator<int, mixed, void, void> */
            function () use($message) : \Generator {
                (yield $this->sendMessageAsync($message));
            }
        );
    }
    /**
     * @return \Amp\Promise<void>
     */
    public final function sendResponseMessageAsync(LSP\ResponseMessage $message)
    {
        return \Amp\call(
            /** @return \Generator<int, mixed, void, void> */
            function () use($message) : \Generator {
                (yield $this->sendMessageAsync($message));
            }
        );
    }
    /**
     * @return \Amp\Promise<void>
     */
    public final function sendNotificationMessageAsync(LSP\NotificationMessage $message)
    {
        return \Amp\call(
            /** @return \Generator<int, mixed, void, void> */
            function () use($message) : \Generator {
                (yield $this->sendMessageAsync($message));
            }
        );
    }
}

