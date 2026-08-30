<?php

namespace App\Policies;

use App\Models\PurchaseOrder;
use App\Models\User;
use App\Services\PurchaseInformedService;
use App\Services\PurchaseOrderChainResolver;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_purchase::order::purchaser');
    }

    /**
     * Determine whether the user can view the model.
     *
     * Quien la cadena nombra como participante puede abrir su propia orden
     * aunque no tenga el permiso general: si el flujo le asigna un nivel,
     * necesita poder verla para responder.
     *
     * El informativo también, aunque no responda nada: sin esta rama la
     * bandeja lista la orden y abrirla devuelve 403.
     */
    public function view(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->can('view_purchase::order::purchaser')
            || $purchaseOrder->participatesInChain($user)
            || app(PurchaseOrderChainResolver::class)->participates($purchaseOrder, $user)
            || app(PurchaseInformedService::class)->isInformed($user, $purchaseOrder->requisition);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_purchase::order::purchaser');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PurchaseOrder $purchaseOrder): bool
    {
        $states = [
            'borrador',
            'devuelto por gerente de compras',
            'devuelto por gerente solicitante',
            'devuelto por DG nivel 1',
            'devuelto por DG nivel 2',
            'devuelto por administrador', // Permite agregar partidas cuando admin devuelve la orden
            'reabierta para edición',
        ];

        return ($user->can('update_purchase::order::purchaser') && in_array($purchaseOrder->status, $states)) || ($user->hasRole('super_admin') || $user->hasRole('administrador_compras') ||
        $user->hasRole('gerente_compras')); // administrador_compras
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->can('delete_purchase::order::purchaser');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_purchase::order::purchaser');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, PurchaseOrder $purchaseOrder): bool
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
    public function restore(User $user, PurchaseOrder $purchaseOrder): bool
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
    public function replicate(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }
}
