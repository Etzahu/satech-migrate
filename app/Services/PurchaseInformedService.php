<?php

namespace App\Services;

use App\Models\ManagementInformedRule;
use App\Models\PurchaseRequisition;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Nivel informativo de compras: quién ve —sin aprobar— las requisiciones y las
 * órdenes de una gerencia, y a quién se le avisa cuando la orden se libera.
 *
 * Fuente única del nivel. La regla de diseño heredada de la Fase A es que los
 * tres puntos de un nivel —listado, acceso y detalle— lean lo mismo: si la
 * bandeja filtra por una cosa y la policy por otra, el documento aparece en el
 * listado y da 403 al abrirlo.
 *
 * La gerencia del documento no vive en la requisición: se resuelve por el
 * solicitante de su cadena de aprobación.
 */
class PurchaseInformedService
{
    /**
     * Usuarios activos que deben estar informados de esta requisición y de sus
     * órdenes.
     *
     * @return Collection<int, User>
     */
    public function usersFor(?PurchaseRequisition $requisition): Collection
    {
        $managementId = $this->managementIdOf($requisition);

        if (! $managementId) {
            return collect();
        }

        $userIds = ManagementInformedRule::query()
            ->matching($managementId, $requisition->category)
            ->pluck('user_id');

        if ($userIds->isEmpty()) {
            return collect();
        }

        return User::whereIn('id', $userIds)->where('active', 1)->get();
    }

    /**
     * Correos de los informativos, listos para Mail::to().
     *
     * @return array<int, string>
     */
    public function emailsFor(?PurchaseRequisition $requisition): array
    {
        return $this->usersFor($requisition)
            ->pluck('email')
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * ¿Este usuario es informativo de esta requisición?
     *
     * Consulta las reglas directamente y no `usersFor()` porque el acceso
     * depende de la regla, no de si la cuenta sigue activa: quien está viendo
     * la pantalla ya inició sesión.
     */
    public function isInformed(?User $user, ?PurchaseRequisition $requisition): bool
    {
        $managementId = $this->managementIdOf($requisition);

        if (! $user || ! $managementId) {
            return false;
        }

        return ManagementInformedRule::query()
            ->matching($managementId, $requisition->category)
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Filtra órdenes de compra a las que el usuario ve como informativo.
     */
    public function applyOrderScope(Builder $query, ?User $user): Builder
    {
        return $this->applyScope($query, $user, 'requisition.approvalChain.requester', 'requisition');
    }

    /**
     * Filtra requisiciones a las que el usuario ve como informativo.
     */
    public function applyRequisitionScope(Builder $query, ?User $user): Builder
    {
        return $this->applyScope($query, $user, 'approvalChain.requester', null);
    }

    /**
     * Arma un OR por regla: cada una acota su gerencia y, si la tiene, su
     * categoría.
     *
     * @param  string  $requesterRelation  ruta hasta el solicitante de la cadena
     * @param  string|null  $categoryRelation  null si la categoría vive en el propio modelo
     */
    private function applyScope(Builder $query, ?User $user, string $requesterRelation, ?string $categoryRelation): Builder
    {
        $rules = $user
            ? ManagementInformedRule::where('user_id', $user->id)->get()
            : collect();

        // Sin reglas no ve nada. Sin este corte, un `where` vacío devolvería
        // la tabla completa, que es exactamente lo contrario de lo pedido.
        if ($rules->isEmpty()) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where(function (Builder $outer) use ($rules, $requesterRelation, $categoryRelation) {
            foreach ($rules as $rule) {
                $outer->orWhere(function (Builder $inner) use ($rule, $requesterRelation, $categoryRelation) {
                    $inner->whereHas(
                        $requesterRelation,
                        fn (Builder $requester) => $requester->where('management_id', $rule->management_id)
                    );

                    if ($rule->category === null) {
                        return;
                    }

                    $categoryRelation === null
                        ? $inner->where('category', $rule->category)
                        : $inner->whereHas(
                            $categoryRelation,
                            fn (Builder $requisition) => $requisition->where('category', $rule->category)
                        );
                });
            }
        });
    }

    private function managementIdOf(?PurchaseRequisition $requisition): ?int
    {
        $managementId = $requisition?->approvalChain?->requester?->management_id;

        return $managementId ? (int) $managementId : null;
    }
}
