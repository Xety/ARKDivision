<?php
namespace Xetaravel\Listeners\Subscribers\Donation;

use Illuminate\Support\Facades\DB;
use Xetaravel\Events\Donation\DonationEvent;

class ArkShopSubscriber
{
    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected $events = [
        DonationEvent::class => 'onDonation'
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
            $events->listen($event, ArkShopSubscriber::class . '@' . $action);
        }
    }

    /**
     * Listener related to the donation.
     *
     * @param \Xetaravel\Events\Donation\DonationEvent $event The event that was fired.
     *
     * @return bool
     */
    public function onDonation(DonationEvent $event): bool
    {
        $user = $event->user;

        $player = DB::connection('arkshop')->table("players")->where('SteamId', $user->steam_id)->first();

        if ($player == null) {
            return true;
        }

        // If the user is not already part of the "Membres," group.
        if (strpos($player->PermissionGroups, 'Membres,') === false) {
            // Add the group "Membres," to the groups.
            $permissionGroups = $player->PermissionGroups. "Membres,";

            DB::connection('arkshop')->update(
                'UPDATE players SET PermissionGroups = ? WHERE SteamId = ?',
                [$permissionGroups, $user->steam_id]
            );
        }

        return true;
    }
}
