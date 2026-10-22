<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages\EditPurchaseRequisition;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\RelationManagers\ItemsRelationManager;
use App\Models\MeasureUnit;
use App\Models\Product;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionItem;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Al agregar una partida, el select de producto/servicio muestra primero lo
 * que el solicitante ya ha pedido, luego lo que él mismo dio de alta en el
 * catálogo y al final el resto del catálogo.
 */
class RequisitionItemProductOrderTest extends TestCase
{
    use DatabaseTransactions;

    private PurchaseRequisition $requisition;

    private User $requester;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');

        $requisition = PurchaseRequisition::query()
            ->with('approvalChain.requester')
            ->where('status', 'borrador')
            ->whereHas('approvalChain.requester', fn ($query) => $query->where('active', 1))
            ->latest('id')
            ->take(50)
            ->get()
            ->first(fn (PurchaseRequisition $requisition) => $requisition->approvalChain->requester->hasRole('solicita_requisicion_compra'));

        $this->assertNotNull($requisition, 'No hay un borrador con un solicitante activo para probar las partidas.');

        $this->requisition = $requisition;
        $this->requester = $requisition->approvalChain->requester;

        $this->actingAs($this->requester);

        session([
            'company_id' => $requisition->company_id,
            'company_name' => 'test',
            'company_acronym' => 'T',
        ]);
    }

    public function test_requested_products_come_first_then_captured_then_the_rest(): void
    {
        // Se crean en orden inverso al esperado para que el orden natural por id
        // no pase la prueba por casualidad.
        $capturedByAnotherUser = $this->product(capturedBy: User::where('id', '!=', $this->requester->id)->value('id'));
        $capturedByRequester = $this->product(capturedBy: $this->requester->id);
        $requestedBefore = $this->product(capturedBy: null);

        PurchaseRequisitionItem::create([
            'requisition_id' => $this->requisition->id,
            'product_id' => $requestedBefore->id,
            'quantity_requested' => 1,
            'quantity_purchase' => 1,
        ]);

        $productIds = $this->productOptionIds();

        $this->assertSame($requestedBefore->id, $productIds[0], 'El último producto pedido no quedó primero.');
        $this->assertLessThan(
            array_search($capturedByAnotherUser->id, $productIds),
            array_search($capturedByRequester->id, $productIds),
            'El producto capturado por el solicitante no quedó antes del resto del catálogo.',
        );
    }

    public function test_captured_product_never_jumps_ahead_of_requested_ones(): void
    {
        $requestedBefore = $this->product(capturedBy: null);
        $capturedByRequester = $this->product(capturedBy: $this->requester->id);

        PurchaseRequisitionItem::create([
            'requisition_id' => $this->requisition->id,
            'product_id' => $requestedBefore->id,
            'quantity_requested' => 1,
            'quantity_purchase' => 1,
        ]);

        $productIds = $this->productOptionIds();

        $this->assertLessThan(
            array_search($capturedByRequester->id, $productIds),
            array_search($requestedBefore->id, $productIds),
        );
    }

    /**
     * Producto aprobado que aparece en el select de esta requisición.
     */
    private function product(?int $capturedBy): Product
    {
        return Product::create([
            'name' => 'Producto de prueba '.uniqid(),
            'code' => 'TEST-'.uniqid(),
            'status' => 'aprobado',
            'type_purchase' => $this->requisition->category ?? 'proveeduria',
            'company_id' => $this->requisition->company_id,
            'unit_id' => MeasureUnit::query()->value('id'),
            'requester_id' => $capturedBy,
        ]);
    }

    /**
     * IDs de las opciones del select de producto/servicio, en el orden en que
     * se muestran al agregar una partida.
     *
     * @return array<int, int>
     */
    private function productOptionIds(): array
    {
        $productIds = [];

        Livewire::test(ItemsRelationManager::class, [
            'ownerRecord' => $this->requisition,
            'pageClass' => EditPurchaseRequisition::class,
        ])
            ->mountAction(TestAction::make('create')->table())
            ->assertFormFieldExists('product_id', function (Select $select) use (&$productIds): bool {
                $productIds = array_keys($select->getOptions());

                return true;
            });

        return $productIds;
    }
}
