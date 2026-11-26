<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource\Pages\ManagePR;
use App\Models\PurchaseOrder;
use App\Models\User;
use App\Services\PurchaseOrderReportService;
use App\Services\SpreadsheetExporter;
use Carbon\CarbonInterface;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use OpenSpout\Writer\Common\AbstractOptions;
use Tests\TestCase;

/**
 * El reporte de órdenes del historial: en rangos largos expiraba a los 30 s
 * por hacer varias consultas por orden y por partida, y en Laragon fallaba
 * porque OpenSpout armaba el Excel en C:\Windows\Temp, que PHP no puede
 * escribir.
 *
 * Corre contra la base real dentro de una transacción.
 */
class PurchaseOrderReportTest extends TestCase
{
    use DatabaseTransactions;

    private const COLUMNS = ['fecha de creacion', 'comprador', 'folio', 'partidas', 'proveedor', 'subtotal', 'total', 'moneda', 'proyecto'];

    protected function setUp(): void
    {
        parent::setUp();

        Bus::fake();
        Mail::fake();

        Filament::setCurrentPanel('compras');

        $manager = User::forceCreate([
            'name' => 'Prueba reporte de órdenes',
            'email' => 'prueba.reporte.ordenes@gptservices.com',
            'puesto' => 'Prueba',
            'active' => true,
        ]);
        $manager->assignRole('gerente_compras');

        $this->actingAs($manager);
    }

    /**
     * Rango de fechas de las últimas órdenes de la empresa con más órdenes,
     * con esa empresa en la sesión como lo hace el panel.
     *
     * @return array{start: CarbonInterface, end: CarbonInterface}
     */
    private function recentOrdersRange(int $count = 40): array
    {
        $companyId = PurchaseOrder::query()
            ->selectRaw('company_id, count(*) as total')
            ->groupBy('company_id')
            ->orderByDesc('total')
            ->value('company_id');

        $this->assertNotNull($companyId, 'No hay órdenes para probar.');

        session(['company_id' => $companyId]);

        $orders = PurchaseOrder::query()
            ->where('company_id', $companyId)
            ->latest('created_at')
            ->take($count)
            ->get('created_at');

        $this->assertCount($count, $orders, 'No hay suficientes órdenes de una misma empresa para probar.');

        return ['start' => $orders->min('created_at'), 'end' => $orders->max('created_at')];
    }

    /**
     * @param  array{start: CarbonInterface, end: CarbonInterface}  $range
     * @return array<string, mixed>
     */
    private function reportData(array $range): array
    {
        return [
            'type_save' => 'excel',
            'columns' => self::COLUMNS,
            'created_start' => $range['start']->format('Y-m-d'),
            'created_end' => $range['end']->format('Y-m-d'),
            'buyers' => null,
            'type_purchase' => [],
        ];
    }

    /**
     * @param  array{start: CarbonInterface, end: CarbonInterface}  $range
     * @return Collection<int, PurchaseOrder>
     */
    private function ordersIn(array $range): Collection
    {
        return PurchaseOrder::query()
            ->with(['requisition', 'items'])
            ->where('company_id', session('company_id'))
            ->whereBetween('created_at', [$range['start']->copy()->startOfDay(), $range['end']->copy()->endOfDay()])
            ->get();
    }

    public function test_el_reporte_no_hace_consultas_por_cada_orden_ni_partida(): void
    {
        $range = $this->recentOrdersRange();
        $ordersCount = $this->ordersIn($range)->count();

        $queries = 0;
        DB::listen(function () use (&$queries): void {
            $queries++;
        });

        $result = (new PurchaseOrderReportService)->generateReport($this->reportData($range));

        $this->assertCount($ordersCount, $result['sheets']->get('ordenes'));
        $this->assertLessThan(
            20,
            $queries,
            "El reporte de {$ordersCount} órdenes hizo {$queries} consultas; debería ser un número fijo."
        );
    }

    public function test_cada_partida_lleva_el_folio_de_su_orden_y_su_requisicion(): void
    {
        $range = $this->recentOrdersRange();
        $orders = $this->ordersIn($range);

        $result = (new PurchaseOrderReportService)->generateReport($this->reportData($range));
        $rowsByOrder = collect($result['sheets']->get('partidas'))->groupBy('Orden');

        $this->assertSame($orders->sum(fn (PurchaseOrder $order) => $order->items->count()), count($result['sheets']->get('partidas')));

        foreach ($orders->filter(fn (PurchaseOrder $order) => $order->items->isNotEmpty()) as $order) {
            $rows = $rowsByOrder->get($order->folio);

            $this->assertNotNull($rows, "Faltan las partidas de la orden {$order->folio}.");
            $this->assertCount($order->items->count(), $rows);
            $this->assertSame([$order->requisition->folio], $rows->pluck('Requisicion')->unique()->values()->all());
        }
    }

    public function test_el_excel_se_arma_en_la_carpeta_temporal_de_storage(): void
    {
        $usedTempFolder = null;
        $path = storage_path('app/temp/prueba-reporte-ordenes.xlsx');

        try {
            SpreadsheetExporter::make([['Folio' => 'OC-1']])
                ->configureWriterUsing(function (AbstractOptions $options) use (&$usedTempFolder) {
                    $usedTempFolder = $options->getTempFolder();

                    return null;
                })
                ->export($path);

            $this->assertSame(storage_path('app/temp'), $usedTempFolder);
            $this->assertFileExists($path);
        } finally {
            File::delete($path);
        }
    }

    public function test_generar_reporte_descarga_el_excel(): void
    {
        $range = $this->recentOrdersRange(5);

        Livewire::test(ManagePR::class)
            ->callAction(TestAction::make('Generar reporte')->table(), data: [
                'columns' => self::COLUMNS,
                'created_start' => $range['start']->format('Y-m-d'),
                'created_end' => $range['end']->format('Y-m-d'),
            ])
            ->assertHasNoFormErrors()
            ->assertFileDownloaded("ordenes de compra {$range['start']->format('d-m-Y')} {$range['end']->format('d-m-Y')}.xlsx");
    }
}
