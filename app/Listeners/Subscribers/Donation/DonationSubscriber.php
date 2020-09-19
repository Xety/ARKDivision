<?php
namespace Xetaravel\Listeners\Subscribers\Donation;

use Illuminate\Support\Facades\Log;
use Xetaravel\Events\Donation\NewDonationEvent;
use Xetaravel\Models\Reward;
use Xetaravel\Models\User;

class DonationSubscriber
{
    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected $events = [
        NewDonationEvent::class => 'onNewDonation'
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
            $events->listen($event, DonationSubscriber::class . '@' . $action);
        }
    }

/**
     * Listener related to the donation.
     *
     * @param \Xetaravel\Events\Donation\NewDonationEvent $event The event that was fired.
     *
     * @return bool
     */
    public function onNewDonation(NewDonationEvent $event): bool
    {
        $user = $event->user;
        $rewardCount = $event->rewards;
        $rewards = Reward::where('type', \Xetaravel\Events\Donation\NewDonationEvent::class)->get();

        $collection = collect();

        // Duplicate reward item regarding to the rule set of each reward.
        $rewards->each(function ($item, $key) use ($collection) {
            $count = 0;

            while ($count < $item->rule) {
                $collection->push($item->id);
                $count++;
            }
        });

        // If the reward count is 1 just attach only one time and return.
        if ($rewardCount == 1) {
            $user->rewards()->attach($collection);

            return true;
        }

        // If the reward count is more than 1, (donation 40€ or more), we need to duplicate the entry.
        for ($i=0; $i < $rewardCount; $i++) {
            $user->rewards()->attach($collection);
        }

        return true;
    }
}
