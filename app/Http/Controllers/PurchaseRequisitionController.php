<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseRequisition;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseRequisitionController extends Controller
{

    public function pdf($id){

        $rq = PurchaseRequisition::with(['items','approvalChain','project','company'])->findOrFail($id);
        // return view('pdf.purchase-requisition',compact('rq'));
        $pdf = Pdf::loadView('pdf.purchase-requisition',compact('rq'))->setPaper('a4', 'landscape');
        return $pdf->stream($rq->folio.'.pdf');
    }
}
