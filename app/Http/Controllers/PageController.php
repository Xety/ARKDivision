<?php
namespace Xetaravel\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use RestCord\DiscordClient;
use Xetaravel\Http\Components\AnalyticsComponent;
use Xetaravel\Models\Arkshopplayer;
use Xetaravel\Models\Badge;
use Xetaravel\Models\User;
use Xetaravel\Models\RewardUser;

class PageController extends Controller
{
    use AnalyticsComponent;

    /**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**$users = DB::connection('division')->table("users")->where('member_expire_at', '>', Carbon::now())
            ->where('steam_id', '!=', null)
            ->select(['slug', 'member_expire_at', 'steam_id'])
            ->get();

        $increment = 0;

        foreach ($users as $user) {
            // User dont have set a steam_id
            if ($user->steam_id == null) {
                continue;
            }

            var_dump($user->steam_id);

            $player = DB::connection('arkshop')->table("players")->where('SteamId', $user->steam_id)->first();

            // Player is Membre but dont play anymore
            if ($player == null) {
                continue;
            }

            if (strpos($player->PermissionGroups, 'Membres,') === false) {
                $permissionGroups = $player->PermissionGroups. "Membres,";

                $test = DB::connection('arkshop')->update(
                    'UPDATE players SET PermissionGroups = ? WHERE SteamId = ?',
                    [$permissionGroups, $user->steam_id]
                );

                $increment += $test;
            }
        }
        dd($increment);**/




        $secondes = config('analytics.cache_lifetime_in_secondes');

        $viewDatas = [];

        $usersCount = Cache::remember('Analytics.users.count', $secondes, function () {
            return User::count();
        });

        $rewardsCount = Cache::remember('Analytics.rewards.count', $secondes, function () {
            return RewardUser::count();
        });

        $pointsCount = Cache::remember('Analytics.points.count', $secondes, function () {
            return Arkshopplayer::where('SteamId', '<>', 76561198099250608)->sum('Points');
        });

        if (config('analytics.enabled')) {
            $allTimesVisitors = Cache::remember('Analytics.alltimesvisitors', $secondes, function () {
                return $this->buildAllTimeVisitors();
            });
        } else {
            $allTimesVisitors = null;
        }

        // Get the last news from Division Discord.
        $discordAnnonces = Cache::remember('Analytics.discord.news', $secondes, function () {
            $discord = new DiscordClient(['token' => config('discord.bot.token')]);
            return $discord->channel->getChannelMessages(['channel.id' => 386898828109938688, 'limit' => 3]);
        });

        // Get the notifications for the user.
        $notifications= null;

        if (Auth::user()) {
            $user = User::find(Auth::id());
            $notifications = $user->notifications()->limit(2)->get();
        }

        $badges= Badge::where('type', 'eventParticipating')->get();

        if (Auth::user()) {
            $user = User::find(Auth::id());
            $badges = $user->badges()->where('type', 'eventParticipating')->get();
        }


        return view(
            'page.index',
            compact(
                'usersCount',
                'rewardsCount',
                'allTimesVisitors',
                'pointsCount',
                'discordAnnonces',
                'notifications',
                'badges'
            )
        );
    }

    /**
     * Show the terms page.
     *
     * @return \Illuminate\Http\Response
     */
    public function terms()
    {

        return view('page.terms');
    }

    /**
     * Display the banished page.
     *
     * @return \Illuminate\Http\Response
     */
    public function banished()
    {
        if (!Auth::user()->hasRole('banni')) {
            return redirect()
                ->route('page.index');
        }

        return view('page.banished');
    }
}
