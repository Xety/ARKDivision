<?php
namespace Xetaravel\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Xetaravel\Events\Events\RewardDailyCoffre;
use Xetaravel\Models\Arkshopplayer;
use Xetaravel\Models\Reward;
use Xetaravel\Models\User;

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

        $firstDayOfNextMonth = Carbon::now();
        $firstDayOfNextMonth->modify('first day of next month');
        $firstDayOfNextMonth->hour(0);
        $firstDayOfNextMonth->minute(0);
        $firstDayOfNextMonth->second(0);

        return view('coffre.index', compact('breadcrumbs', 'days', 'now', 'nextClaimDate', 'firstDayOfNextMonth'));
    }

    /**
     * Claim a coffre.
     *
     * @return \Illuminate\Http\Response
     */
    public function claim()
    {
        $user = User::find(Auth::id());

        $day = $user->claimed_coffre_count_monthly;
        $nextClaimDay = $day +1;
        $days = config('division.coffres.max_days_claim');
        $now = Carbon::now();
        $nextClaimDate = Carbon::create($user->last_claimed_coffre)->addHours(24);

        // Check the next claim date.
        if ($nextClaimDate > $now) {
            return redirect()
                ->route('users.coffre.index')
                ->with(
                    'danger',
                    'Vous pourrez claim votre prochain coffre que le ' . $nextClaimDate->format('d-m-Y à H:i:s')
                );
        }

        // Check if the next claim is a bonus claim.
        $bonus = false;
        if (array_key_exists(
            'bonus_' . $nextClaimDay . '_days_points_amount',
            config('division.coffres.bonus_points')
        )) {
            $bonus = true;
        }

        // Get the bonus amount.
        $bonusType = null;
        if ($bonus == true) {
            $bonusType = config('division.coffres.bonus_points.' . 'bonus_' . $nextClaimDay . '_days_points_amount');
        }

        // Get the bonus reward
        $bonusReward = null;
        if (!is_null($bonusType)) {
            $bonusReward = Reward::where('type', 'Xetaravel\Events\Events\RewardDailyCoffreBonus')
                                                        ->where('rule', $bonusType)
                                                        ->first();
        }

        // Select the random reward.
        $reward = Reward::inRandomOrder()
                ->where('type', \Xetaravel\Events\Events\RewardDailyCoffre::class)
                ->first();

        // Dispatch the event
        event(new RewardDailyCoffre($user, $reward, $bonusReward));

        // Update the user
        $user->claimed_coffre_count_total = $user->claimed_coffre_count_total +1;
        $user->claimed_coffre_count_monthly = $user->claimed_coffre_count_monthly +1;
        $user->last_claimed_coffre = Carbon::now();

        // Update the bonus count field.
        if ($bonus) {
            $user->{'claimed_coffre_bonus_' . $nextClaimDay . '_count_total'}++;
        }
        $user->save();

        return redirect()
            ->route('users.coffre.index')
            ->with('success', "Vous venez de débloquer le reward <b>{$reward->name}</b> !");
    }
}
