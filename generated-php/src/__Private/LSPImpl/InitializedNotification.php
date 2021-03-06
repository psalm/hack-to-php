<?php
/*
 *  Copyright (c) 2017-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */
namespace Facebook\HHAST\__Private\LSPImpl;

use Facebook\HHAST\__Private\LSPLib;
/**
 * @template-extends LSPLib\InitializedNotification<LSPLib\ServerState>
 */
final class InitializedNotification extends LSPLib\InitializedNotification
{
    /**
     * @var LSPLib\Client
     */
    private $client;
    public function __construct(LSPLib\Client $client, LSPLib\ServerState $state)
    {
        $this->client = $client;
        parent::__construct($state);
    }
    /**
     * @param mixed $p
     *
     * @return \Amp\Promise<void>
     */
    public function executeAsync($p)
    {
        return \Amp\call(
            /** @return \Generator<int, mixed, void, void> */
            function () use($p) : \Generator {
                $message = (new LSPLib\RegisterCapabilityCommand(__CLASS__, ['registrations' => [['id' => "relint on watched file change", 'method' => LSPLib\DidChangeWatchedFilesNotification::METHOD, 'registerOptions' => ['watchers' => [['globPattern' => '**/*.php'], ['globPattern' => '**/*.hck'], ['globPattern' => '**/*.hack'], ['globPattern' => '**/*.hh']]]]]]))->asMessage();
                (yield $this->client->sendRequestMessageAsync($message));
                (yield parent::executeAsync($p));
            }
        );
    }
}

