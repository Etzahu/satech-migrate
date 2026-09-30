<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Avisa si un nivel del flujo se quedó sin nadie activo que lo responda. Solo
// manda correo cuando encuentra algo. Requiere el cron de `schedule:run`. La
// zona va fija para que no dependa de APP_TIMEZONE del servidor.
Schedule::command('purchases:flow-health')
    ->weekdays()
    ->at('08:00')
    ->timezone('America/Mexico_City');

// Le vuelve a avisar a cada responsable lo que tiene pendiente por revisar en
// cualquier nivel del flujo: un correo por persona, solo a quien tiene algo.
Schedule::command('purchases:remind-pending')
    ->weekdays()
    ->at('09:00')
    ->timezone('America/Mexico_City');
