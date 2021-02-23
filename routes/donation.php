<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Donation Routes
|--------------------------------------------------------------------------
*/
Route::domain('donation.ark-division.fr')->group(function () {

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

        Route::get('success', 'PaypalController@success')->name('donation.paypal.success');
    });
});
