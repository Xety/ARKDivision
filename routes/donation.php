<?php

use Illuminate\Support\Facades\Route;

$APP_DONATION_URL = 'donation.ark-division.fr';

if (env('APP_ENV') && env('APP_ENV') == 'local') {
    $APP_DONATION_URL = 'donation.arkdivision.io';
}

/*
|--------------------------------------------------------------------------
| Donation Routes
|--------------------------------------------------------------------------
*/
Route::domain($APP_DONATION_URL)->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Regular Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/', 'PageController@index')->name('donation.page.index');

    /*
    |--------------------------------------------------------------------------
    | Paypal Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'paypal'], function () {
        //
        Route::post('checkout', 'PaypalController@checkout')->name('donation.paypal.checkout');
        Route::get('redirect', 'PaypalController@redirect')->name('donation.paypal.redirect');
    });
});
