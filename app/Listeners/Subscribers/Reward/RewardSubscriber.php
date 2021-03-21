<?php
namespace Xetaravel\Listeners\Subscribers\Reward;

use Xetaravel\Events\Events\RewardNakor;
use Xetaravel\Models\Reward;
use Xetaravel\Models\User;
use Xetaravel\Notifications\RewardNotification;

class RewardSubscriber
{
    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected $events = [
        RewardNakor::class => 'onRewardNakor'
    ];

    /**
     * Register the listeners for the subscriber.
     *
     * @param Illuminate\Events\Dispatcher $events
     *
     * @return void
     */
    public function subscribe($events)
    {
        foreach ($this->events as $event => $action) {
            $events->listen($event, RewardSubscriber::class . '@' . $action);
        }
    }

/**
     * Listener related to the RewardNakor.
     *
     * @param \Xetaravel\Events\Events\RewardNakor $event The event that was fired.
     *
     * @return bool
     */
    public function onRewardNakor(RewardNakor $event): bool
    {
        $user = $event->user;
        $rewards = Reward::where('type', \Xetaravel\Events\Events\RewardNakor::class)->get();

        $collection = collect();

        // Duplicate reward item regarding to the rule set of each reward.
        $rewards->each(function ($item, $key) use ($collection) {
            $count = 0;

            while ($count < $item->rule) {
                $collection->push($item->id);
                $count++;
            }
        });

        // Attach all the rewards to the user.
        $user->rewards()->attach($collection);

        // Send a notification for each reward unlocked.
        $rewards->each(function ($reward) use ($user) {
            $user->notify(new RewardNotification($reward));
        });

        return true;
    }
}
