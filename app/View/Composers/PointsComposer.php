<?php
namespace Xetaravel\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Xetaravel\Models\Arkshopplayer;

class PointsComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $player = null;

        if (Auth::user()) {
            $player = Arkshopplayer::where('SteamId', Auth::user()->steam_id)->first();
        }

        $points= 0;
        $hasLinkedSteam = false;
        if (!is_null($player)) {
            $points= $player->Points;
            $hasLinkedSteam = true;
        }

        $view->with([
            'playerPoints' => $points,
            'hasLinkedSteam' => $hasLinkedSteam
        ]);
    }
}
