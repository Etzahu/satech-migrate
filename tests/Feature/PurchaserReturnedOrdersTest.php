<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages\AddItemPR;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages\ListPurchaseOrders;
use App\Models\PurchaseOrder;
use App\Models\User;
use App\Services\StalledOrderService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Toda orden en manos del comprador (borrador, reabierta, devuelta por
 * cualquier nivel o reasignada) aparece en su pestaña Borradores y puede
 * editarla y agregarle partidas. Antes faltaban las devueltas por liberación
 * y por Dirección General, y las reasignadas: no salían en ninguna pestaña.
 *
 * Corre contra la base real dentro de una transacción. Bus::fake() evita que
 * el observer de la orden exporte a las hojas de Google reales, y
 * Mail::fake() que salgan correos.
 */
class PurchaserReturnedOrdersTest extends TestCase
{
    use DatabaseTransactions;

    private User $buyer;

    protected function setUp(): void
    {
        parent::setUp();

        Bus::fake();
        Mail::fake();

        Filament::setCurrentPanel('compras');

        $this->buyer = User::forceCreate([
            'name' => 'Prueba órdenes devueltas',
            'email' => 'prueba.ordenes.devueltas@gptservices.com',
            'puesto' => 'Prueba',
            'active' => true,
        ]);
        $this->buyer->assignRole('comprador');

        $this->actingAs($this->buyer);
    }

    /**
     * Una orden real a nombre del comprador de prueba, en el estatus indicado.
     */
    private function buyerOrder(string $status): PurchaseOrder
    {
        $order = PurchaseOrder::query()->whereHas('requisition.items')->latest('id')->first();
        $this->assertNotNull($order, 'No hay órdenes para probar.');

        session(['company_id' => $order->company_id]);

        $order->forceFill(['status' => $status, 'purchaser_user_id' => $this->buyer->id, 'archived_at' => null])->saveQuietly();

        return $order;
    }

    /**
     * @return array<string, array{string}>
     */
    public static function purchaserStatuses(): array
    {
        return collect(PurchaseOrder::PURCHASER_STATUSES)
            ->mapWithKeys(fn (string $status): array => [$status => [$status]])
            ->all();
    }

    /**
     * @return array<string, array{string}>
     */
    public static function reviewStatuses(): array
    {
        return collect(PurchaseOrder::REVIEW_STATUSES)
            ->mapWithKeys(fn (string $status): array => [$status => [$status]])
            ->all();
    }

    #[DataProvider('purchaserStatuses')]
    public function test_aparece_en_borradores_y_el_comprador_la_edita(string $status): void
    {
        $order = $this->buyerOrder($status);

        $this->assertTrue($this->buyer->can('update', $order));

        Livewire::test(ListPurchaseOrders::class)
            ->set('activeTab', 'draft')
            ->assertCanSeeTableRecords([$order])
            ->assertTableActionVisible('edit', $order);
    }

    #[DataProvider('purchaserStatuses')]
    public function test_el_comprador_puede_agregarle_partidas(string $status): void
    {
        $order = $this->buyerOrder($status);

        Livewire::test(AddItemPR::class, ['record' => $order->id])
            ->assertNoRedirect();
    }

    #[DataProvider('reviewStatuses')]
    public function test_en_revision_no_aparece_en_borradores_ni_se_edita(string $status): void
    {
        $order = $this->buyerOrder($status);

        $this->assertFalse($this->buyer->can('update', $order));

        Livewire::test(ListPurchaseOrders::class)
            ->set('activeTab', 'draft')
            ->assertCanNotSeeTableRecords([$order]);

        Livewire::test(AddItemPR::class, ['record' => $order->id])
            ->assertRedirect();
    }

    public function test_las_ordenes_detenidas_usan_la_misma_lista(): void
    {
        $this->assertSame(PurchaseOrder::PURCHASER_STATUSES, StalledOrderService::EN_CANCHA_DEL_COMPRADOR);
    }
}
