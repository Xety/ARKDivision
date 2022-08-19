<?php
namespace Xetaravel\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Xetaravel\View\Composers\NotificationsComposer;
use Xetaravel\View\Composers\PointsComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials._notifications', NotificationsComposer::class);

        View::composer('partials._points', PointsComposer::class);
    }
}
