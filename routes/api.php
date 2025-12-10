<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PurchaseProviderController;

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

// Rutas para proveedores y usuarios - API v1 (sin middleware)
Route::prefix('v1')->group(function () {
    // Proveedores
    Route::get('/providers', [PurchaseProviderController::class, 'index']);
    Route::post('/providers', [PurchaseProviderController::class, 'store']);
    Route::get('/providers/{id}', [PurchaseProviderController::class, 'show']);
    
    // Usuarios
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
});
