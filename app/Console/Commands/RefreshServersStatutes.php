<?php
namespace Xetaravel\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Xetaravel\Events\RCON\ServerChatToPlayerEvent;
use Xetaravel\Events\Servers\ServerStatusHasFinishedEvent;
use Xetaravel\Http\Helpers\Rcon;
use Xetaravel\Models\Repositories\ServerRepository;
use Xetaravel\Models\Server;
use Xetaravel\Models\Status;

class RefreshServersStatutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'servers:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the statutes of servers';

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
        $start = microtime(true);

        $servers = Server::all();

        if (!$servers) {
            return true;
        }

        $data = ['servers' => []];
        $playersCount = 0;
        $serversOnline = 0;

        foreach ($servers as $server) {
            $rcon = new Rcon($server->ip, $server->rcon_port, $server->password, 3);

            // Get the RCON status related to the connection if it is etablished or not.
            $rconStatus = $this->getRconStatus($rcon);

            // Verify that the server status is different from the RCON status and
            // the server status is expired to update it.
            $updated = false;

            if ($server->status->type != $rconStatus && $server->status->pivot->isExpired) {
                $updated = $this->updateServerStatus($server, $rconStatus);
            }

            $serverStatus = $server->status->type;

            if ($updated) {
                $serverStatus = $rconStatus;
            }

            // If we can't etablished a connection, that means the server is 'stopped'.
            if (!$rcon->connect()) {
                array_push($data['servers'], [
                    'id' => $server->id,
                    'name' => $server->name,
                    'emoji' => $server->emoji,
                    'status' => $serverStatus,
                    'players' => [],
                    'playersCount' => 0
                ]);

                continue;
            }
            $response = $rcon->sendCommand('ListPlayers');
            $rcon->disconnect();

            // Split all players by a return character.
            $users = array_map('trim', explode("\n", trim($response)));

            // If there's no players connected, no need to continue.
            if ($users[0] == "No Players Connected") {
                array_push($data['servers'], [
                    'id' => $server->id,
                    'name' => $server->name,
                    'emoji' => $server->emoji,
                    'status' => $serverStatus,
                    'players' => [],
                    'playersCount' => 0
                ]);

                // Update the number of servers online.
                $serversOnline++;

                continue;
            }

            // Array used to store all steam ids from players for synchronization with the databse.
            $players = [];

            // Apply a callback on all members.
            array_walk($users, function (&$value, $key) use ($server, &$players) {
                $user = explode(",", $value);

                $tribe = $this->sendCommand($server, "GetTribeName " . trim($user[1]));
                $ingame = $this->sendCommand($server, "GetPlayerName " . trim($user[1]));

                $tribe = substr(trim(str_replace("Server received, But no response!!", "", $tribe)), 11);

                $player = [
                    'steam_id' => (int)trim($user[1]),
                    'steam_name' => explode(". ", $user[0])[1],
                    'ingame_name' => substr(trim(str_replace("Server received, But no response!!", "", $ingame)), 13),
                    'tribe' => $tribe,
                ];
                array_push($players, $player);

                // Fire the event that will log the player because he does not have a tribe.
                if ($tribe == false) {
                    event(new ServerChatToPlayerEvent($server, $player));
                }
            });

            $playersCount += count($users);

            array_push($data['servers'], [
                'id' => $server->id,
                'name' => $server->name,
                'emoji' => $server->emoji,
                'status' => $serverStatus,
                'players' => $players,
                'playersCount' => count($users)
            ]);

            // Update the number of servers online.
            $serversOnline++;
        }

        $data += [
            'serversCount' => count($servers),
            'serversOnlineCount' => $serversOnline,
            'playersCount' => $playersCount
        ];

        foreach ($data['servers'] as $serverStats) {
            $server = Server::where('id', $serverStats['id'])->first();

            $server->players()->sync($serverStats['players']);
        }

        if (env('APP_ENV') != 'local') {
            // Fire the event that will update the discord message.
            event(new ServerStatusHasFinishedEvent($data));
        }


        $end = microtime(true);
        $this->info("The command `servers:refresh` took " . round(($end - $start)) . " seconds to complete.");
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
     * Get the RCON status of the current RCON server connection.
     *
     * @param \Xetaravel\Http\Helpers\Rcon $rcon
     *
     * @return string
     */
    protected function getRconStatus(Rcon $rcon): string
    {
        if ($rcon->connect()) {
            return 'started';
        }

        return 'stopped';
    }

    /**
     * Update the Server status with a new one and update the last one.
     *
     * @param Xetaravel\Models\Server $server The server to update the status.
     * @param string $rconStatus The new status type.
     *
     * @return bool
     */
    protected function updateServerStatus(Server $server, string $rconStatus): bool
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
            'event_type' => 'cron'
        ]);

        return true;
    }
}
