<?php

namespace App\Http\Controllers;

use Money\Money;
use Money\Currency;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Services\OrderCalculationService;
use Spatie\Browsershot\Browsershot;
use function Spatie\LaravelPdf\Support\pdf;


class PurchaseOrderController extends Controller
{

    public function pdf($id, $save = false)
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
            $unitPrice =  new Money($item->unit_price, new Currency($data->currency));
            $subTotal =  new Money($item->sub_total, new Currency($data->currency));
            return [
                'code' => $item->product->code,
                'name' => $item->product->name,
                'brand' => $item->product->brand?->name,
                'unit' => $item->product->unit->acronym,
                "quantity" => $item->quantity,
                "unit_price" => $service->moneyFormatter($unitPrice),
                "sub_total" => $service->moneyFormatter($subTotal),
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

        $data['total'] = $total;
        $data['media'] = $media;
        $data['itemsFormatted'] = $itemsFormatted;

        $revisions = $data->status()->timesWas('autorizada para proveedor');

        $stages = [];
        $stages[1] =  $data->status()->snapshotWhen('revisión gerente de compras');
        $stages[2] =  $data->status()->snapshotWhen('aprobado por gerente de compras');
        $stages[3] =  $data->status()->snapshotWhen('aprobado por gerente solicitante');
        $stages[4] =  $data->status()->snapshotWhen('aprobado por DG nivel 1'); //
        $stages[5] =  $data->status()->snapshotWhen('aprobado por DG nivel 2'); //

        $pdf = pdf()
            ->view('pdf.purchase-order.content', ['data' => $data, 'stages' => $stages])
            ->margins(55, 15, 15, 15)
            ->headerView('pdf.purchase-order.header', ['data' => $data, 'revisions' => $revisions])
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot
                    ->noSandbox()
                    ->writeOptionsToFile();
            })
            // ->disk('public')
            ->name("orden-compra-{$data->folio}.pdf");

        if ($save) {
            return $pdf
                ->disk('pdf_temp')
                ->save("orden_compra_{$id}.pdf");
        }

        return $pdf;
    }

    public function download($id)
    {
        $model =  PurchaseOrder::with(['company', 'requisition', 'provider', 'providerContact', 'items', 'items.product', 'items.product.unit', 'items.product.brand', 'purchaser'])->findOrFail($id);
        $service =   storage_path("app/private/docs_purchase_order/servicio.pdf");
        $supplier =   storage_path("app/private/docs_purchase_order/proveeduria.pdf");

        $files = [
            storage_path("app/public/pdf_temp/orden_compra_{$id}.pdf"),
        ];

        // if (blank($model->requisition->category)) {
        //     return redirect()->back();
        // }

        if ($model->requisition->category == 'servicio') {
            $files[] = $supplier;
            $files[] = $service;
        }

        if ($model->requisition->category == 'proveeduria') {
            $files[] = $supplier;
        }

        try {
            $this->pdf($id, true);
        } catch (\Exception $e) {
            logger()->error($e);
        }

        $output = storage_path('app/public/pdf_temp/merged.pdf');

        $cmd = '';
        // Construir el comando de Ghostscript
        if (config('app.env') == 'production') {
            $cmd = 'gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=' . escapeshellarg($output) . ' ';
        } else {
            $cmd = '"C:\Program Files\gs\gs9.22\bin\gs.exe" -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=' . escapeshellarg($output) . ' ';
        }
        foreach ($files as $file) {
            $cmd .= escapeshellarg($file) . ' ';
        }
        // Ejecutar el comando
        // $result = exec($cmd);
        $result = shell_exec($cmd . ' 2>&1'); // Captura errores
        logger()->error($result);

        if (file_exists($output)) {
            $filename = str()->of("Orden de compra {$model->folio}")->replace('/', '-');
            return response()->download($output, "{$filename}.pdf")->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'No se pudo combinar los PDFs'], 500);
        }
    }
}
