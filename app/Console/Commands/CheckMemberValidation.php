<?php
namespace Xetaravel\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Command\Exception\CommandClientException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use RestCord\DiscordClient;
use Xetaravel\Models\Role;

class CheckMemberValidation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:validation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the validation of the members status.';

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
        $role = Role::where('slug', 'membre')->first();
        $users = $role->users()
            //->with('Transactions')
            ->where('users.member_expire_at', '<=', Carbon::now())
            ->get();

        if ($users->isEmpty()) {
            return;
        }

        $discord = new DiscordClient(['token' => config('discord.bot.token')]);

        foreach ($users as $user) {
            // Delete the roles of the user.
            foreach (config('discord.member.roles') as $role) {
                try {
                    $discord->guild->removeGuildMemberRole([
                        'guild.id' => config('discord.guild.id'),
                        'user.id' => $user->discord_id,
                        'role.id' => $role
                    ]);
                } catch (CommandClientException $e) {
                    // The user has left the discord so Discord can't delete it resulting to a 400 NOT FOUND
                }
            }

            // Update the role of the user on the site.
            $role = Role::where('slug', 'utilisateur')->first();
            $user->syncRoles([$role->id]);

            try {
                $member = $discord->guild->getGuildMember([
                    'guild.id' => config('discord.guild.id'),
                    'user.id' => $user->discord_id
                ]);
            } catch (CommandClientException $e) {
                $member = null;
                $name = "(Inconnu#1234)";
            }

            // Check if the user is still on our Discord and has a valid Discord ID.
            if (!is_null($member)) {
                $name = "(" . $user->discordNickname . ")";
            }

            $date = Carbon::parse($user->member_expire_at)->locale('fr');

            $description = "**J'ai supprimé <@" .  $user->discord_id . "> " . $name .
            " des rôles <@&386617500516876289> et <@&431910257367973898>.**\nL'expiration est arrivée à terme le *" .
            $date->translatedFormat('l jS F Y à H:m'). "*";

            if (!is_null($user->transactions()->orderBy('created_at', 'desc')->first())) {
                $lastDonation = 'Le' . $user->transactions()
                    ->orderBy('created_at', 'desc')
                    ->first()->created_at->translatedFormat('l jS F Y à H:m');
            } else {
                $lastDonation = 'Jamais';
            }

            // Send the notification on Discord.
            $discord->channel->createMessage([
                'channel.id' => config('discord.channels.logs-bot'),
                'embed' => [
                    'description' => $description,
                    'color' => hexdec("1DFCEA"),
                    'thumbnail' => [
                        'url' => 'https://cdn.discordapp.com/app-icons/635391187301433380/'.
                        '1816aec0f6a4418f7ed19773e97dfb98.png'
                    ],
                    'author' => [
                        'name' => 'Membre Validation',
                        'icon_url' => 'https://cdn.discordapp.com/attachments/607226558645796864/764084227133931550/'.
                        'Screenshot_895.png'
                    ],
                    'fields' => [
                        [
                            'name' => "Compteur de Donation",
                            'value' => $user->transaction_count,
                            'inline' => true
                        ],
                        [
                            'name' => "Montant total des donations",
                            'value' => isset($user->paypal->amount_total) ? $user->paypal->amount_total : 0,
                            'inline' => true
                        ],
                        [
                            'name' => "Dernière donation",
                            'value' => $lastDonation,
                            'inline' => true
                        ]
                    ]
                ]
            ]);

            // Delete the role "Membres," from the ArkShop for the user
            $player = DB::connection('arkshop')->table("players")->where('SteamId', $user->steam_id)->first();

            // User not found in database.
            if ($player == null) {
                return;
            }

            // Check that the user has the role "Membres,", if not cancel.
            if (strpos($player->PermissionGroups, 'Membres,') === false) {
                return;
            }

            // Add the group "Membres," to the groups.
            $permissionGroups = str_replace("Membres,", "", $player->PermissionGroups);

            // Update the PermissionGroups in database.
            DB::connection('arkshop')->update(
                'UPDATE players SET PermissionGroups = ? WHERE SteamId = ?',
                [$permissionGroups, $user->steam_id]
            );

            sleep(2);
        }
    }
}
