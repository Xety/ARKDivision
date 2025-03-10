<?php
namespace Xetaravel\Listeners\Subscribers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Xetaravel\Events\Badges\RegisterEvent;
use Xetaravel\Events\Donation\DonationEvent;
use Xetaravel\Events\Events\EvenementEvent;
use Xetaravel\Models\Badge;
use Xetaravel\Models\User;
use Xetaravel\Notifications\BadgeNotification;

class BadgeSubscriber
{
    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected $events = [
        RegisterEvent::class => 'onNewRegister',
        DonationEvent::class => 'onNewDonation',
        EvenementEvent::class => 'onEvenement'
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
            $events->listen($event, BadgeSubscriber::class . '@' . $action);
        }
    }

    /**
     * Listener related to all evenements badge.
     *
     * @param \Xetaravel\Events\Events\NakorEvent $event The event that was fired.
     *
     * @return bool
     */
    public function onEvenement(EvenementEvent $event): bool
    {
        $user = $event->user;
        $badges = Badge::where('slug', $event->slug)->get();

        $result = $user->badges()->syncWithoutDetaching($badges);

        return $this->sendNotifications($result, $badges, $user);
    }

    /**
     * Listener related to the register badge.
     *
     * @param \Xetaravel\Events\Badges\RegisterEvent $event The event that was fired.
     *
     * @return bool
     */
    public function onNewRegister(RegisterEvent $event): bool
    {
        $user = $event->user;
        $badges = Badge::where('type', 'onNewRegister')->get();

        $today = new Carbon();
        $diff = $today->diff($user->created_at)->y;

        $collection = $badges->filter(function ($badge) use ($diff) {
            return $badge->rule <= $diff;
        });

        $result = $user->badges()->syncWithoutDetaching($collection);

        return $this->sendNotifications($result, $badges, $user);
    }

    /**
     * Listener related to the donation badge.
     *
     * @param \Xetaravel\Events\Donation\DonationEvent $event The event that was fired.
     *
     * @return bool
     */
    public function onNewDonation(DonationEvent $event): bool
    {
        $user = $event->user;
        $badges = Badge::where('type', 'onNewDonation')->get();

        $collection = $badges->filter(function ($badge) use ($user) {
            return $badge->rule <= $user->transaction_count;
        });

        $result = $user->badges()->syncWithoutDetaching($collection);

        return $this->sendNotifications($result, $badges, $user);
    }

    /**
     * Send a notification for each new badge unlocked.
     *
     * @param array $result The result of the synchronization.
     * @param \Illuminate\Database\Eloquent\Collection $badges The badges collection related to the listener.
     * @param \Xetaravel\Models\User $user The user to notify.
     *
     * @return bool
     */
    protected function sendNotifications(array $result, Collection $badges, User $user): bool
    {
        if (empty($result['attached'])) {
            return true;
        }

        $sendNotification = function ($badgeId, $key, $badges) use ($user) {
            $badgeCollection = $badges->filter(function ($badge) use ($badgeId) {
                return $badge->id == $badgeId;
            })->first();

            $user->notify(new BadgeNotification($badgeCollection));
        };

        return array_walk($result['attached'], $sendNotification, $badges);
    }
}
