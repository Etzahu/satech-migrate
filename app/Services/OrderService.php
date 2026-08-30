<?php

namespace App\Services;

use Money\Money;
use Money\Currency;
use App\Models\User;
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
        return $this->getCompany()->acronym . now()->format('y') . '-' . $this->getCountRecords();
    }
    public function getCountRecords()
    {
        $count = PurchaseOrder::withTrashed()
            ->whereYear('created_at', now()->year)
            ->where('company_id', $this->getCompany()->id)
            ->count() + 1;

        return str($count)->padLeft(3, '0');
    }

    public function getCompany()
    {
        return Company::find(session()->get('company_id'));
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
    public function generateDataEmail($id, $subject)
    {
        $data = PurchaseOrder::with(['company', 'requisition', 'provider', 'providerContact', 'items', 'items.product', 'items.product.unit', 'items.product.brand', 'purchaser'])->find($id);
        // return $data;
        $service = new OrderCalculationService($data->id);
        $items = $data->items;
        $media[] = $data->getMedia('justification')->first();
        $media[] = $data->getMedia('direct_award')->first();
        $media[] = $data->getMedia('certifications')->first();
        $media[] = $data->getMedia('quote')->first();

        $itemsFormatted = $items->map(function ($item) use ($data, $service) {
            // $unitPrice =  new Money($item->unit_price, new Currency($data->currency));
            // $subTotal =  new Money($item->sub_total, new Currency($data->currency));
            $unitPrice = $item->unit_price;
            $subTotal =  $item->sub_total;
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
        $data['total'] = $total;
        $data['media'] = $media;
        $data['itemsFormatted'] = $itemsFormatted;
        $subject = str($subject)->upper();
        $data['subject'] = "{$subject} ORDEN DE COMPRA {$data['folio']}";
        $data['item_label'] = $data->requisition?->item_label ?? 'Producto';
        return $data;
    }

    public function getRecipientsArray($data)
    {
        $recipients = [];
        if ($data->count() > 0) {
            foreach ($data as $item) {
                $recipients[] = $item->email;
            }
        }
        return $recipients;
    }
    /**
     * Copia del correo de cierre de la orden.
     *
     * Incluye a quien firmó de verdad cada nivel: bajo el flujo por rol de los
     * cinco departamentos operativos, los niveles 2 y 3 no los ocupa la cadena
     * sino Alan y Sergio, así que se resuelven con el mismo servicio que decide
     * quién actúa. Se conserva al solicitante de la cadena, que sí es siempre
     * el mismo.
     *
     * Los roles se leen con withRole() —no con el scope role() de Spatie—
     * porque ese lanza RoleDoesNotExist cuando el rol no existe en la base, y
     * este correo no debe tumbar el cierre de una orden por eso.
     */
    public function getUserForEmailFinish($model)
    {
        $resolver = app(\App\Services\PurchaseOrderChainResolver::class);

        $moreUsers = [];
        $moreUsers[] = $model->requisition?->approvalChain?->requester?->email;
        $moreUsers = array_merge(
            $moreUsers,
            $resolver->approverEmails($model),
            $resolver->authorizerEmails($model),
            User::withRole('libera_orden_compra')->pluck('email')->all(),
            User::withRole('gerente_compras')->pluck('email')->all(),
            User::withRole('revisa_almacen_requisicion_compra')->pluck('email')->all(),
        );

        return array_values(array_unique(array_filter($moreUsers)));
    }
}
