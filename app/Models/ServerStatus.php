<?php
namespace Xetaravel\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Xetaravel\Models\Presenters\ServerStatusPresenter;

class ServerStatus extends Pivot
{
    use ServerStatusPresenter;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'was_forced',
        'finished_at'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_expired'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'was_forced' => 'boolean'
    ];
}
