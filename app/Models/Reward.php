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
        'image',
        'gender',
        'gender_female',
        'gender_male',
        'type',
        'data',
        'rule'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array'
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
                'read_at',
                'was_used',
                'used_at'
            ])
            ->withTimestamps();
    }
}
