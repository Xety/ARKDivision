<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::domain(env('APP_API_URL'))->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::post('twitch/eventsub/webhook', 'EventSubController@handleWebhook')
            ->name('twitch.evensub.webhook');

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
        | Users Routes
        |--------------------------------------------------------------------------
        */
        Route::put('user/discord/{id}', 'UserController@updateByDiscord')
            ->name('user.discord.update');
        Route::get('user/discord/{id}', 'UserController@getByDiscord')
            ->name('user.discord.get');

        /*
        |--------------------------------------------------------------------------
        | Paypal Routes
        |--------------------------------------------------------------------------
        */
        Route::get('paypal/user/{id}', 'PaypalController@getByUser')
            ->name('paypal.user.get');

        /*
        |--------------------------------------------------------------------------
        | Steamban Routes
        |--------------------------------------------------------------------------
        */
        Route::get('steamban/{id}', 'SteamBanController@index')
            ->name('steamban.get');
        Route::post('steamban/create', 'SteamBanController@create')
            ->name('steamban.create');
            Route::get('steamban/checkban/{id}', 'SteamBanController@checkBan')
            ->name('steamban.checkban.get');

        /*
        |--------------------------------------------------------------------------
        | Tickets Routes
        |--------------------------------------------------------------------------
        */
        Route::get('ticket/{id}', 'TicketController@index')
            ->name('ticket.get');
        Route::post('ticket/create', 'TicketController@create')
            ->name('ticket.create');
        Route::put('ticket/{id}', 'TicketController@update')
            ->name('ticket.update');
        Route::get('ticket/ticketmessage/{id}', 'TicketController@getByTicketMessage')
            ->name('ticket.ticketmessage.get');

        /*
        |--------------------------------------------------------------------------
        | Settings Routes
        |--------------------------------------------------------------------------
        */
        Route::get('setting', 'SettingController@index')
            ->name('setting.get');
        Route::put('setting', 'SettingController@update')
            ->name('setting.update');

        /*
        |--------------------------------------------------------------------------
        | Transactions Routes
        |--------------------------------------------------------------------------
        */
        Route::get('transaction/user/{id}', 'TransactionController@getByUser')
            ->name('transaction.user.get');

        /*
        |--------------------------------------------------------------------------
        | BotUpdater Routes
        |--------------------------------------------------------------------------
        */
        Route::get('botupdater/membre', 'BotUpdaterController@index')->name('botupdater.membre.index');
    });
});
