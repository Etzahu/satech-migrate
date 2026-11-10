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
     * Niveles que responde un eslabón de la cadena, por el estado en que la
     * requisición lo espera: quién lo responde, quién respondió el anterior,
     * la respuesta que aprueba y la nota que queda en el historial cuando se
     * aprueba sola.
     *
     * @var array<string, array{previous: string, current: string, approval: string, note: string}>
     */
    private const CHAIN_LEVELS = [
        'revisión' => [
            'previous' => 'requester',
            'current' => 'reviewer',
            'approval' => 'aprobado por revisor',
            'note' => 'Aprobada automáticamente: quien revisa es la misma persona que solicitó.',
        ],
        'aprobado por revisor' => [
            'previous' => 'reviewer',
            'current' => 'approver',
            'approval' => 'aprobado por gerencia',
            'note' => 'Aprobada automáticamente: quien aprueba es la misma persona que revisó.',
        ],
        'aprobado por gerencia' => [
            'previous' => 'approver',
            'current' => 'authorizer',
            'approval' => 'aprobado por DG',
            'note' => 'Autorizada automáticamente: quien autoriza es la misma persona que aprobó.',
        ],
    ];

    /**
     * ¿El nivel en que espera la requisición lo ocupa la misma persona que
     * respondió el anterior?
     *
     * Solo cuentan eslabones consecutivos: solicita → revisa → aprueba →
     * autoriza. Almacén no es eslabón —responde por rol— y no corta la
     * secuencia: si quien solicita también revisa, la revisión se aprueba sola
     * en cuanto almacén la libera.
     */
    public function awaitsRepeatedLink(PurchaseRequisition $requisition): bool
    {
        $level = self::CHAIN_LEVELS[$requisition->status] ?? null;
        $chain = $requisition->approvalChain;

        if (! $level || ! $chain) {
            return false;
        }

        $currentId = $chain->{$level['current'].'_id'};

        return filled($currentId) && $currentId === $chain->{$level['previous'].'_id'};
    }

    /**
     * Aprueba sola el nivel cuando lo ocupa la misma persona que respondió el
     * anterior.
     *
     * Compras pidió que un mismo usuario pueda ocupar varios eslabones; hacerlo
     * responder dos veces seguidas la misma requisición solo la detiene. El
     * estado se registra igual —no se salta—, a nombre de ese eslabón y con una
     * nota en el historial, para que las fechas del PDF y el avance cuadren. Si
     * el nivel siguiente también se repite, el hook de ese estado vuelve a
     * llamar aquí y la requisición sigue sola.
     *
     * @return bool Si avanzó; entonces ese nivel ya no debe recibir aviso.
     */
    public function approveRepeatedLink(PurchaseRequisition $requisition): bool
    {
        if (! $this->awaitsRepeatedLink($requisition)) {
            return false;
        }

        $level = self::CHAIN_LEVELS[$requisition->status];

        $requisition->status()->transitionTo(
            $level['approval'],
            ['respuesta' => $level['note'], 'automatica' => true],
            $requisition->approvalChain->{$level['current']},
        );

        return true;
    }

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
     *
     * La llama el hook de `aprobado por gerencia` en PurchaseRequisitionStateMachine.
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
