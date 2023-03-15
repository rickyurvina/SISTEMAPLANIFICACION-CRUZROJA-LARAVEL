<?php

use Illuminate\Support\Facades\Route;

/**
 * 'admin' middleware applied to all routes
 *
 * @see \App\Providers\RouteServiceProvider::mapAdminRoutes()
 */


Route::get('profile/{user}', 'Auth\UserController@show')->name('profile');
Route::group(['prefix' => 'admin'], function () {

    Route::get('/', 'Admin\HomeController@index')->name('admin.home');
    Route::get('/administrativeTasks', 'AdministrativeTasks\AdministrativeTaskController@indexAdmin')->name('admin.administrativeTasks');
    Route::delete('/destroy/administrativeTasks/{id}', 'AdministrativeTasks\AdministrativeTaskController@destroyAdmin')->name('admintaskAdmin.delete');
    Route::resource('users', 'Auth\UserController')->except('show');
    Route::resource('roles', 'Auth\RoleController')->except('show');
    Route::resource('companies', 'Admin\CompanyController');
    Route::resource('departments', 'Admin\DepartmentController')->except('show');
    Route::group(['prefix' => 'catalogs'], function () {
        Route::view('/', 'modules.admin.catalogs.index')->name('admin.catalogs');
        Route::resource('/indicators/thresholds', 'Indicators\Thresholds\ThresHoldController')->only(['index']);
        Route::resource('/indicators/indicatorUnits', 'Indicators\Units\IndicatorUnitController')->only(['index']);
        Route::resource('/indicators/indicatorSources', 'Indicators\Sources\IndicatorSourceController')->only(['index']);
        Route::resource('perspectives', 'Admin\PerspectiveController')->only(['index']);
    });
});