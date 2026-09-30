<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages\EditPurchaseRequisition;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages\ViewPurchaseRequisition;
use App\Models\PurchaseRequisition;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * El solicitante solo puede eliminar un borrador. Antes el botón aparecía en
 * cualquier estado, y borrar una requisición en curso dejaba sus órdenes
 * colgando de una requisición borrada.
 */
class RequisitionDeleteOnlyDraftsTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');
    }

    /**
     * Una requisición vista por su propio solicitante, que puede entrar al
     * panel y tiene permiso de eliminar.
     *
     * @param  array<int, string>  $statuses
     */
    private function requisitionOfItsRequester(array $statuses): PurchaseRequisition
    {
        $requisition = PurchaseRequisition::query()
            ->with('approvalChain.requester')
            ->whereIn('status', $statuses)
            ->whereHas('approvalChain.requester', fn ($query) => $query->where('email', 'like', '%@gptservices.com'))
            ->latest('id')
            ->take(50)
            ->get()
            ->first(fn (PurchaseRequisition $requisition) => $requisition->approvalChain->requester->hasRole('solicita_requisicion_compra'));

        $this->assertNotNull($requisition, 'No hay requisiciones en '.implode(', ', $statuses).' con un solicitante válido.');

        $this->actingAs($requisition->approvalChain->requester);

        session([
            'company_id' => $requisition->company_id,
            'company_name' => 'test',
            'company_acronym' => 'T',
        ]);

        return $requisition;
    }

    public function test_el_solicitante_puede_eliminar_un_borrador(): void
    {
        $requisition = $this->requisitionOfItsRequester(['borrador']);

        Livewire::test(ViewPurchaseRequisition::class, ['record' => $requisition->getRouteKey()])
            ->assertActionVisible('delete');

        Livewire::test(EditPurchaseRequisition::class, ['record' => $requisition->getRouteKey()])
            ->assertActionVisible('delete');
    }

    public function test_una_requisicion_en_curso_ya_no_se_puede_eliminar(): void
    {
        $requisition = $this->requisitionOfItsRequester(['revisión', 'aprobado por DG', 'comprador asignado']);

        Livewire::test(ViewPurchaseRequisition::class, ['record' => $requisition->getRouteKey()])
            ->assertActionHidden('delete');
    }

    public function test_una_requisicion_devuelta_tampoco_se_puede_eliminar(): void
    {
        $requisition = $this->requisitionOfItsRequester(['devuelto por revisor', 'devuelto por gerencia', 'devuelto por DG', 'devuelto por almacén']);

        Livewire::test(ViewPurchaseRequisition::class, ['record' => $requisition->getRouteKey()])
            ->assertActionHidden('delete');
    }
}
