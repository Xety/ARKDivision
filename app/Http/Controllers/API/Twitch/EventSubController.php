<?php

namespace Xetaravel\Http\Controllers\API\Twitch;

use romanzipp\Twitch\Http\Controllers\EventSubController as BaseController;
use RestCord\DiscordClient;
use Symfony\Component\HttpFoundation\Response;

class EventSubController extends BaseController
{
    public function handleStreamOnlineNotification(array $payload): Response
    {
        // Send the message to the #logs-bot channel.
        $discord = new DiscordClient(['token' => config('discord.bot.token')]);

        $description = "**" . $payload['subscription']['condition']['broadcaster_user_id'] .
        "**  vient de lancer son Live !\n";

        $discord->channel->createMessage([
            'channel.id' => config('discord.channels.logs-bot'),
            'embed' => [
                'description' => $description,
                'color' => hexdec("9146ff"),
                'thumbnail' => [
                    'url' => 'https://cdn.discordapp.com/app-icons/635391187301433380/'.
                    '1816aec0f6a4418f7ed19773e97dfb98.png'
                ],
                'author' => [
                    'name' => 'Twitch Notification',
                    'icon_url' => 'https://cdn.discordapp.com/attachments/631999661112033280/'.
                    '744946610169053364/pp258.png'
                ]
            ]
        ]);

        return $this->successMethod(); // handle the channel follow notification...
    }

    protected function handleNotification(array $payload): Response
    {
        return $this->successMethod(); // handle all other incoming notifications...
    }

    protected function handleRevocation(array $payload): Response
    {
        return $this->successMethod(); // handle the subscription revocation...
    }
}
