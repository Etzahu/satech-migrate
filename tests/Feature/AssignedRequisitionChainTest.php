<?php

namespace Tests\Feature;

use App\Filament\Purchases\Pages\CheckUserRequisitions;
use App\Mail\PurchaseOrder\Notification;
use App\Models\Management;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use App\Services\AssignedRequisitionChainService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * «Verificar requisiciones» también encuentra las requisiciones ya asignadas
 * cuyas órdenes van a pasar por quien se va, y las cambia de cadena sin
 * regresarlas al inicio.
 *
 * Toma una requisición real sin órdenes y una orden real, las cuelga de
 * cadenas armadas para cada caso y corre dentro de una transacción.
 */
class AssignedRequisitionChainTest extends TestCase
{
    use DatabaseTransactions;

    private PurchaseRequisition $requisition;

    private User $requester;

    private User $leaver;

    private User $newApprover;

    private PurchaseRequisitionApprovalChain $oldChain;

    private PurchaseRequisitionApprovalChain $newChain;

    private AssignedRequisitionChainService $service;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');
        Bus::fake();
        Mail::fake();

        $this->service = app(AssignedRequisitionChainService::class);

        $requisition = PurchaseRequisition::query()
            ->whereDoesntHave('orders')
            ->whereNotNull('company_id')
            ->latest('id')
            ->first();

        $this->assertNotNull($requisition, 'No hay requisiciones sin órdenes en la base.');

        $management = Management::query()->first();
        $management->forceFill(['purchase_order_flow' => 0])->save();

        $this->requester = $this->person('solicita', management: $management);
        $this->leaver = $this->person('se-fue', active: false);
        $this->newApprover = $this->person('aprueba-nuevo');

        $reviewer = $this->person('revisa');
        $authorizer = $this->person('autoriza');

        $this->oldChain = $this->chain($reviewer, $this->leaver, $authorizer);
        $this->newChain = $this->chain($reviewer, $this->newApprover, $authorizer);

        DB::table('purchase_requisitions')->where('id', $requisition->id)->update([
            'approval_chain_id' => $this->oldChain->id,
            'status' => 'comprador asignado',
        ]);

        $this->requisition = $requisition->fresh();

        $admin = $this->person('admin');
        $admin->assignRole('gerente_compras');
        $this->actingAs($admin);

        session(['company_id' => $this->requisition->company_id]);
    }

    private function person(string $name, bool $active = true, ?Management $management = null): User
    {
        return User::forceCreate([
            'name' => "Prueba cadena asignada {$name}",
            'email' => "prueba.asignada.{$name}@gptservices.com",
            'puesto' => 'Prueba',
            'active' => $active,
            'management_id' => $management?->id,
        ]);
    }

    private function chain(User $reviewer, User $approver, ?User $authorizer, ?User $requester = null): PurchaseRequisitionApprovalChain
    {
        return PurchaseRequisitionApprovalChain::forceCreate([
            'requester_id' => ($requester ?? $this->requester)->id,
            'reviewer_id' => $reviewer->id,
            'approver_id' => $approver->id,
            'authorizer_id' => $authorizer?->id,
        ]);
    }

    /**
     * Cuelga de la requisición una orden real con el estado indicado.
     */
    private function orderInStatus(string $status): PurchaseOrder
    {
        $order = PurchaseOrder::query()
            ->whereHas('items')
            ->whereHas('provider')
            ->latest('id')
            ->first();

        $this->assertNotNull($order, 'No hay órdenes con partidas y proveedor en la base.');

        DB::table('purchase_orders')->where('id', $order->id)->update([
            'requisition_id' => $this->requisition->id,
            'status' => $status,
        ]);

        return $order->fresh();
    }

    private function pendingFolios(User $user): array
    {
        return $this->service->pendingFor($user, $this->requisition->company_id)->pluck('folio')->all();
    }

    public function test_lista_la_asignada_sin_orden_en_la_cadena_de_quien_se_va(): void
    {
        $this->assertContains($this->requisition->folio, $this->pendingFolios($this->leaver));
    }

    public function test_lista_la_que_tiene_una_orden_devuelta_que_volvera_a_pasar_por_la_cadena(): void
    {
        $this->orderInStatus('devuelto por administrador');

        $this->assertContains($this->requisition->folio, $this->pendingFolios($this->leaver));
    }

    public function test_no_lista_la_que_ya_tiene_su_orden_autorizada(): void
    {
        $this->orderInStatus('autorizada para proveedor');

        $this->assertNotContains($this->requisition->folio, $this->pendingFolios($this->leaver));
    }

    public function test_si_su_unica_orden_se_cancelo_cuenta_como_sin_orden(): void
    {
        $this->orderInStatus('cancelado por administrador');

        $this->assertContains($this->requisition->folio, $this->pendingFolios($this->leaver));
    }

    public function test_no_lista_las_requisiciones_que_todavia_no_se_aprueban(): void
    {
        DB::table('purchase_requisitions')->where('id', $this->requisition->id)->update(['status' => 'aprobado por revisor']);

        $this->assertNotContains($this->requisition->folio, $this->pendingFolios($this->leaver));
    }

    public function test_no_lista_las_de_gerencias_con_flujo_por_rol(): void
    {
        $this->requester->management->forceFill(['purchase_order_flow' => 1])->save();

        $this->assertNotContains($this->requisition->folio, $this->pendingFolios($this->leaver));
    }

    public function test_solo_ofrece_cadenas_utilizables_del_mismo_solicitante(): void
    {
        $other = $this->person('otro-solicitante');
        $foreign = $this->chain($this->person('revisa-2'), $this->newApprover, null, requester: $other);
        $blocked = $this->chain($this->person('revisa-3'), $this->leaver, null);

        $available = $this->service->availableChains($this->requisition)->modelKeys();

        $this->assertContains($this->newChain->id, $available);
        $this->assertNotContains($this->oldChain->id, $available);
        $this->assertNotContains($foreign->id, $available);
        $this->assertNotContains($blocked->id, $available);
    }

    public function test_la_pagina_la_muestra_y_cambia_la_cadena_sin_reiniciar(): void
    {
        $order = $this->orderInStatus('borrador');

        Livewire::test(CheckUserRequisitions::class)
            ->set('data.selectedUserId', $this->leaver->id)
            ->assertSet('userStats.pending_in_orders', 1)
            ->assertSee($this->requisition->folio)
            ->assertSee($order->folio)
            ->callAction('changeAssignedChain', data: ['new_chain_id' => $this->newChain->id], arguments: ['requisition' => $this->requisition->id])
            ->assertNotified('Cadena cambiada')
            ->assertSet('userStats.pending_in_orders', 0);

        $requisition = $this->requisition->fresh();

        $this->assertSame($this->newChain->id, (int) $requisition->approval_chain_id);
        $this->assertSame('comprador asignado', $requisition->status);
        $this->assertSame('borrador', $order->fresh()->status);

        $trace = $requisition->stateHistory()->where('field', 'approval_chain_id')->latest('id')->first();

        $this->assertNotNull($trace);
        $this->assertSame((string) $this->oldChain->id, (string) $trace->from);
        $this->assertSame((string) $this->newChain->id, (string) $trace->to);
        $this->assertSame(auth()->id(), (int) $trace->responsible_id);
        $this->assertSame(0, $requisition->status()->history()->where('created_at', '>=', $trace->created_at)->count());
    }

    public function test_avisa_a_quien_firma_ahora_las_ordenes_que_ya_esperaban_aprobacion(): void
    {
        $order = $this->orderInStatus('aprobado por gerente de compras');

        $notified = $this->service->switchChain($this->requisition, $this->newChain, auth()->user());

        $this->assertSame(1, $notified);
        $this->assertSame('aprobado por gerente de compras', $order->fresh()->status);
        Mail::assertSent(Notification::class, fn (Notification $mail) => $mail->hasTo($this->newApprover->email));
    }

    public function test_sin_ordenes_esperando_no_manda_avisos(): void
    {
        $this->orderInStatus('borrador');

        $this->assertSame(0, $this->service->switchChain($this->requisition, $this->newChain, auth()->user()));

        Mail::assertNothingSent();
    }

    public function test_rechaza_una_cadena_bloqueada_y_deja_la_requisicion_como_estaba(): void
    {
        $blocked = $this->chain($this->person('revisa-4'), $this->leaver, null);

        try {
            $this->service->switchChain($this->requisition, $blocked, auth()->user());
            $this->fail('Debió rechazar la cadena bloqueada.');
        } catch (InvalidArgumentException) {
            $this->assertSame($this->oldChain->id, (int) $this->requisition->fresh()->approval_chain_id);
        }
    }
}
