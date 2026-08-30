<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Quién aprueba (nivel 2) y quién autoriza (nivel 3) una orden de compra.
 *
 * Conviven dos flujos y esta clase es lo único que sabe cuál aplica:
 *
 *  - **Por rol** — los cinco departamentos operativos del correo. Aprueba quien
 *    tenga `aprueba_orden_compra` (Alan Anaya) y autoriza quien tenga
 *    `autoriza_orden_compra` (Sergio Ordaz), sin importar cómo esté armada la
 *    cadena. La requisición sigue su camino de siempre.
 *  - **Por cadena** — el resto de la empresa, sin cambios: aprueba
 *    `chain.approver` y autoriza `chain.authorizer`.
 *
 * Una orden entra al flujo por rol si la gerencia del solicitante de su cadena
 * tiene `purchase_order_flow` y la cadena no está marcada `po_flow_excluded`.
 *
 * Regla de diseño heredada de la Fase A: el listado, el acceso a la sección y
 * el botón de respuesta tienen que leer **esto**. Si uno de los tres decide por
 * su cuenta, la orden aparece en la bandeja sin botón, o el botón aparece y el
 * detalle devuelve 403.
 */
class PurchaseOrderChainResolver
{
    public const APPROVER_ROLE = 'aprueba_orden_compra';

    public const AUTHORIZER_ROLE = 'autoriza_orden_compra';

    /**
     * ¿Esta orden se resuelve por rol en vez de por cadena?
     */
    public function usesRoleFlow(?PurchaseOrder $order): bool
    {
        $chain = $order?->requisition?->approvalChain;

        if (! $chain || $chain->po_flow_excluded) {
            return false;
        }

        return (bool) $chain->requester?->management?->purchase_order_flow;
    }

    /**
     * ¿El usuario es quien debe aprobar esta orden en el nivel 2?
     */
    public function isApprover(?PurchaseOrder $order, ?User $user): bool
    {
        if (! $order || ! $user) {
            return false;
        }

        return $this->usesRoleFlow($order)
            ? $user->hasRole(self::APPROVER_ROLE)
            : $order->isChainApprover($user);
    }

    /**
     * ¿El usuario es quien debe autorizar esta orden en el nivel 3?
     */
    public function isAuthorizer(?PurchaseOrder $order, ?User $user): bool
    {
        if (! $order || ! $user) {
            return false;
        }

        return $this->usesRoleFlow($order)
            ? $user->hasRole(self::AUTHORIZER_ROLE)
            : $order->isChainAuthorizer($user);
    }

    /**
     * ¿El usuario interviene en algún nivel de esta orden?
     *
     * Lo usa la policy: bajo el flujo por rol, Alan y Sergio no aparecen en la
     * cadena, así que `participatesInChain()` no basta para dejarlos abrir la
     * orden que les toca responder.
     */
    public function participates(?PurchaseOrder $order, ?User $user): bool
    {
        return $this->isApprover($order, $user) || $this->isAuthorizer($order, $user);
    }

    /**
     * Correos de quien debe aprobar esta orden en el nivel 2.
     *
     * @return array<int, string>
     */
    public function approverEmails(?PurchaseOrder $order): array
    {
        return $this->usesRoleFlow($order)
            ? $this->emailsWithRole(self::APPROVER_ROLE)
            : array_filter([$order?->requisition?->approvalChain?->approver?->email]);
    }

    /**
     * Correos de quien debe autorizar esta orden en el nivel 3.
     *
     * @return array<int, string>
     */
    public function authorizerEmails(?PurchaseOrder $order): array
    {
        return $this->usesRoleFlow($order)
            ? $this->emailsWithRole(self::AUTHORIZER_ROLE)
            : array_filter([$order?->requisition?->approvalChain?->authorizer?->email]);
    }

    /**
     * Nombre de quien debe aprobar esta orden, o null si no hay nadie.
     *
     * Lo usa el PDF para los niveles que todavía no se firmaron.
     */
    public function approverName(?PurchaseOrder $order): ?string
    {
        return $this->usesRoleFlow($order)
            ? $this->firstNameWithRole(self::APPROVER_ROLE)
            : $order?->requisition?->approvalChain?->approver?->name;
    }

    /**
     * Nombre de quien debe autorizar esta orden, o null si no hay nadie.
     */
    public function authorizerName(?PurchaseOrder $order): ?string
    {
        return $this->usesRoleFlow($order)
            ? $this->firstNameWithRole(self::AUTHORIZER_ROLE)
            : $order?->requisition?->approvalChain?->authorizer?->name;
    }

    private function firstNameWithRole(string $role): ?string
    {
        return User::withRole($role)->where('active', 1)->value('name');
    }

    /**
     * ¿El usuario puede entrar a la sección del nivel 2, con cualquier orden?
     */
    public function canAccessApproval(?User $user): bool
    {
        return $this->canAccessLevel($user, self::APPROVER_ROLE, 'approverChainsPR');
    }

    /**
     * ¿El usuario puede entrar a la sección del nivel 3, con cualquier orden?
     */
    public function canAccessAuthorization(?User $user): bool
    {
        return $this->canAccessLevel($user, self::AUTHORIZER_ROLE, 'authorizerChainsPR');
    }

    /**
     * Órdenes que le tocan al usuario en el nivel 2.
     */
    public function applyApproverScope(Builder $query, ?User $user): Builder
    {
        return $this->applyScope($query, $user, self::APPROVER_ROLE, 'approverChainsPR');
    }

    /**
     * Órdenes que le tocan al usuario en el nivel 3.
     */
    public function applyAuthorizerScope(Builder $query, ?User $user): Builder
    {
        return $this->applyScope($query, $user, self::AUTHORIZER_ROLE, 'authorizerChainsPR');
    }

    /**
     * Órdenes cuya cadena corre bajo el flujo por rol.
     */
    public function whereInRoleFlow(Builder $query): Builder
    {
        return $query->whereHas('requisition.approvalChain', fn (Builder $chain) => $this->roleFlowChain($chain));
    }

    /**
     * Órdenes que siguen resolviéndose por cadena.
     *
     * Es el complemento exacto: incluye las que no tienen cadena o cuyo
     * solicitante no tiene gerencia, que deben seguir el camino de siempre.
     */
    public function whereNotInRoleFlow(Builder $query): Builder
    {
        return $query->whereDoesntHave('requisition.approvalChain', fn (Builder $chain) => $this->roleFlowChain($chain));
    }

    private function roleFlowChain(Builder $chain): Builder
    {
        return $chain
            ->where(fn (Builder $q) => $q->whereNull('po_flow_excluded')->orWhere('po_flow_excluded', 0))
            ->whereHas('requester.management', fn (Builder $m) => $m->where('purchase_order_flow', 1));
    }

    private function canAccessLevel(?User $user, string $role, string $chainRelation): bool
    {
        if (! $user) {
            return false;
        }

        return $user->hasRole($role)
            || $user->{$chainRelation}()->notArchived()->exists();
    }

    /**
     * Une las dos ramas: las órdenes que le tocan por rol y las que le tocan
     * por cadena. El `1 = 0` final cierra el grupo cuando no aplica ninguna,
     * para que un usuario sin nada no termine viendo la tabla completa.
     */
    private function applyScope(Builder $query, ?User $user, string $role, string $chainRelation): Builder
    {
        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        $chains = $user->{$chainRelation}()->notArchived()->pluck('id')->unique()->all();

        return $query->where(function (Builder $outer) use ($user, $role, $chains) {
            if ($user->hasRole($role)) {
                $outer->orWhere(fn (Builder $q) => $this->whereInRoleFlow($q));
            }

            if ($chains !== []) {
                $outer->orWhere(function (Builder $q) use ($chains) {
                    $this->whereNotInRoleFlow($q);
                    $q->whereHas('requisition', fn (Builder $r) => $r->whereIn('approval_chain_id', $chains));
                });
            }

            $outer->orWhereRaw('1 = 0');
        });
    }

    /**
     * @return array<int, string>
     */
    private function emailsWithRole(string $role): array
    {
        return User::withRole($role)
            ->where('active', 1)
            ->pluck('email')
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
