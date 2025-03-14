<?php
namespace Xetaravel\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Xetaravel\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern('id', '[0-9]+');

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        // Statut subdomain
        Route::group([
            'middleware' => 'web',
            'namespace' => 'Xetaravel\Http\Controllers\Statut',
        ], function ($router) {
            require base_path('routes/statut.php');
        });

        // Donation subdomain
        Route::group([
            'middleware' => 'web',
            'namespace' => 'Xetaravel\Http\Controllers\Donation',
        ], function ($router) {
            require base_path('routes/donation.php');
        });

        // Discuss subdomain
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace ,
        ], function ($router) {
            require base_path('routes/web.php');
            require base_path('routes/admin.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => 'Xetaravel\Http\Controllers\API',
            'prefix' => 'v1',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }
}
