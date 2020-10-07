<?php

/*
|--------------------------------------------------------------------------
| Regular Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['permission:access.site,allowGuest']], function () {
    Route::get('/', 'PageController@index')->name('page.index');
});

Route::group(['middleware' => ['auth', 'permission:show.banished']], function () {
    Route::get('banished', 'PageController@banished')->name('page.banished');
});

/*
|--------------------------------------------------------------------------
| Socialite Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'auth',
    'namespace' => 'Auth',
    'middleware' => 'permission:access.site,allowGuest'
], function () {
    Route::get('{driver}/redirect', 'SocialiteController@redirectToProvider')
        ->name('auth.driver.redirect');
    Route::get('{driver}/callback', 'SocialiteController@handleProviderCallback')
        ->name('auth.driver.callback');
    Route::get('{driver}/register/form', 'SocialiteController@showRegistrationForm')
        ->name('auth.driver.register');
    Route::post('{driver}/register/validate', 'SocialiteController@register')
        ->name('auth.driver.register.validate');
});

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'users', 'middleware' => ['permission:access.site,allowGuest']], function () {

    Route::get('profile/@{slug}', 'UserController@show')->name('users.user.show');
    Route::get('/', 'UserController@index')->name('users.user.index');

    // Auth Namespace
    Route::group(['namespace' => 'Auth'], function () {
        // Authentication Routes
        Route::get('login', 'LoginController@showLoginForm')->name('users.auth.login');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('users.auth.logout');

        // Registration Routes
        Route::get('register', 'RegisterController@showRegistrationForm')->name('users.auth.register');
        Route::post('register', 'RegisterController@register');

        // Password Reset Routes
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')
            ->name('users.auth.password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')
            ->name('users.auth.password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')
            ->name('users.auth.password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset')
            ->name('users.auth.password.handlereset');
    });

    // Auth Middleware
    Route::group(['middleware' => ['auth']], function () {
        // User Routes
        Route::get('settings', 'UserController@showSettingsForm')->name('users.user.settings');
        Route::put('settings', 'UserController@update');
        //Route::delete('delete', 'UserController@delete')->name('users.user.delete');

        // Account Routes
        Route::get('account', 'AccountController@index')->name('users.account.index');
        Route::put('account', 'AccountController@update')->name('users.account.update');

        // Social Routes
        Route::get('social', 'SocialController@index')->name('users.social.index');

        Route::get('social/discord', 'SocialController@discord')->name('users.social.discord');
        Route::get('social/discordcallback', 'SocialController@discordCallback')->name('users.social.discordcallback');

        Route::get('social/steam', 'SocialController@steam')->name('users.social.steam');
        Route::get('social/steamcallback/{id}', 'SocialController@steamCallback')->name('users.social.steamcallback');

        Route::delete('social/delete/{type}', 'SocialController@delete')->name('users.social.delete');

        // Rewards
        Route::get('reward', 'RewardController@index')->name('users.reward.index');
        Route::post('reward/claim', 'RewardController@claim')->name('users.reward.claim');
        Route::post('reward/markasread', 'RewardController@markAsRead')->name('users.reward.markasread');

        // Notification Routes
        Route::get('notification', 'NotificationController@index')
            ->name('users.notification.index');
        Route::post('notification/markasread', 'NotificationController@markAsRead')
            ->name('users.notification.markasread');
        Route::post('notification/markAllAsRead', 'NotificationController@markAllAsRead')
            ->name('users.notification.markallasread');
        Route::delete('notification/delete/{slug?}', 'NotificationController@delete')
            ->name('users.notification.delete');
    });
});
