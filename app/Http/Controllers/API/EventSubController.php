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
    public function handleStreamOnlineNotification(array $payload): Response
    {
        $twitch = new Twitch;
        $stream = $twitch->getStreams(['user_id' => $user->id]);

        // Check if there's an user
        if (!isset($stream->data()[0])) {
            return $this->missingMethod();
        }

        // Check if the game is ARK Survival Evolved
        if ($stream->data()[0]->game_id != '489635') {
            return $this->missingMethod();
        }

        // Check if the user has ARK Division in this title
        $matchs = preg_match('/^(ARK Division)$/i', $stream->data()[0]->title);
        if (!$matchs) {
            return $this->missingMethod();
        }

        $avatar = str_replace("{width}", "200", $stream->data()[0]->thumbnail_url);
        $avatar = str_replace("{height}", "200", $avatar);

        // Send the message to the #logs-bot channel.
        $discord = new DiscordClient(['token' => config('discord.bot.token')]);

        $user = User::where('twitch_id', $payload['subscription']['condition']['broadcaster_user_id'])->first();

        // Check if the user exist or if he has a discord_id
        if (!$user || is_null($user->discord_id)) {
            return $this->missingMethod();
        }

        $description = "**<@" . $user->discord_id .
        ">**  vient de lancer son Live !\nhttps://www.twitch.tv/" . $payload['event']['broadcaster_user_name'];

        $discord->channel->createMessage([
            'channel.id' => config('discord.channels.logs-bot'),
            'embed' => [
                'description' => $description,
                'color' => hexdec("9146ff"),
                'thumbnail' => [
                    'url' => $avatar
                ],
                'author' => [
                    'name' => 'Twitch Notification',
                    'icon_url' => 'https://cdn.discordapp.com/attachments/337045603588505610/' .
                    '817129539821240350/twitch-logo-4931D91F85-seeklogo.com.png'
                ]
            ]
        ]);

        $discord->guild->addGuildMemberRole([
            'guild.id' => config('discord.guild.id'),
            'user.id' => $user->discord_id,
            'role.id' => config('discord.streamer')
        ]);

        return $this->successMethod(); // handle the channel follow notification...
    }

    public function handleStreamOfflineNotification(array $payload): Response
    {
        // Send the message to the #logs-bot channel.
        $discord = new DiscordClient(['token' => config('discord.bot.token')]);

        $user = User::where('twitch_id', $payload['subscription']['condition']['broadcaster_user_id'])->first();

        $description = "**<@" . $user->discord_id .
        ">**  vient de couper son Live !\nhttps://www.twitch.tv/" . $payload['event']['broadcaster_user_name'];

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
                    'icon_url' => 'https://cdn.discordapp.com/attachments/337045603588505610/' .
                    '817129539821240350/twitch-logo-4931D91F85-seeklogo.com.png'
                ]
            ]
        ]);

        $discord->guild->removeGuildMemberRole([
            'guild.id' => config('discord.guild.id'),
            'user.id' => $user->discord_id,
            'role.id' => config('discord.streamer')
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
