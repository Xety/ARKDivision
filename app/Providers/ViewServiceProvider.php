<?php
namespace Xetaravel\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Xetaravel\View\Composers\NotificationsComposer;

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
    }
}
