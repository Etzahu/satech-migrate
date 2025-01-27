<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseRequisition;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseRequisitionController extends Controller
{

    public function pdf($id){

        // TODO:falta limitar para solo los que esten relacionados con esta requisicion puedan verla
        $rq = PurchaseRequisition::with(['items','approvalChain','project','items.product','items.product.unit','company'])->findOrFail($id);
        // dd($rq->toArray());
        // return view('pdf.purchase-requisition',compact('rq'));
        // $m1= $rq->getMedia('supports');
        // $m2= $rq->getMedia('technical_data_sheets');
        // dd($m1->toArray(),$m2->toArray());
        $revisions = $rq->status()->timesWas('aprobado por gerencia');

        $pdf = Pdf::loadView('pdf.purchase-requisition',compact('rq','revisions'))->setPaper('a4', 'landscape');
        return $pdf->stream($rq->folio.'.pdf');
    }
}
