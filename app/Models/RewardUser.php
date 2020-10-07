<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RewardUser extends Pivot
{
    use Countable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'read_at',
        'was_used',
        'used_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'was_used' => 'boolean',
        'read_at' => 'datetime',
        'used_at' => 'datetime'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    /*protected $dates = [
        'read_at'
    ];*/

    /**
     * Return the count cache configuration.
     *
     * @return array
     */
    public function countCaches(): array
    {
        return [
            'reward_count' => [User::class, 'user_id', 'id']
        ];
    }
}
