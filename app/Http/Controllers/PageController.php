<?php
namespace Xetaravel\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Xetaravel\Http\Components\AnalyticsComponent;
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

        if (config('analytics.enabled')) {
            $allTimesVisitors = Cache::remember('Analytics.alltimesvisitors', $secondes, function () {
                return $this->buildAllTimeVisitors();
            });
        } else {
            $allTimesVisitors = null;
        }

        return view('page.index', compact('usersCount', 'rewardsCount', 'allTimesVisitors'));
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
