<?php

namespace App\Services;

use App\Models\PurchaseRequisition;

/**
 * Reglas de avance del flujo de aprobación de requisiciones.
 *
 * Hermana de PurchaseOrderFlowService, que hace lo mismo del lado de la orden.
 */
class PurchaseRequisitionFlowService
{
    /**
     * ¿Esta requisición lleva nivel de autorización?
     *
     * En Soldadura y Servicios Técnicos ese nivel se eliminó —la tabla del
     * correo dice "N/A"— y la casilla de la cadena queda vacía.
     */
    public function requiresAuthorization(PurchaseRequisition $requisition): bool
    {
        return filled($requisition->approvalChain?->authorizer_id);
    }

    /**
     * Avanza la requisición después de que la gerencia la aprobó.
     *
     * Si la cadena no tiene autorizador, ese paso no existe: la requisición
     * pasa sola a `aprobado por DG` y queda lista para que se le asigne
     * comprador. El estado se registra igual —no se salta— para que el
     * histórico, las fechas del PDF y `getRevisionDates()` sigan cuadrando;
     * lo único que cambia es que la firma se imprime como N/A.
     */
    public function advanceAfterManagementApproval(PurchaseRequisition $requisition): void
    {
        if ($this->requiresAuthorization($requisition)) {
            return;
        }

        if (! $requisition->status()->canBe('aprobado por DG')) {
            return;
        }

        $requisition->status()->transitionTo('aprobado por DG');
    }
}
