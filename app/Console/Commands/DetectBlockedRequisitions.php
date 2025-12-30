<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;

class DetectBlockedRequisitions extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'requisitions:detect-blocked
                            {--company-id= : ID de la compañía (opcional)}
                            {--export : Exportar resultados a CSV}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Detecta requisiciones bloqueadas por usuarios inactivos en la cadena de aprobación';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $companyId = $this->option('company-id');
    $export = $this->option('export');

    $this->info('Analizando requisiciones bloqueadas...');

    // Obtener cadenas con usuarios inactivos
    $chainsWithInactiveUsers = PurchaseRequisitionApprovalChain::query()
      ->with(['reviewer', 'approver', 'authorizer', 'requester'])
      ->get()
      ->filter(function ($chain) {
        return !empty($chain->getInactiveUsers());
      });

    if ($chainsWithInactiveUsers->isEmpty()) {
      $this->info('✓ No se encontraron cadenas de aprobación con usuarios inactivos');
      return 0;
    }

    $this->warn("Encontradas {$chainsWithInactiveUsers->count()} cadenas con usuarios inactivos");

    $blockedRequisitions = [];

    foreach ($chainsWithInactiveUsers as $chain) {
      $inactiveUsers = $chain->getInactiveUsers();

      // Obtener requisiciones pendientes
      $requisitions = $chain->requisitions()
        ->when($companyId, function ($query) use ($companyId) {
          $query->where('company_id', $companyId);
        })
        ->whereIn('status', [
          'revisión',
          'aprobado por revisor',
          'aprobado por gerencia',
          'revisión por almacén'
        ])
        ->get();

      foreach ($requisitions as $requisition) {
        $currentApprover = $requisition->getCurrentApprover();

        if ($currentApprover && $currentApprover->trashed()) {
          $blockedRequisitions[] = [
            'folio' => $requisition->folio,
            'status' => $requisition->status,
            'chain_id' => $chain->id,
            'blocked_role' => $this->getRoleByStatus($requisition->status),
            'inactive_user_id' => $currentApprover->id,
            'inactive_user_name' => $currentApprover->name,
            'requester' => $chain->requester?->name ?? 'N/A',
            'created_at' => $requisition->created_at->format('Y-m-d'),
            'days_blocked' => $requisition->updated_at->diffInDays(now()),
          ];
        }
      }
    }

    if (empty($blockedRequisitions)) {
      $this->info('✓ No hay requisiciones actualmente bloqueadas');
      return 0;
    }

    // Mostrar resultados
    $this->error("⚠ Encontradas " . count($blockedRequisitions) . " requisiciones bloqueadas");

    $this->table(
      ['Folio', 'Estado', 'Rol Bloqueado', 'Usuario Inactivo', 'Solicitante', 'Días Bloqueado'],
      collect($blockedRequisitions)->map(function ($item) {
        return [
          $item['folio'],
          $item['status'],
          $item['blocked_role'],
          $item['inactive_user_name'],
          $item['requester'],
          $item['days_blocked'],
        ];
      })
    );

    // Agrupar por cadena de aprobación
    $groupedByChain = collect($blockedRequisitions)->groupBy('chain_id');

    $this->newLine();
    $this->info('Resumen por cadena de aprobación:');

    foreach ($groupedByChain as $chainId => $items) {
      $chain = $chainsWithInactiveUsers->firstWhere('id', $chainId);
      $inactiveUsers = $chain->getInactiveUsers();

      $this->line("Cadena #{$chainId}: {$items->count()} requisiciones bloqueadas");

      foreach ($inactiveUsers as $role => $userId) {
        $user = $chain->{$role};
        $this->line("  - {$role}: {$user->name} (ID: {$userId}) [INACTIVO]");
      }

      $this->line("  Comando sugerido:");
      foreach ($inactiveUsers as $role => $userId) {
        $this->line("  php artisan requisitions:reassign --user-id={$userId} --role={$role} --new-user-id=<NUEVO_ID> --chain-id={$chainId}");
      }

      $this->newLine();
    }

    // Exportar a CSV si se solicita
    if ($export) {
      $filename = 'blocked_requisitions_' . now()->format('Y-m-d_His') . '.csv';
      $filepath = storage_path('app/' . $filename);

      $file = fopen($filepath, 'w');
      fputcsv($file, array_keys($blockedRequisitions[0]));

      foreach ($blockedRequisitions as $row) {
        fputcsv($file, $row);
      }

      fclose($file);

      $this->info("✓ Resultados exportados a: {$filepath}");
    }

    return 0;
  }

  /**
   * Determina el rol basado en el estado de la requisición
   */
  protected function getRoleByStatus(string $status): string
  {
    return match ($status) {
      'revisión' => 'reviewer',
      'aprobado por revisor' => 'approver',
      'aprobado por gerencia' => 'authorizer',
      'revisión por almacén' => 'warehouse',
      default => 'unknown',
    };
  }
}
