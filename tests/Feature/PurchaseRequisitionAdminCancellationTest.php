<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseRequisition\HistoryResource\Pages\ManagePR;
use App\Mail\PurchaseRequisition\Notification;
use App\Models\PurchaseRequisition;
use App\Models\User;
use App\Services\PendingReviewReminderService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Un administrador saca del flujo una requisición detenida en cualquier
 * nivel, siempre que no tenga órdenes vivas.
 *
 * Corre contra la base real dentro de una transacción.
 */
class PurchaseRequisitionAdminCancellationTest extends TestCase
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
     * Una requisición en revisión, sin órdenes y con solicitante activo.
     */
    private function openRequisition(): PurchaseRequisition
    {
        $requisition = PurchaseRequisition::query()
            ->whereIn('status', ['revisión', 'aprobado por revisor', 'aprobado por gerencia'])
            ->whereDoesntHave('orders')
            ->whereNotNull('date_delivery')
            ->whereHas('project')
            ->whereHas('approvalChain.requester', fn ($query) => $query->where('active', 1)->whereNotNull('email')->whereNotNull('management_id'))
            ->latest('id')
            ->first();

        $this->assertNotNull($requisition, 'No hay requisiciones abiertas sin órdenes para probar.');

        session(['company_id' => $requisition->company_id]);

        return $requisition;
    }

    private function requisitionIn(string $status): PurchaseRequisition
    {
        $requisition = new PurchaseRequisition;
        $requisition->status = $status;

        return $requisition;
    }

    public function test_el_gerente_de_compras_cancela_una_requisicion_detenida_con_motivo(): void
    {
        $this->actingAsRole('gerente_compras');
        $requisition = $this->openRequisition();
        $previous = $requisition->status;

        Livewire::test(ManagePR::class)
            ->callTableAction('cancelar_requisicion', $requisition, data: ['motivo' => 'El revisor ya no está en la empresa.'])
            ->assertHasNoTableActionErrors();

        $requisition->refresh();

        $this->assertSame('cancelado por administrador', $requisition->status);

        $history = $requisition->status()->history()->latest('id')->first();

        $this->assertSame($previous, $history->from);
        $this->assertSame('El revisor ya no está en la empresa.', $history->getCustomProperty('respuesta'));

        Mail::assertSent(Notification::class, fn (Notification $mail) => $mail->hasTo($requisition->approvalChain->requester->email)
            && str_contains($mail->data['subject'], 'CANCELADO POR ADMINISTRADOR')
            && $mail->data['reason'] === 'El revisor ya no está en la empresa.'
            && str_contains($mail->render(), 'El revisor ya no está en la empresa.'));
    }

    public function test_el_motivo_es_obligatorio(): void
    {
        $this->actingAsRole('gerente_compras');
        $requisition = $this->openRequisition();
        $previous = $requisition->status;

        Livewire::test(ManagePR::class)
            ->callTableAction('cancelar_requisicion', $requisition, data: ['motivo' => ''])
            ->assertHasTableActionErrors(['motivo' => 'required']);

        $this->assertSame($previous, $requisition->fresh()->status);

        Mail::assertNothingSent();
    }

    public function test_la_requisicion_cancelada_deja_de_recordarse(): void
    {
        $this->actingAsRole('gerente_compras');
        $requisition = $this->openRequisition();

        Livewire::test(ManagePR::class)
            ->callTableAction('cancelar_requisicion', $requisition, data: ['motivo' => 'Ya no procede.']);

        $this->assertNotContains($requisition->id, app(PendingReviewReminderService::class)->pendingRequisitions()->pluck('id'));
    }

    public function test_con_ordenes_vivas_no_se_ofrece(): void
    {
        $this->actingAsRole('gerente_compras');

        $requisition = PurchaseRequisition::query()
            ->whereHas('orders', fn ($query) => $query->where('status', 'not like', 'cancelado%'))
            ->where('status', '!=', 'cerrada')
            ->where('status', 'not like', 'cancelado%')
            ->latest('id')
            ->first();

        $this->assertNotNull($requisition, 'No hay requisiciones con órdenes vivas para probar.');

        session(['company_id' => $requisition->company_id]);

        $this->assertFalse($requisition->canBeCancelledByAdmin());

        Livewire::test(ManagePR::class)
            ->assertTableActionHidden('cancelar_requisicion', $requisition);
    }

    public function test_con_todas_sus_ordenes_canceladas_si_se_puede(): void
    {
        $requisition = PurchaseRequisition::query()
            ->whereHas('orders')
            ->whereDoesntHave('orders', fn ($query) => $query->where('status', 'not like', 'cancelado%'))
            ->where('status', '!=', 'cerrada')
            ->where('status', 'not like', 'cancelado%')
            ->first();

        if (! $requisition) {
            $this->markTestSkipped('No hay requisiciones abiertas cuyas órdenes estén todas canceladas.');
        }

        $this->assertTrue($requisition->canBeCancelledByAdmin());
    }

    public function test_cerrada_o_cancelada_ya_no_se_puede(): void
    {
        foreach (['cerrada', 'cancelado por revisor', 'cancelado por DG', 'cancelado por administrador'] as $status) {
            $this->assertFalse($this->requisitionIn($status)->canBeCancelledByAdmin(), "No debería poder cancelarse en «{$status}».");
        }
    }

    public function test_no_se_ofrece_a_quien_no_administra_el_flujo(): void
    {
        $this->actingAsRole('visor_requisiciones');
        $requisition = $this->openRequisition();

        Livewire::test(ManagePR::class)
            ->set('activeTab', 'all')
            ->assertTableActionHidden('cancelar_requisicion', $requisition);
    }
}
