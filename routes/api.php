<?php

Route::middleware('jwt.auth')->group(function () {
    Route::prefix('product')->group(function () {
        Route::post('/', 'ProductController@store');
    });
});
Route::prefix('product')->group(function () {
    Route::get('/', 'ProductController@index');
});


Route::post('/register', 'TokenAuthController@register');
Route::post('/authenticate', 'TokenAuthController@authenticate');
Route::get('/authenticate/user', 'TokenAuthController@getAuthenticatedUser');
