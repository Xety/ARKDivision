<?php

namespace Xetaravel\Http\Controllers\Donation;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use RestCord\DiscordClient;
use Xetaravel\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        URL::forceRootUrl(config('app.url'));
    }

    /**
     *  Get all the discord users and display them on the donation page.
     *
     * @return void
     */
    public function index()
    {
        $discord = null;

        if (Auth::check() && !is_null(Auth::user()->discord_id)) {
            $user = Auth::user();
            $discordClient = new DiscordClient(['token' => config('discord.bot.token')]);

            try {
                $discord = $discordClient->guild->getGuildMember([
                    'guild.id' => config('discord.guild.id'),
                    'user.id' => $user->discord_id
                ]);
            } catch (\GuzzleHttp\Command\Exception\CommandClientException $e) {
                $discord = 404;
            }
        }

        $steam = null;

        // Check if the user has link his steam_id
        if (Auth::check() && !is_null(Auth::user()->steam_id)) {
            $steam = Auth::user()->steam_id;
        }

        return view('Donation.page.index', compact('discord', 'steam'));
    }
}
