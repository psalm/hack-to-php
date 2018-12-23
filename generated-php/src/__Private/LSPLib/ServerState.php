<?php
namespace Facebook\HHAST\__Private\LSPLib;

use Facebook\HHAST\__Private\LSP as LSP;
use HH\Lib\C as C;
class ServerState
{
    /**
     * @var ServerStatus::PRE_INIT|ServerStatus::INITIALIZING|ServerStatus::INITIALIZED|ServerStatus::SHUTTING_DOWN|ServerStatus::EXITING
     */
    private $status = ServerStatus::PRE_INIT;
    /**
     * @var null|LSP\ClientCapabilities
     */
    private $clientCapabilities = null;
    /**
     * @return ServerStatus::PRE_INIT|ServerStatus::INITIALIZING|ServerStatus::INITIALIZED|ServerStatus::SHUTTING_DOWN|ServerStatus::EXITING
     */
    public final function getStatus()
    {
        return $this->status;
    }
    /**
     * @param ServerStatus::PRE_INIT|ServerStatus::INITIALIZING|ServerStatus::INITIALIZED|ServerStatus::SHUTTING_DOWN|ServerStatus::EXITING $new
     *
     * @return static
     */
    public final function setStatus($new)
    {
        $this->status = $new;
        return $this;
    }
    /**
     * @return static
     */
    public final function setClientCapabilities(LSP\ClientCapabilities $caps)
    {
        invariant($this->clientCapabilities === null, 'Shouldn\'t set client capabilities more than once');
        $this->clientCapabilities = $caps;
        return $this;
    }
    /**
     * @return null|LSP\ClientCapabilities
     */
    public final function getClientCapabilities()
    {
        return $this->clientCapabilities;
    }
    /**
     * @return \Sabre\Event\Promise<void>
     */
    public final function waitForInitAsync()
    {
        return \Sabre\Event\coroutine(
            /** @return \Generator<int, mixed, void, void> */
            function () : \Generator {
                $pre_init = array(ServerStatus::PRE_INIT => ServerStatus::PRE_INIT, ServerStatus::INITIALIZING => ServerStatus::INITIALIZING);
                while (C\contains_key($pre_init, $this->getStatus())) {
                    (yield \HH\Asio\usleep(100 * 1000));
                }
            }
        );
    }
}
