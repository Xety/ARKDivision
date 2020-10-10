<?php
namespace Xetaravel\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use RestCord\DiscordClient;
use Xetaravel\Models\SteamBan;
use Xetaravel\Models\User;

class SteamBanChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'steamban:checker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the ban between the database and pastebin.';

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
        // Get the content of the pastebin list.
        $client = new Client();
        $response = $client->request('GET', config('xetaravel.pastebin.banlist_url'));
        $status = $response->getStatusCode();
        $body = $response->getBody();

        if ($status !== 200) {
            return;
        }

        $pastebinIDs = array_map('intval', explode("\n", $body->getContents()));

        // Find all active bans.
        $activeBans = SteamBan::where('forever', true)->orWhere('expire_at', '>', Carbon::now())->get();

        // If there's no active ban, cancel the script.
        if ($activeBans->isEmpty()) {
            return;
        }
        $notInPastebin = [];

        // Compare the steam IDs from database to the Pastebin steam IDs.
        foreach ($activeBans as $ban) {
            // Check if the steam ID is in the Pastebin list.
            if (!in_array($ban->steam_id, $pastebinIDs)) {
                array_push($notInPastebin, $ban->steam_id);
            }
        }

        $notInDatabase = [];

        // Compare the steam IDs from Pastebin to the database steam IDs.
        foreach ($pastebinIDs as $pastebinID) {
            $check = SteamBan::where('steam_id', $pastebinID)
                                ->where(function ($query) {
                                    $query->where('forever', true)
                                                ->orWhere('expire_at', '>', Carbon::now());
                                })
                                ->get();

            if ($check->isEmpty()) {
                array_push($notInDatabase, $pastebinID);
            }
        }

        $body = "";

        // Check if the array is not empty.
        if (!empty($notInPastebin)) {
            $body .= "Ces steam IDs ont besoin d'être **ajoutés** au Pastebin (Nouveaux Bans) : \n";

            foreach ($notInPastebin as $id) {
                $body .= "` " . $id . " `\n";
            }
        }

        if (!empty($notInDatabase)) {
            $body .= "\nCes steam IDs ont besoin d'être **supprimés** du Pastebin (Bans arrivés à expiration) : \n";

            foreach ($notInDatabase as $id) {
                $body .= "` " . $id . " `\n";
            }
        }

        if (empty($body)) {
            return;
        }

        $discord = new DiscordClient(['token' => config('discord.bot.token')]);

        // Send the notification on Discord.
        $discord->channel->createMessage([
            'channel.id' => config('discord.channels.logs-bot'),
            'content' => "**<@&652647274681335860>**",
            'embed' => [
                'description' =>  $body,
                'color' => hexdec("1DFCEA"),
                'thumbnail' => [
                    'url' => 'https://cdn.discordapp.com/app-icons/635391187301433380/'.
                    '1816aec0f6a4418f7ed19773e97dfb98.png'
                ],
                'author' => [
                    'name' => 'Steam Ban Checker',
                    'icon_url' => 'https://cdn.discordapp.com/attachments/631999661112033280/764454187861671936/'.
                    'Screenshot_898.png'
                ]
            ]
        ]);
    }
}
