<?php

namespace App\Imports;

use App\Models\MeasureUnit;
use App\Models\Product;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Exception\OpenSpoutException;
use OpenSpout\Reader\XLSX\Options as XlsxReaderOptions;
use OpenSpout\Writer\Common\AbstractOptions as WriterOptions;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Registra varios productos/servicios del catálogo a partir de un Excel hecho
 * con la plantilla. Es todo o nada: si una fila tiene un error no se registra
 * ninguna, así el solicitante corrige y vuelve a subir el mismo archivo sin
 * duplicar las filas que ya estaban bien.
 */
class CatalogProductImport
{
    public const MAX_ROWS = 100;

    public const MAX_DESCRIPTION_LENGTH = 600;

    public const TEMPLATE_FILE_NAME = 'plantilla-altas-productos-servicios.xlsx';

    /**
     * Encabezados de la plantilla, indexados por su forma normalizada.
     *
     * @var array<string, string>
     */
    public const COLUMNS = [
        'descripcion' => 'Descripción',
        'unidad_de_medida' => 'Unidad de medida',
        'tipo' => 'Tipo',
    ];

    /**
     * Lo que se acepta en la columna Tipo y el type_purchase que guarda.
     *
     * @var array<string, string>
     */
    private const TYPES = [
        'producto' => 'proveeduria',
        'proveeduria' => 'proveeduria',
        'servicio' => 'servicio',
    ];

    /**
     * @return array{products: EloquentCollection<int, Product>, errors: list<string>}
     */
    public function import(UploadedFile|string $file, int $companyId, int $requesterId): array
    {
        try {
            $rows = $this->readRows($file);
        } catch (OpenSpoutException) {
            return $this->failed(['No se pudo leer el archivo. Verifica que sea un Excel (.xlsx) hecho con la plantilla.']);
        }

        $missingColumns = array_diff_key(self::COLUMNS, $rows->first() ?? []);

        if ($rows->isNotEmpty() && $missingColumns !== []) {
            return $this->failed([
                'Al archivo le falta la columna «'.implode('», «', $missingColumns).'». Descarga la plantilla y captura los elementos en ella.',
            ]);
        }

        $filledRows = $rows->reject(fn (array $values): bool => implode('', $values) === '');

        if ($filledRows->isEmpty()) {
            return $this->failed(['El archivo no tiene elementos para registrar. Captura uno por fila debajo de los encabezados.']);
        }

        if ($filledRows->count() > self::MAX_ROWS) {
            return $this->failed([
                "El archivo tiene {$filledRows->count()} elementos y el máximo por carga es ".self::MAX_ROWS.'. Divídelo en varios archivos.',
            ]);
        }

        $unitIds = $this->unitIdsByMatchKey();
        $errors = [];
        $attributes = [];
        $firstRowByDescription = [];

        foreach ($filledRows as $index => $values) {
            $rowNumber = $index + 2;
            $rowErrors = [];

            $description = Str::lower($values['descripcion']);
            $unit = $values['unidad_de_medida'];
            $type = $values['tipo'];

            $unitId = $unitIds[$this->matchKey($unit)] ?? null;
            $typePurchase = self::TYPES[$this->matchKey($type)] ?? null;

            if ($description === '') {
                $rowErrors[] = 'falta la descripción';
            } elseif (mb_strlen($description) > self::MAX_DESCRIPTION_LENGTH) {
                $rowErrors[] = 'la descripción tiene '.mb_strlen($description).' caracteres y el máximo es '.self::MAX_DESCRIPTION_LENGTH;
            } elseif (isset($firstRowByDescription[$description])) {
                $rowErrors[] = "la descripción ya está en la fila {$firstRowByDescription[$description]}";
            }

            if ($unit === '') {
                $rowErrors[] = 'falta la unidad de medida';
            } elseif ($unitId === null) {
                $rowErrors[] = "la unidad de medida «{$unit}» no existe; usa una de la hoja «Unidades de medida»";
            }

            if ($type === '') {
                $rowErrors[] = 'falta el tipo';
            } elseif ($typePurchase === null) {
                $rowErrors[] = "el tipo «{$type}» no es válido; escribe Producto o Servicio";
            }

            if ($description !== '') {
                $firstRowByDescription[$description] ??= $rowNumber;
            }

            if ($rowErrors !== []) {
                $errors[] = "Fila {$rowNumber}: ".implode('; ', $rowErrors).'.';

                continue;
            }

            $attributes[] = [
                'name' => $description,
                'code' => 'Sin código asignado',
                'unit_id' => $unitId,
                'type_purchase' => $typePurchase,
                'company_id' => $companyId,
                'requester_id' => $requesterId,
            ];
        }

        if ($errors !== []) {
            return $this->failed($errors);
        }

        $products = DB::transaction(fn (): EloquentCollection => new EloquentCollection(
            array_map(fn (array $productAttributes): Product => Product::create($productAttributes), $attributes),
        ));

        return ['products' => $products, 'errors' => []];
    }

    /**
     * Plantilla con la hoja de captura, el catálogo de unidades de medida y
     * las instrucciones. La hoja de captura va primero porque es la que se lee.
     */
    public function downloadTemplate(): StreamedResponse
    {
        $units = MeasureUnit::query()
            ->orderBy('name')
            ->get(['name', 'acronym'])
            ->map(fn (MeasureUnit $unit): array => [
                'Unidad de medida' => $unit->name,
                'Abreviatura' => $unit->acronym,
            ]);

        $instructions = collect([
            [
                'Columna' => self::COLUMNS['descripcion'],
                'Ejemplo' => 'Guantes de nitrilo talla M',
                'Qué capturar' => 'Obligatoria. Descripción del producto o servicio, máximo '.self::MAX_DESCRIPTION_LENGTH.' caracteres.',
            ],
            [
                'Columna' => self::COLUMNS['unidad_de_medida'],
                'Ejemplo' => 'Caja',
                'Qué capturar' => 'Obligatoria. Nombre o abreviatura tal como aparece en la hoja «Unidades de medida».',
            ],
            [
                'Columna' => self::COLUMNS['tipo'],
                'Ejemplo' => 'Producto',
                'Qué capturar' => 'Obligatorio. Producto o Servicio.',
            ],
            [
                'Columna' => 'Notas',
                'Ejemplo' => '',
                'Qué capturar' => 'Un elemento por fila, máximo '.self::MAX_ROWS.' por archivo. Si una fila tiene un error no se registra ninguna. La ficha técnica (PDF) no se carga por Excel.',
            ],
        ]);

        return (new FastExcel(new SheetCollection([
            'Elementos' => collect([array_fill_keys(array_values(self::COLUMNS), '')]),
            'Unidades de medida' => $units,
            'Instrucciones' => $instructions,
        ])))
            ->headerStyle((new Style)->setFontBold())
            ->configureOptionsUsing(function (object $options): void {
                if ($options instanceof WriterOptions) {
                    $options->setColumnWidth(60, 1);
                    $options->setColumnWidth(30, 2, 3);
                }
            })
            ->download(self::TEMPLATE_FILE_NAME);
    }

    /**
     * Filas de la primera hoja con los encabezados normalizados y el texto de cada
     * celda limpio. Las filas vacías se conservan para que el índice siga
     * correspondiendo a la fila de Excel en los mensajes de error.
     *
     * @return Collection<int, array<string, string>>
     */
    private function readRows(UploadedFile|string $file): Collection
    {
        return (new FastExcel)
            ->configureOptionsUsing(function (object $options): void {
                if ($options instanceof XlsxReaderOptions) {
                    $options->SHOULD_PRESERVE_EMPTY_ROWS = true;
                }
            })
            ->import($file)
            ->map(fn (array $row): array => collect($row)
                ->mapWithKeys(fn (mixed $value, int|string $header): array => [
                    Str::slug((string) $header, '_') => $this->cellText($value),
                ])
                ->all())
            ->values();
    }

    private function cellText(mixed $value): string
    {
        if ($value instanceof DateTimeInterface) {
            return $value->format('d/m/Y');
        }

        return Str::squish((string) $value);
    }

    /**
     * Ids de unidad por nombre y, cuando no choca con un nombre, por abreviatura.
     *
     * @return array<string, int>
     */
    private function unitIdsByMatchKey(): array
    {
        $units = MeasureUnit::query()->orderBy('id')->get(['id', 'name', 'acronym']);
        $unitIds = [];

        foreach ($units as $unit) {
            $unitIds[$this->matchKey($unit->name)] ??= $unit->id;
        }

        foreach ($units->filter(fn (MeasureUnit $unit): bool => filled($unit->acronym)) as $unit) {
            $unitIds[$this->matchKey($unit->acronym)] ??= $unit->id;
        }

        return $unitIds;
    }

    /**
     * Ignora mayúsculas, acentos y espacios: «Galón», «galon» y «GALON» son la
     * misma unidad, igual que «Cubeta(10 litros)» y «Cubeta (10 litros)».
     */
    private function matchKey(string $value): string
    {
        return Str::of($value)->ascii()->lower()->remove(' ')->toString();
    }

    /**
     * @param  list<string>  $errors
     * @return array{products: EloquentCollection<int, Product>, errors: list<string>}
     */
    private function failed(array $errors): array
    {
        return ['products' => new EloquentCollection, 'errors' => $errors];
    }
}
