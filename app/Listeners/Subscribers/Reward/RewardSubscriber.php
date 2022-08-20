<?php
namespace Xetaravel\Listeners\Subscribers\Reward;

use Illuminate\Support\Facades\DB;
use Xetaravel\Events\Events\RewardLabyrintheTatie;
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
        RewardNakor::class => 'onRewardNakor',
        RewardLabyrintheTatie::class => 'onRewardLabyrintheTatie'
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

    /**
     * Listener related to the RewardNakor.
     *
     * @param \Xetaravel\Events\Events\RewardLabyrintheTatie $event The event that was fired.
     *
     * @return bool
     */
    public function onRewardLabyrintheTatie(RewardLabyrintheTatie $event): bool
    {
        $user = $event->user;
        $rewards = Reward::where('type', \Xetaravel\Events\Events\RewardLabyrintheTatie::class)->get();

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

        // Add the Group to the user in ArkSHop database.
        $player = DB::connection('arkshop')->table("players")->where('SteamId', $user->steam_id)->first();

        if ($player == null) {
            return true;
        }

        // If the user is not already part of the "RewardLabyrintheTatie," group.
        if (strpos($player->PermissionGroups, 'RewardLabyrintheTatie,') === false) {
            // Add the group "RewardLabyrintheTatie," to the groups.
            $permissionGroups = $player->PermissionGroups . "RewardLabyrintheTatie,";

            DB::connection('arkshop')->update(
                'UPDATE players SET PermissionGroups = ? WHERE SteamId = ?',
                [$permissionGroups, $user->steam_id]
            );
        }

        return true;
    }
}
