<?php
namespace Xetaravel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RewardsMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If the rewards system is disabled and the user is not admin.
        if (!config('settings.user.rewards.enabled') && Auth::user()->level() < 4) {
            return redirect()
                        ->route('page.index')
                        ->with('danger', 'Le système de récompenses est temporairement désactivé.');
        }

        // If the rewards system is disabled and the user is admin.
        if (!config('settings.user.rewards.enabled') && Auth::user()->level() >= 4) {
            Session::flash('danger', 'Le système de récompenses est actuellement désactivé.');
        }

        return $next($request);
    }
}
