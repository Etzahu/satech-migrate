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
                'id' => 1,
                'folio' => 'G-ALM-2024-0001',
                'confidential' => 0,
                'motive' => 'Non aut tempora et ut in iure voluptas debitis hic ut facilis molestiae nulla',
                'observation' => 'Aliquid sapiente iusto iusto praesentium ut in ut quia sed vel voluptates sunt voluptas',
                'date_delivery' => '2024-12-19',
                'delivery_address' => 'Quis suscipit molestiae officia natus dolore tempor soluta nulla aspernatur omnis',
                'status' => 'revisión por almacén',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 1,
                'approval_chain_id' => 1,
                'assign_user_id' => 274,
                'created_at' => '2024-11-14 16:31:09',
                'updated_at' => '2024-12-18 19:37:33',
            ),
        ));
        
        
    }
}