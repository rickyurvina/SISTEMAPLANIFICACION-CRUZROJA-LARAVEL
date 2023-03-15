<?php

use App\Http\Controllers\Strategy\MeasureController;
use App\Http\Controllers\Strategy\PlanController;
use Illuminate\Support\Facades\Route;

/**
 * 'strategy' middleware applied to all routes
 *
 * @see \App\Providers\RouteServiceProvider::mapStrategyRoutes()
 */

Route::group(['prefix' => 'strategy'], function () {

    Route::get('/', 'Strategy\HomeController@index')->name('strategy.home');
    Route::get('/show/{id}/{type}', 'Strategy\HomeController@showDetail')->name('show.strategy.home');

    Route::resource('templates', 'Strategy\TemplateController');

    Route::resource('plans', 'Strategy\PlanController');

    Route::delete('plans/{plan}/delete', 'Strategy\PlanController@destroy')->name('plans.delete');
    Route::delete('plan/{plan}/delete', 'Strategy\PlanController@delete')->name('plan.delete');

    Route::get('plans/{plan}/details', 'Strategy\PlanController@detail')->name('plans.detail');
    Route::get('plans/{plan}/details-index', 'Strategy\PlanController@listDetails')->name('plans.details');

    Route::get('plans/indicators/{planDetailId?}',[PlanController::class, 'showPlanDetailsIndicators'])->name('plan_details.indicators');

    Route::get('plans/{plan}/articulations', 'Strategy\PlanController@articulations')->name('plans.articulations');
    Route::get('plans/detail/{id}/edit', 'Strategy\PlanController@detailEdit')->name('plans.detail.edit');
    Route::post('plans/detail/{id}/update', 'Strategy\PlanController@detailUpdate')->name('plans.detail.update');
    Route::get('report', 'Strategy\StrategyReportController@reportIndicators')->name('report.index');
    Route::get('report/structure/poa', 'Strategy\StrategyReportController@structurePoaUpload')->name('report.structure_poa');
    Route::get('report/structure/poa/excel', 'Strategy\StrategyReportController@structurePoaExcel')->name('report.structure_excel');
    Route::get('report_articulations', 'Strategy\StrategyReportController@reportArticulations')->name('report_articulations.index');

    Route::get('report/poa', 'Strategy\StrategyReportController@exportPdf')->name('report.poa');

    Route::get('measures', 'Strategy\MeasureController@index')->name('index.measure.strategy');
    Route::get('measures/update/periods', 'Strategy\MeasureController@updateByPeriod')->name('index.measure.strategy-period');
    Route::get('measures/update/frequency', 'Strategy\MeasureController@updateByFrequency')->name('index.measure.strategy-frequency');
    Route::delete('measures/{measure}', 'Strategy\MeasureController@destroy')->name('destroy.measure.strategy');
});