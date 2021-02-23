<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Statut Routes
|--------------------------------------------------------------------------
*/
Route::domain('statut.ark-division.fr')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Regular Routes
    |--------------------------------------------------------------------------
    */
    //Route::group(['middleware' => ['permission:access.site,allowGuest']], function () {
        Route::get('/', 'PageController@index')->name('statut.page.index');
    //});
});
