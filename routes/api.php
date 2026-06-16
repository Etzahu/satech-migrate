<?php

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
