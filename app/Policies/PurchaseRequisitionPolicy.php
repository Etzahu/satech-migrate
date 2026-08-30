<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PurchaseRequisition;
use App\Services\PurchaseInformedService;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseRequisitionPolicy
{
    use HandlesAuthorization;

    public function viewReviewWarehouse(User $user): bool
    {
        return $user->can('view_review_warehouse_purchase::requisition');
    }
    public function viewReview(User $user): bool
    {
        return $user->can('view_review_purchase::requisition');
    }
    public function viewApprove(User $user): bool
    {
        return $user->can('view_approve_purchase::requisition');
    }
    public function viewAuthorize(User $user): bool
    {
        return $user->can('view_authorize_purchase::requisition');
    }
    public function assign(User $user): bool
    {
        return $user->can('view_assing_purchase::requisition::requester');
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_purchase::requisition::requester');
    }

    /**
     * Determine whether the user can view the model.
     *
     * El informativo entra por su propia rama: no depende del permiso base ni
     * de estar en la cadena, y sin esto la bandeja lista la requisición pero
     * abrirla devuelve 403.
     */
    public function view(User $user, PurchaseRequisition $purchaseRequisition): bool
    {
        if (app(PurchaseInformedService::class)->isInformed($user, $purchaseRequisition)) {
            return true;
        }

        // Antes venían tres ids sueltos: 106 (Dirección Administrativa), 199 y
        // 306 (las cuentas de sistemas). Cada uno se sostiene solo por su rol,
        // así que un cambio de persona ya no obliga a tocar código.
        $usersRoles = User::withRole([
            'revisa_almacen_requisicion_compra',
            'gerente_compras',
            'comprador',
            'libera_orden_compra',
            'super_admin',
            'administrador_compras',
        ])->pluck('id')->toArray();

        $allowedIds = $purchaseRequisition->approvalChain?->only(['requester_id', 'reviewer_id', 'approver_id', 'authorizer_id']) ?? [];
        $allowedIds = array_values(array_filter(array_merge($allowedIds, $usersRoles)));
        $allowedIds[] = $purchaseRequisition->purchaser?->id;

        return $user->can('view_purchase::requisition::requester') && in_array($user->id, $allowedIds);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_purchase::requisition::requester');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PurchaseRequisition $purchaseRequisition): bool
    {
        $states = [
            'borrador',
            'devuelto por almacén',
            'devuelto por revisor',
            'devuelto por gerencia',
            'devuelto por DG',
            'devuelto por comprador',
            'devuelto por gerente de compras'
        ];

        return ($user->can('update_purchase::requisition::requester') &&  in_array($purchaseRequisition->status, $states)) || $user->hasRole('super_admin') || $user->hasRole('administrador_compras');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PurchaseRequisition $purchaseRequisition): bool
    {
        return $user->can('delete_purchase::requisition::requester');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_purchase::requisition::requester');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, PurchaseRequisition $purchaseRequisition): bool
    {
        return $user->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, PurchaseRequisition $purchaseRequisition): bool
    {
        return $user->can('{{ Restore }}');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, PurchaseRequisition $purchaseRequisition): bool
    {
        return true;
        // return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }
}
