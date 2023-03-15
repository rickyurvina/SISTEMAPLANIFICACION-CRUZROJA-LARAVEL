<?php

use Illuminate\Support\Facades\Route;

/**
 * 'audit' middleware applied to all routes
 *
 * @see \App\Providers\RouteServiceProvider::mapAuditRoutes()
 */

Route::group(['prefix' => 'audit'], function () {

    Route::get('/', 'Audit\HomeController@index')->name('audit.home');

});