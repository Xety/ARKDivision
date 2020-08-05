<?php
namespace Xetaravel\Models\Presenters;

use Carbon\Carbon;

trait ServerStatusPresenter
{

    /**
     * Get whatever the statut is expired or not.
     *
     * @return boolean
     */
    public function getIsExpired(): bool
    {
        if ($this->event_type != 'discord') {
            return false;
        }

        if (is_null($this->finished_at)) {
            return false;
        }

        if ($this->created_at > Carbon::now()->subMinutes(20)) {
            return false;
        }

        return true;
    }
}
