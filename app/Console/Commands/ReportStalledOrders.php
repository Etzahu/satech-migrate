<?php

namespace App\Console\Commands;

use App\Services\StalledOrderService;
use Illuminate\Console\Command;

/**
 * Reporte de antigüedad de las órdenes de compra detenidas.
 *
 * Complementa a `requisitions:detect-blocked`, que mira el lado de las
 * requisiciones y solo detecta el caso del usuario dado de baja. Aquí importa
 * además el tiempo: una orden puede llevar tres semanas parada con un
 * responsable perfectamente activo.
 */
class ReportStalledOrders extends Command
{
    protected $signature = 'orders:report-stalled
                            {--company-id= : ID de la compañía (opcional)}
                            {--esperando : Solo las que esperan una decisión, no las del comprador}
                            {--problemas : Solo las que además tienen un responsable inactivo o un rol vacío}';

    protected $description = 'Lista las órdenes de compra detenidas más allá del umbral de su estado';

    public function handle(StalledOrderService $service): int
    {
        $companyId = $this->option('company-id');

        $filas = $service->stalled($companyId ? (int) $companyId : null);

        if ($this->option('esperando')) {
            $filas = $filas->where('esperando_decision', true);
        }

        if ($this->option('problemas')) {
            $filas = $filas->whereNotNull('problema');
        }

        if ($filas->isEmpty()) {
            $this->info('No hay órdenes detenidas con los filtros indicados.');

            return self::SUCCESS;
        }

        $this->table(
            ['Folio', 'Estado', 'Días', 'Umbral', 'Gerencia', 'Espera a', 'Problema'],
            $filas->map(fn (array $fila) => [
                $fila['folio'],
                $fila['estado'],
                $fila['dias'],
                $fila['umbral'],
                $fila['gerencia'] ?? '—',
                $fila['responsables'] === [] ? '—' : implode(', ', $fila['responsables']),
                $fila['problema'] ?? '',
            ])->all()
        );

        $esperando = $filas->where('esperando_decision', true)->count();
        $conProblema = $filas->whereNotNull('problema')->count();

        $this->newLine();
        $this->line("Detenidas: {$filas->count()}  ·  esperando decisión: {$esperando}  ·  con responsable inactivo o rol vacío: {$conProblema}");

        return $conProblema > 0 ? self::FAILURE : self::SUCCESS;
    }
}
