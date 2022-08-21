<?php
namespace Xetaravel\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Xetaravel\Models\Arkshopplayer;

class CoffreController extends Controller
{
    /**
     * Show the Coffre page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->addCrumb('Coffres', route('users.coffre.index'));

        $days = config('division.coffres.max_days_claim');
        $now = Carbon::now();
        $nextClaimDate = Carbon::create(Auth::user()->last_claimed_coffre)->addHours(24);

        return view('coffre.index', compact('breadcrumbs', 'days', 'now', 'nextClaimDate'));
    }
}
