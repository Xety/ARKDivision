<?php
namespace Xetaravel\Console\Commands;

use Illuminate\Console\Command;
use RestCord\DiscordClient;
use Xetaravel\Models\Server;

class RefreshServersPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'players:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the players of servers for Discord.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $servers = Server::withoutGlobalScopes()->get();

        if (!$servers) {
            return;
        }
        $discord = new DiscordClient(['token' => config('discord.bot.token')]);

        $playersTotal = 0;

        foreach ($servers as $server) {
            $text = "";

            // Check if there're players on this server.
            if ($server->user_count > 0) {
                foreach ($server->players as $player) {
                    $text .= "> :small_blue_diamond:   `" . $player['steam_id'] . "` | " .
                    $player['steam_name'] . " | **" . $player['ingame_name'] . "** | **" . $player['tribe'] . "** \n";
                }
            } else {
                $text .= "> :small_orange_diamond: Aucun joueur connecté sur ce serveur.";
            }

            // Sometimes Discord send back a 400 Bad Request, so to avoid that, just do a try.
            try {
                $discord->channel->editMessage([
                    'channel.id' => 742877577575923762,
                    'message.id' => $server->discord_message_id,
                    'content' => "** **",
                    'embed' => [
                        'title' => sprintf('**:arrow_right: %s**', $server->name),
                        'description' => $text,
                        'color' => hexdec($server->color),
                        'footer' => [
                            'text' => $server->user_count . ' joueur(s) connecté(s)'
                        ]
                    ]
                ]);
            } catch (\GuzzleHttp\Exception\ClientException $th) {
                continue;
            }


            $playersTotal = $playersTotal + $server->user_count;

            sleep(3);
        }

        $discord->channel->editMessage([
            'channel.id' => 742877577575923762,
            'message.id' => 769136048700784650,
            'content' => "** **",
            'embed' => [
                'description' => '**' . $playersTotal . '** joueur(s) connecté(s) au total.',
                'color' => hexdec("1DFCEA")
            ]
        ]);
    }
}
