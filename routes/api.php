<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

});
Route::middleware('jwt')->group(function () {
    Route::get('car', 'CarController@index');
    Route::get('logout', 'AuthController@logout');
    Route::resource('/category','CategoryController');
    Route::resource('/car','CarController');
    Route::resource('/brand','BrandController');
});


