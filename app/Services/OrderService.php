<?php

namespace App\Services;

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
}
