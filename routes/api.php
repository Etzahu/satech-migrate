<?php

use App\Http\Controllers\Api\RrhhUserController;
use App\Http\Controllers\Api\RrhhWebhookController;
use App\Http\Middleware\VerifyRrhhWebhookSignature;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Rutas de máquina a máquina. Se cargan con el prefijo "/api".
|
*/

Route::post('webhooks/rrhh', RrhhWebhookController::class)
    ->middleware(VerifyRrhhWebhookSignature::class)
    ->name('api.webhooks.rrhh');

/*
|--------------------------------------------------------------------------
| Padrón de colaboradores (consumido por rrhh)
|--------------------------------------------------------------------------
|
| rrhh es la plataforma maestra de colaboradores: desde ahí se lista el
| padrón de este proyecto y se empuja la sincronización de los activos.
| Ambas rutas van firmadas con el mismo secret HMAC que los webhooks.
|
*/
Route::middleware(VerifyRrhhWebhookSignature::class)
    ->prefix('rrhh/users')
    ->name('api.rrhh.users.')
    ->group(function () {
        Route::post('inventory', [RrhhUserController::class, 'inventory'])->name('inventory');
        Route::post('sync', [RrhhUserController::class, 'sync'])->name('sync');
    });
