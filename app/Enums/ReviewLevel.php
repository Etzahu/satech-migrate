<?php

namespace App\Enums;

use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\User;
use App\Services\PurchaseOrderChainResolver;
use App\Services\PurchaseOrderFlowService;
use App\Services\PurchaseRequisitionFlowService;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Cada bandeja donde se responde una orden o una requisición.
 *
 * Reúne lo que el botón "Capturar respuesta" de cada vista decide por su
 * cuenta —desde qué estado se responde, qué respuestas hay, quién puede darlas
 * y qué pasa sola después de aprobar— para que la respuesta en lote haga
 * exactamente lo mismo, registro por registro. Si una vista cambia su regla,
 * hay que cambiarla aquí también.
 */
enum ReviewLevel
{
    // ── Órdenes de compra ────────────────────────────────────────────────────
    case OrderPurchasingReview;
    case OrderApproval;
    case OrderAuthorization;
    case OrderRelease;
    case OrderAmountAuthorization;
    case OrderSpecialRoute;

    // ── Requisiciones ────────────────────────────────────────────────────────
    case RequisitionWarehouse;
    case RequisitionReview;
    case RequisitionApproval;
    case RequisitionAuthorization;

    /**
     * Estado en el que el registro espera la respuesta de este nivel.
     */
    public function sourceStatus(): string
    {
        return match ($this) {
            self::OrderPurchasingReview => 'revisión gerente de compras',
            self::OrderApproval => 'aprobado por gerente de compras',
            self::OrderAuthorization => 'aprobado por gerente solicitante',
            self::OrderRelease => 'aprobado por DG nivel 1',
            self::OrderAmountAuthorization => 'liberado por dirección administrativa',
            self::OrderSpecialRoute => 'revision por dirección general',
            self::RequisitionWarehouse => 'revisión por almacén',
            self::RequisitionReview => 'revisión',
            self::RequisitionApproval => 'aprobado por revisor',
            self::RequisitionAuthorization => 'aprobado por gerencia',
        };
    }

    /**
     * Respuestas del nivel, con la etiqueta que ve quien responde. La primera
     * es la que aprueba y la única que no pide observación.
     *
     * @return array<string, string>
     */
    public function responses(): array
    {
        return match ($this) {
            self::OrderPurchasingReview => [
                'aprobado por gerente de compras' => 'Aprobar',
                'devuelto por gerente de compras' => 'Devolver',
                'cancelado por gerente de compras' => 'Cancelar',
            ],
            self::OrderApproval => [
                'aprobado por gerente solicitante' => 'Aprobar',
                'devuelto por gerente solicitante' => 'Devolver',
                'cancelado por gerente solicitante' => 'Cancelar',
            ],
            self::OrderAuthorization => [
                'aprobado por DG nivel 1' => 'Aprobar',
                'devuelto por DG nivel 1' => 'Devolver',
                'cancelado por DG nivel 1' => 'Cancelar',
            ],
            self::OrderRelease => [
                'liberado por dirección administrativa' => 'Liberar',
                'devuelto por liberación' => 'Devolver',
                'cancelado por liberación' => 'Cancelar',
            ],
            self::OrderAmountAuthorization => [
                'aprobado por DG nivel 2' => 'Aprobar',
                'devuelto por DG nivel 2' => 'Devolver',
                'cancelado por DG nivel 2' => 'Cancelar',
            ],
            self::OrderSpecialRoute => [
                'autorizada para proveedor' => 'Aprobar',
                'devuelto por dirección general' => 'Devolver',
                'cancelado por dirección general' => 'Cancelar',
            ],
            // Almacén solo revisa existencias: no puede cancelar.
            self::RequisitionWarehouse => [
                'revisión' => 'Revisado',
                'devuelto por almacén' => 'Devolver',
            ],
            self::RequisitionReview => [
                'aprobado por revisor' => 'Aprobar',
                'devuelto por revisor' => 'Devolver',
                'cancelado por revisor' => 'Cancelar',
            ],
            self::RequisitionApproval => [
                'aprobado por gerencia' => 'Aprobar',
                'devuelto por gerencia' => 'Devolver',
                'cancelado por gerencia' => 'Cancelar',
            ],
            self::RequisitionAuthorization => [
                'aprobado por DG' => 'Aprobar',
                'devuelto por DG' => 'Devolver',
                'cancelado por DG' => 'Cancelar',
            ],
        };
    }

    /**
     * La respuesta que aprueba.
     */
    public function approval(): string
    {
        return array_key_first($this->responses());
    }

    /**
     * ¿El registro sigue esperando la respuesta de este nivel?
     *
     * Se compara el estado exacto en vez de usar `status()->canBe()`: el
     * comodín de la requisición deja llegar a `revisión` desde cualquier
     * estado, y aquí solo cuenta lo que está en la bandeja.
     */
    public function isAwaiting(Model $record): bool
    {
        return $record->status === $this->sourceStatus()
            && ! $record->trashed();
    }

    /**
     * ¿El usuario responde este nivel en alguna de sus bandejas? Decide si ve
     * la acción; qué registros puede responder lo decide canRespond().
     */
    public function isAvailableTo(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return match ($this) {
            self::OrderApproval => app(PurchaseOrderChainResolver::class)->canAccessApproval($user),
            self::OrderAuthorization => app(PurchaseOrderChainResolver::class)->canAccessAuthorization($user),
            default => $user->hasRole($this->role()),
        };
    }

    /**
     * ¿El usuario puede responder este registro en este nivel? Es la misma
     * regla que muestra el botón en la vista de cada bandeja.
     */
    public function canRespond(Model $record, ?User $user): bool
    {
        if (! $user || ! $this->isAwaiting($record)) {
            return false;
        }

        return match ($this) {
            self::OrderApproval => app(PurchaseOrderChainResolver::class)->isApprover($record, $user),
            self::OrderAuthorization => app(PurchaseOrderChainResolver::class)->isAuthorizer($record, $user),
            default => $user->hasRole($this->role()),
        };
    }

    /**
     * Rol que responde el nivel. Los niveles 2 y 3 de la orden no tienen uno
     * fijo: los decide PurchaseOrderChainResolver, por rol o por cadena.
     */
    private function role(): ?string
    {
        return match ($this) {
            self::OrderPurchasingReview => 'gerente_compras',
            self::OrderApproval, self::OrderAuthorization => null,
            self::OrderRelease => 'libera_orden_compra',
            self::OrderAmountAuthorization => 'autoriza_nivel-2-orden_compra',
            self::OrderSpecialRoute => 'autoriza_nivel-1-orden_compra',
            self::RequisitionWarehouse => 'revisa_almacen_requisicion_compra',
            self::RequisitionReview => 'revisa_requisicion_compra',
            self::RequisitionApproval => 'aprueba_requisicion_compra',
            self::RequisitionAuthorization => 'autoriza_requisicion_compra',
        };
    }

    /**
     * Aplica la respuesta y, si aprueba, los pasos que siguen solos.
     *
     * @param  PurchaseOrder|PurchaseRequisition  $record
     */
    public function respond(Model $record, string $response, ?string $observation): void
    {
        if (! array_key_exists($response, $this->responses())) {
            throw new InvalidArgumentException("La respuesta [{$response}] no existe en este nivel.");
        }

        $record->status()->transitionTo($response, ['respuesta' => $observation]);

        if ($response !== $this->approval()) {
            return;
        }

        match ($this) {
            // Si la orden no supera el límite, la liberación es el último paso.
            self::OrderRelease => (new PurchaseOrderFlowService)->advanceAfterRelease($record),
            // Dirección General es la última aprobación: deja traza y cierra.
            self::OrderAmountAuthorization => $record->status()->transitionTo('autorizada para proveedor'),
            // Sin autorizador en la cadena, la aprobación de gerencia es la última.
            self::RequisitionApproval => app(PurchaseRequisitionFlowService::class)->advanceAfterManagementApproval($record),
            default => null,
        };
    }
}
