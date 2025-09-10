<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseRequisition;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseRequisitionController extends Controller
{

    public function pdf($id)
    {

        // TODO:falta limitar para solo los que esten relacionados con esta requisicion puedan verla
        $rq = PurchaseRequisition::with(['items', 'approvalChain', 'project', 'items.product', 'items.product.unit', 'company'])->findOrFail($id);
        $revisions = $rq->status()->timesWas('aprobado por DG');
        $stages = [];
        $stages = $rq->progress;
        unset($stages['purchaser']);

        // return view('pdf.purchase-requisition',compact('rq','revisions','stages'));
        $pdf = Pdf::loadView('pdf.purchase-requisition', compact('rq', 'revisions', 'stages'))->setPaper('a4', 'landscape');
        return $pdf->stream($rq->folio . '.pdf');
    }
}
