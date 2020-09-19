<?php
namespace Xetaravel\Models;

class Reward extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'data',
        'rule'
    ];

    /**
     * Get the users that owns the badge.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTomany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(RewardUser::class)
            ->withPivot([
                'id',
                'was_used'
            ])
            ->withTimestamps();
    }
}
