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
                'observation' => 'Sin observaciones',
                'user_warehouse_id' => NULL,
                'requisition_id' => 1,
                'product_id' => 6,
                'created_at' => '2025-01-25 01:22:19',
                'updated_at' => '2025-01-25 01:22:19',
            ),
            1 => 
            array (
                'id' => 2,
                'quantity_requested' => 1,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 1,
                'observation' => 'Sin observaciones',
                'user_warehouse_id' => NULL,
                'requisition_id' => 2,
                'product_id' => 19,
                'created_at' => '2025-01-25 02:45:02',
                'updated_at' => '2025-01-25 02:45:02',
            ),
            2 => 
            array (
                'id' => 3,
                'quantity_requested' => 1,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 1,
                'observation' => 'Sin observaciones',
                'user_warehouse_id' => NULL,
                'requisition_id' => 3,
                'product_id' => 48,
                'created_at' => '2025-01-25 02:59:36',
                'updated_at' => '2025-01-25 02:59:36',
            ),
            3 => 
            array (
                'id' => 4,
                'quantity_requested' => 1,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 1,
                'observation' => 'Sin observaciones',
                'user_warehouse_id' => NULL,
                'requisition_id' => 5,
                'product_id' => 38,
                'created_at' => '2025-01-25 04:28:55',
                'updated_at' => '2025-01-25 04:28:55',
            ),
        ));
        
        
    }
}