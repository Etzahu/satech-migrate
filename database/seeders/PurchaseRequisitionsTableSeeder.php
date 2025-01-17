<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseRequisitionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_requisitions')->delete();
        
        \DB::table('purchase_requisitions')->insert(array (
            0 => 
            array (
                'id' => 2,
                'folio' => 'G-SG-2025-0001',
                'confidential' => 0,
                'motive' => 'Aliqua Vero voluptas mollit id incididunt et sunt aliquip veniam neque omnis do in consequuntur modi aute quas',
                'observation' => 'Nihil cillum velit et laboris laboriosam mollit sed',
                'date_delivery' => '2025-01-14',
                'delivery_address' => 'Ex aliqua Enim ducimus enim quidem suscipit labore iusto voluptas labore atque qui eligendi sed lorem est Nam',
                'status' => 'comprador asignado',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 2,
                'approval_chain_id' => 2,
                'assign_user_id' => 199,
                'created_at' => '2025-01-13 15:07:58',
                'updated_at' => '2025-01-13 15:10:34',
            ),
        ));
        
        
    }
}