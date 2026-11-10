<?php

namespace Tests\Feature;

use App\Enums\ReviewLevel;
use App\Filament\Purchases\Resources\PurchaseRequisition\ApproverResource\Pages\ViewPR;
use App\Mail\PurchaseRequisition\Notification;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use Asantibanez\LaravelEloquentStateMachines\Models\StateHistory;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Cuando el mismo usuario ocupa dos eslabones seguidos de la cadena, el
 * segundo nivel se aprueba solo y la requisición pasa al siguiente.
 *
 * Toma una requisición real —para que los correos tengan proyecto, compañía y
 * partidas— y la cuelga de una cadena armada para cada caso. Corre contra la
 * base real dentro de una transacción.
 */
class RequisitionRepeatedChainLinkTest extends TestCase
{
    use DatabaseTransactions;

    private PurchaseRequisition $requisition;

    /** @var array<string, User> */
    private array $users = [];

    protected function setUp(): void
    {
        parent::setUp();

        Bus::fake();
        Mail::fake();

        $this->requisition = PurchaseRequisition::query()
            ->whereNotNull('date_delivery')
            ->whereHas('project')
            ->whereHas('company')
            ->whereHas('approvalChain.requester', fn ($query) => $query->whereNotNull('management_id'))
            ->latest('id')
            ->firstOrFail();

        session(['company_id' => $this->requisition->company_id]);

        $managementId = $this->requisition->approvalChain->requester->management_id;

        foreach (['ana', 'beto', 'carla'] as $name) {
            $this->users[$name] = User::forceCreate([
                'name' => "Prueba {$name}",
                'email' => "prueba.eslabon.{$name}@gptservices.com",
                'puesto' => 'Prueba',
                'active' => true,
                'management_id' => $managementId,
            ]);
        }
    }

    /**
     * Cuelga la requisición de una cadena con estos eslabones y la deja en el
     * estado indicado.
     */
    private function inChain(string $status, string $requester, string $reviewer, string $approver, ?string $authorizer): PurchaseRequisition
    {
        $chain = PurchaseRequisitionApprovalChain::forceCreate([
            'requester_id' => $this->users[$requester]->id,
            'reviewer_id' => $this->users[$reviewer]->id,
            'approver_id' => $this->users[$approver]->id,
            'authorizer_id' => $authorizer ? $this->users[$authorizer]->id : null,
        ]);

        $this->requisition
            ->forceFill(['approval_chain_id' => $chain->id, 'status' => $status])
            ->saveQuietly();

        return $this->requisition->fresh();
    }

    /**
     * Entrada del historial con la que la requisición llegó a ese estado.
     */
    private function snapshot(PurchaseRequisition $requisition, string $status): StateHistory
    {
        $snapshot = $requisition->status()->snapshotWhen($status);

        $this->assertNotNull($snapshot, "La requisición nunca pasó por [{$status}].");

        return $snapshot;
    }

    private function assertApprovedAutomaticallyBy(PurchaseRequisition $requisition, string $status, string $user): void
    {
        $snapshot = $this->snapshot($requisition, $status);

        $this->assertTrue($snapshot->getCustomProperty('automatica'), "[{$status}] no quedó como automática.");
        $this->assertStringContainsString('automáticamente', $snapshot->getCustomProperty('respuesta'));
        $this->assertSame($this->users[$user]->id, (int) $snapshot->responsible_id, "[{$status}] no quedó a nombre de {$user}.");
    }

    private function assertMailedTo(string $user): void
    {
        Mail::assertSent(Notification::class, fn (Notification $mail) => $mail->hasTo($this->users[$user]->email));
    }

    private function assertNotMailedTo(string $user): void
    {
        Mail::assertNotSent(Notification::class, fn (Notification $mail) => $mail->hasTo($this->users[$user]->email));
    }

    public function test_si_quien_solicita_tambien_revisa_la_revision_se_aprueba_sola_al_salir_de_almacen(): void
    {
        $requisition = $this->inChain('revisión por almacén', 'ana', 'ana', 'beto', 'carla');

        ReviewLevel::RequisitionWarehouse->respond($requisition, 'revisión', null);

        $this->assertSame('aprobado por revisor', $requisition->status);
        $this->assertSame('aprobado por revisor', $requisition->fresh()->status);
        $this->assertApprovedAutomaticallyBy($requisition, 'aprobado por revisor', 'ana');

        // El aviso "revisar" no le llega a quien ya revisó al solicitar: va
        // directo a quien aprueba.
        $this->assertNotMailedTo('ana');
        $this->assertMailedTo('beto');
    }

    public function test_si_quien_revisa_tambien_aprueba_la_aprobacion_sale_sola(): void
    {
        $requisition = $this->inChain('revisión', 'ana', 'beto', 'beto', 'carla');
        $this->actingAs($this->users['beto']);

        ReviewLevel::RequisitionReview->respond($requisition, 'aprobado por revisor', null);

        $this->assertSame('aprobado por gerencia', $requisition->fresh()->status);
        $this->assertApprovedAutomaticallyBy($requisition, 'aprobado por gerencia', 'beto');

        $this->assertNotMailedTo('beto');
        $this->assertMailedTo('carla');
    }

    public function test_si_quien_aprueba_tambien_autoriza_la_autorizacion_sale_sola(): void
    {
        $requisition = $this->inChain('aprobado por revisor', 'ana', 'beto', 'carla', 'carla');
        $this->actingAs($this->users['carla']);

        ReviewLevel::RequisitionApproval->respond($requisition, 'aprobado por gerencia', null);

        $this->assertSame('aprobado por DG', $requisition->fresh()->status);
        $this->assertApprovedAutomaticallyBy($requisition, 'aprobado por DG', 'carla');

        // Carla solo va en copia del aviso final, nunca como destinataria del
        // "aprobar".
        $this->assertNotMailedTo('carla');
        $this->assertMailedTo('ana');
    }

    public function test_si_toda_la_cadena_es_la_misma_persona_llega_sola_hasta_direccion(): void
    {
        $requisition = $this->inChain('borrador', 'ana', 'ana', 'ana', 'ana');
        $this->actingAs($this->users['ana']);

        $requisition->status()->transitionTo('revisión');

        $this->assertSame('aprobado por DG', $requisition->fresh()->status);
        $this->assertApprovedAutomaticallyBy($requisition, 'aprobado por revisor', 'ana');
        $this->assertApprovedAutomaticallyBy($requisition, 'aprobado por gerencia', 'ana');
        $this->assertApprovedAutomaticallyBy($requisition, 'aprobado por DG', 'ana');

        // Solo sale el aviso final.
        Mail::assertSent(Notification::class, 1);
        Mail::assertSent(Notification::class, fn (Notification $mail) => $mail->hasTo($this->users['ana']->email)
            && str_contains($mail->data['subject'], 'APROBADO POR DIRECCIÓN GENERAL'));
    }

    public function test_eslabones_repetidos_que_no_son_seguidos_no_se_saltan(): void
    {
        // Ana solicita y aprueba, pero entre ambos revisa Beto.
        $requisition = $this->inChain('borrador', 'ana', 'beto', 'ana', 'carla');
        $this->actingAs($this->users['ana']);

        $requisition->status()->transitionTo('revisión');

        $this->assertSame('revisión', $requisition->fresh()->status);
        $this->assertMailedTo('beto');
    }

    public function test_sin_autorizador_un_revisor_que_tambien_aprueba_llega_hasta_direccion(): void
    {
        // La aprobación sale sola en cascada y, sin autorizador, el nivel de
        // Dirección no existe: no debe quedarse esperando en `aprobado por gerencia`.
        $requisition = $this->inChain('revisión', 'ana', 'beto', 'beto', null);
        $this->actingAs($this->users['beto']);

        ReviewLevel::RequisitionReview->respond($requisition, 'aprobado por revisor', null);

        $this->assertSame('aprobado por DG', $requisition->fresh()->status);
        $this->assertApprovedAutomaticallyBy($requisition, 'aprobado por gerencia', 'beto');

        // El paso de Dirección es el de "N/A", no una autorización automática.
        $this->assertNull($this->snapshot($requisition, 'aprobado por DG')->getCustomProperty('automatica'));
    }

    public function test_sin_autorizador_la_aprobacion_de_gerencia_desde_la_vista_sigue_siendo_la_ultima(): void
    {
        $requisition = $this->inChain('aprobado por revisor', 'ana', 'beto', 'carla', null);
        $this->users['carla']->assignRole('aprueba_requisicion_compra');
        $this->actingAs($this->users['carla']);
        Filament::setCurrentPanel('compras');

        Livewire::test(ViewPR::class, ['record' => $requisition->getRouteKey()])
            ->callAction('Capturar respuesta', data: ['response' => 'aprobado por gerencia'])
            ->assertHasNoActionErrors();

        $this->assertSame('aprobado por DG', $requisition->fresh()->status);
    }

    public function test_un_eslabon_distinto_sigue_esperando_su_respuesta(): void
    {
        $requisition = $this->inChain('revisión', 'ana', 'beto', 'carla', 'ana');
        $this->actingAs($this->users['beto']);

        ReviewLevel::RequisitionReview->respond($requisition, 'aprobado por revisor', null);

        $this->assertSame('aprobado por revisor', $requisition->fresh()->status);
        $this->assertNull($this->snapshot($requisition, 'aprobado por revisor')->getCustomProperty('automatica'));
        $this->assertMailedTo('carla');
    }
}
