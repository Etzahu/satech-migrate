<?php

namespace App\Http\Controllers;

use Money\Money;
use App\Models\PurchaseOrder;
use App\Services\OrderCalculationService;
use Spatie\Browsershot\Browsershot;
use function Spatie\LaravelPdf\Support\pdf;


class PurchaseOrderController extends Controller
{

    public function pdf($id, $save = false, $disk = 'pdf_temp')
    {
        $data = PurchaseOrder::with(['company', 'requisition', 'provider', 'providerContact', 'items', 'items.product', 'items.product.unit', 'items.product.brand', 'purchaser'])->findOrFail($id);
        // return $data;
        $service = new OrderCalculationService($data->id);
        $items = $data->items;
        $media[] = $data->getMedia('quote')->first();
        $media[] = $data->getMedia('justification')->first();
        // opcionales
        if (filled($data->getMedia('direct_award')->first())) {
            $media[] = $data->getMedia('direct_award')->first();
        }
        if (filled($data->getMedia('certifications')->first())) {
            $media[] = $data->getMedia('certifications')->first();
        }

        $itemsFormatted = $items->map(function ($item) use ($data, $service) {
            // $unitPrice =  new Money($item->unit_price, new Currency($data->currency));
            // $subTotal =  new Money($item->sub_total, new Currency($data->currency));
            $unitPrice =  $item->unit_price;
            $subTotal = $item->sub_total;
            return [
                'code' => $item->product->code,
                'name' => $item->product->name,
                'brand' => $item->product->brand?->name,
                'unit' => $item->product->unit->acronym,
                "quantity" => $item->quantity,
                "unit_price" => $service->brickFormatter($unitPrice),
                "sub_total" => $service->brickFormatter($subTotal),
                "observation" => $item->observation,
            ];
        });
        $total = [
            'Subtotal' =>  $service->getSubtotalItems(true),
            'Descuento' =>  $service->getDiscountProvider(true),
            'IVA' =>  $service->getTaxIva(true),
            'Retención de IVA' =>  $service->getRetentionIva(true),
            'Retención de ISR' =>  $service->getRetentionIsr(true),
            'Total' =>  $service->getTotal(true),
        ];

// dd($data->provider->approval_chain == 'especial');
        $data['total'] = $total;
        $data['media'] = $media;
        $data['itemsFormatted'] = $itemsFormatted;
        // $data['progress'] = ($data->provider->approval_chain == 'especial') ? $data->progress_special : $data->progress;
        // dd($data->progress_special , $data->progress,$data['progress']);
        // return($data);

        $revisions = $data->status()->timesWas('autorizada para proveedor');

        $stages = [];
        $stages[1] =  $data->status()->snapshotWhen('revisión gerente de compras');
        $stages[2] =  $data->status()->snapshotWhen('aprobado por gerente de compras');
        $stages[3] =  $data->status()->snapshotWhen('aprobado por gerente solicitante');
        $stages[4] =  $data->status()->snapshotWhen('aprobado por DG nivel 1'); //
        $stages[5] =  $data->status()->snapshotWhen('aprobado por DG nivel 2'); //

        // Determinar qué anexos incluir
        $includeSupplier = in_array($data->requisition->category, ['proveeduria', 'servicio']) || $data->requisition->company_id == 1;
        $includeService = $data->requisition->category == 'servicio' || $data->requisition->company_id == 1;
        $includeTerms = $this->getTermsAndConditionsByCompany($data->company_id);

        $pdf = pdf()
            ->view('pdf.purchase-order.complete', [
                'data' => $data,
                'stages' => $stages,
                'includeSupplier' => $includeSupplier,
                'includeService' => $includeService,
                'includeTerms' => $includeTerms,
            ])
            ->margins(55, 15, 15, 15)
            ->headerView('pdf.purchase-order.header', ['data' => $data, 'revisions' => $revisions])
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot
                    ->noSandbox()
                    ->showBackground()
                    ->displayHeaderFooter() // Habilita @pageNumber y @totalPages
                    ->writeOptionsToFile();
            })
            ->name("orden-compra-{$data->folio}.pdf");

        if ($save) {
            return $pdf
                ->disk($disk)
                ->save("orden_compra_{$id}.pdf");
        }

        // return view('pdf.purchase-order.complete', [
        //     'data' => $data,
        //     'stages' => $stages,
        //     'includeSupplier' => $includeSupplier,
        //     'includeService' => $includeService,
        //     'includeTerms' => $includeTerms,
        // ]);
        return $pdf;
    }

    public function show($id)
    {
        $model = PurchaseOrder::with(['company', 'requisition', 'provider', 'providerContact', 'items', 'items.product', 'items.product.unit', 'items.product.brand', 'purchaser'])->findOrFail($id);

        try {
            // Generar PDF completo con todos los anexos y numeración continua
            $pdf = $this->pdf($id, false);

            $filename = str()->of("Orden de compra {$model->folio}")->replace('/', '-');

            return $pdf->inline($filename . '.pdf');
        } catch (\Exception $e) {
            logger()->error('Error al generar PDF completo', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'order_id' => $id
            ]);
            return response()->json(['error' => 'No se pudo generar el PDF: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Obtiene el archivo de términos y condiciones según la empresa
     */
    protected function getTermsAndConditionsByCompany($companyId): ?string
    {
        // Mapeo de empresas a archivos de términos y condiciones
        $termsMap = [
            // 1 => storage_path("app/private/docs_purchase_order/terminos-condiciones-gpt-im.pdf"),
            // 2 => storage_path("app/private/docs_purchase_order/terminos-condiciones-tech.pdf"),
            1 => "pdf/purchase-order/annexes/terms-conditions-gpt-im",
            2 => "pdf/purchase-order/annexes/terms-conditions-tech",
            // Agregar más empresas según sea necesario
        ];
        return $termsMap[$companyId] ?? null;
    }

    public function download($id)
    {
        $model = PurchaseOrder::with(['company', 'requisition', 'provider', 'providerContact', 'items', 'items.product', 'items.product.unit', 'items.product.brand', 'purchaser'])->findOrFail($id);

        try {
            // Generar PDF completo con todos los anexos y numeración continua
            $this->pdf($id, true, 'private');

            $output = storage_path("app/private/orden_compra_{$id}.pdf");

            if (file_exists($output)) {
                $filename = str()->of("Orden de compra {$model->folio}")->replace('/', '-');
                return response()->download($output, "{$filename}.pdf");
            } else {
                return response()->json(['error' => 'No se pudo generar el PDF'], 500);
            }
        } catch (\Exception $e) {
            logger()->error('Error al generar PDF para descarga', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'order_id' => $id
            ]);
            return response()->json(['error' => 'No se pudo generar el PDF: ' . $e->getMessage()], 500);
        }
    }
}
