<?php
namespace Xetaravel\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use RestCord\DiscordClient;
use Xetaravel\Models\User;

class RefreshCoffresDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coffres:refreshdaily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the daily coffres for everyone.';

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
        $discord = new DiscordClient(['token' => config('discord.bot.token')]);

        // Send the notification on Discord.
        $discord->channel->createMessage([
            'channel.id' =>
            (env('APP_ENV') == 'local') ? config('discord.channels.logs-bot') : config('discord.channels.general'),
            'content' => "\n",
            'embed' => [
                'description' => "Les coffres journaliers sur le site " . env('APP_URL') .
                                                " viennent d'être réinitialisés !",
                'color' => hexdec("1DFCEA"),
                'thumbnail' => [
                    'url' => 'https://cdn.discordapp.com/app-icons/635391187301433380/'.
                    '1816aec0f6a4418f7ed19773e97dfb98.png'
                ],
                'author' => [
                    'name' => 'Coffres Division',
                    'icon_url' => 'https://cdn.discordapp.com/attachments/'.
                    '636286155352047665/1011978870146203708/chest-closed-highlight.jpg'
                ]
            ]
        ]);
    }
}
