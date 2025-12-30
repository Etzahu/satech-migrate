<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;

class ReplaceUserInChains extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'requisitions:replace-user
                            {--old-user-id= : ID del usuario que se va o está inactivo}
                            {--new-reviewer-id= : ID del nuevo usuario para rol reviewer}
                            {--new-approver-id= : ID del nuevo usuario para rol approver}
                            {--new-authorizer-id= : ID del nuevo usuario para rol authorizer}
                            {--reset : Regresar las requisiciones pendientes al estado inicial}
                            {--dry-run : Simular sin guardar cambios}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Reemplaza un usuario en TODAS las cadenas de aprobación donde aparezca (reviewer, approver, authorizer)';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $oldUserId = $this->option('old-user-id');
    $newReviewerId = $this->option('new-reviewer-id');
    $newApproverId = $this->option('new-approver-id');
    $newAuthorizerId = $this->option('new-authorizer-id');
    $reset = $this->option('reset');
    $dryRun = $this->option('dry-run');

    // Validaciones
    if (!$oldUserId) {
      $this->error('El parámetro --old-user-id es obligatorio');
      return 1;
    }

    $oldUser = User::withTrashed()->find($oldUserId);
    if (!$oldUser) {
      $this->error("El usuario con ID {$oldUserId} no existe");
      return 1;
    }

    $this->info("Analizando usuario: {$oldUser->name} (ID: {$oldUserId})");
    $this->newLine();

    // Buscar en qué roles aparece el usuario
    $chainsAsReviewer = PurchaseRequisitionApprovalChain::where('reviewer_id', $oldUserId)->get();
    $chainsAsApprover = PurchaseRequisitionApprovalChain::where('approver_id', $oldUserId)->get();
    $chainsAsAuthorizer = PurchaseRequisitionApprovalChain::where('authorizer_id', $oldUserId)->get();

    $totalChains = $chainsAsReviewer->count() + $chainsAsApprover->count() + $chainsAsAuthorizer->count();

    if ($totalChains === 0) {
      $this->info('✓ El usuario no aparece en ninguna cadena de aprobación');
      return 0;
    }

    // Mostrar resumen
    $this->table(
      ['Rol', 'Cadenas', 'IDs de Cadenas'],
      [
        ['Reviewer (Revisa)', $chainsAsReviewer->count(), $chainsAsReviewer->pluck('id')->implode(', ') ?: 'N/A'],
        ['Approver (Aprueba)', $chainsAsApprover->count(), $chainsAsApprover->pluck('id')->implode(', ') ?: 'N/A'],
        ['Authorizer (Autoriza)', $chainsAsAuthorizer->count(), $chainsAsAuthorizer->pluck('id')->implode(', ') ?: 'N/A'],
      ]
    );

    // Contar requisiciones pendientes por rol
    $pendingByRole = $this->countPendingRequisitions($chainsAsReviewer, $chainsAsApprover, $chainsAsAuthorizer);

    if ($pendingByRole['total'] > 0) {
      $this->newLine();
      $this->warn("⚠ Requisiciones pendientes que serán afectadas:");
      $this->table(
        ['Rol', 'Estado', 'Cantidad', 'Folios'],
        array_filter([
          $pendingByRole['reviewer']['count'] > 0 ? ['Reviewer', 'revisión', $pendingByRole['reviewer']['count'], $pendingByRole['reviewer']['folios']] : null,
          $pendingByRole['approver']['count'] > 0 ? ['Approver', 'aprobado por revisor', $pendingByRole['approver']['count'], $pendingByRole['approver']['folios']] : null,
          $pendingByRole['authorizer']['count'] > 0 ? ['Authorizer', 'aprobado por gerencia', $pendingByRole['authorizer']['count'], $pendingByRole['authorizer']['folios']] : null,
        ])
      );
      $this->info("Total de requisiciones pendientes: {$pendingByRole['total']}");
    }

    // Validar que se proporcionaron los nuevos usuarios necesarios
    $replacements = [];

    if ($chainsAsReviewer->count() > 0) {
      if (!$newReviewerId) {
        $this->error('Se requiere --new-reviewer-id porque el usuario aparece como reviewer');
        return 1;
      }
      $replacements['reviewer'] = ['chains' => $chainsAsReviewer, 'new_user_id' => $newReviewerId];
    }

    if ($chainsAsApprover->count() > 0) {
      if (!$newApproverId) {
        $this->error('Se requiere --new-approver-id porque el usuario aparece como approver');
        return 1;
      }
      $replacements['approver'] = ['chains' => $chainsAsApprover, 'new_user_id' => $newApproverId];
    }

    if ($chainsAsAuthorizer->count() > 0) {
      if (!$newAuthorizerId) {
        $this->error('Se requiere --new-authorizer-id porque el usuario aparece como authorizer');
        return 1;
      }
      $replacements['authorizer'] = ['chains' => $chainsAsAuthorizer, 'new_user_id' => $newAuthorizerId];
    }

    // Validar que los nuevos usuarios existen
    foreach ($replacements as $role => $data) {
      $newUser = User::find($data['new_user_id']);
      if (!$newUser) {
        $this->error("El usuario con ID {$data['new_user_id']} para {$role} no existe");
        return 1;
      }
    }

    $this->newLine();

    if ($reset && $pendingByRole['total'] > 0) {
      $this->warn("⚠ Las {$pendingByRole['total']} requisiciones pendientes serán regresadas al estado inicial");
    }

    if ($dryRun) {
      $this->warn('MODO DRY-RUN: No se realizarán cambios');
      $this->newLine();
      $this->info('Cambios que se realizarían:');
      foreach ($replacements as $role => $data) {
        $newUser = User::find($data['new_user_id']);
        $this->line("  - {$role}: {$data['chains']->count()} cadenas → {$newUser->name}");
      }
      return 0;
    }

    // Confirmar acción
    $this->newLine();
    if (!$this->confirm("¿Desea continuar con el reemplazo del usuario {$oldUser->name} en {$totalChains} cadenas?")) {
      $this->info('Operación cancelada');
      return 0;
    }

    // Realizar reemplazos
    $updated = 0;
    $resetCount = 0;

    foreach ($replacements as $role => $data) {
      $newUser = User::find($data['new_user_id']);
      $this->info("Reemplazando {$role}...");

      foreach ($data['chains'] as $chain) {
        if ($chain->updateApprovalRole($role, $data['new_user_id'])) {
          $updated++;

          // Si se solicitó reset, actualizar requisiciones pendientes
          if ($reset) {
            $status = $this->getStatusByRole($role);
            $pendingRequisitions = $chain->requisitions()
              ->where('status', $status)
              ->get();

            foreach ($pendingRequisitions as $requisition) {
              $requisition->resetToInitialState();
              $requisition->save();
              $resetCount++;
            }
          }
        }
      }

      $this->info("  ✓ {$data['chains']->count()} cadenas actualizadas → {$newUser->name}");
    }

    $this->newLine();
    $this->info("✓ Se actualizaron {$updated} asignaciones en las cadenas de aprobación");

    if ($reset && $resetCount > 0) {
      $this->info("✓ Se regresaron {$resetCount} requisiciones al estado inicial");
    }

    $this->newLine();
    $this->info('🎉 Proceso completado exitosamente');

    return 0;
  }

  /**
   * Cuenta las requisiciones pendientes por rol
   */
  protected function countPendingRequisitions($chainsAsReviewer, $chainsAsApprover, $chainsAsAuthorizer): array
  {
    $reviewerPending = PurchaseRequisition::whereIn('approval_chain_id', $chainsAsReviewer->pluck('id'))
      ->where('status', 'revisión')
      ->get();

    $approverPending = PurchaseRequisition::whereIn('approval_chain_id', $chainsAsApprover->pluck('id'))
      ->where('status', 'aprobado por revisor')
      ->get();

    $authorizerPending = PurchaseRequisition::whereIn('approval_chain_id', $chainsAsAuthorizer->pluck('id'))
      ->where('status', 'aprobado por gerencia')
      ->get();

    return [
      'reviewer' => [
        'count' => $reviewerPending->count(),
        'folios' => $reviewerPending->pluck('folio')->implode(', ') ?: 'N/A'
      ],
      'approver' => [
        'count' => $approverPending->count(),
        'folios' => $approverPending->pluck('folio')->implode(', ') ?: 'N/A'
      ],
      'authorizer' => [
        'count' => $authorizerPending->count(),
        'folios' => $authorizerPending->pluck('folio')->implode(', ') ?: 'N/A'
      ],
      'total' => $reviewerPending->count() + $approverPending->count() + $authorizerPending->count()
    ];
  }

  /**
   * Obtiene el estado pendiente según el rol
   */
  protected function getStatusByRole(string $role): string
  {
    return match ($role) {
      'reviewer' => 'revisión',
      'approver' => 'aprobado por revisor',
      'authorizer' => 'aprobado por gerencia',
      default => '',
    };
  }
}
