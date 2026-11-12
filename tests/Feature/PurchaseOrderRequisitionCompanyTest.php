<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages\CreatePurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * La empresa de la sesión es la misma en todas las pestañas: si el comprador cambia
 * de empresa en otra, no debe poder guardar la orden de una requisición de la otra
 * razón social (la orden tomaría empresa y folio equivocados, p. ej. G396/26 para
 * T-QHSE-2026-0106).
 *
 * Corre contra la base real dentro de una transacción.
 */
class PurchaseOrderRequisitionCompanyTest extends TestCase
{
    use DatabaseTransactions;

    private const GPT = 1;

    private const TECH_ENERGY = 2;

    protected function setUp(): void
    {
        parent::setUp();

        Bus::fake();
        Mail::fake();

        Filament::setCurrentPanel('compras');

        $buyer = User::forceCreate([
            'name' => 'Prueba comprador',
            'email' => 'prueba.empresa.orden@gptservices.com',
            'puesto' => 'Prueba',
            'active' => true,
        ]);
        $buyer->assignRole('comprador');

        $this->actingAs($buyer);
    }

    private function requisitionOf(int $companyId): PurchaseRequisition
    {
        return PurchaseRequisition::query()->where('company_id', $companyId)->latest('id')->firstOrFail();
    }

    public function test_crear_orden_desde_una_requisicion_de_otra_empresa_avisa_y_no_la_precarga(): void
    {
        session(['company_id' => self::GPT]);
        $requisition = $this->requisitionOf(self::TECH_ENERGY);

        Livewire::test(CreatePurchaseOrder::class, ['requisition' => $requisition->id])
            ->assertSet('data.requisition_id', null)
            ->assertNotified('La requisición es de otra empresa');
    }

    public function test_crear_orden_desde_una_requisicion_de_la_misma_empresa_la_precarga(): void
    {
        session(['company_id' => self::TECH_ENERGY]);
        $requisition = $this->requisitionOf(self::TECH_ENERGY);

        Livewire::test(CreatePurchaseOrder::class, ['requisition' => $requisition->id])
            ->assertSet('data.requisition_id', $requisition->id)
            ->assertNotNotified('La requisición es de otra empresa');
    }

    public function test_no_guarda_la_orden_si_la_requisicion_es_de_otra_empresa(): void
    {
        // La página se abrió en Tech Energy y luego se cambió a GPT en otra pestaña.
        session(['company_id' => self::TECH_ENERGY]);
        $requisition = $this->requisitionOf(self::TECH_ENERGY);

        $page = Livewire::test(CreatePurchaseOrder::class, ['requisition' => $requisition->id]);

        session(['company_id' => self::GPT]);

        $errors = $page->call('create')
            ->assertHasFormErrors(['requisition_id'])
            ->errors();

        $this->assertStringContainsString(
            "La requisición {$requisition->folio} es de Tech Energy Control",
            $errors->first('data.requisition_id'),
        );
    }

    public function test_la_requisicion_de_la_misma_empresa_pasa_la_validacion(): void
    {
        session(['company_id' => self::TECH_ENERGY]);
        $requisition = $this->requisitionOf(self::TECH_ENERGY);

        Livewire::test(CreatePurchaseOrder::class, ['requisition' => $requisition->id])
            ->call('create')
            ->assertHasNoFormErrors(['requisition_id']);
    }
}
