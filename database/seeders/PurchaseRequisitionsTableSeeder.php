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
                'folio' => 'G-ISW-2024-0001',
                'motive' => 'Nisi eaque voluptate eos illum ullamco omnis sequi eu',
                'observation' => 'texto de observaciones',
                'date_delivery' => '2024-11-04',
                'delivery_address' => 'Reprehenderit pariatur Id dolores magna dolor consequuntur non aliquid eveniet aliquam commodo',
                'status' => 'revisión por almacén',
                'company_id' => 1,
                'project_id' => 1,
                'approval_chain_id' => 1,
                'created_at' => '2024-11-01 16:11:19',
                'updated_at' => '2024-11-01 16:41:07',
            ),
        ));
        
        
    }
}