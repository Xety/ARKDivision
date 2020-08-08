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
Route::domain(env('APP_API_URL'))->group(function () {
    //Route::get('/', 'PageController@index')->name('api.v1.page.index');
    /*Route::fallback(function () {
        return response()->json([
            'data' => [],
            'error' => 'Page not found!',
            'error_code' => 404,
            'version' => env('APP_API_VERSION')
        ], 404);
    });*/
    Route::middleware('auth:api')->group(function () {
        /*
        |--------------------------------------------------------------------------
        | Servers Routes
        |--------------------------------------------------------------------------
        */
        Route::apiResource('server', 'ServerController');

        Route::put('server/{slug}/status/', 'ServerStatusController@update')
            ->name('server.status.update');
    });
});
