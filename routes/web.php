<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Regular Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['permission:access.site,allowGuest']], function () {
    Route::get('/', 'PageController@index')->name('page.index');

    Route::get('terms', 'PageController@terms')->name('page.terms');

    // Leaderboard
    Route::get('leaderboard', 'LeaderboardController@index')->name('leaderboard.index');
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

        // Email Verification Routes
        Route::get('email/verify/{hash}', 'VerificationController@show')
            ->name('users.auth.verification.notice');
        Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')
            ->name('users.auth.verification.verify');
        Route::post('email/resend', 'VerificationController@resend')
            ->name('users.auth.verification.resend');
    });

    // Auth Middleware
    Route::group(['middleware' => ['auth']], function () {
        // User Routes
        Route::get('account', 'UserController@account')->name('users.user.account');
        Route::put('settings', 'UserController@update')->name('users.user.settings');
        Route::get('transactions', 'UserController@transactions')->name('users.user.transactions');
        Route::get('member', 'UserController@member')->name('users.user.member');
        //Route::delete('delete', 'UserController@delete')->name('users.user.delete');

        // Coffres
        Route::get('coffre', 'CoffreController@index')->name('users.coffre.index');
        Route::post('coffre/claim', 'CoffreController@claim')->name('users.coffre.claim');

        // Account Routes
        Route::put('account', 'AccountController@update')->name('users.account.update');

        // Social Routes
        Route::get('social', 'SocialController@index')->name('users.social.index');
        Route::get('social/discord', 'SocialController@discord')->name('users.social.discord');
        Route::get('social/discordcallback', 'SocialController@discordCallback')->name('users.social.discordcallback');
        Route::get('social/twitch', 'SocialController@twitch')->name('users.social.twitch');
        Route::get('social/twitchcallback', 'SocialController@twitchCallback')->name('users.social.twitchcallback');
        Route::get('social/steam', 'SocialController@steam')->name('users.social.steam');
        Route::get('social/steamcallback/{id}', 'SocialController@steamCallback')->name('users.social.steamcallback');
        Route::delete('social/delete/{type}', 'SocialController@delete')->name('users.social.delete');

        // Rewards
        Route::middleware('rewards.maintenance')->group(function () {
            Route::get('reward', 'RewardController@index')->name('users.reward.index');
            Route::post('reward/claim', 'RewardController@claim')->name('users.reward.claim');
            Route::post('reward/markasread', 'RewardController@markAsRead')->name('users.reward.markasread');
        });

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
