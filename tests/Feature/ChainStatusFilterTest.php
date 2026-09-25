<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource\Pages\ListPurchaseRequisitionApprovalChains;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Collection;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * El filtro de estado devuelve lo mismo que muestra la columna Estado.
 *
 * El filtro anterior era binario y solo miraba el apagado manual, así que
 * "Solo activas" traía también las bloqueadas por tener a alguien dado de
 * baja. Cada prueba contrasta una opción contra los otros dos estados.
 */
class ChainStatusFilterTest extends TestCase
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
     * Las cadenas de un estado, tal como lo calcula la columna. Se limitan
     * para no chocar con la paginación del listado.
     *
     * @return Collection<int, PurchaseRequisitionApprovalChain>
     */
    private function chainsInState(string $state, int $limit = 5): Collection
    {
        $chains = PurchaseRequisitionApprovalChain::query()
            ->get()
            ->filter(fn (PurchaseRequisitionApprovalChain $chain): bool => match ($state) {
                'desactivada' => $chain->isArchived(),
                'bloqueada' => ! $chain->isArchived() && $chain->hasInactiveUsers(),
                'activa' => ! $chain->isArchived() && ! $chain->hasInactiveUsers(),
            })
            ->take($limit);

        $this->assertNotEmpty($chains, "No hay cadenas en estado {$state} para probar.");

        return $chains;
    }

    public function test_activa_leaves_out_the_blocked_ones(): void
    {
        Livewire::test(ListPurchaseRequisitionApprovalChains::class)
            ->filterTable('estado', 'activa')
            ->assertCanSeeTableRecords($this->chainsInState('activa'))
            ->assertCanNotSeeTableRecords($this->chainsInState('bloqueada'))
            ->assertCanNotSeeTableRecords($this->chainsInState('desactivada'));
    }

    public function test_bloqueada_shows_only_chains_with_someone_on_leave(): void
    {
        Livewire::test(ListPurchaseRequisitionApprovalChains::class)
            ->filterTable('estado', 'bloqueada')
            ->assertCanSeeTableRecords($this->chainsInState('bloqueada'))
            ->assertCanNotSeeTableRecords($this->chainsInState('activa'))
            ->assertCanNotSeeTableRecords($this->chainsInState('desactivada'));
    }

    public function test_desactivada_shows_only_the_ones_switched_off_by_hand(): void
    {
        Livewire::test(ListPurchaseRequisitionApprovalChains::class)
            ->filterTable('estado', 'desactivada')
            ->assertCanSeeTableRecords($this->chainsInState('desactivada'))
            ->assertCanNotSeeTableRecords($this->chainsInState('activa'))
            ->assertCanNotSeeTableRecords($this->chainsInState('bloqueada'));
    }

    /**
     * Sin filtro conviven los tres estados. Además de ser el comportamiento
     * esperado, esto descarta que las pruebas anteriores den verde solo
     * porque la paginación esconda los registros de contraste.
     */
    public function test_without_the_filter_the_three_states_are_visible(): void
    {
        Livewire::test(ListPurchaseRequisitionApprovalChains::class)
            ->assertCanSeeTableRecords($this->chainsInState('activa'))
            ->assertCanSeeTableRecords($this->chainsInState('bloqueada'))
            ->assertCanSeeTableRecords($this->chainsInState('desactivada'));
    }

    /**
     * Los tres estados reparten el total sin traslapes ni huecos: es lo que
     * permite leer el filtro como una partición del listado.
     */
    public function test_the_three_states_add_up_to_every_chain(): void
    {
        $total = PurchaseRequisitionApprovalChain::count();

        $counted = collect(['activa', 'bloqueada', 'desactivada'])
            ->sum(fn (string $state): int => $this->chainsInState($state, PHP_INT_MAX)->count());

        $this->assertSame($total, $counted);
    }
}
