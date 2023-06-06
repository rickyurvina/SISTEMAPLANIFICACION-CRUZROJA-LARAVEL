<?php

use App\Http\Middleware\Azure\Azure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/**
 * 'guest' middleware applied to all routes
 *
 * @see \App\Providers\RouteServiceProvider::mapGuestRoutes
 */

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', 'Auth\LoginController@create')->name('login');
    Route::post('login', 'Auth\LoginController@store');
});

Route::get('/auth/azure', [Azure::class, 'azure'])->name('azure.login');
Route::get('/auth/callback', [Azure::class, 'azureCallback'])->name('azure.callback');

Route::get('/logout/azure/callback', [Azure::class, 'azureLogoutCallback']);
Route::get('/verifyAzureUser', 'Common\HomeController@verifyAzureUser')->name('common.verify-azure-user');

