<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
});


// Route::get('/profile', 'ProfileController@index');

Route::middleware('jwt')->group(function () {
    Route::group(['prefix' => 'admin-page', 'namespace' => 'AdminPage', 'middleware' => ['role']],function (){
        Route::resource('/categories','CategoryController');
        Route::resource('/brands','BrandController');
        Route::post('/car-upload-image/{id}','CarController@uploadImage');
    });

    Route::group(['prefix' => 'shop-owner-page', 'namespace' => 'ShopOwnerPage', 'middleware' => ['role-shop-owner']],function (){
        Route::resource('/shops','ShopController');
        Route::resource('/cars','CarController');
    });

    Route::get('/search','SearchController@search');
    Route::get('/cars','ShopOwnerPage\CarController@index');
    Route::get('/cars-shop/{id}','ShopOwnerPage\CarController@carsShop');
    Route::post('/checkout/{id}','TransactionController@checkout');
    Route::post('/cancel-order/{id}','OrderController@cancelOrder');
    Route::post('/cancel-transaction/{id}','TransactionController@cancelTransaction');
    Route::resource('/orders','OrderController');
    Route::resource('/transactions','TransactionController');
    Route::get('logout', 'AuthController@logout');
});

