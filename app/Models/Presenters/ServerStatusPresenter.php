<?php
namespace Xetaravel\Models\Presenters;

use Carbon\Carbon;

trait ServerStatusPresenter
{

    /**
     * Get whatever the status is expired or not.
     *
     * @return boolean
     */
    public function getIsExpiredAttribute(): bool
    {
        // Only 'discord' type can be expirable.
        if ($this->event_type == 'cron') {
            return true;
        }

        // Check if the 'created_date' is at least 20 minutes old.
        if ($this->created_at > Carbon::now()->subMinutes(20)) {
            return false;
        }

        return true;
    }
}
