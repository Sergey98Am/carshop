<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

});

// Route::get('/profile', 'ProfileController@index');

Route::middleware('jwt')->group(function () {
    // Route::post('get_user_details', 'AuthController@get_user_details');
    Route::get('car', 'CarController@index');
    Route::get('logout', 'AuthController@logout');
    Route::resource('/category','CategoryController');
    Route::resource('/cars','CarController');
    Route::resource('/brand','BrandController');
});


