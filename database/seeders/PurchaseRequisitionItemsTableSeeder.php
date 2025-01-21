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
                'observation' => 'p',
                'user_warehouse_id' => NULL,
                'requisition_id' => 1,
                'product_id' => 4266546,
                'created_at' => '2025-01-21 16:01:31',
                'updated_at' => '2025-01-21 16:01:31',
            ),
            1 => 
            array (
                'id' => 2,
                'quantity_requested' => 2,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 2,
                'observation' => 'p',
                'user_warehouse_id' => NULL,
                'requisition_id' => 2,
                'product_id' => 4266568,
                'created_at' => '2025-01-21 16:04:11',
                'updated_at' => '2025-01-21 16:04:11',
            ),
            2 => 
            array (
                'id' => 3,
                'quantity_requested' => 1,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 1,
                'observation' => 'p',
                'user_warehouse_id' => NULL,
                'requisition_id' => 2,
                'product_id' => 4266570,
                'created_at' => '2025-01-21 16:08:52',
                'updated_at' => '2025-01-21 16:08:52',
            ),
            3 => 
            array (
                'id' => 4,
                'quantity_requested' => 7,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 7,
                'observation' => '00',
                'user_warehouse_id' => NULL,
                'requisition_id' => 2,
                'product_id' => 4266580,
                'created_at' => '2025-01-21 16:11:24',
                'updated_at' => '2025-01-21 16:11:24',
            ),
            4 => 
            array (
                'id' => 5,
                'quantity_requested' => 7,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 7,
                'observation' => 'pp',
                'user_warehouse_id' => NULL,
                'requisition_id' => 3,
                'product_id' => 4266544,
                'created_at' => '2025-01-21 16:17:52',
                'updated_at' => '2025-01-21 16:17:52',
            ),
            5 => 
            array (
                'id' => 6,
                'quantity_requested' => 9,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 9,
                'observation' => 'o',
                'user_warehouse_id' => NULL,
                'requisition_id' => 3,
                'product_id' => 4266549,
                'created_at' => '2025-01-21 16:20:10',
                'updated_at' => '2025-01-21 16:20:10',
            ),
            6 => 
            array (
                'id' => 7,
                'quantity_requested' => 2,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 2,
                'observation' => 'mm',
                'user_warehouse_id' => NULL,
                'requisition_id' => 3,
                'product_id' => 4266586,
                'created_at' => '2025-01-21 16:23:23',
                'updated_at' => '2025-01-21 16:23:23',
            ),
            7 => 
            array (
                'id' => 8,
                'quantity_requested' => 2,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 2,
                'observation' => 'ppp',
                'user_warehouse_id' => NULL,
                'requisition_id' => 4,
                'product_id' => 4266591,
                'created_at' => '2025-01-21 16:25:26',
                'updated_at' => '2025-01-21 16:25:26',
            ),
        ));
        
        
    }
}