<?php
namespace Xetaravel\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Xetaravel\Http\Components\AnalyticsComponent;
use Xetaravel\Models\User;
use Xetaravel\Models\DiscussPost;
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
        $secondes = config('analytics.cache_lifetime_in_secondes');

        $viewDatas = [];

        $usersCount = Cache::remember('Analytics.users.count', $secondes, function () {
            return User::count();
        });

        $postsCount = Cache::remember('Analytics.posts.count', $secondes, function () {
            return DiscussPost::count();
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

        return view('page.index', compact('usersCount', 'postsCount', 'rewardsCount', 'allTimesVisitors'));
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
