<?php

use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {

    Route::post('login', 'AuthController@login');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::post('payload', 'AuthController@payload');

});
Route::group(['middleware' => ['jwt']],
     function () { 
         Route::get('car', 'CarController@index');
         Route::get('logout', 'AuthController@logout');
});


