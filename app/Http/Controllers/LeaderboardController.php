<?php
namespace Xetaravel\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Xetaravel\Models\Arkshopplayer;
use Xetaravel\Models\LethalquestsStat;

class LeaderboardController extends Controller
{
    /**
     * Show all the Leaderboards.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $secondes = config('division.leaderboard.cache_in_secondes');

        $bossKills = Cache::remember('Leaderbaord.index.bosskills', $secondes, function () {
            return LethalquestsStat::select('Name', 'TribeName', 'BossKills')
                                                        ->limit(10)
                                                        ->orderBy('BossKills', 'desc')
                                                        ->get();
        });

        $purpleOSDWaves = Cache::remember('Leaderbaord.index.purpleosdwaves', $secondes, function () {
            return LethalquestsStat::select('Name', 'TribeName', 'PurpleOSDWaves')
                                                        ->limit(10)
                                                        ->orderBy('PurpleOSDWaves', 'desc')
                                                        ->get();
        });

        $fishCaughts = Cache::remember('Leaderbaord.index.fishcaughts', $secondes, function () {
            return LethalquestsStat::select('Name', 'TribeName', 'FishCaught')
                                                        ->limit(10)
                                                        ->orderBy('FishCaught', 'desc')
                                                        ->get();
        });

        $refresh = Cache::remember('Leaderbaord.index.refresh', $secondes, function () use ($secondes) {
            return Carbon::now()->addSeconds($secondes);
        });

        $breadcrumbs = $this->breadcrumbs->addCrumb('Leaderboard', route('leaderboard.index'));

        return view(
            'leaderboard.index',
            compact('breadcrumbs', 'refresh', 'bossKills', 'purpleOSDWaves', 'fishCaughts')
        );
    }
}
