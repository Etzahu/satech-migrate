<?php

namespace App\Console\Commands;

use App\Mail\FlowHealthReport;
use App\Models\User;
use App\Services\FlowHealthService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

/**
 * Revisión diaria del flujo: avisa por correo de los niveles que nadie puede
 * responder. Corre sola desde routes/console.php; a mano sirve con --dry-run
 * para ver qué saldría sin mandar nada.
 */
class ReportFlowHealth extends Command
{
    protected $signature = 'purchases:flow-health
                            {--dry-run : Muestra el resultado sin mandar el correo}';

    protected $description = 'Avisa por correo de los roles del flujo sin titular activo y de lo que espera a una cuenta inactiva';

    public function handle(FlowHealthService $service): int
    {
        $report = $service->report();

        if ($report['vacant_roles'] === [] && $report['inactive'] === []) {
            $this->info('Todos los niveles del flujo tienen a alguien activo que los responda.');

            return self::SUCCESS;
        }

        $this->printReport($report);

        if ($this->option('dry-run')) {
            $this->comment('Modo de prueba: no se mandó el correo.');

            return self::SUCCESS;
        }

        $recipients = $this->recipients();

        if ($recipients === []) {
            $this->error('No hay a quién mandar el aviso: define FLOW_ALERT_RECIPIENTS o asigna super_admin a alguien activo.');

            return self::FAILURE;
        }

        Mail::to($recipients)->send(new FlowHealthReport($report));

        $this->info('Aviso enviado a '.implode(', ', $recipients).'.');

        return self::SUCCESS;
    }

    /**
     * Los correos configurados o, si no hay, los super_admin activos.
     *
     * @return array<int, string>
     */
    private function recipients(): array
    {
        $configured = config('purchases.flow_alerts.recipients', []);

        if ($configured !== []) {
            return $configured;
        }

        return User::withRole('super_admin')
            ->where('active', 1)
            ->pluck('email')
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $report
     */
    private function printReport(array $report): void
    {
        if ($report['vacant_roles'] !== []) {
            $this->warn('Roles sin titular activo');
            $this->table(
                ['Rol', 'Cubre', 'Pendientes'],
                collect($report['vacant_roles'])->map(fn (array $role) => [
                    $role['role'],
                    $role['label'],
                    collect($role['items'])->pluck('folio')->implode(', ') ?: '—',
                ])->all()
            );
        }

        if ($report['inactive'] !== []) {
            $this->warn('Pendientes que esperan a una cuenta inactiva');
            $this->table(
                ['Espera a', 'Documento', 'Folio', 'Nivel', 'Días'],
                collect($report['inactive'])->flatMap(fn (array $group) => collect($group['items'])->map(fn (array $item) => [
                    $group['name'],
                    $item['type'],
                    $item['folio'],
                    $item['level'],
                    $item['days'],
                ]))->all()
            );
        }
    }
}
