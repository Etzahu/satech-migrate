<?php

namespace Tests\Feature;

use App\Models\PurchaseRequisition;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class RequisitionViewPageTest extends TestCase
{
    /**
     * Requisiciones cuyo solicitante puede entrar al panel y al recurso.
     */
    private function accessibleRequisitions(): Collection
    {
        return PurchaseRequisition::query()
            ->with('approvalChain.requester')
            ->latest('id')
            ->take(50)
            ->get()
            ->filter(function (PurchaseRequisition $requisition) {
                $requester = $requisition->approvalChain?->requester;

                return $requester
                    && str_ends_with($requester->email, '@gptservices.com')
                    && $requester->hasRole('solicita_requisicion_compra');
            });
    }

    private function viewRequisitionAs(PurchaseRequisition $requisition): TestResponse
    {
        return $this->actingAs($requisition->approvalChain->requester)
            ->withSession([
                'company_id' => $requisition->company_id,
                'company_name' => 'test',
                'company_acronym' => 'T',
            ])
            ->get("/compras/mis-requisiciones/{$requisition->id}");
    }

    /**
     * La página de detalle de una requisición debe renderizar con la nueva
     * estructura del infolist: encabezado, tabs principales y barra lateral
     * con resumen y seguimiento.
     */
    public function test_requisition_view_page_renders_with_sidebar_layout(): void
    {
        // Buscar una requisición cuyo solicitante pueda acceder al panel y al
        // recurso, de preferencia una que ya esté dentro del flujo de aprobación
        $candidates = $this->accessibleRequisitions();

        $requisition = $candidates->firstWhere('status', '!=', 'borrador') ?? $candidates->first();

        if (! $requisition) {
            $this->markTestSkipped('No hay requisiciones con solicitante válido para probar.');
        }

        $response = $this->viewRequisitionAs($requisition);

        $response->assertOk();
        $response->assertSee('Datos generales');
        $response->assertSee('Partidas');
        $response->assertSee('Resumen');
        $response->assertSee('Comprador asignado');

        if ($requisition->status !== 'borrador') {
            $response->assertSee('Flujo de aprobación');
            $response->assertSee('data-progress-approval', false);
        }
    }

    /**
     * La sección de órdenes debe listar las órdenes relacionadas con su folio,
     * proveedor y estado, no solo la cantidad.
     */
    public function test_orders_section_lists_related_orders(): void
    {
        // De preferencia una con varias órdenes, para cubrir también las pestañas
        $requisition = $this->accessibleRequisitions()
            ->loadCount('orders')
            ->where('orders_count', '>', 0)
            ->sortByDesc('orders_count')
            ->first();

        if (! $requisition) {
            $this->markTestSkipped('No hay requisiciones con órdenes para probar.');
        }

        $order = $requisition->orders()->latest('id')->first();

        $response = $this->viewRequisitionAs($requisition);

        $response->assertOk();
        $response->assertSee('Órdenes de compra');
        $response->assertSee($order->folio);
        $response->assertSee(route('order.pdf.show', ['id' => $order->id]));

        if (filled($order->provider?->company_name)) {
            $response->assertSee($order->provider->company_name);
        }

        // Cada orden trae su propio flujo de aprobación
        $orderCount = $requisition->orders()->count();
        $response->assertSee('data-progress-approval', false);
        $this->assertSame(
            $orderCount,
            substr_count($response->getContent(), 'data-progress-approval') - 1, // -1: el flujo de la requisición
            'Debe renderizarse un flujo de aprobación por orden.'
        );

        // Con varias órdenes se navegan por pestañas
        if ($orderCount > 1) {
            $response->assertSee('role="tablist"', false);
            $this->assertSame($orderCount, substr_count($response->getContent(), 'role="tab"'));
        }
    }

    /**
     * Cuando la requisición todavía no genera órdenes, la sección debe avisarlo
     * de forma visible en lugar de mostrar un cero.
     */
    public function test_orders_section_warns_when_there_are_no_orders(): void
    {
        $requisition = $this->accessibleRequisitions()
            ->first(fn (PurchaseRequisition $requisition) => ! $requisition->orders()->exists());

        if (! $requisition) {
            $this->markTestSkipped('No hay requisiciones sin órdenes para probar.');
        }

        $response = $this->viewRequisitionAs($requisition);

        $response->assertOk();
        $response->assertSee('Órdenes de compra');
        $response->assertSee('Sin órdenes de compra');
    }
}
