<?php
namespace Xetaravel\Models;

class Status extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'statutes';

    /**
     * The statutes that belong to the server.
     */
    public function servers()
    {
        return $this->belongsToMany(Server::class)->using(ServerStatus::class)->withPivot([
            'id',
            'event_type',
            'was_forced',
            'finished_at'
        ])->withTimestamps();
    }
}
