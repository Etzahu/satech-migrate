<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\ProductResource\Pages\EditProduct;
use App\Models\MeasureUnit;
use App\Models\Product;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequisitionItem;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use LogicException;
use Tests\TestCase;

/**
 * Las partidas de requisición y de orden de compra se borran en cascada con
 * su producto, así que un producto que ya se usó en compras no se puede
 * eliminar del catálogo.
 */
class ProductDeletionGuardTest extends TestCase
{
    use DatabaseTransactions;

    private User $purchasingManager;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');

        $purchasingManager = User::withRole('gerente_compras')->where('active', 1)->first();

        $this->assertNotNull($purchasingManager, 'No hay un gerente de compras activo para probar el catálogo.');
        $this->assertTrue($purchasingManager->can('delete_product'), 'El gerente de compras ya no tiene permiso de eliminar productos.');

        $this->purchasingManager = $purchasingManager;
        $this->actingAs($purchasingManager);

        session([
            'company_id' => $this->usedProduct()->company_id,
            'company_name' => 'test',
            'company_acronym' => 'T',
        ]);
    }

    public function test_used_product_shows_a_disabled_delete_button_that_explains_why(): void
    {
        $product = $this->usedProduct();

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->assertActionVisible(DeleteAction::class)
            ->assertActionDisabled(DeleteAction::class)
            ->callAction(DeleteAction::class);

        $this->assertModelExists($product);
        $this->assertStringStartsWith(
            'No se puede eliminar: se usa en',
            Gate::forUser($this->purchasingManager)->inspect('delete', $product)->message(),
        );
    }

    public function test_unused_product_can_still_be_deleted(): void
    {
        $product = $this->unusedProduct();

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->assertActionEnabled(DeleteAction::class)
            ->callAction(DeleteAction::class);

        $this->assertModelMissing($product);
    }

    public function test_deleting_a_used_product_from_code_is_refused_and_keeps_its_lines(): void
    {
        $product = $this->usedProduct();
        $orderLinesBefore = PurchaseOrderItem::where('product_id', $product->id)->count();

        try {
            $product->delete();
            $this->fail('Se eliminó un producto que ya se usó en compras.');
        } catch (LogicException $exception) {
            $this->assertStringContainsString('partidas de compra', $exception->getMessage());
        }

        $this->assertModelExists($product);
        $this->assertSame($orderLinesBefore, PurchaseOrderItem::where('product_id', $product->id)->count());
    }

    public function test_trashed_requisition_lines_and_replacements_also_count_as_use(): void
    {
        $product = $this->unusedProduct();

        DB::table('purchase_requisition_items')
            ->where('id', PurchaseRequisitionItem::query()->value('id'))
            ->update(['product_id' => $product->id, 'deleted_at' => now()]);

        DB::table('purchase_order_items')
            ->where('id', PurchaseOrderItem::query()->value('id'))
            ->update(['product_replace_id' => $product->id]);

        $this->assertSame(2, $product->purchaseLinesCount());
        $this->assertFalse(Gate::forUser($this->purchasingManager)->allows('delete', $product));
    }

    private function usedProduct(): Product
    {
        return Product::query()
            ->whereIn('id', PurchaseOrderItem::query()->select('product_id'))
            ->firstOrFail();
    }

    private function unusedProduct(): Product
    {
        return Product::create([
            'name' => 'producto sin uso '.uniqid(),
            'code' => 'Sin código asignado',
            'status' => 'aprobado',
            'type_purchase' => 'proveeduria',
            'company_id' => session('company_id'),
            'unit_id' => MeasureUnit::query()->value('id'),
        ]);
    }
}
