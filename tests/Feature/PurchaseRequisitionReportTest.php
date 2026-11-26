<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseRequisition\HistoryResource\Pages\ManagePR;
use App\Models\PurchaseRequisition;
use App\Models\User;
use Carbon\CarbonInterface;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * El reporte en Excel del historial de requisiciones. La hoja de partidas
 * cargaba la requisición de cada partida por separado: una consulta por
 * partida, que en rangos largos acercaba la petición al límite de 30 s.
 *
 * Corre contra la base real dentro de una transacción.
 */
class PurchaseRequisitionReportTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Bus::fake();
        Mail::fake();

        Filament::setCurrentPanel('compras');

        $manager = User::forceCreate([
            'name' => 'Prueba reporte de requisiciones',
            'email' => 'prueba.reporte.requisiciones@gptservices.com',
            'puesto' => 'Prueba',
            'active' => true,
        ]);
        $manager->assignRole('gerente_compras');

        $this->actingAs($manager);
    }

    /**
     * Rango de fechas de las últimas requisiciones con orden de la empresa
     * que más tiene, con esa empresa en la sesión como lo hace el panel.
     *
     * @return array{start: CarbonInterface, end: CarbonInterface}
     */
    private function recentRequisitionsWithOrdersRange(int $count): array
    {
        $companyId = PurchaseRequisition::query()
            ->whereHas('orders')
            ->selectRaw('company_id, count(*) as total')
            ->groupBy('company_id')
            ->orderByDesc('total')
            ->value('company_id');

        $this->assertNotNull($companyId, 'No hay requisiciones con orden para probar.');

        session(['company_id' => $companyId]);

        $requisitions = PurchaseRequisition::query()
            ->where('company_id', $companyId)
            ->whereHas('orders')
            ->latest('created_at')
            ->take($count)
            ->get('created_at');

        $this->assertCount($count, $requisitions, 'No hay suficientes requisiciones con orden de una misma empresa para probar.');

        return ['start' => $requisitions->min('created_at'), 'end' => $requisitions->max('created_at')];
    }

    /**
     * @param  array{start: CarbonInterface, end: CarbonInterface}  $range
     * @return Collection<int, PurchaseRequisition>
     */
    private function requisitionsWithOrdersIn(array $range): Collection
    {
        return PurchaseRequisition::query()
            ->with('items')
            ->where('company_id', session('company_id'))
            ->whereHas('orders')
            ->whereBetween('created_at', [$range['start']->copy()->startOfDay(), $range['end']->copy()->endOfDay()])
            ->get();
    }

    /**
     * @param  array{start: CarbonInterface, end: CarbonInterface}  $range
     */
    private function generateReport(array $range): Testable
    {
        return Livewire::test(ManagePR::class)
            ->callAction(TestAction::make('Generar reporte')->table(), data: [
                'type_save' => 'excel',
                'columns' => ['folio', 'motivo', 'partidas'],
                'without_orders' => true,
                'created_start' => $range['start']->format('Y-m-d'),
                'created_end' => $range['end']->format('Y-m-d'),
            ])
            ->assertHasNoFormErrors();
    }

    /**
     * Las filas de la hoja «partidas» del Excel que descargó el componente.
     *
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    private function downloadedItemRows(Testable $component): \Illuminate\Support\Collection
    {
        $path = storage_path('app/temp/prueba-reporte-requisiciones.xlsx');

        File::ensureDirectoryExists(dirname($path));
        File::put($path, base64_decode($component->effects['download']['content']));

        try {
            return collect(fastexcel()->withSheetsNames()->importSheets($path)->get('partidas'));
        } finally {
            File::delete($path);
        }
    }

    public function test_la_hoja_de_partidas_no_hace_una_consulta_por_partida(): void
    {
        $range = $this->recentRequisitionsWithOrdersRange(60);
        $itemsCount = $this->requisitionsWithOrdersIn($range)->sum(fn (PurchaseRequisition $requisition) => $requisition->items->count());

        $component = Livewire::test(ManagePR::class);

        $queries = 0;
        DB::listen(function () use (&$queries): void {
            $queries++;
        });

        $component->callAction(TestAction::make('Generar reporte')->table(), data: [
            'type_save' => 'excel',
            'columns' => ['folio', 'motivo', 'partidas'],
            'without_orders' => true,
            'created_start' => $range['start']->format('Y-m-d'),
            'created_end' => $range['end']->format('Y-m-d'),
        ]);

        $this->assertGreaterThan(60, $itemsCount);
        $this->assertLessThan(
            $itemsCount,
            $queries,
            "Generar el reporte de {$itemsCount} partidas hizo {$queries} consultas; no debería crecer con las partidas."
        );
    }

    public function test_cada_partida_lleva_el_folio_de_su_requisicion(): void
    {
        $range = $this->recentRequisitionsWithOrdersRange(10);
        $requisitions = $this->requisitionsWithOrdersIn($range);

        $component = $this->generateReport($range)
            ->assertFileDownloaded("requisiciones de compra {$range['start']->format('d-m-Y')} {$range['end']->format('d-m-Y')}.xlsx");

        $rowsByRequisition = $this->downloadedItemRows($component)->countBy('Requisición');

        $this->assertSame(
            $requisitions->filter(fn (PurchaseRequisition $requisition) => $requisition->items->isNotEmpty())
                ->mapWithKeys(fn (PurchaseRequisition $requisition) => [$requisition->folio => $requisition->items->count()])
                ->sortKeys()
                ->all(),
            $rowsByRequisition->sortKeys()->all()
        );
    }
}
