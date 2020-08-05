<?php
namespace Xetaravel\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ServerStatus extends Pivot
{
    use ServerStatusPresenter;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}
