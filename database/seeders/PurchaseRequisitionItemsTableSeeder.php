<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseRequisitionItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_requisition_items')->delete();
        
        \DB::table('purchase_requisition_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'quantity_requested' => 1,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 1,
                'observation' => 'Eos est eum esse nulla eveniet mollit in ut blanditiis et',
                'user_warehouse_id' => NULL,
                'requisition_id' => 1,
                'product_id' => 1,
                'created_at' => '2025-01-09 17:32:46',
                'updated_at' => '2025-01-09 17:32:46',
            ),
        ));
        
        
    }
}