<?php
namespace Xetaravel\Listeners\Subscribers\Server;

use RestCord\DiscordClient;
use Xetaravel\Events\Servers\ServerStatusHasFinishedEvent;
use Xetaravel\Models\Server;
use Xetaravel\Models\Status;

class ServerStatusSubscriber
{
    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected $events = [
        ServerStatusHasFinishedEvent::class => 'serverStatusHasFinished',
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
            $events->listen($event, ServerStatusSubscriber::class . '@' . $action);
        }
    }

    /**
     * Handle a ServerStatusHasFinished event.
     *
     * @param \Xetaravel\Events\Server\ServerStatusHasFinishedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function serverStatusHasFinished(ServerStatusHasFinishedEvent $event)
    {
        $discord = new DiscordClient(['token' => config('xetaravel.bot.token')]);

        $fields = [];

        // Build the fields array.
        foreach ($event->data['servers'] as $server) {
            $serverStatus = Status::where('type', $server['status']) ->first();
            $status = $serverStatus->emoji . " " . $serverStatus->type_formatted;
            $players = $server['playersCount'] > 1 ?
            "**" . $server['playersCount'] . "** joueurs" :
            "**" . $server['playersCount'] . "** joueur";

            array_push($fields, [
                'name' => sprintf("%s  **` %s `**", $server['emoji'], $server['name']),
                'value' => sprintf("** **\n**%s**\nJoueur(s) : %s \n**\n\n\n **", $status, $players),
                'inline' => true
            ]);
        }

        $discord->channel->editMessage([
            'channel.id' => 739126558106845224,
            'message.id' => 739280060971876402,
            'content'    => "** **",
            'embed'      => [
                "title" => "***:small_blue_diamond:  ━━━  Statuts des serveurs ARK Division France  ━━━ ".
                " :small_blue_diamond:***",
                "description" => "**\n **<:division:693196707592274030> **` ARK Division `**\n :small_blue_diamond: **".
                $event->data['playersCount'] ."** joueurs connectés\n :small_blue_diamond: **" .
                $event->data['serversCount'] . "** serveurs en ligne **\n\n\n **",
                "color" => hexdec("1DFCEA"),
                "footer" => [
                    "text" => "Dernière mise à jour • " . date('d-m-Y à H:i:s') . " (v2)"
                ],
                "fields" => $fields
            ]
        ]);
        //$event->servers
    }

    /**
     * Create the ruby.
     *
     * @param array $data The data used to create the ruby.
     *
     * @return bool
     */
    protected function create(array $data) : bool
    {
        if (!isset($data['data'])) {
            $data['data'] = [];
        }
        $ruby = Ruby::create($data);

        switch ($ruby->event_type) {
            case PostWasSolvedEvent::class:
                    $ruby->user->increment('rubies_total', $this->rubies[PostWasSolvedEvent::class]);
                break;
        }

        return !(is_null($ruby));
    }
}
