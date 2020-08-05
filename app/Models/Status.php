<?php
namespace Xetaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    /**
     * The statutes that belong to the server.
     */
    public function servers()
    {
        return $this->belongsToMany(Server::class)->using(ServerStatus::class)->withTimestamps();
    }
}
