<?php

namespace App\Services;

use App\Models\Company;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;

class PurchaseRequisitionChainService
{
    public function getAuthUser()
    {

        return auth()->user()->id;
    }
    public function getChainsReviewer()
    {
        $chains = PurchaseRequisitionApprovalChain::where('requester_id', $this->getAuthUser())->get();
        if (filled($chains)) {
            $chains = $chains->pluck('reviewer_id')->toArray();
            return $chains;
        } else {
            return [];
        }
    }
    public function getChainsApprover()
    {
        $chains = PurchaseRequisitionApprovalChain::where('approver', $this->getAuthUser())->get();
        if (filled($chains)) {
            $chains = $chains->pluck('reviewer_id')->toArray();
            return $chains;
        } else {
            return [];
        }
    }
}
