<?php

namespace Tests\Feature;

use App\Models\PurchaseRequisition;
use Tests\TestCase;

class RequisitionViewPageTest extends TestCase
{
    /**
     * La página de detalle de una requisición debe renderizar con la nueva
     * estructura del infolist: encabezado, tabs principales y barra lateral
     * con resumen y seguimiento.
     */
    public function test_requisition_view_page_renders_with_sidebar_layout(): void
    {
        // Buscar una requisición cuyo solicitante pueda acceder al panel y al
        // recurso, de preferencia una que ya esté dentro del flujo de aprobación
        $candidates = PurchaseRequisition::query()
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

        $requisition = $candidates->firstWhere('status', '!=', 'borrador') ?? $candidates->first();

        if (! $requisition) {
            $this->markTestSkipped('No hay requisiciones con solicitante válido para probar.');
        }

        $user = $requisition->approvalChain->requester;

        $response = $this->actingAs($user)
            ->withSession([
                'company_id' => $requisition->company_id,
                'company_name' => 'test',
                'company_acronym' => 'T',
            ])
            ->get("/compras/mis-requisiciones/{$requisition->id}");

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
}
