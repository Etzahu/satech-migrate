<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource\Pages\CreatePurchaseRequisitionApprovalChain;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Una cadena es duplicada solo si coincide en los cuatro niveles: Solicita,
 * Revisa, Aprueba y Autoriza. Antes la página de alta comparaba solo los tres
 * primeros, así que reemplazar al autorizador dado de baja de una cadena
 * (p. ej. la 156) era imposible: el alta decía que la cadena ya existía.
 */
class ChainDuplicateValidationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array{requester_id: int, reviewer_id: int, approver_id: int}
     */
    private array $baseLevels;

    private int $currentAuthorizerId;

    private int $otherAuthorizerId;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');

        $admin = User::role('super_admin')->first();

        $this->assertNotNull($admin, 'No hay un super_admin para probar el panel.');

        $this->actingAs($admin);

        $requester = User::query()
            ->where('active', 1)
            ->where('email', 'like', '%@gptservices.com')
            ->whereNotIn('id', PurchaseRequisitionApprovalChain::query()->select('requester_id'))
            ->first();

        $reviewer = User::query()
            ->where('active', 1)
            ->where('email', 'like', '%@gptservices.com')
            ->whereKeyNot($requester?->getKey())
            ->first();

        $approver = User::role('aprueba_requisicion_compra')->where('active', 1)->first();

        $authorizers = User::role('autoriza_requisicion_compra')->where('active', 1)->take(2)->pluck('id');

        $this->assertNotNull($requester, 'No hay un solicitante activo sin cadenas para probar.');
        $this->assertNotNull($reviewer, 'No hay un revisor activo para probar.');
        $this->assertNotNull($approver, 'No hay un aprobador activo para probar.');
        $this->assertCount(2, $authorizers, 'Se necesitan dos autorizadores activos para probar.');

        $this->baseLevels = [
            'requester_id' => $requester->getKey(),
            'reviewer_id' => $reviewer->getKey(),
            'approver_id' => $approver->getKey(),
        ];

        [$this->currentAuthorizerId, $this->otherAuthorizerId] = $authorizers->all();
    }

    private function existingChain(?int $authorizerId): PurchaseRequisitionApprovalChain
    {
        return PurchaseRequisitionApprovalChain::create([
            ...$this->baseLevels,
            'authorizer_id' => $authorizerId,
        ]);
    }

    private function chainsWithBaseLevels(): int
    {
        return PurchaseRequisitionApprovalChain::where($this->baseLevels)->count();
    }

    public function test_permite_crear_la_cadena_si_solo_cambia_el_autorizador(): void
    {
        $this->existingChain($this->currentAuthorizerId);

        Livewire::test(CreatePurchaseRequisitionApprovalChain::class)
            ->fillForm([...$this->baseLevels, 'authorizer_id' => $this->otherAuthorizerId])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('purchase_requisition_approval_chains', [
            ...$this->baseLevels,
            'authorizer_id' => $this->otherAuthorizerId,
        ]);
        $this->assertSame(2, $this->chainsWithBaseLevels());
    }

    public function test_permite_crear_la_cadena_sin_autorizador_si_la_existente_lo_tiene(): void
    {
        $this->existingChain($this->currentAuthorizerId);

        Livewire::test(CreatePurchaseRequisitionApprovalChain::class)
            ->fillForm([...$this->baseLevels, 'authorizer_id' => null])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(2, $this->chainsWithBaseLevels());
    }

    public function test_rechaza_la_cadena_identica_en_los_cuatro_niveles(): void
    {
        $this->existingChain($this->currentAuthorizerId);

        Livewire::test(CreatePurchaseRequisitionApprovalChain::class)
            ->fillForm([...$this->baseLevels, 'authorizer_id' => $this->currentAuthorizerId])
            ->call('create')
            ->assertHasFormErrors(['requester_id']);

        $this->assertSame(1, $this->chainsWithBaseLevels());
    }

    public function test_rechaza_la_cadena_identica_sin_autorizador(): void
    {
        $this->existingChain(null);

        Livewire::test(CreatePurchaseRequisitionApprovalChain::class)
            ->fillForm([...$this->baseLevels, 'authorizer_id' => null])
            ->call('create')
            ->assertHasFormErrors(['requester_id']);

        $this->assertSame(1, $this->chainsWithBaseLevels());
    }
}
