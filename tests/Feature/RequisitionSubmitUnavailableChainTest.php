<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages\EditPurchaseRequisition;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages\ViewPurchaseRequisition;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * "Enviar a revisión" no deja salir una requisición cuya cadena ya no puede
 * usarse —con alguien dado de baja o desactivada por el administrador—: se
 * detenía al llegarle a esa persona sin que nadie pudiera responderla.
 *
 * Toma una requisición real de un solicitante real, la cuelga de una cadena
 * armada para cada caso y corre dentro de una transacción.
 */
class RequisitionSubmitUnavailableChainTest extends TestCase
{
    use DatabaseTransactions;

    private PurchaseRequisition $requisition;

    private User $requester;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');
        Bus::fake();
        Mail::fake();

        $requisition = PurchaseRequisition::query()
            ->with('approvalChain.requester')
            ->whereNotNull('category')
            ->whereHas('items')
            ->whereHas('project')
            ->whereHas('approvalChain.requester', fn ($query) => $query
                ->where('active', 1)
                ->where('email', 'like', '%@gptservices.com')
                ->whereNotNull('management_id'))
            ->latest('id')
            ->take(50)
            ->get()
            ->first(fn (PurchaseRequisition $requisition) => $requisition->approvalChain->requester->hasRole('solicita_requisicion_compra'));

        $this->assertNotNull($requisition, 'No hay requisiciones con partidas de un solicitante válido.');

        $this->requisition = $requisition;
        $this->requester = $requisition->approvalChain->requester;

        $this->actingAs($this->requester);

        session([
            'company_id' => $requisition->company_id,
            'company_name' => 'test',
            'company_acronym' => 'T',
        ]);
    }

    /**
     * Cuelga la requisición, en borrador, de una cadena del mismo solicitante
     * con participantes nuevos.
     *
     * @param  array{approver_active?: bool, archived?: bool}  $options
     */
    private function draftInChain(array $options = []): PurchaseRequisition
    {
        $participant = fn (string $name, bool $active = true): User => User::forceCreate([
            'name' => "Prueba envío {$name}",
            'email' => "prueba.envio.{$name}@gptservices.com",
            'puesto' => 'Prueba',
            'active' => $active,
            'management_id' => $this->requester->management_id,
        ]);

        $chain = PurchaseRequisitionApprovalChain::forceCreate([
            'requester_id' => $this->requester->id,
            'reviewer_id' => $participant('revisa')->id,
            'approver_id' => $participant('aprueba', $options['approver_active'] ?? true)->id,
            'authorizer_id' => $participant('autoriza')->id,
            'archived_at' => ($options['archived'] ?? false) ? now() : null,
        ]);

        $this->requisition
            ->forceFill(['approval_chain_id' => $chain->id, 'status' => 'borrador'])
            ->save();

        return $this->requisition->fresh();
    }

    public function test_no_se_envia_si_alguien_de_la_cadena_esta_dado_de_baja(): void
    {
        $requisition = $this->draftInChain(['approver_active' => false]);

        Livewire::test(ViewPurchaseRequisition::class, ['record' => $requisition->getRouteKey()])
            ->callAction('enviarRevision')
            ->assertNotified('No se puede enviar la requisición');

        $this->assertSame('borrador', $requisition->fresh()->status);
    }

    public function test_tampoco_se_envia_desde_la_edicion(): void
    {
        $requisition = $this->draftInChain(['approver_active' => false]);

        Livewire::test(EditPurchaseRequisition::class, ['record' => $requisition->getRouteKey()])
            ->callAction('enviarRevision')
            ->assertNotified('No se puede enviar la requisición');

        $this->assertSame('borrador', $requisition->fresh()->status);
    }

    public function test_no_se_envia_con_una_cadena_desactivada(): void
    {
        $requisition = $this->draftInChain(['archived' => true]);

        Livewire::test(ViewPurchaseRequisition::class, ['record' => $requisition->getRouteKey()])
            ->callAction('enviarRevision')
            ->assertNotified('No se puede enviar la requisición');

        $this->assertSame('borrador', $requisition->fresh()->status);
    }

    public function test_con_la_cadena_vigente_se_envia_como_siempre(): void
    {
        $requisition = $this->draftInChain();

        Livewire::test(ViewPurchaseRequisition::class, ['record' => $requisition->getRouteKey()])
            ->callAction('enviarRevision')
            ->assertNotified('Requisición enviada');

        $this->assertContains($requisition->fresh()->status, ['revisión por almacén', 'revisión']);
    }

    public function test_el_motivo_nombra_a_quien_esta_dado_de_baja(): void
    {
        $requisition = $this->draftInChain(['approver_active' => false]);

        $this->assertStringContainsString('Prueba envío aprueba', $requisition->submissionBlocker());
    }
}
