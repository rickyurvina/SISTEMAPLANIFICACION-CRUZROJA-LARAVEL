<?php

use Illuminate\Support\Facades\Route;

/**
 * 'admin' middleware applied to all routes
 *
 * @see \App\Providers\RouteServiceProvider::mapRiskRoutes()
 */

Route::group(['prefix' => 'risk'], function () {
    Route::get('/', 'Risks\Risk\RiskController@index')->name('risk.home');
    Route::resource('risks', 'Risks\Risk\RiskController')->except('show');
});