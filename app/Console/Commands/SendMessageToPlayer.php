<?php
namespace Xetaravel\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use RestCord\DiscordClient;
use Xetaravel\Http\Helpers\Rcon;
use Xetaravel\Models\Server;
use Xetaravel\Models\ServerUser;
use Xetaravel\Models\UserLog;

class SendMessageToPlayer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:player';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a message to the player.';

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
        $logs = UserLog::where('event_type', \Xetaravel\Events\RCON\ServerChatToPlayerEvent::class)
            ->where('is_executed', false)
            ->get();

        if (!$logs) {
            return true;
        }
        $discord = new DiscordClient(['token' => config('discord.bot.token')]);

        foreach ($logs as $log) {
            $server = Server::where('id', $log->data['server_id'])->first();

            // Check if the user is still connected else continue.
            $player = ServerUser::where('steam_id', $log->steam_id)->first();

            if (!$player) {
                continue;
            }

            $response = $this->sendCommand($server, $log->data['command']);

            // Update the log.
            $log->is_executed = true;
            $log->save();

            // Avoid the spam on Discord.
            sleep(2);
        }
    }

    /**
     * Connect to RCON, send the command and return the response.
     *
     * @param string $command The command tos end to the RCON server.
     *
     * @return string
     */
    protected function sendCommand(Server $server, $command): string
    {
        $rcon = new Rcon($server->ip, $server->rcon_port, $server->password, 3);

        $rcon->connect();

        $response = $rcon->sendCommand($command);

        $rcon->disconnect();

        return $response;
    }
}
