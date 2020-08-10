<?php
namespace Xetaravel\Events\Servers;

use Xetaravel\Models\Server;

class ServerStatusHasFinishedEvent
{
    public $data;

    /**
     * Create a new event instance.
     *
     * @param array $data The data array that was build.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
