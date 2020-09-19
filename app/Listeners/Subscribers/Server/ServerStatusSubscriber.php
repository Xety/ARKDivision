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
        $discord = new DiscordClient(['token' => config('discord.bot.token')]);

        $fields = [];

        $statusCritical = 0;
        $statusWarning = 0;

        // Build the fields array.
        foreach ($event->data['servers'] as $server) {
            // Get the critical and warning status for each server to display the right alert.
            switch ($server['status']) {
                case 'stopped':
                    $statusCritical = $statusCritical + 1;
                    break;

                case 'starting':
                case 'initializing':
                case 'stopping':
                    $statusWarning = $statusWarning + 1;
                    break;
            }

            $serverStatus = Status::where('type', $server['status']) ->first();
            $status = $serverStatus->emoji . " " . $serverStatus->type_formatted;
            $players = $server['playersCount'] > 1 ?
            "**" . $server['playersCount'] . "** joueurs" :
            "**" . $server['playersCount'] . "** joueur";

            // Build the field for each server.
            array_push($fields, [
                'name' => sprintf("%s  **` %s `**", $server['emoji'], $server['name']),
                'value' => sprintf("** **\n**%s**\nJoueur(s) : %s \n**\n\n\n **", $status, $players),
                'inline' => true
            ]);
        }

        // Get the message related to status of all servers.
        $alert = "\n```yaml\n= 🟢 Tous nos serveurs sont actuellement en ligne !\n```";
        if ($statusWarning > 0) {
            $alert = "\n```fix\n 🟡 Des opérations sont actuellement en cours sur certains de nos serveurs.\n```";
        }
        if ($statusCritical > 0) {
            $alert = "\n```diff\n- 🔴 Certains de nos serveurs sont actuellement hors ligne, " .
            "l'équipe travaille dessus !\n```";
        }

        // Build the new message and edit it.
        $discord->channel->editMessage([
            'channel.id' => 739126558106845224,
            'message.id' => 739280060971876402,
            'content' => "** **",
            'embed' => [
                "title" => "***:small_blue_diamond:  ━━━  Statuts des serveurs ARK Division France  ━━━ ".
                " :small_blue_diamond:***",
                "description" => "**\n **<:division:693196707592274030> **` ARK Division `**\n :small_blue_diamond: **".
                $event->data['playersCount'] ."** joueurs connectés\n :small_blue_diamond: **" .
                $event->data['serversOnlineCount'] . "** serveurs en ligne **\n\n** $alert **\n **",
                "color" => hexdec("1DFCEA"),
                "footer" => [
                    "text" => "Dernière mise à jour • " . date('d-m-Y à H:i:s')
                ],
                "fields" => $fields
            ]
        ]);

        return true;
    }
}
