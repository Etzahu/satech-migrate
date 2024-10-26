<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseRequisitionApprovalChainsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_requisition_approval_chains')->delete();
        
        \DB::table('purchase_requisition_approval_chains')->insert(array (
            0 => 
            array (
                'id' => 1,
                'requester_id' => 199,
                'reviewer_id' => 152,
                'approver_id' => 331,
                'created_at' => '2024-10-24 20:11:03',
                'updated_at' => '2024-10-24 20:11:03',
            ),
            1 => 
            array (
                'id' => 2,
                'requester_id' => 199,
                'reviewer_id' => 199,
                'approver_id' => 331,
                'created_at' => '2024-10-24 20:11:28',
                'updated_at' => '2024-10-24 20:11:28',
            ),
        ));
        
        
    }
}