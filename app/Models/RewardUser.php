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
        'was_used'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'was_used' => 'boolean'
    ];

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
