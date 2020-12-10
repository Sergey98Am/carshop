<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
});
Route::get('/countries','AuthController@countries');
Route::get('/categories','CategoryController@index');
Route::get('/limited-categories','CategoryController@limitedCategories');
Route::get('/brands','BrandController@index');
Route::get('/limited-brands','BrandController@limitedBrands');
Route::get('/shops','ShopController@index');
Route::get('/cars','CarController@index');
Route::get('/cars/{id}','CarController@show');
Route::get('/recommended-shops','ShopController@recommendedShops');
Route::get('/recommended-cars','CarController@recommendedCars');


Route::middleware('jwt')->group(function () {
    Route::group(['prefix' => 'admin', 'middleware' => ['role']],function (){
        Route::resource('/categories','CategoryController');
        Route::resource('/brands','BrandController');
    });

    Route::group(['prefix' => 'shop-owner', 'middleware' => ['role-shop-owner']],function (){
        Route::resource('/shops','ShopController');
        Route::resource('/cars','CarController');
    });
    Route::post('/check-token','AuthController@checkToken');
    Route::get('/profile','AuthController@profile');
    Route::get('/search','CarController@search');
    Route::get('/cars/shop/{id}','CarController@carsShop');
    Route::post('/checkout/{id}','TransactionController@checkout');
    Route::post('/cancel-order/{id}','OrderController@cancelOrder');
    Route::post('/cancel-transaction/{id}','TransactionController@cancelTransaction');
    Route::resource('/orders','OrderController');
    Route::post('/orders','OrderController@add');
    Route::resource('/transactions','TransactionController');
    Route::get('/logout', 'AuthController@logout');
});
