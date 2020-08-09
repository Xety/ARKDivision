<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::domain(env('APP_STATUT_URL'))->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Regular Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['permission:access.site,allowGuest']], function () {
        Route::get('/', 'PageController@index')->name('statut.page.index');
    });
});
