<?php
namespace Xetaravel\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use RestCord\DiscordClient;
use Xetaravel\Models\PaypalUser;
use Xetaravel\Models\Role;

class DivisionStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'division:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the stats for the last 30 days.';

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
        $now = Carbon::now();
        $date = Carbon::now()->modify('-30 days');

        // Get the amount total for the last 30days.
        $amount = PaypalUser::where('user_id', '!=', 1)->where('created_at', '>', $date)->sum('amount_total');
        $count = PaypalUser::where('user_id', '!=', 1)->where('created_at', '>', $date)->count();
        $role = Role::where('slug', 'membre')->withCount('users')->first();

        $discord = new DiscordClient(['token' => config('discord.bot.token')]);

        // Send the notification on Discord.
        $discord->channel->createMessage([
            'channel.id' => 468825433136300032,
            'content' => "\n",
            'embed' => [
                'description' => "Voici les statistiques de Division pour la période du **{$date->format('d-m-Y')}**".
                " au **{$now->format('d-m-Y')}**",
                'color' => hexdec("1DFCEA"),
                'thumbnail' => [
                    'url' => 'https://cdn.discordapp.com/app-icons/635391187301433380/'.
                    '1816aec0f6a4418f7ed19773e97dfb98.png'
                ],
                'fields' => [
                    [
                        'name' => 'Montant des Donations',
                        'value' => "{$amount} €",
                        'inline' => false
                    ],
                    [
                        'name' => 'Nombre de Donations',
                        'value' => "{$count} donations",
                        'inline' => false
                    ],
                    [
                        'name' => 'Membres',
                        'value' => "{$role->users_count} membres",
                        'inline' => false
                    ]
                ],
                'author' => [
                    'name' => 'Statistiques Division',
                    'icon_url' => 'https://cdn.discordapp.com/attachments/636575768809439232/821912203354439680/'.
                    'kisspng-chart-computer-icons-statistics-report-elevator-repair-5ad986adef4327.'.
                    '78399718152420522998.jpg'
                ]
            ]
        ]);
    }
}
