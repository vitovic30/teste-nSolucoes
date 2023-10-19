<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Middleware\ValidateToken;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function() {
    Route::group(['middleware' => 'role_or_permission:admin'], function () {
        Route::get('clients', [ClientController::class, 'index']);
        Route::post('clients', [ClientController::class, 'store']);
    });
    Route::group(['middleware' => 'role_or_permission:user'], function () {
        Route::post('clients/charges', [ClientController::class, 'charge']);
        Route::post('clients/forma-pagamento', [ClientController::class, 'formaPagamento']);
        Route::post('clients/payment', [ClientController::class, 'payment']);
    });
});
