<?php

namespace Tests\Unit;

use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Services\PurchaseRequisitionFlowService;
use Tests\TestCase;

/**
 * Una cadena sin autorizador no espera a nadie.
 *
 * "Alan solicita que se elimine el último nivel de autorización en los
 * departamentos de soldadura y ST" — Jorge Ojeda, 18-ago-2026. Como
 * `authorizer_id` era NOT NULL, ese "N/A" de la tabla del correo se había
 * quedado como un sustituto temporal; ahora la casilla puede quedar vacía y la
 * requisición avanza sola por ese paso.
 *
 * Arma el grafo en memoria y no persiste nada, igual que
 * PurchaseOrderChainResolverTest.
 */
class PurchaseRequisitionFlowServiceTest extends TestCase
{
    private PurchaseRequisitionFlowService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new PurchaseRequisitionFlowService;
    }

    private function requisition(?int $authorizerId): PurchaseRequisition
    {
        $chain = new PurchaseRequisitionApprovalChain;
        $chain->requester_id = 1;
        $chain->reviewer_id = 2;
        $chain->approver_id = 3;
        $chain->authorizer_id = $authorizerId;

        $requisition = new PurchaseRequisition;
        $requisition->setRelation('approvalChain', $chain);

        return $requisition;
    }

    public function test_una_cadena_con_autorizador_conserva_el_nivel(): void
    {
        $this->assertTrue($this->service->requiresAuthorization($this->requisition(341)));
    }

    public function test_una_cadena_sin_autorizador_no_lleva_nivel(): void
    {
        $this->assertFalse($this->service->requiresAuthorization($this->requisition(null)));
    }

    public function test_una_requisicion_sin_cadena_no_lleva_nivel(): void
    {
        // No debe reventar: `approval_chain_id` es nullable en el esquema.
        $requisition = new PurchaseRequisition;
        $requisition->setRelation('approvalChain', null);

        $this->assertFalse($this->service->requiresAuthorization($requisition));
    }

    public function test_con_autorizador_no_avanza_sola(): void
    {
        // Con nivel vigente, advanceAfterManagementApproval() no debe tocar el
        // estado: la requisición se queda esperando la firma.
        $requisition = $this->requisition(341);
        $requisition->status = 'aprobado por gerencia';

        $this->service->advanceAfterManagementApproval($requisition);

        $this->assertSame('aprobado por gerencia', $requisition->status);
    }
}
