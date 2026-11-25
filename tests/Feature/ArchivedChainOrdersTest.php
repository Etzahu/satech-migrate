<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseOrder\ApproveResource\Pages\ListPurchaseOrders as AuthorizationOrders;
use App\Filament\Purchases\Resources\PurchaseOrder\ApproveResource\Pages\ViewOrder as AuthorizationOrder;
use App\Filament\Purchases\Resources\PurchaseOrder\ReviewResource\Pages\ListPurchaseOrders as ApprovalOrders;
use App\Filament\Purchases\Resources\PurchaseOrder\ReviewResource\Pages\ViewOrder as ApprovalOrder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use App\Services\PurchaseOrderChainResolver;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Las órdenes en curso de una cadena desactivada siguen en la bandeja de quien
 * la cadena nombra.
 *
 * Desactivar una cadena la retira para requisiciones nuevas, no para las
 * órdenes que ya venían en ella. Cuando se rehicieron las cadenas de Contratos
 * el 18-nov-2026, T868–T875/26 se quedaron sin bandeja: Kevin y Denise seguían
 * siendo quienes debían aprobarlas, pero la bandeja filtraba las cadenas
 * desactivadas y nadie las veía.
 *
 * Toma una orden real, cuelga su requisición de una cadena desactivada armada
 * para la prueba y corre dentro de una transacción. El solicitante no tiene
 * gerencia, así que la orden se resuelve por cadena y no por rol.
 */
class ArchivedChainOrdersTest extends TestCase
{
    use DatabaseTransactions;

    private User $approver;

    private User $authorizer;

    private PurchaseRequisitionApprovalChain $chain;

    private PurchaseOrder $order;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');
        Bus::fake();
        Mail::fake();

        $this->approver = $this->person('aprueba');
        $this->authorizer = $this->person('autoriza');

        $this->chain = PurchaseRequisitionApprovalChain::forceCreate([
            'requester_id' => $this->person('solicita')->id,
            'reviewer_id' => $this->person('revisa')->id,
            'approver_id' => $this->approver->id,
            'authorizer_id' => $this->authorizer->id,
            'archived_at' => now(),
        ]);

        $order = PurchaseOrder::query()
            ->whereNotNull('requisition_id')
            ->whereNotNull('company_id')
            ->latest('id')
            ->first();

        $this->assertNotNull($order, 'No hay órdenes con requisición en la base.');

        DB::table('purchase_requisitions')
            ->where('id', $order->requisition_id)
            ->update(['approval_chain_id' => $this->chain->id]);

        $this->order = $order;

        session(['company_id' => $order->company_id]);
    }

    private function person(string $name): User
    {
        return User::forceCreate([
            'name' => "Prueba cadena desactivada {$name}",
            'email' => "prueba.desactivada.{$name}@gptservices.com",
            'puesto' => 'Prueba',
            'active' => true,
        ]);
    }

    private function orderIn(string $status): PurchaseOrder
    {
        DB::table('purchase_orders')->where('id', $this->order->id)->update(['status' => $status]);

        return $this->order->fresh();
    }

    public function test_el_aprobador_ve_y_abre_la_orden_de_una_cadena_desactivada(): void
    {
        $order = $this->orderIn('aprobado por gerente de compras');
        $this->actingAs($this->approver);

        $this->assertTrue(app(PurchaseOrderChainResolver::class)->canAccessApproval($this->approver));

        Livewire::test(ApprovalOrders::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords([$order]);

        Livewire::test(ApprovalOrder::class, ['record' => $order->getRouteKey()])
            ->assertSuccessful()
            ->assertActionVisible('Capturar respuesta');
    }

    public function test_el_autorizador_ve_y_abre_la_orden_de_una_cadena_desactivada(): void
    {
        $order = $this->orderIn('aprobado por gerente solicitante');
        $this->actingAs($this->authorizer);

        $this->assertTrue(app(PurchaseOrderChainResolver::class)->canAccessAuthorization($this->authorizer));

        Livewire::test(AuthorizationOrders::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords([$order]);

        Livewire::test(AuthorizationOrder::class, ['record' => $order->getRouteKey()])
            ->assertSuccessful()
            ->assertActionVisible('Capturar respuesta');
    }

    public function test_sin_nada_pendiente_una_cadena_desactivada_no_abre_la_seccion(): void
    {
        // La orden ya pasó de nivel: quien solo tiene cadenas desactivadas no
        // tiene nada que responder y no debe ver la sección en el menú.
        $this->orderIn('autorizada para proveedor');

        $resolver = app(PurchaseOrderChainResolver::class);

        $this->assertFalse($resolver->canAccessApproval($this->approver));
        $this->assertFalse($resolver->canAccessAuthorization($this->authorizer));
    }

    public function test_el_aprobador_no_ve_la_orden_que_espera_otro_nivel(): void
    {
        $order = $this->orderIn('aprobado por gerente solicitante');
        $this->actingAs($this->approver);

        $this->assertFalse(app(PurchaseOrderChainResolver::class)->canAccessApproval($this->approver));
        $this->assertFalse(
            PurchaseOrder::query()->reviewManagement()->whereKey($order->id)->exists(),
        );
    }
}
