<?php

use App\Http\Controllers\Api\Auth\AuthApiController;
use App\Http\Controllers\Api\Budget\AccountController;
use App\Http\Controllers\Api\Budget\TransactionController;
use App\Http\Controllers\Api\Company\CompanyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);

//Route::group(['middleware' => 'auth:sanctum'], function () {
Route::get('transactions', [TransactionController::class, 'index']);
Route::post('transactions', [TransactionController::class, 'store']);
Route::get('accounts/{id}', [AccountController::class, 'show']);
Route::get('accounts', [AccountController::class, 'index']);
Route::get('companies', [CompanyController::class, 'index']);
//});
