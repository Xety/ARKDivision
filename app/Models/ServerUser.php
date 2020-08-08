<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\Countable;

class ServerUser extends Model
{
    use Countable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'server_user';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'steam_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'steam_id',
        'server_id',
        'steam_name',
        'ingame_name',
        'tribe'
    ];

    /**
     * Return the count cache configuration.
     *
     * @return array
     */
    public function countCaches(): array
    {
        return [
            'user_count' => [Server::class, 'server_id', 'id']
        ];
    }

    /**
     * Get the user that owns the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the conversation that owns the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
