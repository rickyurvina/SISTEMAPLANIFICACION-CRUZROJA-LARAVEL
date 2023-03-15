<?php

use Illuminate\Support\Facades\Route;

/**
 * 'indicator' middleware applied to all routes
 *
 * @see \App\Providers\RouteServiceProvider::mapIndicatorRoutes()
 */


Route::group(['prefix' => 'indicator'], function () {

    Route::get('/', 'Indicators\Indicator\IndicatorController@index')->name('indicator.home');
    Route::resource('indicators', 'Indicators\Indicator\IndicatorController');
    Route::get('indicators\progressReport\{id}', 'Indicators\Indicator\IndicatorController@progressReport')->name('indicators.progress_report');

});