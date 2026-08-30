<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource;
use App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource\Pages\ListPurchaseRequisitionApprovalChains;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Una cadena que ya se usó al menos una vez es de solo lectura: en el listado
 * solo queda la acción de ver, y la edición queda cerrada incluso por URL.
 */
class ChainEditLockTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');

        $admin = User::role('super_admin')->first();

        $this->assertNotNull($admin, 'No hay un super_admin para probar el panel.');

        $this->actingAs($admin);
    }

    private function usedChain(): PurchaseRequisitionApprovalChain
    {
        $chain = PurchaseRequisitionApprovalChain::inUse()->first();

        $this->assertNotNull($chain, 'No hay cadenas con requisiciones para probar.');

        return $chain;
    }

    private function unusedChain(): PurchaseRequisitionApprovalChain
    {
        $chain = PurchaseRequisitionApprovalChain::unused()->first();

        $this->assertNotNull($chain, 'No hay cadenas sin requisiciones para probar.');

        return $chain;
    }

    public function test_used_chain_only_offers_the_view_action(): void
    {
        Livewire::test(ListPurchaseRequisitionApprovalChains::class)
            ->assertTableActionHidden('edit', $this->usedChain())
            ->assertTableActionVisible('view', $this->usedChain());
    }

    public function test_unused_chain_keeps_the_edit_action(): void
    {
        Livewire::test(ListPurchaseRequisitionApprovalChains::class)
            ->assertTableActionVisible('edit', $this->unusedChain())
            ->assertTableActionHidden('view', $this->unusedChain());
    }

    public function test_the_view_action_opens_and_shows_the_chain(): void
    {
        $chain = $this->usedChain();

        Livewire::test(ListPurchaseRequisitionApprovalChains::class)
            ->mountTableAction('view', $chain)
            ->assertHasNoTableActionErrors()
            ->assertSee($chain->reviewer->name);
    }

    public function test_edit_url_is_closed_for_a_used_chain(): void
    {
        $this->assertFalse(ChainResource::canEdit($this->usedChain()));
        $this->assertTrue(ChainResource::canEdit($this->unusedChain()));

        $this->get(ChainResource::getUrl('edit', ['record' => $this->usedChain()]))
            ->assertForbidden();
    }
}
