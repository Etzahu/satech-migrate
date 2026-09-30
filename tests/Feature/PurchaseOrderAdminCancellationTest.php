<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource\Pages\ManagePR;
use App\Mail\PurchaseOrder\Notification;
use App\Models\PurchaseOrder;
use App\Models\User;
use App\Services\PendingReviewReminderService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Un administrador saca del flujo una orden detenida en cualquier nivel,
 * aunque nadie pueda responderlo.
 *
 * Corre contra la base real dentro de una transacción. Bus::fake() evita que
 * el observer de la orden exporte a las hojas de Google reales al guardarla.
 */
class PurchaseOrderAdminCancellationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Bus::fake();
        Mail::fake();

        Filament::setCurrentPanel('compras');
    }

    private function actingAsRole(string $role): User
    {
        $user = User::forceCreate([
            'name' => "Prueba {$role}",
            'email' => "prueba.cancelacion.{$role}@gptservices.com",
            'puesto' => 'Prueba',
            'active' => true,
        ]);

        $user->assignRole($role);

        $this->actingAs($user);

        return $user;
    }

    /**
     * Una orden que espera una firma y cuyo comprador sigue activo.
     */
    private function openOrder(): PurchaseOrder
    {
        $order = PurchaseOrder::query()
            ->whereIn('status', array_keys(PendingReviewReminderService::ORDER_LEVELS))
            ->whereHas('purchaser', fn ($query) => $query->where('active', 1)->whereNotNull('email'))
            ->latest('id')
            ->first();

        $this->assertNotNull($order, 'No hay órdenes abiertas con comprador activo para probar.');

        session(['company_id' => $order->company_id]);

        return $order;
    }

    private function orderIn(string $status): PurchaseOrder
    {
        $order = new PurchaseOrder;
        $order->status = $status;

        return $order;
    }

    public function test_el_gerente_de_compras_cancela_una_orden_detenida_con_motivo(): void
    {
        $this->actingAsRole('gerente_compras');
        $order = $this->openOrder();
        $previous = $order->status;

        Livewire::test(ManagePR::class)
            ->callTableAction('cancelar_orden', $order, data: ['motivo' => 'El aprobador ya no está en la empresa.'])
            ->assertHasNoTableActionErrors();

        $order->refresh();

        $this->assertSame('cancelado por administrador', $order->status);

        $history = $order->status()->history()->latest('id')->first();

        $this->assertSame($previous, $history->from);
        $this->assertSame('El aprobador ya no está en la empresa.', $history->getCustomProperty('respuesta'));

        Mail::assertSent(Notification::class, fn (Notification $mail) => $mail->hasTo($order->purchaser->email)
            && str_contains($mail->data['subject'], 'CANCELADO POR ADMINISTRADOR')
            && $mail->data['reason'] === 'El aprobador ya no está en la empresa.'
            && str_contains($mail->render(), 'El aprobador ya no está en la empresa.'));
    }

    public function test_el_motivo_es_obligatorio(): void
    {
        $this->actingAsRole('gerente_compras');
        $order = $this->openOrder();
        $previous = $order->status;

        Livewire::test(ManagePR::class)
            ->callTableAction('cancelar_orden', $order, data: ['motivo' => ''])
            ->assertHasTableActionErrors(['motivo' => 'required']);

        $this->assertSame($previous, $order->fresh()->status);

        Mail::assertNothingSent();
    }

    public function test_si_el_comprador_ya_no_esta_activo_se_cancela_sin_mandar_correo(): void
    {
        $this->actingAsRole('gerente_compras');
        $order = $this->openOrder();

        $order->purchaser->forceFill(['active' => 0])->save();

        Livewire::test(ManagePR::class)
            ->callTableAction('cancelar_orden', $order, data: ['motivo' => 'El comprador dejó la empresa.'])
            ->assertHasNoTableActionErrors();

        $this->assertSame('cancelado por administrador', $order->fresh()->status);

        Mail::assertNothingSent();
    }

    public function test_la_orden_cancelada_deja_de_recordarse(): void
    {
        $this->actingAsRole('gerente_compras');
        $order = $this->openOrder();

        Livewire::test(ManagePR::class)
            ->callTableAction('cancelar_orden', $order, data: ['motivo' => 'Ya no procede.']);

        $this->assertNotContains($order->id, app(PendingReviewReminderService::class)->pendingOrders()->pluck('id'));
    }

    public function test_no_se_ofrece_a_quien_no_administra_el_flujo(): void
    {
        $this->actingAsRole('visor_ordenes');
        $order = $this->openOrder();

        Livewire::test(ManagePR::class)
            ->set('activeTab', 'all')
            ->assertTableActionHidden('cancelar_orden', $order);
    }

    public function test_no_se_ofrece_para_una_orden_que_ya_salio_al_proveedor(): void
    {
        $this->actingAsRole('gerente_compras');

        $order = PurchaseOrder::where('status', 'autorizada para proveedor')->latest('id')->first();

        $this->assertNotNull($order, 'No hay órdenes autorizadas para probar.');

        session(['company_id' => $order->company_id]);

        Livewire::test(ManagePR::class)
            ->assertTableActionHidden('cancelar_orden', $order);
    }

    public function test_solo_una_orden_abierta_se_puede_cancelar(): void
    {
        $open = ['borrador', 'revisión gerente de compras', 'aprobado por gerente de compras', 'aprobado por DG nivel 1', 'devuelto por administrador', 'reabierta para edición'];

        foreach ($open as $status) {
            $this->assertTrue($this->orderIn($status)->canBeCancelledByAdmin(), "Debería poder cancelarse en «{$status}».");
        }

        foreach (['autorizada para proveedor', 'cancelado por gerente de compras', 'cancelado por administrador'] as $status) {
            $this->assertFalse($this->orderIn($status)->canBeCancelledByAdmin(), "No debería poder cancelarse en «{$status}».");
        }
    }
}
