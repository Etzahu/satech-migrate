<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\Health\Commands\ScheduleCheckHeartbeatCommand;
use Tapp\FilamentMailLog\Models\MailLog;

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
// Si se configura REVIEW_REMINDER_PING_URL (healthchecks.io, Oh Dear), avisa
// al terminar sin errores: ese servicio alerta cuando el ping no llega.
$reminderPingUrl = config('purchases.reminders.ping_url');

Schedule::command('purchases:remind-pending')
    ->weekdays()
    ->at('09:00')
    ->timezone('America/Mexico_City')
    ->pingOnSuccessIf(filled($reminderPingUrl), (string) $reminderPingUrl);

// Página de Salud: el latido prueba que el cron sigue vivo y los checks
// guardan el resultado que muestra el panel. Con SCHEDULE_HEARTBEAT_URL, el
// check del scheduler además le avisa cada minuto a un servicio externo, que
// alerta si el cron muere (desde dentro de la app nadie podría avisarlo).
Schedule::command(ScheduleCheckHeartbeatCommand::class)->everyMinute();
Schedule::command(RunHealthChecksCommand::class)->everyMinute();

// La bitácora de correos guarda cada correo completo, adjuntos incluidos: cada
// domingo se borra lo que pasa de MAIL_LOG_KEEP_DAYS.
Schedule::call(fn () => MailLog::query()
    ->where('created_at', '<', now()->subDays(config('filament-maillog.keep_for_days')))
    ->delete())
    ->name('Limpia la bitácora de correos')
    ->weeklyOn(0, '03:00')
    ->timezone('America/Mexico_City');
