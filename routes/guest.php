<?php

use Illuminate\Support\Facades\Route;

/**
 * 'guest' middleware applied to all routes
 *
 * @see \App\Providers\RouteServiceProvider::mapGuestRoutes
 */

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', 'Auth\LoginController@create')->name('login');
    Route::post('login', 'Auth\LoginController@store');

//
//    Route::get('forgot', 'Auth\Forgot@create')->name('forgot');
//    Route::post('forgot', 'Auth\Forgot@store');
//
//    //Route::get('reset', 'Auth\Reset@create');
//    Route::get('reset/{token}', 'Auth\Reset@create')->name('reset');
//    Route::post('reset', 'Auth\Reset@store')->name('reset.store');

});

//Route::get('/login/azure', '\App\Http\Middleware\AppAzure@azure')->name('azure.login');
//Route::get('/login/azurecallback', '\App\Http\Middleware\AppAzure@azurecallback')->name('azure.callback');
