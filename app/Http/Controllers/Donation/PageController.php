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
        $member = null;

        if (Auth::check() && !is_null(Auth::user()->discord_id)) {
            $user = Auth::user();
            $discord = new DiscordClient(['token' => config('discord.bot.token')]);

            try {
                $member = $discord->guild->getGuildMember([
                    'guild.id' => config('discord.guild.id'),
                    'user.id' => $user->discord_id
                ]);
            } catch (\GuzzleHttp\Command\Exception\CommandClientException $e) {
                $member = 404;
            }
        }

        return view('Donation.page.index', compact('member'));
    }
}
