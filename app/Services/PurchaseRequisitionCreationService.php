<?php

namespace App\Services;

use App\Models\User;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PurchaseRequisition;
use Illuminate\Support\Facades\Storage;
use App\Models\PurchaseRequisitionApprovalChain;

class PurchaseRequisitionCreationService
{
    public function generateFolio()
    {
        return $this->getCompany() . '-' . $this->getManangement() . '-' . now()->year . '-' . $this->getCountRecords();
    }

    public function getCountRecords()
    {
        $count = PurchaseRequisition::whereYear('created_at', now()->year)
            ->withWhereHas(
                'approvalChain.requester',
                function ($query) {
                    $query->where('management_id', auth()->user()->management_id);
                }
            )->count() + 1;

        return str($count)->padLeft(4, '0');
    }

    public function getApprovalChain($reviewerId, $approverId)
    {
        return PurchaseRequisitionApprovalChain::where('requester_id', auth()->user()->id)
            ->where('reviewer_id', $reviewerId)
            ->where('approver_id', $approverId)->first()->id;
    }
    public function getApprovalChainConfidential()
    {
        return PurchaseRequisitionApprovalChain::where('requester_id', auth()->user()->id)->first()->id;
    }
    public function getManangement()
    {
        return auth()->user()->management->acronym;
    }
    public function getCompany()
    {
        return Company::find(session()->get('company_id'))->acronym;
    }

    public function generateDataForEmail($subject, $model)
    {
        $subject = str($subject)->upper();
        $data = [
            'subject' => "{$subject} REQUISICIÓN:{$model->folio}",
            'company' => $model->company->name,
            'management' => $model->approvalChain->requester->management->name,
            'requester' => $model->approvalChain->requester->name,
            'folio' => $model->folio,
            'created_at' => $model->created_at->format('d-m-Y'),
            'date_delivery' => $model->date_delivery->format('d-m-Y'),
            'delivery_address' => $model->delivery_address,
            'project' => $model->project->code . '-' . $model->project->name,
            'observation' => $model->observation,
            'items' => $this->getItemsForEmail($model->items),
            'mensaje' => '',
            'url_btn' => ''
        ];

        return $data;
    }

    public function getItemsForEmail($items)
    {
        $data = [];
        foreach ($items as $item) {
            if ($item->quantity_purchase > 0) {
                $data[] = [
                    'code' => $item->product->code,
                    'product' => $item->product->name,
                    'um' => $item->product->unit->acronym,
                    'quantity_requested' => $item->quantity_requested,
                    'quantity_warehouse' => $item->quantity_warehouse,
                    'quantity_purchase' => $item->quantity_purchase,
                    'observation' => $item->observation,
                ];
            }
        }
        return $data;
    }

    public function generatePdf($model)
    {
        $rq =  $model->load(['items', 'approvalChain', 'project', 'items.product', 'items.product.unit', 'company']);
        $pdf = Pdf::loadView('pdf.purchase-requisition', compact('rq'))->setPaper('a4', 'landscape');
        Storage::disk('public')->put('requisicion-compra.pdf', $pdf->output());
    }
    public function getUserForEmail($data)
    {
        $recipient = [];
        if (count($data) >= 1) {
            foreach ($data as $user) {
                $recipient[] = $user['email'];
            }
        } else {
            return $data[0]['email'];
        }
        return $recipient;
    }

    public function compareRequestedAndPurchase($items)
    {
        $data = [];
        foreach ($items as $item) {
            if ($item->quantity_requested !== $item->quantity_purchase) {
                $data[] = $item;
            }
        }
        return $data;
    }
    public function getUserForEmailPRFinish($model){
        $moreUsers = [];
        $moreUsers[] = $model->approvalChain->reviewer->email;
        $moreUsers[] = $model->approvalChain->approver->email;
        $moreUsers[] = User::role('autoriza_requisicion_compra')->first()->email;
        $usersWareHouse = User::role('revisa_almacen_requisicion_compra')->get()->flatten();
        foreach ($usersWareHouse as $user) {
            $moreUsers[] = $user->email;
        }
        return array_unique($moreUsers);
    }
}
