<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\RequestIncorporation\CatalogResource\Pages\ListProducts;
use App\Imports\CatalogProductImport;
use App\Mail\CatalogBulkNotification;
use App\Mail\CatalogNotification;
use App\Models\Company;
use App\Models\MeasureUnit;
use App\Models\Product;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use Rap2hpoutre\FastExcel\FastExcel;
use Tests\TestCase;

/**
 * Altas de productos/servicios desde Excel: todo o nada, con errores que
 * señalan la fila de Excel y un solo correo de resumen a Compras.
 */
class CatalogProductImportTest extends TestCase
{
    use DatabaseTransactions;

    private const HEADERS = ['Descripción', 'Unidad de medida', 'Tipo'];

    private User $requester;

    private int $companyId;

    private string $marker;

    private MeasureUnit $unit;

    /** @var list<string> */
    private array $files = [];

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Filament::setCurrentPanel('compras');

        $requester = User::role('solicita_requisicion_compra')->where('active', 1)->first();

        $this->assertNotNull($requester, 'No hay un solicitante activo para probar las altas.');

        $this->requester = $requester;
        $this->companyId = Company::query()->value('id');
        $this->marker = strtolower(uniqid('xls'));
        $this->unit = MeasureUnit::create(['name' => "Galón {$this->marker}", 'acronym' => "GL{$this->marker}"]);

        $this->actingAs($this->requester);

        session([
            'company_id' => $this->companyId,
            'company_name' => 'test',
            'company_acronym' => 'T',
        ]);
    }

    protected function tearDown(): void
    {
        foreach ($this->files as $file) {
            @unlink($file);
        }

        parent::tearDown();
    }

    public function test_valid_rows_create_pending_products_like_the_manual_form(): void
    {
        $result = $this->import([
            ["  Guantes   de NITRILO {$this->marker} ", "galon {$this->marker}", 'Producto'],
            ["Mantenimiento {$this->marker}", "gl{$this->marker}", 'servicio'],
        ]);

        $this->assertSame([], $result['errors']);
        $this->assertCount(2, $result['products']);

        $gloves = $this->importedProducts()->firstWhere('name', "guantes de nitrilo {$this->marker}");
        $maintenance = $this->importedProducts()->firstWhere('name', "mantenimiento {$this->marker}");

        $this->assertNotNull($gloves, 'La descripción no se limpió igual que en el formulario.');
        $this->assertNotNull($maintenance);

        $this->assertSame('proveeduria', $gloves->type_purchase);
        $this->assertSame('servicio', $maintenance->type_purchase);

        foreach ([$gloves, $maintenance] as $product) {
            $this->assertSame($this->unit->id, $product->unit_id, 'La unidad no se encontró por nombre sin acento o por abreviatura.');
            $this->assertSame('pendiente', $product->status);
            $this->assertSame('Sin código asignado', $product->code);
            $this->assertEquals($this->companyId, $product->company_id);
            $this->assertEquals($this->requester->id, $product->requester_id);
        }
    }

    public function test_one_invalid_row_rejects_the_whole_file(): void
    {
        $result = $this->import([
            ["Producto bueno {$this->marker}", $this->unit->name, 'Producto'],
            ["Producto malo {$this->marker}", 'Unidad que no existe', 'Equipo'],
        ]);

        $this->assertCount(0, $result['products']);
        $this->assertSame([
            'Fila 3: la unidad de medida «Unidad que no existe» no existe; usa una de la hoja «Unidades de medida»; el tipo «Equipo» no es válido; escribe Producto o Servicio.',
        ], $result['errors']);
        $this->assertCount(0, $this->importedProducts(), 'Se guardó la fila buena aunque otra tenía errores.');
    }

    public function test_blank_rows_are_skipped_and_errors_name_the_excel_row(): void
    {
        $result = $this->import([
            ["Producto {$this->marker}", $this->unit->name, 'Producto'],
            [],
            ['', $this->unit->name, ''],
        ]);

        $this->assertSame(['Fila 4: falta la descripción; falta el tipo.'], $result['errors']);
    }

    public function test_repeated_description_is_reported_against_its_first_row(): void
    {
        $result = $this->import([
            ["Cinta adhesiva {$this->marker}", $this->unit->name, 'Producto'],
            ["CINTA  ADHESIVA {$this->marker}", $this->unit->name, 'Producto'],
        ]);

        $this->assertSame(['Fila 3: la descripción ya está en la fila 2.'], $result['errors']);
    }

    public function test_description_longer_than_the_form_allows_is_rejected(): void
    {
        $result = $this->import([
            [str_repeat('a', CatalogProductImport::MAX_DESCRIPTION_LENGTH + 1), $this->unit->name, 'Producto'],
        ]);

        $this->assertSame(['Fila 2: la descripción tiene 601 caracteres y el máximo es 600.'], $result['errors']);
    }

    public function test_file_without_a_template_column_is_rejected(): void
    {
        $result = $this->import(
            [["Producto {$this->marker}", $this->unit->name]],
            headers: ['Descripción', 'Unidad de medida'],
        );

        $this->assertCount(1, $result['errors']);
        $this->assertStringContainsString('le falta la columna «Tipo»', $result['errors'][0]);
    }

    public function test_file_with_only_headers_is_rejected(): void
    {
        $result = $this->import([]);

        $this->assertSame(['El archivo no tiene elementos para registrar. Captura uno por fila debajo de los encabezados.'], $result['errors']);
    }

    public function test_more_rows_than_allowed_are_rejected(): void
    {
        $rows = array_map(
            fn (int $number): array => ["Producto {$number} {$this->marker}", $this->unit->name, 'Producto'],
            range(1, CatalogProductImport::MAX_ROWS + 1),
        );

        $result = $this->import($rows);

        $this->assertSame(['El archivo tiene 101 elementos y el máximo por carga es 100. Divídelo en varios archivos.'], $result['errors']);
        $this->assertCount(0, $this->importedProducts());
    }

    public function test_file_that_is_not_an_excel_is_rejected(): void
    {
        $path = $this->temporaryPath();
        file_put_contents($path, 'esto no es un excel');

        $result = (new CatalogProductImport)->import($path, $this->companyId, $this->requester->id);

        $this->assertSame(['No se pudo leer el archivo. Verifica que sea un Excel (.xlsx) hecho con la plantilla.'], $result['errors']);
    }

    public function test_template_puts_the_capture_sheet_first_and_lists_every_unit(): void
    {
        $path = $this->temporaryPath();
        $response = (new CatalogProductImport)->downloadTemplate();

        ob_start();
        $response->sendContent();
        file_put_contents($path, ob_get_clean());

        $sheets = (new FastExcel)->withSheetsNames()->importSheets($path);
        $captureSheet = (new FastExcel)->withoutHeaders()->import($path);

        $this->assertSame(['Elementos', 'Unidades de medida', 'Instrucciones'], $sheets->keys()->all());
        $this->assertSame(self::HEADERS, $captureSheet->first());
        $this->assertContains($this->unit->name, array_column($sheets['Unidades de medida'], 'Unidad de medida'));
    }

    public function test_import_action_registers_products_and_sends_one_summary_email(): void
    {
        $file = $this->upload([
            ["Pintura blanca {$this->marker}", $this->unit->name, 'Producto'],
            ["Pintura negra {$this->marker}", $this->unit->name, 'Producto'],
        ]);

        Livewire::test(ListProducts::class)
            ->assertActionVisible('importFromExcel')
            ->mountAction('importFromExcel')
            ->fillForm(['file' => $file])
            ->callMountedAction()
            ->assertHasNoFormErrors()
            ->assertNotified('Se registraron 2 elementos');

        $this->assertCount(2, $this->importedProducts());

        Mail::assertSent(CatalogBulkNotification::class, 1);
        Mail::assertSent(CatalogBulkNotification::class, fn (CatalogBulkNotification $mail): bool => $mail->products->count() === 2
            && $mail->hasTo(User::withRole('gerente_compras')->value('email')));
        Mail::assertNotSent(CatalogNotification::class);
    }

    public function test_import_action_with_errors_keeps_the_modal_open_and_sends_nothing(): void
    {
        $file = $this->upload([
            ["Pintura {$this->marker}", 'Unidad que no existe', 'Producto'],
        ]);

        Livewire::test(ListProducts::class)
            ->mountAction('importFromExcel')
            ->fillForm(['file' => $file])
            ->callMountedAction()
            ->assertNotified('No se registró ningún elemento')
            ->assertActionMounted('importFromExcel');

        $this->assertCount(0, $this->importedProducts());
        Mail::assertNothingSent();
    }

    public function test_import_action_requires_a_file(): void
    {
        Livewire::test(ListProducts::class)
            ->mountAction('importFromExcel')
            ->callMountedAction()
            ->assertHasFormErrors(['file' => 'required']);
    }

    public function test_template_can_be_downloaded_from_the_import_modal(): void
    {
        Livewire::test(ListProducts::class)
            ->callAction([TestAction::make('importFromExcel'), TestAction::make('downloadTemplate')])
            ->assertFileDownloaded(CatalogProductImport::TEMPLATE_FILE_NAME);
    }

    /**
     * @param  list<list<string>>  $rows
     * @param  list<string>  $headers
     * @return array{products: Collection<int, Product>, errors: list<string>}
     */
    private function import(array $rows, array $headers = self::HEADERS): array
    {
        return (new CatalogProductImport)->import($this->excel($rows, $headers), $this->companyId, $this->requester->id);
    }

    /**
     * @param  list<list<string>>  $rows
     */
    private function upload(array $rows): UploadedFile
    {
        return UploadedFile::fake()->createWithContent('altas.xlsx', file_get_contents($this->excel($rows)));
    }

    /**
     * Escribe el Excel con OpenSpout para que una fila vacía quede de verdad
     * sin celdas, como cuando el usuario deja un renglón en blanco.
     *
     * @param  list<list<string>>  $rows
     * @param  list<string>  $headers
     */
    private function excel(array $rows, array $headers = self::HEADERS): string
    {
        $path = $this->temporaryPath();
        $writer = new Writer;
        $writer->openToFile($path);
        $writer->addRow(Row::fromValues($headers));

        foreach ($rows as $row) {
            $writer->addRow(Row::fromValues($row));
        }

        $writer->close();

        return $path;
    }

    private function temporaryPath(): string
    {
        $reservedName = tempnam(sys_get_temp_dir(), 'catalogo');
        $path = $reservedName.'.xlsx';
        $this->files[] = $reservedName;
        $this->files[] = $path;

        return $path;
    }

    /**
     * @return Collection<int, Product>
     */
    private function importedProducts(): Collection
    {
        return Product::query()->where('name', 'like', "%{$this->marker}%")->get();
    }
}
