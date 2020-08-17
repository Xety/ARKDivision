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

    /**
     * Update the Server status with a new one and update the last one.
     *
     * @param Xetaravel\Models\Server $server The server to update the status.
     * @param string $rconStatus The new status type.
     *
     * @return bool
     */
    protected function updateServerStatus(Server $server, $rconStatus): bool
    {
        // Update the pivot table record and force it to be closed.
        $data = [
            'status_id' => $server->status->id,
            'pivot_id' => $server->status->pivot->id,
            'was_forced' => true,
            'finished_at' => Carbon::now()
        ];
        $pivot = ServerRepository::updatePivot($data, $server);

        // Get the status related to the rcon status
        $status = Status::where(['type' => $rconStatus])->first();

        // Create a new status for this server.
        $server->statutes()->attach($status->id, [
            'event_type' => 'rcon'
        ]);

        return true;
    }
}
