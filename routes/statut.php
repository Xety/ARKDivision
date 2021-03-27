<?php

use Illuminate\Http\Request;

$APP_STATUT_URL = 'statut.ark-division.fr';

if (env('APP_ENV') && env('APP_ENV') == 'local') {
    $APP_STATUT_URL = 'statut.arkdivision.io';
}

/*
|--------------------------------------------------------------------------
| Statut Routes
|--------------------------------------------------------------------------
*/
Route::domain($APP_STATUT_URL)->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Regular Routes
    |--------------------------------------------------------------------------
    */
    //Route::group(['middleware' => ['permission:access.site,allowGuest']], function () {
        Route::get('/', 'PageController@index')->name('statut.page.index');
    //});
});
