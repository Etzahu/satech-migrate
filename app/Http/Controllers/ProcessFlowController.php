<?php

namespace App\Http\Controllers;

use App\Filament\Purchases\Pages\ProcessFlow;
use Spatie\Browsershot\Browsershot;
use function Spatie\LaravelPdf\Support\pdf;

class ProcessFlowController extends Controller
{
    /**
     * Exporta los dos diagramas de flujo a un PDF: cada flujo en una página
     * horizontal que abarca todo el ancho y alto de la hoja.
     *
     * El diagrama lo dibuja D3 en el navegador (flow-diagram.js); por eso se
     * usa Browsershot (Chrome headless), que ejecuta el JS y espera a que los
     * diagramas estén renderizados antes de generar el PDF.
     */
    public function pdf()
    {
        $page = new ProcessFlow();

        return pdf()
            ->view('pdf.process-flow', [
                'requisitionFlow' => $page->getRequisitionFlow(),
                'orderFlow' => $page->getOrderFlow(),
            ])
            ->margins(0, 0, 0, 0)
            // Hoja horizontal y ancha: cada diagrama (muy apaisado) llena la página.
            ->paperSize(420, 158, 'mm')
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot
                    ->noSandbox()
                    ->showBackground()
                    // Sirve el HTML como si viniera de APP_URL. Sin esto el documento
                    // es file:// y el <script type="module"> de Vite (cargado por http)
                    // queda cross-origin y el navegador NO lo ejecuta: D3 nunca corre
                    // y waitForFunction expira. Con el mismo origen, los módulos cargan.
                    ->setContentUrl(config('app.url'))
                    ->waitForFunction('window.__flowDiagramsReady === true')
                    ->writeOptionsToFile();
            })
            ->name('flujo-del-proceso.pdf')
            ->inline('flujo-del-proceso.pdf');
    }
}
