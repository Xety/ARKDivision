<?php
namespace Xetaravel\Listeners\Subscribers\RCON;

use Carbon\Carbon;
use Xetaravel\Events\RCON\ServerChatToPlayerEvent;
use Xetaravel\Models\ServerUser;
use Xetaravel\Models\UserLog;

class RCONSubscriber
{
    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected $events = [
        ServerChatToPlayerEvent::class => 'serverChatToPlayer',
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
            $events->listen($event, RCONSubscriber::class . '@' . $action);
        }
    }

    /**
     * Handle a ServerChatToPlayer event.
     *
     * @param \Xetaravel\Events\RCON\ServerChatToPlayerEvent $event The event that was fired.
     *
     * @return bool
     */
    public function serverChatToPlayer(ServerChatToPlayerEvent $event)
    {
        // Verify that this player has not already a valid log to avoid spamming.
        $log = UserLog::where('steam_id', $event->player['steam_id'])
            ->where('event_type', ServerChatToPlayerEvent::class)
            ->where('created_at', '>', Carbon::now()->subHour())
            ->first();

        if ($log) {
            return true;
        }

        $steamId = $event->player['steam_id'];

        // Check if there is an user with this steam_id to determinate the loggable_type.
        $user = ServerUser::where('steam_id', $steamId)->first();

        if (!$user) {
            return false;
        }

        $name = $user->steam_name;

        $data = [
            'steam_id' => $steamId,
            'loggable_id' => $steamId,
            'loggable_type' => \Xetaravel\Models\ServerUser::class,
            'event_type' => ServerChatToPlayerEvent::class,
            'data' => [
                'server_id' =>  $event->server->id,
                'command' => "ServerChatToPlayer \"$name\" \"Merci de creer une tribu en pressant L. Obligatoire.\""
            ]
        ];

        return $this->create($data);
    }

    /**
     * Create the log.
     *
     * @param array $data The data used to create the log.
     *
     * @return bool
     */
    protected function create(array $data): bool
    {
        if (!isset($data['data'])) {
            $data['data'] = [];
        }
        $log = UserLog::create($data);

        return !(is_null($log));
    }
}
