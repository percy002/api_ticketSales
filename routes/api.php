<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\Api\AuthenticationController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [ClienteController::class, 'store']);

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::post('login', [AuthenticationController::class, 'store'])->name('login');

    Route::middleware('auth:api')->post('logout', [AuthenticationController::class, 'destroy']);
    Route::middleware('auth:api')->get('/user', [UserController::class, 'getUser']);
    
    Route::middleware('auth:api')->post('/pagar', [VentaController::class, 'store']);
    Route::middleware('auth:api')->get('/boletos', [VentaController::class, 'boletos']);
    Route::middleware('auth:api')->get('/ventas/{id}', [VentaController::class, 'ventasXusuario']);
    Route::middleware('auth:api')->get('/venta/{id}', [VentaController::class, 'show']);

  });
