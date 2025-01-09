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
                'folio' => 'G-SG-2025-0001',
                'confidential' => 0,
                'motive' => 'Iure reiciendis neque sint fugiat a aliquid',
                'observation' => 'Sapiente suscipit velit perspiciatis nihil qui deserunt perspiciatis tenetur quibusdam quia ea velit qui expedita qui consequatur esse ipsum qui',
                'date_delivery' => '2025-01-10',
                'delivery_address' => 'Maiores non est magni quisquam possimus eligendi omnis quia velit impedit voluptatibus ut pariatur Et laboris',
                'status' => 'comprador asignado',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 2,
                'approval_chain_id' => 2,
                'assign_user_id' => 199,
                'created_at' => '2025-01-09 17:31:31',
                'updated_at' => '2025-01-09 17:44:53',
            ),
        ));
        
        
    }
}