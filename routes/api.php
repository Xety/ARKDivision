<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::domain(env('APP_API_URL'))->group(function () {
    Route::middleware('auth:api')->group(function () {
        /*
        |--------------------------------------------------------------------------
        | Servers Routes
        |--------------------------------------------------------------------------
        */
        Route::apiResource('server', 'ServerController');

        Route::put('server/{slug}/status/', 'ServerStatusController@update')
            ->name('server.status.update');

        /*
        |--------------------------------------------------------------------------
        | BotUpdater Routes
        |--------------------------------------------------------------------------
        */
        Route::get('botupdater/membre', 'BotUpdaterController@index')->name('botupdater.membre.index');
    });
});
