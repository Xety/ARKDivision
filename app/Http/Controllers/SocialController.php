<?php
namespace Xetaravel\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use romanzipp\Twitch\Enums\EventSubType;
use romanzipp\Twitch\Twitch;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponseSF;
use Xetaravel\Models\Repositories\AccountRepository;
use Xetaravel\Models\Repositories\UserRepository;
use Xetaravel\Models\User;

class SocialController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        // Need to set a new redirect URL for Discord.
        config(['services.discord.redirect' => route('users.social.discordcallback')]);

        $this->breadcrumbs->addCrumb('Social', route('users.social.index'));
    }

    /**
     * Show the social index.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $user = User::find(Auth::id());

        $breadcrumbs = $this->breadcrumbs;

        return view('social.index', compact('user', 'breadcrumbs'));
    }

    /**
     * Build the steam link to get the steam ID and redirect to steam.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function steam(): RedirectResponse
    {
        $user = Auth::user();

        // Build all the required param to use openid.
        $params = [
            'openid.ns' => 'http://specs.openid.net/auth/2.0',
            'openid.mode' => 'checkid_setup',
            'openid.return_to' => route('users.social.steamcallback', ['id' => $user->id]),
            'openid.realm' => env('APP_URL'),
            'openid.identity' => 'http://specs.openid.net/auth/2.0/identifier_select',
            'openid.claimed_id' => 'http://specs.openid.net/auth/2.0/identifier_select',
        ];

        $url = 'https://steamcommunity.com/openid/login?' . http_build_query($params);

        return redirect()->away($url);
    }

    /**
     * Handle a callback from steam after a successfull login on steam.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The user id that made the request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function steamCallback(Request $request, int $id): RedirectResponse
    {
        $data = [
            "openid_claimed_id" => (int)str_replace(
                'https://steamcommunity.com/openid/id/',
                '',
                $request->input('openid_claimed_id')
            )
        ];

        $validator = Validator::make($data, [
            'openid_claimed_id' => 'required|digits_between:17,25',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('users.social.index')
                ->with('danger', 'Ce steam ID n\'est pas valide.');
        }

        $steamId = $request->input('openid_claimed_id');

        // Validate wheather it's true and if we have a good ID

        /*preg_match("#([0-9]{17,25})#", $claimedId, $matches);
        dump($matches);
        $steamId = is_numeric($matches[0]) ? $matches[0] : 0;

        // Check if the steam ID is valide.
        if ($steamId == 0) {
            return redirect()
                ->route('users.social.index')
                ->with('danger', 'Ce steam ID n\'est pas valide.');
        }*/

        // Get the steam username for this steam id.
        $client = new Client();
        $res = $client->request(
            'GET',
            sprintf(config('xetaravel.steam.api_url'), config('xetaravel.steam.api_key'), $steamId)
        );
        $steamUsers = json_decode($res->getBody())->response->players;

        // Check if the response is not empty, that means the steam id is not valide.
        if (empty($steamUsers)) {
            return redirect()
                ->route('users.social.index')
                ->with('danger', 'Ce steam ID n\'est pas valide.');
        }

        // Check if the user is in the database
        $user = User::where('id', $id)->firstOrFail();

        // Save the steam ID.
        UserRepository::updateSteam([
            'steam_id' => $steamUsers[0]->steamid
        ], $user);

        // Update or create the account with related steam fields.
        AccountRepository::updateSteam([
            'steam_username' => $steamUsers[0]->personaname,
        ], $user->id);

        return redirect()
            ->route('users.social.index')
            ->with('success', 'Votre compte Steam à bien été lié à votre compte Division.');
    }

    /**
     * Redirect the user to the Discord authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function discord(): RedirectResponseSF
    {
        return Socialite::driver('discord')
                ->setScopes(['identify'])
                ->redirectUrl(route('users.social.discordcallback'))
                ->redirect();
    }

    /**
     * Obtain the user information from Discord and save the information for the current logged in user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function discordCallback(): RedirectResponse
    {
        try {
            $user = Socialite::driver('discord')->user();
        } catch (Exception $e) {
            return redirect()
                ->route('users.social.index')
                ->with(
                    'danger',
                    "Une erreur s'est produite lors de l'obtention de vos informations auprès de Discord !"
                );
        }

        // Check if the discord_id is not already used.
        if ($member = User::where('discord_id', $user->id)->first()) {
            return redirect()
                ->route('users.social.index')
                ->with('danger', 'Ce Discord est déjà lié à un compte Division !');
        }

        // Save the discord_id field.
        UserRepository::updateDiscord([
            'discord_id' => $user->id
        ], Auth::user());

        // Save the username and discriminator fields.
        AccountRepository::updateDiscord([
            'discord_username' => $user->user['username'],
            'discord_discriminator' => $user->user['discriminator']
        ], Auth::id());

        return redirect()
            ->route('users.social.index')
            ->with('success', 'Votre compte Discord à bien été lié à votre compte Division.');
    }

    /**
     * Redirect the user to the Twitch authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function twitch(): RedirectResponseSF
    {
        return Socialite::driver('twitch')
                //->setScopes(['identify'])
                //->redirectUrl(route('users.social.twitchcallback'))
                ->redirectUrl('https://arkdivision.io/users/social/twitchcallback')
                ->redirect();
    }

    /**
     * Obtain the user information from Twitch and save the information for the current logged in user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function twitchCallback(): RedirectResponse
    {
        try {
            $user = Socialite::driver('twitch')->user();
        } catch (Exception $e) {
            return redirect()
                ->route('users.social.index')
                ->with(
                    'danger',
                    "Une erreur s'est produite lors de l'obtention de vos informations auprès de Twitch !"
                );
        }

        // Save the twitch_id field.
        UserRepository::updateTwitch([
            'twitch_id' => $user->id
        ], Auth::user());

        // Save the username field.
        AccountRepository::updateTwitch([
            'twitch_username' => $user->user['display_name'],
        ], Auth::id());

        // Subscribe to the stream.online and stream.offline EventSub
        $twitch = new Twitch;
        $twitch->subscribeEventSub([], [
            'type' => EventSubType::STREAM_ONLINE,
            'version' => '1',
            'condition' => [
                'broadcaster_user_id' => $user->id,
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' => 'https://api.ark-division.fr/v1/twitch/eventsub/webhook',
            ]
        ]);

        $twitch->subscribeEventSub([], [
            'type' => EventSubType::STREAM_OFFLINE,
            'version' => '1',
            'condition' => [
                'broadcaster_user_id' => $user->id,
            ],
            'transport' => [
                'method' => 'webhook',
                'callback' => 'https://api.ark-division.fr/v1/twitch/eventsub/webhook',
            ]
        ]);

        return redirect()
            ->route('users.social.index')
            ->with('success', 'Votre compte Twitch à bien été lié à votre compte Division.');
    }

    /**
     * Handle a delete request for the specified type.
     *
     * @param string $type The type of social media to delete.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(string $type): RedirectResponse
    {
        switch ($type) {
            // Handle a Discord type.
            case 'discord':
                UserRepository::updateDiscord([
                    'discord_id' => null
                ], Auth::user());

                AccountRepository::updateDiscord([
                    'discord_username' => null,
                    'discord_discriminator' => null
                ], Auth::id());

                return back()
                    ->with(
                        'success',
                        'La liaison de votre compte Discord avec votre compte Division à bien été supprimé.'
                    );

            // Handle a Steam type.
            case 'steam':
                UserRepository::updateSteam([
                    'steam_id' => null
                ], Auth::user());

                AccountRepository::updateSteam([
                    'steam_username' => null
                ], Auth::id());

                return back()
                    ->with(
                        'success',
                        'La liaison de votre compte Steam avec votre compte Division à bien été supprimé.'
                    );

            // Handle a Twitch type.
            case 'twitch':
                UserRepository::updateTwitch([
                    'twitch_id' => null
                ], Auth::user());

                AccountRepository::updateTwitch([
                    'twitch_username' => null,
                ], Auth::id());

                return back()
                    ->with(
                        'success',
                        'La liaison de votre compte Twitch avec votre compte Division à bien été supprimé.'
                    );

            default:
                return back()
                    ->with('danger', 'Invalide social type.');
        }
    }
}
