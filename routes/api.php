<?php

use Illuminate\Support\Facades\Route;

Route::post('/checkout/{id}','TransactionController@store');
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

});


// Route::get('/profile', 'ProfileController@index');

Route::middleware('jwt')->group(function () {
    Route::group(['prefix' => 'admin-page', 'namespace' => 'AdminPage', 'middleware' => ['role']],function (){
        Route::resource('/categories','CategoryController');
        Route::resource('/brands','BrandController');
        Route::resource('/cars','CarController');
        Route::post('/car-upload-image/{id}','CarController@uploadImage');
    });

    Route::post('/checkout/{id}','TransactionController@checkout');
    Route::post('/cancel-transaction/{id}','TransactionController@cancelTransaction');
    Route::resource('/orders','OrderController');
    Route::resource('/transactions','TransactionController');
    Route::get('logout', 'AuthController@logout');
});


