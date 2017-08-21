<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('jwt.auth')->group(function () {
    Route::prefix('product')->group(function () {
        //
    });
});
Route::prefix('product')->group(function () {
    Route::get('/', 'ProductController@index');
});


Route::post('/register', 'TokenAuthController@register');
Route::post('/authenticate', 'TokenAuthController@authenticate');
Route::get('/authenticate/user', 'TokenAuthController@getAuthenticatedUser');
