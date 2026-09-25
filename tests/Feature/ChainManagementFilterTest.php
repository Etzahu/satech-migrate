<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource\Pages\ListPurchaseRequisitionApprovalChains;
use App\Models\Management;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Collection;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * El listado de cadenas se puede acotar al área de quien solicita: elegir una
 * gerencia deja a la vista las cadenas de todos sus solicitantes y esconde las
 * demás.
 */
class ChainManagementFilterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');

        $admin = User::role('super_admin')->first();

        $this->assertNotNull($admin, 'No hay un super_admin para probar el panel.');

        $this->actingAs($admin);
    }

    /**
     * Una gerencia que tenga cadenas propias y que no sea la única con ellas:
     * sin una segunda gerencia en juego, la prueba no distinguiría un filtro
     * que funciona de uno que no filtra nada.
     */
    private function managementWithChains(): Management
    {
        $management = Management::query()
            ->whereHas('users.approvalChainsPurchaseRequisition')
            ->first();

        $this->assertNotNull($management, 'No hay ninguna gerencia con cadenas para probar.');

        return $management;
    }

    /** @return Collection<int, PurchaseRequisitionApprovalChain> */
    private function chainsOfManagement(Management $management)
    {
        return PurchaseRequisitionApprovalChain::query()
            ->whereHas('requester', fn ($query) => $query->where('management_id', $management->id))
            ->get();
    }

    /**
     * Las cadenas con las que se contrasta. Son las mismas en las dos pruebas
     * a propósito: si el listado paginara y las dejara fuera por sí solo, la
     * prueba sin filtro lo delataría en vez de dar un falso verde.
     *
     * @return Collection<int, PurchaseRequisitionApprovalChain>
     */
    private function chainsOfOtherManagements(Management $management)
    {
        $chains = PurchaseRequisitionApprovalChain::query()
            ->whereHas('requester', fn ($query) => $query->where('management_id', '!=', $management->id))
            ->limit(5)
            ->get();

        $this->assertNotEmpty($chains, 'No hay cadenas de otras gerencias para contrastar.');

        return $chains;
    }

    public function test_the_filter_lists_every_chain_of_that_management(): void
    {
        $management = $this->managementWithChains();

        $expected = $this->chainsOfManagement($management);

        Livewire::test(ListPurchaseRequisitionApprovalChains::class)
            ->filterTable('requester_management', $management->id)
            ->assertCanSeeTableRecords($expected);
    }

    public function test_the_filter_hides_chains_of_other_managements(): void
    {
        $management = $this->managementWithChains();

        Livewire::test(ListPurchaseRequisitionApprovalChains::class)
            ->filterTable('requester_management', $management->id)
            ->assertCanNotSeeTableRecords($this->chainsOfOtherManagements($management));
    }

    public function test_without_the_filter_those_same_chains_are_visible(): void
    {
        $management = $this->managementWithChains();

        Livewire::test(ListPurchaseRequisitionApprovalChains::class)
            ->assertCanSeeTableRecords($this->chainsOfOtherManagements($management));
    }

    public function test_every_management_is_offered_with_its_acronym(): void
    {
        $management = $this->managementWithChains();

        Livewire::test(ListPurchaseRequisitionApprovalChains::class)
            ->assertTableFilterExists(
                'requester_management',
                fn ($filter) => in_array(
                    trim($management->name)." ({$management->acronym})",
                    $filter->getOptions(),
                    true,
                ),
            );
    }
}
