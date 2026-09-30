<?php

namespace Tests\Unit;

use App\Enums\ReviewLevel;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use InvalidArgumentException;
use Tests\TestCase;

/**
 * Las reglas de cada bandeja para responder en lote.
 *
 * Arma los registros en memoria y no persiste nada.
 */
class ReviewLevelTest extends TestCase
{
    private function requisitionIn(string $status): PurchaseRequisition
    {
        $requisition = new PurchaseRequisition;
        $requisition->status = $status;

        return $requisition;
    }

    public function test_solo_espera_lo_que_esta_en_el_estado_del_nivel(): void
    {
        $this->assertTrue(ReviewLevel::RequisitionReview->isAwaiting($this->requisitionIn('revisión')));

        // Un borrador puede pasar a `revisión`, pero no está en la bandeja del
        // revisor: por eso se compara el estado y no `canBe()`.
        $draft = $this->requisitionIn('borrador');

        $this->assertTrue($draft->status()->canBe('revisión'));
        $this->assertFalse(ReviewLevel::RequisitionReview->isAwaiting($draft));
    }

    public function test_lo_borrado_no_espera_respuesta(): void
    {
        $order = new PurchaseOrder;
        $order->status = 'revisión gerente de compras';
        $order->deleted_at = now();

        $this->assertFalse(ReviewLevel::OrderPurchasingReview->isAwaiting($order));
    }

    public function test_no_acepta_una_respuesta_de_otro_nivel(): void
    {
        $requisition = $this->requisitionIn('revisión');

        $this->expectException(InvalidArgumentException::class);

        ReviewLevel::RequisitionReview->respond($requisition, 'aprobado por DG', null);
    }

    public function test_almacen_no_puede_cancelar(): void
    {
        $this->assertSame(['revisión', 'devuelto por almacén'], array_keys(ReviewLevel::RequisitionWarehouse->responses()));
    }

    public function test_la_primera_respuesta_de_cada_nivel_aprueba(): void
    {
        foreach (ReviewLevel::cases() as $level) {
            $this->assertStringNotContainsString('devuelto', $level->approval(), $level->name);
            $this->assertStringNotContainsString('cancelado', $level->approval(), $level->name);
        }
    }

    public function test_cada_respuesta_sale_del_estado_del_nivel_en_la_maquina_de_estados(): void
    {
        foreach (ReviewLevel::cases() as $level) {
            $record = str_starts_with($level->name, 'Order') ? new PurchaseOrder : new PurchaseRequisition;
            $record->status = $level->sourceStatus();

            foreach (array_keys($level->responses()) as $response) {
                $this->assertTrue($record->status()->canBe($response), "{$level->name}: {$level->sourceStatus()} → {$response}");
            }
        }
    }
}
