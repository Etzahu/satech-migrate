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
                'id' => 2,
                'quantity_requested' => 1,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 1,
                'observation' => 'pp',
                'user_warehouse_id' => NULL,
                'requisition_id' => 2,
                'product_id' => 4266544,
                'created_at' => '2025-01-13 15:08:22',
                'updated_at' => '2025-01-13 15:08:22',
            ),
        ));
        
        
    }
}