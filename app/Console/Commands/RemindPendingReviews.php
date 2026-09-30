<?php

namespace App\Console\Commands;

use App\Mail\PendingReviewReminder;
use App\Services\PendingReviewReminderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Vuelve a avisar a cada responsable lo que tiene pendiente por revisar, en
 * cualquier nivel del flujo. Un correo por persona y solo a quien tiene algo.
 * Corre solo desde routes/console.php; a mano sirve con --dry-run para ver a
 * quién le llegaría sin mandar nada.
 */
class RemindPendingReviews extends Command
{
    protected $signature = 'purchases:remind-pending
                            {--dry-run : Muestra a quién le llegaría el recordatorio sin mandar correos}';

    protected $description = 'Recuerda por correo a cada responsable las órdenes y requisiciones que esperan su revisión';

    public function handle(PendingReviewReminderService $service): int
    {
        $result = $service->reminders();

        if ($result['unattended'] !== []) {
            $count = count($result['unattended']);

            $this->warn("{$count} ".($count === 1 ? 'pendiente no tiene' : 'pendientes no tienen').' a nadie activo que los reciba; los avisa purchases:flow-health.');
        }

        if ($result['reminders'] === []) {
            $this->info('Nadie tiene pendientes por revisar.');

            return self::SUCCESS;
        }

        $this->table(
            ['Para', 'Correo', 'Pendientes', 'Folios'],
            collect($result['reminders'])->map(fn (array $reminder) => [
                $reminder['user']->name,
                $reminder['user']->email,
                count($reminder['items']),
                collect($reminder['items'])->pluck('folio')->implode(', '),
            ])->all()
        );

        if ($this->option('dry-run')) {
            $this->comment('Modo de prueba: no se mandó ningún correo.');

            return self::SUCCESS;
        }

        $failed = 0;

        // Un envío que falla no debe dejar sin recordatorio a los demás.
        foreach ($result['reminders'] as $reminder) {
            try {
                Mail::to($reminder['user']->email)->send(new PendingReviewReminder($reminder['user'], $reminder['items']));
            } catch (Throwable $exception) {
                report($exception);
                $failed++;

                $this->error("No se pudo mandar a {$reminder['user']->email}: {$exception->getMessage()}");
            }
        }

        $sent = count($result['reminders']) - $failed;

        $this->info("Recordatorios enviados: {$sent}.");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
