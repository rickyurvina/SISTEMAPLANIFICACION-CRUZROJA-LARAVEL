<?php

use Illuminate\Support\Facades\Route;

/**
 * 'process' middleware applied to all routes
 *
 * @see \App\Providers\RouteServiceProvider::mapProcessRoutes()
 */

Route::group(['prefix' => 'process'], function () {
    Route::resource('processes', 'Process\ProcessController')->except('show');
    Route::get('/{department}/showProcess/', 'Process\ProcessController@showProcess')->name('process.showProcess');
    Route::get('/{process}/showInformation/{page}/', 'Process\ProcessController@showInformation')->name('process.showInformation');
    Route::get('/{process}/showRisks/{page}/', 'Process\ProcessController@showRisks')->name('process.showRisks');
    Route::get('/{process}/showPlanChanges/{page}/', 'Process\ProcessController@showPlanChanges')->name('process.showPlanChanges');
    Route::get('/{process}/showFiles/{page}/', 'Process\ProcessController@showFiles')->name('process.showFiles');
    Route::get('/{process}/showIndicators/{page}/', 'Process\ProcessController@showIndicators')->name('process.showIndicators');
    Route::get('/{process}/showActivities/{page}/', 'Process\ProcessController@showActivities')->name('process.showActivities');
    Route::get('/{process}/showConformities/{page}/', 'Process\ProcessController@showConformities')->name('process.showConformities');

    Route::group(['prefix' => 'catalogs'], function () {
        Route::view('/', 'modules.process.catalogs.index')->name('process.catalogs');
        Route::resource('generated_services', 'Process\Catalogs\GeneratedServiceController');

    });
    Route::group(['prefix' => 'activities'], function () {
        Route::delete('/destroy/activityProcess/{id}/{page}/', 'Process\ActivityController@destroyActivity')->name('activityProcess.delete');
    });
    Route::group(['prefix' => 'reports'], function () {
        Route::view('/', 'modules.process.reports.index')->name('process.reports');
        Route::get('/{process}/reports/{page}/', 'Process\ProcessReportController@index')->name('process.reportsIndex');
        Route::get('/reports/nonConformitiesReport', 'Process\ProcessReportController@nonConformitiesReport')->name('process.nonConformitiesReport');
    });

    Route::group(['prefix' => 'planChanges'], function () {
        Route::delete('/destroy/planChange/{id}/{page}/', 'Process\ProcessPlanChangesController@destroy')->name('planChanges.delete');
        Route::get('/{processPlanChanges}/edit/{subMenu}/{page}/', 'Process\ProcessPlanChangesController@edit')->name('planChanges.edit');
    });

    Route::group(['prefix' => 'nonConformities'], function () {
        Route::delete('/destroy/nonConformity/{id}/{page}/', 'Process\NonConformitiesController@destroy')->name('nonConformities.delete');
        Route::get('/{nonConformities}/edit/{subMenu}/{page}/', 'Process\NonConformitiesController@edit')->name('nonConformities.edit');
    });
});