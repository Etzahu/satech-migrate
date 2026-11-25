<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseOrder\AdminResource\Pages\ViewOrder as PurchasingReviewOrder;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages\ViewOrder as PurchaserOrder;
use App\Filament\Purchases\Resources\PurchaseOrder\ReviewResource\Pages\ListPurchaseOrders as ApprovalOrders;
use App\Filament\Purchases\Resources\PurchaseOrder\ReviewResource\Pages\ViewOrder as ApprovalOrder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Una orden no avanza hacia un firmante de su cadena que ya no está activo.
 *
 * Kevin siguió aprobando órdenes de Contratos hacia Sergio Ordaz cuando ya
 * estaba dado de baja (T401/26 el 25-nov-2026): cada una se quedaba detenida
 * en Autoriza sin que nadie la viera. Ahora el comprador no puede enviarla, y
 * ni el gerente de compras ni el gerente solicitante pueden aprobarla, hasta
 * que Compras le cambie la cadena. Devolver y cancelar siguen disponibles.
 *
 * Toma una orden real con partidas y proveedor normal, cuelga su requisición
 * de una cadena armada para la prueba y corre dentro de una transacción. El
 * solicitante no tiene gerencia, así que la orden se resuelve por cadena.
 */
class InactiveSignerBrakeTest extends TestCase
{
    use DatabaseTransactions;

    private User $approver;

    private User $authorizer;

    private PurchaseOrder $order;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');
        Bus::fake();
        Mail::fake();

        $this->approver = $this->person('aprueba');
        $this->authorizer = $this->person('autoriza');

        $chain = PurchaseRequisitionApprovalChain::forceCreate([
            'requester_id' => $this->person('solicita')->id,
            'reviewer_id' => $this->person('revisa')->id,
            'approver_id' => $this->approver->id,
            'authorizer_id' => $this->authorizer->id,
        ]);

        $order = PurchaseOrder::query()
            ->whereNotNull('requisition_id')
            ->whereNotNull('company_id')
            ->whereHas('items')
            ->whereHas('purchaser', fn (Builder $purchaser) => $purchaser->whereNotNull('email'))
            ->whereHas('provider', fn (Builder $provider) => $provider->where(fn (Builder $query) => $query
                ->whereNull('approval_chain')
                ->orWhere('approval_chain', '!=', 'especial')))
            ->latest('id')
            ->first();

        $this->assertNotNull($order, 'No hay órdenes con partidas y proveedor normal en la base.');

        DB::table('purchase_requisitions')
            ->where('id', $order->requisition_id)
            ->update(['approval_chain_id' => $chain->id]);

        $this->order = $order;

        session(['company_id' => $order->company_id]);
    }

    private function person(string $name): User
    {
        return User::forceCreate([
            'name' => "Prueba freno firmante {$name}",
            'email' => "prueba.freno.{$name}@gptservices.com",
            'puesto' => 'Prueba',
            'active' => true,
        ]);
    }

    private function deactivate(User $user): void
    {
        $user->forceFill(['active' => false])->save();
    }

    private function orderIn(string $status, array $attributes = []): PurchaseOrder
    {
        DB::table('purchase_orders')
            ->where('id', $this->order->id)
            ->update(['status' => $status, 'archived_at' => null, ...$attributes]);

        return $this->order->fresh();
    }

    // ── Gerente solicitante (nivel 2) ───────────────────────────────────────

    public function test_el_gerente_solicitante_no_puede_aprobar_hacia_un_autorizador_inactivo(): void
    {
        $this->deactivate($this->authorizer);
        $order = $this->orderIn('aprobado por gerente de compras');
        $this->actingAs($this->approver);

        Livewire::test(ApprovalOrder::class, ['record' => $order->getRouteKey()])
            ->callAction('Capturar respuesta', data: ['response' => 'aprobado por gerente solicitante'])
            ->assertNotified('La orden no puede avanzar');

        $this->assertSame('aprobado por gerente de compras', $order->fresh()->status);
        Mail::assertNothingSent();
    }

    public function test_el_gerente_solicitante_puede_devolverla_aunque_el_autorizador_este_inactivo(): void
    {
        $this->deactivate($this->authorizer);
        $order = $this->orderIn('aprobado por gerente de compras');
        $this->actingAs($this->approver);

        Livewire::test(ApprovalOrder::class, ['record' => $order->getRouteKey()])
            ->callAction('Capturar respuesta', data: ['response' => 'devuelto por gerente solicitante', 'observation' => 'Falta cambiar la cadena'])
            ->assertNotified('Respuesta enviada');

        $this->assertSame('devuelto por gerente solicitante', $order->fresh()->status);
    }

    public function test_con_la_cadena_activa_el_gerente_solicitante_aprueba_como_siempre(): void
    {
        $order = $this->orderIn('aprobado por gerente de compras');
        $this->actingAs($this->approver);

        Livewire::test(ApprovalOrder::class, ['record' => $order->getRouteKey()])
            ->callAction('Capturar respuesta', data: ['response' => 'aprobado por gerente solicitante'])
            ->assertNotified('Respuesta enviada');

        $this->assertSame('aprobado por gerente solicitante', $order->fresh()->status);
    }

    public function test_en_lote_la_reporta_detenida_y_no_con_error(): void
    {
        $this->deactivate($this->authorizer);
        $order = $this->orderIn('aprobado por gerente de compras');
        $this->approver->assignRole('super_admin');
        $this->actingAs($this->approver);

        Livewire::test(ApprovalOrders::class)
            ->callTableBulkAction('responder_seleccionadas', [$order], data: ['response' => 'aprobado por gerente solicitante'])
            ->assertNotified('No se envió ninguna respuesta');

        $this->assertSame('aprobado por gerente de compras', $order->fresh()->status);
    }

    // ── Gerente de compras (nivel 1) ────────────────────────────────────────

    public function test_el_gerente_de_compras_no_puede_aprobar_hacia_un_aprobador_inactivo(): void
    {
        $this->deactivate($this->approver);
        $order = $this->orderIn('revisión gerente de compras');

        $manager = $this->person('gerente-compras');
        $manager->assignRole('gerente_compras');
        $this->actingAs($manager);

        Livewire::test(PurchasingReviewOrder::class, ['record' => $order->getRouteKey()])
            ->callAction('Capturar respuesta', data: ['response' => 'aprobado por gerente de compras'])
            ->assertNotified('La orden no puede avanzar');

        $this->assertSame('revisión gerente de compras', $order->fresh()->status);
    }

    // ── Comprador ───────────────────────────────────────────────────────────

    public function test_el_comprador_no_puede_enviarla_hacia_un_firmante_inactivo(): void
    {
        $this->deactivate($this->authorizer);

        $buyer = $this->person('comprador');
        $buyer->assignRole('comprador');
        $this->actingAs($buyer);

        $order = $this->orderIn('borrador', ['purchaser_user_id' => $buyer->id]);

        Livewire::test(PurchaserOrder::class, ['record' => $order->getRouteKey()])
            ->callAction('Solicitar')
            ->assertNotified('La orden no puede avanzar');

        $this->assertSame('borrador', $order->fresh()->status);
    }

    // ── Candado en la máquina de estados ────────────────────────────────────

    public function test_la_maquina_de_estados_la_detiene_por_cualquier_camino(): void
    {
        $this->deactivate($this->authorizer);
        $order = $this->orderIn('aprobado por gerente de compras');

        try {
            $order->status()->transitionTo('aprobado por gerente solicitante');
            $this->fail('La orden avanzó hacia un autorizador inactivo.');
        } catch (ValidationException $exception) {
            $this->assertStringContainsString('Autoriza: Prueba freno firmante autoriza', $exception->getMessage());
        }

        $this->assertSame('aprobado por gerente de compras', $order->fresh()->status);
    }
}
