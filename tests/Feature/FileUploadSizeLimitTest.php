<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages\CreatePurchaseRequisition;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Testing\File;
use Livewire\Features\SupportFileUploads\FileUploadConfiguration;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Un archivo más grande de lo permitido mostraba "Subir
 * data.supports.<uuid> ha fallado": Livewire arma el mensaje con la ruta
 * interna del campo. Ahora el navegador conoce el límite y rechaza el archivo
 * antes de subirlo, y si aun así el servidor lo rechaza el mensaje se entiende.
 */
class FileUploadSizeLimitTest extends TestCase
{
    use DatabaseTransactions;

    private const FILE_KEY = 'data.supports.da92a5ec-bf44-49aa-a94d-4632534b5686';

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');

        $requester = User::role('solicita_requisicion_compra')->where('active', 1)->first();

        $this->assertNotNull($requester, 'No hay un solicitante activo para probar el panel.');

        $this->actingAs($requester);
    }

    public function test_requisition_uploads_know_the_server_size_limit(): void
    {
        $page = Livewire::test(CreatePurchaseRequisition::class);

        foreach (['supports', 'technical_data_sheets'] as $field) {
            $page->assertFormFieldExists($field, function (FileUpload $upload): bool {
                $maxSize = $upload->getMaxSize();

                $this->assertNotNull($maxSize, "{$upload->getName()} no tiene tamaño máximo; el navegador enviaría cualquier archivo.");
                $this->assertLessThanOrEqual($this->livewireMaxKilobytes(), $maxSize);
                $this->assertLessThanOrEqual(ini_parse_quantity(ini_get('upload_max_filesize')), $maxSize * 1024);
                $this->assertLessThanOrEqual(config('media-library.max_file_size'), $maxSize * 1024);

                return true;
            });
        }
    }

    public function test_file_rejected_by_php_shows_a_readable_message(): void
    {
        $rejectedByPhp = new class('soporte.pdf', tmpfile()) extends File
        {
            public function isValid(): bool
            {
                return false;
            }
        };

        $page = Livewire::test(CreatePurchaseRequisition::class)
            ->upload(self::FILE_KEY, [$rejectedByPhp]);

        $this->assertReadableUploadError($page->errors()->first(self::FILE_KEY));
    }

    public function test_upload_cut_before_reaching_laravel_shows_a_readable_message(): void
    {
        $page = Livewire::test(CreatePurchaseRequisition::class)
            ->call('_uploadErrored', self::FILE_KEY, null, false);

        $this->assertReadableUploadError($page->errors()->first(self::FILE_KEY));
    }

    private function assertReadableUploadError(string $message): void
    {
        $this->assertSame('No se pudo subir el archivo. Verifica que no exceda el tamaño máximo permitido e inténtalo de nuevo.', $message);
        $this->assertStringNotContainsString('data.supports', $message);
    }

    private function livewireMaxKilobytes(): int
    {
        $maxRule = collect(FileUploadConfiguration::rules())
            ->first(fn (mixed $rule): bool => is_string($rule) && str_starts_with($rule, 'max:'));

        return (int) str($maxRule)->after('max:')->toString();
    }
}
