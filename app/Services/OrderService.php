<?php

namespace App\Services;

use Money\Money;
use Money\Currency;
use App\Models\Company;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;
use function Spatie\LaravelPdf\Support\pdf;

class OrderService
{
    public function generateFolio($rq_id)
    {
        return $this->getCompany() . '-' . $this->getManagement($rq_id)  . now()->format('y') . '-' . $this->getCountRecords();
    }
    public function getCountRecords()
    {
        $count = PurchaseOrder::whereYear('created_at', now()->year)
            ->count() + 1;

        return str($count)->padLeft(3, '0');
    }

    public function getCompany()
    {
        return Company::find(session()->get('company_id'))->acronym;
    }
    public function getManagement($rq_id)
    {
        $rq = PurchaseRequisition::find($rq_id);
        return $rq->approvalChain->requester->management->acronym;
    }

    public function generatePdf($model)
    {
        return pdf()
        ->view('pdf.purchase-order.content')
        ->margins(40, 15, 15, 15)
        ->headerView('pdf.purchase-order.header')
        ->withBrowsershot(function (Browsershot $browsershot) {
            $browsershot
                ->noSandbox()
                ->writeOptionsToFile();
        })
        ->disk('public')
        ->save('orden-compra.pdf')
        ->name('orden-compra.pdf');
        // Storage::disk('public')->put('orden-compra.pdf', $pdf->output());
    }
    public function generateDataEmail($id,$subject){
        $data = PurchaseOrder::with(['company', 'requisition', 'provider', 'providerContact', 'items', 'items.product', 'items.product.unit', 'items.product.brand', 'purchaser'])->find($id);
        // return $data;
        $service = new OrderCalculationService($data->id);
        $items = $data->items;
        $media[] = $data->getMedia('justification')->first();
        $media[] = $data->getMedia('direct_award')->first();
        $media[] = $data->getMedia('certifications')->first();
        $media[] = $data->getMedia('quote')->first();

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
        $data['subject']="ORDEN DE COMPRA {$data['folio']} {$subject}";
        return $data;
    }

    public function getRecipientsArray($data){
        $recipients = [];
        if($data->count()> 0){
            foreach($data as $item){
                $recipients[] = $item->email;
            }
        }
        return $recipients;
    }
}
