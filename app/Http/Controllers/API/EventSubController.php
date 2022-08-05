<?php

namespace Xetaravel\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use RestCord\DiscordClient;
use romanzipp\Twitch\Events\EventSubHandled;
use romanzipp\Twitch\Events\EventSubReceived;
use romanzipp\Twitch\Http\Controllers\EventSubController as BaseController;
use romanzipp\Twitch\Http\Middleware\VerifyEventSubSignature;
use romanzipp\Twitch\Twitch;
use Symfony\Component\HttpFoundation\Response;
use Xetaravel\Models\User;

class EventSubController extends Controller
{

    /**
     * Handle a Stream.Online notification from Twitch.
     *
     * @param array $payload The informations provided by Twitch.
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#stream-subscriptions
     */
    public function handleStreamOnlineNotification(array $payload): Response
    {
        $user = User::where('twitch_id', $payload['subscription']['condition']['broadcaster_user_id'])->first();

        // Check if the user exist and if he has a discord_id
        if (!$user || is_null($user->discord_id)) {
            return $this->missingMethod();
        }

        $twitch = new Twitch;
        $stream = $twitch->getStreams(['user_id' => $user->twitch_id]);

        // Check if there's an user
        if (!isset($stream->data()[0])) {
            return $this->missingMethod();
        }

        // Check if the game is ARK: Survival Evolved
        if ($stream->data()[0]->game_id != "489635") {
            return $this->missingMethod();
        }

        // Check if the user has ARKDivision in his title
        $matchs = [];
        preg_match('/(ARKDivision)/im', $stream->data()[0]->title, $matchs);
        if (!$matchs) {
            return $this->missingMethod();
        }

        $discord = new DiscordClient(['token' => config('discord.bot.token')]);

        $description = "**<@" . $user->discord_id .
        ">**  vient de lancer son Live sur les serveurs ARK Division !\nhttps://www.twitch.tv/" .
        $payload['event']['broadcaster_user_name'] . "\n";

        // Send the message to the #taverne channel.
        $discord->channel->createMessage([
            'channel.id' => config('discord.channels.taverne'),
            'embed' => [
                'description' => $description,
                'color' => hexdec("9146ff"),
                'thumbnail' => [
                    'url' => 'https://cdn.discordapp.com/attachments/337045603588505610/' .
                    '817129539821240350/twitch-logo-4931D91F85-seeklogo.com.png'
                ],
                'author' => [
                    'name' => 'Twitch Notification',
                    'icon_url' => 'https://cdn.discordapp.com/attachments/337045603588505610/' .
                    '817129539821240350/twitch-logo-4931D91F85-seeklogo.com.png'
                ]
            ]
        ]);

        // Add the role STreamer on Discord.
        $discord->guild->addGuildMemberRole([
            'guild.id' => config('discord.guild.id'),
            'user.id' => $user->discord_id,
            'role.id' => config('discord.streamer')
        ]);

        return $this->successMethod();
    }

     /**
     * Handle a Stream.Offline notification from Twitch.
     *
     * @param array $payload The informations provided by Twitch.
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#stream-subscriptions
     */
    public function handleStreamOfflineNotification(array $payload): Response
    {
        //$user = User::where('twitch_id', $payload['subscription']['condition']['broadcaster_user_id'])->first();

        /*$twitch = new Twitch;
        $stream = $twitch->getStreams(['user_id' => $user->twitch_id]);

        // Check if there's an user
        if (!isset($stream->data()[0])) {
            return $this->missingMethod();
        }*/

        /*$discord = new DiscordClient(['token' => config('discord.bot.token')]);

        $description = "**<@" . $user->discord_id .
        ">**  vient de couper son Live sur les serveurs ARK Division !\nhttps://www.twitch.tv/" .
        $payload['event']['broadcaster_user_name'];

        $discord->channel->createMessage([
            'channel.id' => config('discord.channels.taverne'),
            'embed' => [
                'description' => $description,
                'color' => hexdec("9146ff"),
                'thumbnail' => [
                    'url' => 'https://cdn.discordapp.com/attachments/337045603588505610/' .
                    '817129539821240350/twitch-logo-4931D91F85-seeklogo.com.png'
                ],
                'author' => [
                    'name' => 'Twitch Notification',
                    'icon_url' => 'https://cdn.discordapp.com/attachments/337045603588505610/' .
                    '817129539821240350/twitch-logo-4931D91F85-seeklogo.com.png'
                ]
            ]
        ]);*/

        /*$discord->guild->removeGuildMemberRole([
            'guild.id' => config('discord.guild.id'),
            'user.id' => $user->discord_id,
            'role.id' => config('discord.streamer')
        ]);*/

        return $this->successMethod(); // handle the channel follow notification...
    }

    /**
     * Handle a Channel.Update notification from Twitch.
     *
     * @param array $payload The informations provided by Twitch.
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types#channel-subscriptions
     */
    public function handleChannelUpdateNotification(array $payload): Response
    {
        /*$discord = new DiscordClient(['token' => config('discord.bot.token')]);

        $user = User::where('twitch_id', $payload['subscription']['condition']['broadcaster_user_id'])->first();*/

        //  The user has changed his game
        /*if ($payload['event']['category_id'] != "489635") {
            $description = "**<@" . $user->discord_id .
            ">**  vient de couper son Live sur les serveurs ARK Division ! (Changement de jeu)\n".
            "https://www.twitch.tv/" . $payload['event']['broadcaster_user_name'];

            $discord->channel->createMessage([
                'channel.id' => config('discord.channels.taverne'),
                'embed' => [
                    'description' => $description,
                    'color' => hexdec("9146ff"),
                    'thumbnail' => [
                        'url' => 'https://cdn.discordapp.com/attachments/337045603588505610/' .
                        '817129539821240350/twitch-logo-4931D91F85-seeklogo.com.png'
                    ],
                    'author' => [
                        'name' => 'Twitch Notification',
                        'icon_url' => 'https://cdn.discordapp.com/attachments/337045603588505610/' .
                        '817129539821240350/twitch-logo-4931D91F85-seeklogo.com.png'
                    ]
                ]
            ]);*/

            // Delete the Streamer role on Discord
            /*$discord->guild->removeGuildMemberRole([
                'guild.id' => config('discord.guild.id'),
                'user.id' => $user->discord_id,
                'role.id' => config('discord.streamer')
            ]);*/

            //return $this->successMethod();
        //}

        // Check if the user has not changed ARKDivision in his title
        /*$matchs = [];
        preg_match('/(ARKDivision)/im', $payload['event']['title'], $matchs);
        if (!$matchs) {
            $description = "**<@" . $user->discord_id .
            ">**  vient de couper son Live sur les serveurs ARK Division ! (Changement de titre)\n".
            "https://www.twitch.tv/" . $payload['event']['broadcaster_user_name'];

            $discord->channel->createMessage([
                'channel.id' => config('discord.channels.taverne'),
                'embed' => [
                    'description' => $description,
                    'color' => hexdec("9146ff"),
                    'thumbnail' => [
                        'url' => 'https://cdn.discordapp.com/attachments/337045603588505610/' .
                        '817129539821240350/twitch-logo-4931D91F85-seeklogo.com.png'
                    ],
                    'author' => [
                        'name' => 'Twitch Notification',
                        'icon_url' => 'https://cdn.discordapp.com/attachments/337045603588505610/' .
                        '817129539821240350/twitch-logo-4931D91F85-seeklogo.com.png'
                    ]
                ]
            ]);

            // Delete the Streamer role on Discord
            $discord->guild->removeGuildMemberRole([
                'guild.id' => config('discord.guild.id'),
                'user.id' => $user->discord_id,
                'role.id' => config('discord.streamer')
            ]);

            return $this->successMethod();
        }*/

        // The user has changed a non required parameter.
        return $this->successMethod();
    }

    protected function handleNotification(array $payload): Response
    {
        return $this->successMethod(); // handle all other incoming notifications...
    }

    protected function handleRevocation(array $payload): Response
    {
        return $this->successMethod(); // handle the subscription revocation...
    }

    public function __construct()
    {
        if (config('twitch-api.eventsub.secret')) {
            //$this->middleware(VerifyEventSubSignature::class);
        }
    }

    /**
     * Handle a Twitch webhook call.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handleWebhook(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);

        $messageType = $request->header('twitch-eventsub-message-type');

        if ('notification' === $messageType) {
            $messageType = sprintf('%s.notification', $payload['subscription']['type']);
        }

        $method = 'handle' . Str::studly(str_replace('.', '_', $messageType));

        EventSubReceived::dispatch($payload);

        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            EventSubHandled::dispatch($payload);

            return $response;
        }

        return $this->missingMethod();
    }

    /**
     * Handle a EventSub callback verification call.
     *
     * @param array $payload
     *
     * @return Response
     */
    protected function handleWebhookCallbackVerification(array $payload): Response
    {
        return new Response($payload['challenge'], 200);
    }

    /**
     * Handle successful calls on the controller.
     *
     * @param array $parameters
     *
     * @return Response
     */
    protected function successMethod($parameters = []): Response
    {
        return new Response('Webhook Handled', 200);
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param array $parameters
     *
     * @return Response
     */
    protected function missingMethod($parameters = []): Response
    {
        return new Response();
    }
}
