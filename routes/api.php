<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

});

// Route::get('/profile', 'ProfileController@index');

Route::middleware('jwt')->group(function () {
    Route::group(['prefix' => 'admin-page', 'namespace' => 'AdminPage', 'middleware' => ['auth','role']],function (){
        Route::resource('/categories','CategoryController');
        Route::resource('/brands','BrandController');
        Route::resource('/cars','CarController');
        Route::post('/car-upload-image/{id}','CarController@uploadImage');
    });

    Route::resource('/orders','OrderController');
    Route::resource('/transactions','TransactionController');
    Route::post('/checkout/{id}','CheckoutController@store');
    Route::get('logout', 'AuthController@logout');
});


