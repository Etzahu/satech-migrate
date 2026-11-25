<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource\Pages\ManagePR;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages\AddItemPR;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages\ListPurchaseOrders;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages\ViewOrder;
use App\Models\PurchaseOrder;
use App\Models\User;
use App\Services\GoogleSheetsService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Queue\CallQueuedClosure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * El comprador archiva órdenes que no están en revisión para sacarlas de sus
 * pestañas. Archivar no cambia el estatus; el historial y su reporte lo
 * muestran aparte.
 *
 * Corre contra la base real dentro de una transacción. Bus::fake() evita que
 * el observer de la orden exporte a las hojas de Google reales, y
 * Mail::fake() que salgan correos.
 */
class PurchaserArchiveOrdersTest extends TestCase
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
            'name' => 'Prueba archivar órdenes',
            'email' => 'prueba.archivar.orden@gptservices.com',
            'puesto' => 'Prueba',
            'active' => true,
        ]);
        $this->buyer->assignRole('comprador');

        $this->actingAs($this->buyer);
    }

    /**
     * Órdenes reales de una misma empresa, puestas a nombre del comprador de
     * prueba, sin archivar y en el estatus indicado.
     *
     * @return Collection<int, PurchaseOrder>
     */
    private function buyerOrders(string $status, int $count = 1): Collection
    {
        $query = PurchaseOrder::query()->whereHas('requisition.project')->latest('id');

        $companyId = (clone $query)->value('company_id');
        $this->assertNotNull($companyId, 'No hay órdenes para probar.');

        $orders = $query->where('company_id', $companyId)->take($count)->get();
        $this->assertCount($count, $orders, 'No hay suficientes órdenes de una misma empresa para probar.');

        session(['company_id' => $companyId]);

        return $orders->each(fn (PurchaseOrder $order) => $order
            ->forceFill(['status' => $status, 'purchaser_user_id' => $this->buyer->id, 'archived_at' => null])
            ->saveQuietly());
    }

    private function buyerOrder(string $status): PurchaseOrder
    {
        return $this->buyerOrders($status)->first();
    }

    /**
     * Una orden con partidas y proveedor, para abrir su vista.
     */
    private function viewableOrder(string $status): PurchaseOrder
    {
        $order = PurchaseOrder::query()
            ->whereHas('requisition.project')
            ->whereHas('provider')
            ->whereHas('items')
            ->whereDoesntHave('items', fn ($items) => $items->where('unit_price', 0))
            ->latest('id')
            ->first();

        $this->assertNotNull($order, 'No hay órdenes con partidas para probar.');

        session(['company_id' => $order->company_id]);

        $order->forceFill(['status' => $status, 'purchaser_user_id' => $this->buyer->id, 'archived_at' => null])->saveQuietly();

        return $order;
    }

    // ── Cuándo se puede ─────────────────────────────────────────────────────

    /**
     * @return array<string, array{string}>
     */
    public static function outOfReviewStatuses(): array
    {
        return [
            'borrador' => ['borrador'],
            'devuelta' => ['devuelto por gerente de compras'],
            'devuelta por liberación' => ['devuelto por liberación'],
            'reabierta' => ['reabierta para edición'],
            'liberada' => ['autorizada para proveedor'],
            'cancelada' => ['cancelado por administrador'],
        ];
    }

    #[DataProvider('outOfReviewStatuses')]
    public function test_se_archiva_mientras_no_este_en_revision(string $status): void
    {
        $this->assertTrue((new PurchaseOrder(['status' => $status]))->canBeArchived());
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

    #[DataProvider('reviewStatuses')]
    public function test_no_se_archiva_en_revision(string $status): void
    {
        $this->assertFalse((new PurchaseOrder(['status' => $status]))->canBeArchived());
    }

    public function test_una_archivada_no_se_vuelve_a_archivar(): void
    {
        $order = new PurchaseOrder(['status' => 'autorizada para proveedor']);
        $order->archived_at = now();

        $this->assertFalse($order->canBeArchived());
    }

    // ── Qué hace ────────────────────────────────────────────────────────────

    public function test_archivar_no_mueve_la_fecha_de_actualizacion_ni_exporta_a_sheets(): void
    {
        $order = $this->buyerOrder('autorizada para proveedor');
        $updatedAt = $order->fresh()->updated_at;

        $this->travel(5)->minutes();
        $order->archive();

        $order->refresh();
        $this->assertTrue($order->isArchived());
        $this->assertTrue($updatedAt->equalTo($order->updated_at));
        Bus::assertNotDispatchedAfterResponse(CallQueuedClosure::class);

        // Control: un cambio real a la orden sí exporta.
        $order->forceFill(['observations' => 'Cambio real'])->save();
        Bus::assertDispatchedAfterResponse(CallQueuedClosure::class);
    }

    public function test_si_cambia_de_estatus_vuelve_a_las_pestanas_del_comprador(): void
    {
        $order = $this->buyerOrder('autorizada para proveedor');
        $order->archive();

        $order->status()->transitionTo('reabierta para edición');

        $this->assertFalse($order->fresh()->isArchived());
    }

    // ── Mis órdenes ─────────────────────────────────────────────────────────

    /**
     * @return array<string, array{string, string}>
     */
    public static function buyerTabs(): array
    {
        return [
            'borradores' => ['draft', 'borrador'],
            'reabiertas' => ['reopened', 'reabierta para edición'],
            'liberadas' => ['released', 'autorizada para proveedor'],
        ];
    }

    #[DataProvider('buyerTabs')]
    public function test_el_comprador_archiva_y_la_orden_pasa_a_archivadas(string $tab, string $status): void
    {
        $order = $this->buyerOrder($status);

        Livewire::test(ListPurchaseOrders::class)
            ->set('activeTab', $tab)
            ->assertCanSeeTableRecords([$order])
            ->callTableAction('archive', $order)
            ->assertNotified('Orden archivada')
            ->assertCanNotSeeTableRecords([$order])
            ->set('activeTab', 'archived')
            ->assertCanSeeTableRecords([$order]);

        $this->assertTrue($order->fresh()->isArchived());
        $this->assertSame($status, $order->fresh()->status);
    }

    public function test_desarchivar_la_regresa_a_su_pestana(): void
    {
        $order = $this->buyerOrder('autorizada para proveedor');
        $order->archive();

        Livewire::test(ListPurchaseOrders::class)
            ->set('activeTab', 'archived')
            ->assertTableActionHidden('archive', $order)
            ->callTableAction('unarchive', $order)
            ->assertNotified('Orden desarchivada')
            ->assertCanNotSeeTableRecords([$order])
            ->set('activeTab', 'released')
            ->assertCanSeeTableRecords([$order]);

        $this->assertFalse($order->fresh()->isArchived());
    }

    public function test_archiva_varias_en_lote(): void
    {
        $orders = $this->buyerOrders('autorizada para proveedor', 2);

        Livewire::test(ListPurchaseOrders::class)
            ->set('activeTab', 'released')
            ->callTableBulkAction('archive_selected', $orders)
            ->assertNotified('2 órdenes archivadas');

        foreach ($orders as $order) {
            $this->assertTrue($order->fresh()->isArchived());
        }
    }

    public function test_desarchiva_varias_en_lote(): void
    {
        $orders = $this->buyerOrders('autorizada para proveedor', 2);
        $orders->each(fn (PurchaseOrder $order) => $order->archive());

        Livewire::test(ListPurchaseOrders::class)
            ->set('activeTab', 'archived')
            ->callTableBulkAction('unarchive_selected', $orders)
            ->assertNotified('2 órdenes desarchivadas');

        foreach ($orders as $order) {
            $this->assertFalse($order->fresh()->isArchived());
        }
    }

    public function test_cada_pestana_ofrece_solo_la_accion_en_lote_que_le_toca(): void
    {
        $this->buyerOrder('autorizada para proveedor');

        Livewire::test(ListPurchaseOrders::class)
            ->set('activeTab', 'released')
            ->assertTableBulkActionVisible('archive_selected')
            ->assertTableBulkActionHidden('unarchive_selected')
            ->set('activeTab', 'archived')
            ->assertTableBulkActionHidden('archive_selected')
            ->assertTableBulkActionVisible('unarchive_selected');
    }

    // ── Archivada solo se ve ────────────────────────────────────────────────

    public function test_archivada_no_se_envia_a_revision_ni_se_edita(): void
    {
        $order = $this->viewableOrder('borrador');

        Livewire::test(ViewOrder::class, ['record' => $order->getRouteKey()])
            ->assertActionVisible('Solicitar')
            ->assertActionVisible('edit')
            ->assertActionHidden('unarchive');

        $order->archive();

        Livewire::test(ViewOrder::class, ['record' => $order->getRouteKey()])
            ->assertActionHidden('Solicitar')
            ->assertActionHidden('edit')
            ->assertActionHidden('Agregar partidas de la requisición')
            ->assertActionVisible('unarchive')
            ->assertSee('Orden archivada. Desarchívala para editarla o enviarla a revisión.');
    }

    public function test_archivada_liberada_no_se_reabre_pero_se_descarga(): void
    {
        $order = $this->viewableOrder('autorizada para proveedor');
        $order->archive();

        Livewire::test(ViewOrder::class, ['record' => $order->getRouteKey()])
            ->assertActionHidden('Reabrir para edición')
            ->assertActionVisible('Descargar orden')
            ->assertActionVisible('Ver pdf');
    }

    public function test_desarchivar_desde_la_vista_devuelve_las_acciones(): void
    {
        $order = $this->viewableOrder('borrador');
        $order->archive();

        Livewire::test(ViewOrder::class, ['record' => $order->getRouteKey()])
            ->callAction('unarchive')
            ->assertNotified('Orden desarchivada')
            ->assertActionVisible('Solicitar')
            ->assertActionVisible('edit');

        $this->assertFalse($order->fresh()->isArchived());
    }

    public function test_el_comprador_no_edita_ni_agrega_partidas_a_una_archivada(): void
    {
        $order = $this->buyerOrder('borrador');
        $this->assertTrue($this->buyer->can('update', $order));

        $order->archive();

        $this->assertFalse($this->buyer->can('update', $order));

        Livewire::test(ListPurchaseOrders::class)
            ->set('activeTab', 'archived')
            ->assertTableActionHidden('edit', $order);

        Livewire::test(AddItemPR::class, ['record' => $order->id])
            ->assertRedirect();
    }

    public function test_el_gerente_de_compras_si_edita_una_archivada(): void
    {
        $order = $this->buyerOrder('borrador');
        $order->archive();

        $manager = User::forceCreate([
            'name' => 'Prueba gerente archivadas',
            'email' => 'prueba.gerente.archivadas@gptservices.com',
            'puesto' => 'Prueba',
            'active' => true,
        ]);
        $manager->assignRole('gerente_compras');

        $this->assertTrue($manager->can('update', $order));
    }

    // ── Historial ───────────────────────────────────────────────────────────

    public function test_el_historial_filtra_las_archivadas(): void
    {
        [$archived, $active] = $this->buyerOrders('autorizada para proveedor', 2)->all();
        $archived->archive();

        Livewire::test(ManagePR::class)
            ->set('activeTab', 'myRequisitions')
            ->assertCanSeeTableRecords([$archived, $active])
            ->filterTable('archived_at', true)
            ->assertCanSeeTableRecords([$archived])
            ->assertCanNotSeeTableRecords([$active])
            ->filterTable('archived_at', false)
            ->assertCanSeeTableRecords([$active])
            ->assertCanNotSeeTableRecords([$archived]);
    }

    public function test_el_reporte_del_historial_marca_las_archivadas(): void
    {
        [$archived, $active] = $this->buyerOrders('autorizada para proveedor', 2)->all();
        $archived->archive();

        $rows = (new GoogleSheetsService)->processOrdersReport([
            'type_save' => 'excel',
            'columns' => ['folio', 'archivada'],
            'created_start' => min($archived->created_at, $active->created_at)->format('Y-m-d'),
            'created_end' => max($archived->created_at, $active->created_at)->format('Y-m-d'),
            'buyers' => [$this->buyer->id],
            'type_purchase' => [],
        ])->keyBy('folio');

        $this->assertSame('Sí', $rows[$archived->folio]['archivada']);
        $this->assertSame('No', $rows[$active->folio]['archivada']);
    }
}
