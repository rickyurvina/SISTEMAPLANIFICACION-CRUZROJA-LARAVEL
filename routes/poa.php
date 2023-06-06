<?php

use Illuminate\Support\Facades\Route;

/**
 * 'poa' middleware applied to all routes
 *
 * @see \App\Providers\RouteServiceProvider::mapPoaRoutes()
 */

Route::group(['prefix' => 'poa'], function () {

    Route::resource('poas', 'Poa\PoaController')->except('index');
    Route::get('poas', 'Poa\PoaController@index')->name('poa.poas');
    Route::get('poasChangeControl/{poaId?}', 'Poa\PoaController@changeControl')->name('poa.change_control');
    Route::get('poasConfig/{poaId?}', 'Poa\PoaController@config')->name('poa.config');
    Route::post('create/{year?}', 'Poa\PoaController@store')->name('poa.create');
    Route::get('replicate/{poaId}', 'Poa\PoaController@replicate')->name('poa.replicate');
    Route::get('goalChangeRequest', 'Poa\PoaController@goalChangeRequest')->name('poa.goal_change_request');
    Route::get('manageCatalogActivities', 'Poa\PoaController@manageCatalogActivities')->name('poa.manage_catalog_activities');
    Route::delete('deleteCatalogActivities/{id}', 'Poa\PoaController@deleteCatalogActivities')->name('poa.delete_catalog_activities');
    Route::get('budget/{poa}', 'Poa\PoaController@poaBudget')->name('poa.budget');

    /*rutas de reportes del POA*/
    Route::get('reports/index/{poaId?}', 'Poa\PoaReportController@index')->name('poa.reports.index');
    Route::get('reports/report-objectives', 'Poa\PoaReportController@reportObjectives')->name('poa.reports.report_objectives');;
    Route::get('reports/goals/{poaId?}', 'Poa\PoaReportController@goals')->name('poa.reports.goals');
    Route::get('reports/activity-status/{poaId?}', 'Poa\PoaReportController@activityStatus')->name('poa.reports.activity_status');
    Route::get('reports/activity-status-export/{poaId?}', 'Poa\PoaReportController@exportActivityStatus')->name('poa.reports.activity_status.export');
    Route::get('reports/showActivities/{poaId?}', 'Poa\PoaReportController@showActivitiesReport')->name('poa.reports.showActivitiesReport');
    Route::get('reports/showEvaluation', 'Poa\PoaReportController@showEvaluationReport')->name('poa.reports.showEvaluationReport');
    Route::resource('poas.activities', 'Poa\ActivityController')->shallow();
    Route::get('rescheduling/{poaId}', 'Poa\PoaController@rescheduling')->name('poa.rescheduling');
    Route::delete('/destroy/rescheduling/{id}', 'Poa\PoaController@deleteRescheduling')->name('poa.delete_rescheduling');

    //settings
    Route::get('/configuration/thresholds', 'Poa\PoaController@configurationThreshold')->name('poa.config_threshold');

    //budget
    Route::group(['prefix' => 'budget'], function () {
        Route::get('/expenses/activity/{activity}', 'Poa\ActivityController@expensesPoaActivity')->name('poa.expenses_activity');
        Route::delete('/destroy/expense/poa/{accountId}/{activityId}', 'Poa\ActivityController@deleteExpenseActivityPoa')->name('poa.expenses_delete');

    });

});
Route::group(['prefix' => 'piat'], function () {
//piat
    Route::get('reschedulingPiatActivity/{piat}', 'Piat\PiatController@showReschedulings')->name('piat.piat_rescheduling');
    Route::delete('deleteReschedulingPiatActivity/{id}', 'Piat\PiatController@deleteRescheduling')->name('piat.delete_piat_rescheduling');
    Route::get('/report/piat/{activityPiatReport}', 'Piat\PiatController@reportPiat')->name('piat.reportPiat');
});
