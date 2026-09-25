<?php

namespace App\Console\Commands;

use App\Filament\Purchases\Pages\ProcessFlow;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

/**
 * Genera las guías de uso en PDF a partir de sus vistas Blade.
 *
 * Las guías viven en storage/app/public/guides y se enlazan desde la página
 * «Guías de uso» del panel. Regenerarlas es un comando y no un despliegue:
 * cuando cambia el módulo, se edita la vista y se vuelve a correr.
 *
 * Cada `.page` de una guía es una hoja A4 exacta, así que el contenido que se
 * pase de largo se recortaría en silencio. Antes de escribir el PDF el comando
 * mide las hojas en el navegador y avisa de cualquier desbordamiento.
 */
class BuildGuidePdf extends Command
{
    protected $signature = 'guias:pdf
                            {guia? : Clave de la guía a generar. Si se omite, se generan todas.}
                            {--list : Solo muestra las guías disponibles.}
                            {--sin-revision : Omite la medición de hojas.}';

    protected $description = 'Genera en PDF las guías de uso del sistema de compras';

    /**
     * Hoja tamaño carta a 96 ppp, que es la caja que define `.page`.
     */
    protected const ANCHO_HOJA = 816;

    protected const ALTO_HOJA = 1056;

    /**
     * Guías disponibles.
     *
     * vista  → Blade que se renderiza
     * salida → nombre del archivo dentro de storage/app/public/guides
     * datos  → variables extra para la vista
     *
     * @return array<string, array<string, mixed>>
     */
    protected function guias(): array
    {
        return [
            'requisiciones' => [
                'vista' => 'pdf.guides.requisiciones',
                'salida' => 'guia-solicitante-requisiciones.pdf',
            ],
            'flujo' => [
                'vista' => 'pdf.guides.flujo-aprobacion',
                'salida' => 'guia-flujo-aprobacion.pdf',
                // El contenido sale de los mismos arreglos que dibuja la página
                // «Flujo del proceso»: así la guía no puede contradecir al flujo.
                'datos' => function (): array {
                    $page = new ProcessFlow;

                    return [
                        'requisitionFlow' => $page->getRequisitionFlow(),
                        'orderFlow' => $page->getOrderFlow(),
                    ];
                },
            ],
            'altas' => [
                'vista' => 'pdf.guides.altas',
                'salida' => 'guia-solicitante-alta-productos-proyectos.pdf',
            ],
            'cadena' => [
                'vista' => 'pdf.guides.cadena-requisicion',
                'salida' => 'guia-admin-cadena-requisicion.pdf',
            ],
            'orden' => [
                'vista' => 'pdf.guides.orden-compra',
                'salida' => 'guia-orden-de-compra.pdf',
            ],
        ];
    }

    public function handle(): int
    {
        $guias = $this->guias();

        if ($this->option('list')) {
            $this->table(
                ['Clave', 'Archivo'],
                collect($guias)->map(fn ($g, $k) => [$k, $g['salida']])->values()->all()
            );

            return self::SUCCESS;
        }

        $clave = $this->argument('guia');

        if ($clave && ! isset($guias[$clave])) {
            $this->error("La guía «{$clave}» no existe. Usa --list para ver las disponibles.");

            return self::FAILURE;
        }

        $pendientes = $clave ? [$clave => $guias[$clave]] : $guias;

        Storage::disk('public')->makeDirectory('guides');

        $conDesborde = 0;

        foreach ($pendientes as $guia) {
            $destino = Storage::disk('public')->path('guides/'.$guia['salida']);
            $datos = $this->datosDeVista($guia);

            if (! $this->option('sin-revision')) {
                $desbordes = $this->medirHojas($guia['vista'], $datos);

                foreach ($desbordes as $pagina => $sobra) {
                    $conDesborde++;
                    $this->components->warn("{$guia['salida']}: la hoja {$pagina} se pasa {$sobra} px y se va a recortar.");
                }
            }

            $this->components->task("Generando {$guia['salida']}", function () use ($guia, $datos, $destino) {
                Pdf::view($guia['vista'], $datos)
                    ->paperSize(8.5, 11, 'in')
                    ->margins(0, 0, 0, 0)
                    ->withBrowsershot(function (Browsershot $browsershot) {
                        $browsershot
                            ->noSandbox()
                            ->showBackground()
                            ->writeOptionsToFile();
                    })
                    ->save($destino);

                return true;
            });

            $this->line('   <fg=gray>'.$destino.' · '.number_format(filesize($destino) / 1024, 1).' KB</>');
        }

        if ($conDesborde > 0) {
            $this->newLine();
            $this->components->error("{$conDesborde} hoja(s) con contenido recortado. Ajusta el corte en la vista y vuelve a generar.");

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    /**
     * Variables que recibe la vista: las comunes más las propias de la guía.
     *
     * @param  array<string, mixed>  $guia
     * @return array<string, mixed>
     */
    protected function datosDeVista(array $guia): array
    {
        $propias = isset($guia['datos']) ? ($guia['datos'])() : [];

        return array_merge([
            'logo' => $this->comoDataUri(public_path('images/logo-app.png')),
            'fuentes' => $this->reglasDeFuentes(),
            'fecha' => Carbon::now()->locale('es')->isoFormat('MMMM [de] YYYY'),
        ], $propias);
    }

    /**
     * Reglas `@font-face` con las tipografías incrustadas en base64.
     *
     * Chrome headless no espera a que Google Fonts responda, así que un
     * `<link>` deja el PDF en Arial. Con las fuentes dentro del documento el
     * resultado es el mismo con o sin conexión.
     */
    protected function reglasDeFuentes(): string
    {
        $fuentes = [
            // El eje wght de cada fuente variable: declararlo corto hace que
            // Chrome use la instancia por omisión en vez de mapear el peso.
            ['Playfair Display', 'playfair-display-latin.woff2', '400 900'],
            ['Source Sans 3', 'source-sans-3-latin.woff2', '200 900'],
        ];

        return collect($fuentes)
            ->map(function (array $fuente): string {
                [$familia, $archivo, $pesos] = $fuente;
                $binario = base64_encode(file_get_contents(resource_path('fonts/'.$archivo)));

                return <<<CSS
                @font-face {
                    font-family: '{$familia}';
                    font-style: normal;
                    font-weight: {$pesos};
                    font-display: block;
                    src: url(data:font/woff2;base64,{$binario}) format('woff2');
                }
                CSS;
            })
            ->implode("\n");
    }

    /**
     * Mide cada `.page` en el navegador y devuelve las que no caben.
     *
     * @param  array<string, mixed>  $datos
     * @return array<int, int> [número de hoja => píxeles sobrantes]
     */
    protected function medirHojas(string $vista, array $datos): array
    {
        $html = View::make($vista, $datos)->render();

        $medidas = Browsershot::html($html)
            ->noSandbox()
            ->windowSize(self::ANCHO_HOJA, self::ALTO_HOJA)
            ->evaluate(sprintf(<<<'JS'
                JSON.stringify([...document.querySelectorAll('.page')].map((hoja) => {
                    const cuerpo = hoja.querySelector('.page-body');
                    // La hoja crece cuando el contenido no cabe entre encabezado y pie;
                    // el recorte interno delata el texto que se perdería dentro del cuerpo.
                    return Math.max(
                        Math.round(hoja.getBoundingClientRect().height) - %d,
                        cuerpo ? cuerpo.scrollHeight - cuerpo.clientHeight : 0,
                    );
                }))
            JS, self::ALTO_HOJA));

        $desbordes = [];

        foreach (json_decode($medidas, true) ?? [] as $indice => $sobra) {
            // Un par de píxeles es redondeo del navegador, no contenido perdido.
            if ($sobra > 2) {
                // La portada no se numera, por eso la hoja 1 es el índice 0.
                $desbordes[$indice + 1] = $sobra;
            }
        }

        return $desbordes;
    }

    /**
     * Incrusta una imagen en la vista como data URI.
     *
     * Chrome headless carga el HTML desde un archivo temporal, así que una ruta
     * absoluta de Windows en el `src` no resuelve. Empotrar el binario evita
     * depender de dónde quedó ese temporal.
     */
    protected function comoDataUri(string $ruta): string
    {
        $tipo = match (strtolower(pathinfo($ruta, PATHINFO_EXTENSION))) {
            'svg' => 'image/svg+xml',
            'jpg', 'jpeg' => 'image/jpeg',
            default => 'image/png',
        };

        return 'data:'.$tipo.';base64,'.base64_encode(file_get_contents($ruta));
    }
}
