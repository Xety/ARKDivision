<?php
namespace Xetaravel\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use RestCord\DiscordClient;
use Xetaravel\Http\Helpers\Rcon;
use Xetaravel\Models\Server;

class EventsBoss extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:boss {boss=DodoRex}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launching community Boss events.';

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
        $server = Server::where('slug', 'zevent')->first();

        if (!$server) {
            return;
        }
        $discord = new DiscordClient(['token' => config('discord.bot.token')]);

        $rcon = new Rcon($server->ip, $server->rcon_port, $server->password, 3);

        if (!$rcon->connect()) {
            return;
        }

        // Start the Event.
        $rcon->sendCommand('serverevents.start ' . $this->argument('boss') .
        ' -73226 -4141 -11757 -95.38 -19.87');
        $rcon->disconnect();

        // Prepare Discord Starting message.
        $date = Carbon::now()->modify('+1 hour');
        $body = "L'Event `{$this->argument('boss')}` vient d'être lancé sur la map Event ! \n\n**L'Event demarrera" .
        " le `{$date->format('d-m-Y à H:i:s')}`**.\n\n **Plus d'infos dans le channel <#1003670007399592067> sur" .
        " les loots, la difficulté... du Boss.** \n\n *Soyez prêt avec vos Dinos dans l'Arène avant le spawn du Boss" .
        " pour avoir vos récompenses !*";

        try {
            $discord->channel->createMessage([
                'channel.id' => config('discord.channels.events-notifs'),
                'content' => "** **",
                'embed' => [
                    'description' =>  $body,
                    'color' => hexdec("1DFCEA"),
                    'thumbnail' => [
                        'url' => 'https://cdn.discordapp.com/app-icons/635391187301433380/'.
                        '1816aec0f6a4418f7ed19773e97dfb98.png'
                    ],
                    'author' => [
                        'name' => 'Events Boss',
                        'icon_url' => 'https://cdn.discordapp.com/attachments/631999661112033280/1003658653699686441/'
                        . 'Dodorex.webp'
                    ]
                ]
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $th) {
        }

        // Cooldown before Cancel Event (1 hour before and 1 hour after Event = 7200)
        sleep(7200);

        if (!$rcon->connect()) {
            return;
        }

        // Send The Cancel command.
        $rcon->sendCommand('serverevents.cancel');
        $rcon->disconnect();

        // Prepare Discord Cancel message.
        $body = "L'Event `{$this->argument('boss')}` vient d'être arrêté sur la map Event !\n\n*N'oubliez pas de " .
        "vous retransférer sur le cluster à la fin de l'Event.*";

        try {
            $discord->channel->createMessage([
                'channel.id' => config('discord.channels.events-notifs'),
                'content' => "** **",
                'embed' => [
                    'description' =>  $body,
                    'color' => hexdec("1DFCEA"),
                    'thumbnail' => [
                        'url' => 'https://cdn.discordapp.com/app-icons/635391187301433380/'.
                        '1816aec0f6a4418f7ed19773e97dfb98.png'
                    ],
                    'author' => [
                        'name' => 'Events Boss',
                        'icon_url' => 'https://cdn.discordapp.com/attachments/631999661112033280/1003658653699686441/'
                        . 'Dodorex.webp'
                    ]
                ]
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $th) {
        }
    }
}
