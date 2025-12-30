<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;

class ReassignPurchaseRequisitions extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'requisitions:reassign
                            {--user-id= : ID del usuario que ha renunciado o está inactivo}
                            {--role= : Rol del usuario (reviewer, approver, authorizer)}
                            {--new-user-id= : ID del nuevo usuario asignado}
                            {--chain-id= : ID de la cadena de aprobación específica (opcional)}
                            {--reset : Regresar las requisiciones al estado inicial}
                            {--dry-run : Simular la reasignación sin guardar cambios}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Reasigna requisiciones de compra cuando un usuario de la cadena de aprobación está inactivo';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $userId = $this->option('user-id');
    $role = $this->option('role');
    $newUserId = $this->option('new-user-id');
    $chainId = $this->option('chain-id');
    $reset = $this->option('reset');
    $dryRun = $this->option('dry-run');

    // Validaciones
    if (!$userId || !$role || !$newUserId) {
      $this->error('Los parámetros --user-id, --role y --new-user-id son obligatorios');
      return 1;
    }

    if (!in_array($role, ['reviewer', 'approver', 'authorizer'])) {
      $this->error('El rol debe ser: reviewer, approver o authorizer');
      return 1;
    }

    // Verificar que el nuevo usuario existe
    $newUser = User::find($newUserId);
    if (!$newUser) {
      $this->error("El usuario con ID {$newUserId} no existe");
      return 1;
    }

    $this->info("Buscando requisiciones pendientes...");

    // Construir query de cadenas de aprobación
    $chainsQuery = PurchaseRequisitionApprovalChain::query();

    if ($chainId) {
      $chainsQuery->where('id', $chainId);
    } else {
      $chainsQuery->where($role . '_id', $userId);
    }

    $chains = $chainsQuery->get();

    if ($chains->isEmpty()) {
      $this->warn('No se encontraron cadenas de aprobación que coincidan con los criterios');
      return 0;
    }

    $this->info("Encontradas {$chains->count()} cadenas de aprobación");

    $totalRequisitions = 0;
    $affectedChains = [];

    foreach ($chains as $chain) {
      // Obtener requisiciones pendientes
      $pendingRequisitions = $chain->requisitions()
        ->whereIn('status', $this->getPendingStatusesByRole($role))
        ->get();

      if ($pendingRequisitions->isEmpty()) {
        continue;
      }

      $affectedChains[] = [
        'chain_id' => $chain->id,
        'count' => $pendingRequisitions->count(),
        'requisitions' => $pendingRequisitions->pluck('folio')->toArray()
      ];

      $totalRequisitions += $pendingRequisitions->count();
    }

    if ($totalRequisitions === 0) {
      $this->warn('No hay requisiciones pendientes que requieran reasignación');
      return 0;
    }

    // Mostrar resumen
    $this->table(
      ['Cadena ID', 'Requisiciones Afectadas', 'Folios'],
      collect($affectedChains)->map(function ($item) {
        return [
          $item['chain_id'],
          $item['count'],
          implode(', ', $item['requisitions'])
        ];
      })
    );

    $this->info("Total de requisiciones a reasignar: {$totalRequisitions}");

    if ($reset) {
      $this->warn("⚠ Las requisiciones serán regresadas al estado inicial");
    }

    if ($dryRun) {
      $this->warn('MODO DRY-RUN: No se realizarán cambios');
      return 0;
    }

    // Confirmar acción
    $confirmMessage = $reset
      ? "¿Desea reasignar el {$role} al usuario {$newUser->name} y REGRESAR las requisiciones al inicio?"
      : "¿Desea continuar con la reasignación del {$role} al usuario {$newUser->name}?";

    if (!$this->confirm($confirmMessage)) {
      $this->info('Operación cancelada');
      return 0;
    }

    // Realizar reasignación
    $updated = 0;
    $resetCount = 0;

    foreach ($chains as $chain) {
      if ($chain->updateApprovalRole($role, $newUserId)) {
        $updated++;

        // Si se solicitó reset, actualizar todas las requisiciones pendientes
        if ($reset) {
          $pendingRequisitions = $chain->requisitions()
            ->whereIn('status', $this->getPendingStatusesByRole($role))
            ->get();

          foreach ($pendingRequisitions as $requisition) {
            $requisition->resetToInitialState();
            $requisition->save();
            $resetCount++;
          }
        }
      }
    }

    $this->info("✓ Se actualizaron {$updated} cadenas de aprobación exitosamente");

    if ($reset) {
      $this->info("✓ Se regresaron {$resetCount} requisiciones al estado inicial");
      $this->info("✓ Las requisiciones serán revisadas desde el principio por {$newUser->name}");
    } else {
      $this->info("✓ {$totalRequisitions} requisiciones ahora serán procesadas por {$newUser->name}");
    }

    return 0;
  }

  /**
   * Obtiene los estados pendientes según el rol
   */
  protected function getPendingStatusesByRole(string $role): array
  {
    return match ($role) {
      'reviewer' => ['revisión'],
      'approver' => ['aprobado por revisor'],
      'authorizer' => ['aprobado por gerencia'],
      default => [],
    };
  }
}
