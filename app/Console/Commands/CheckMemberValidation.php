<?php
namespace Xetaravel\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Command\Exception\CommandClientException;
use Illuminate\Console\Command;
use RestCord\DiscordClient;
use Xetaravel\Models\Role;
use Xetaravel\Models\User;

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
                $discord->guild->removeGuildMemberRole([
                    'guild.id' => config('discord.guild.id'),
                    'user.id' => $user->discord_id,
                    'role.id' => $role
                ]);
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
                            'value' => $user->paypal->amount_total,
                            'inline' => true
                        ],
                        [
                            'name' => "Dernière donation",
                            'value' => 'Le ' .$user->transactions()
                                                                    ->orderBy('created_at', 'desc')
                                                                    ->first()
                                                                    ->created_at->translatedFormat('l jS F Y à H:m'),
                            'inline' => true
                        ]
                    ]
                ]
            ]);

            sleep(2);
        }
    }
}
