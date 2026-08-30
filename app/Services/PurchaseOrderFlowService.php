<?php

namespace App\Services;

use App\Models\PurchaseOrder;

/**
 * Reglas de avance del flujo de aprobación de órdenes de compra.
 *
 * La condición de monto estaba escrita tres veces —en el hook de
 * `aprobado por DG nivel 1` de la máquina de estados, en la pantalla de
 * autorización y en el armado de firmas del PDF— cada una con su propia copia
 * de los límites y de la lista de proveedores exentos. Aquí queda una sola.
 */
class PurchaseOrderFlowService
{
    /**
     * Proveedores que no pasan por el nivel de monto, sin importar el total.
     */
    public const PROVEEDORES_EXENTOS = [427, 425, 332];

    /**
     * ¿La orden necesita la aprobación por monto de Dirección General CA?
     *
     * Se evalúa después de la liberación: es la última aprobación del flujo.
     */
    public function requiresAmountApproval(PurchaseOrder $order): bool
    {
        if (in_array($order->provider_id, self::PROVEEDORES_EXENTOS)) {
            return false;
        }

        return ! (new OrderCalculationService($order->id))->isOrderTotalBetweenLimits();
    }

    /**
     * Avanza la orden después de que Dirección Administrativa la liberó.
     *
     * Si supera el límite se queda esperando a Dirección General CA; si no,
     * la liberación es el último paso y la orden queda lista para el proveedor.
     */
    public function advanceAfterRelease(PurchaseOrder $order): void
    {
        if ($this->requiresAmountApproval($order)) {
            return;
        }

        $order->status()->transitionTo('autorizada para proveedor');
    }
}
