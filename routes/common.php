<?php

use Illuminate\Support\Facades\Route;

/**
 * 'common' middleware applied to all routes
 *
 * @see \App\Providers\RouteServiceProvider::mapCommonRoutes()
 */

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => [/*'can:read-home-panel', */'menu.common']], function () {
        Route::get('/', 'Common\HomeController@index')->name('common.home');
    });

    Route::get('companies/{company}/switch', 'Admin\CompanyController@switch')->name('companies.switch');

    Route::get('/geographic/search/{type?}', 'Common\CatalogGeographicClassifierController@search')->name('catalog.geographic.search');

    Route::get('/purchase/search/', 'Common\CatalogPurchaseController@search')->name('catalog.purchase.search');

});

Route::group(['prefix' => 'auth', 'middleware' => 'auth'], function () {
    Route::get('logout', 'Auth\LoginController@destroy')->name('logout');
    Route::get('/logout/azure', '\App\Http\Middleware\AppAzure@azurelogout')->name('azure.logout');
});
