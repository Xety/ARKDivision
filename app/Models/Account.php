<?php
namespace Xetaravel\Models;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'discord_username',
        'discord_discriminator',
        'steam_username',
        'twitch_username'
    ];

    /**
     * Get the user that owns the account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
