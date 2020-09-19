<?php
namespace Xetaravel\Models\Repositories;

use Xetaravel\Models\Server;

class ServerRepository
{

    /**
     * Update the server pivot table.
     *
     * @param array $data The data used to update the category.
     * @param \Xetaravel\Models\Server $Server The server that need to update their pivot table.
     *
     * @return bool
     */
    public static function updatePivot(array $data, Server $server) : bool
    {
        return $server->statutes()->wherePivot('id', $data['pivot_id'])->updateExistingPivot($data['status_id'], [
            'was_forced' => $data['was_forced'],
            'finished_at' => $data['finished_at']
        ]);
    }
}
