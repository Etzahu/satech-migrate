<?php

namespace App\Services;

use App\Models\Company;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;

class PurchaseRequisitionCreationService
{
    public function generateFolio()
    {
        return $this->getCompany() . '-' . $this->getManangement() . '-' . now()->year . '-' . $this->getCountRecords();
    }

    public function getCountRecords()
    {
        $count =PurchaseRequisition::whereYear('created_at', now()->year)
        ->withWhereHas(
            'approvalChain.requester',
            function ($query) {
                $query->where('management_id', auth()->user()->management_id);
            }
        )->count()+1;

        return str($count)->padLeft(4, '0');
    }

    public function getApprovalChain($reviewerId, $approverId)
    {
        return PurchaseRequisitionApprovalChain::where('requester_id', auth()->user()->id)
            ->where('reviewer_id', $reviewerId)
            ->where('approver_id', $approverId)->first()->id;
    }
    public function getManangement()
    {
        return auth()->user()->management->acronym;
    }
    public function getCompany()
    {
        return Company::find(session()->get('company_id'))->acronym;
    }

    public function generateDataForEmail($subject,$model,$user){

        $data = [
            'asunto_email' => "Requicisión:{$model->folio}, {$subject}",
            'user' => ['nombre' => $user['nombre'], 'email' => $user['email']],
            'folio' => $model->folio,
            'solicitud' => [
                'solicitante' => $model->approvalChain->requester->nombre(),
                'area' =>  $model->approvalChain->requester->management->name,
                'fecha de creación' => $model->created_at->format('Y-m-d'),
                'fecha de deseable de entrega' => $model->date_delivery->format('Y-m-d'),
            ],
            'items' => $this->getItemsForEmail($model),
            'status' => 'Para revisión por almacén',
            'mensaje' => '',
            'url_btn' => route('ingenieria.solicitud.trabajo.revision.show', $model->id)
        ];

        return $data;
    }

    public function getItemsForEmail($model){
        $items = [];
        foreach($model->items as $item){
            $items[] = [
                'producto' => $item->product->name,
                'cantidad' => $item->quantity,
            ];
        }
        return $items;
    }
}
