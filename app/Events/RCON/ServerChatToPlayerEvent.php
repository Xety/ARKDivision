<?php
namespace Xetaravel\Events\RCON;

use Xetaravel\Models\Server;

class ServerChatToPlayerEvent
{
    /**
     *  The player that has no tribe.
     *
     * @var string
     */
    public $player;

    /**
     *  The server where will be executed the command.
     *
     * @var \Xetaravel\Models\Server
     */
    public $server;

    /**
     * Create a new event instance.
     *
     * @param \Xetaravel\Models\Server $server The server where will be executed the command.
     * @param array $array The player that has no tribe.
     */
    public function __construct(Server $server, array $player)
    {
        $this->server = $server;
        $this->player = $player;
    }
}
