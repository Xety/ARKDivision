<?php
namespace Xetaravel\Models;

class Arkshopplayer extends Model
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'arkshop';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'SteamId',
        'Points',
        'TotalSpent'
    ];

    /**
     * Get the user that owns the account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*public function user()
    {
        return $this->belongsTo(User::class);
    }*/
}
