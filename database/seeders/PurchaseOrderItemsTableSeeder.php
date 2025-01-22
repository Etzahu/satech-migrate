<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseOrderItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_order_items')->delete();
        
        \DB::table('purchase_order_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'quantity' => 2,
                'unit_price' => 10000,
                'sub_total' => 20000,
                'observation' => 'p',
                'product_id' => 4266591,
                'product_replace_id' => NULL,
                'purchase_order_id' => 1,
                'created_at' => '2025-01-21 17:19:24',
                'updated_at' => '2025-01-21 17:19:48',
            ),
            1 => 
            array (
                'id' => 2,
                'quantity' => 2,
                'unit_price' => 0,
                'sub_total' => 0,
                'observation' => '',
                'product_id' => 4266591,
                'product_replace_id' => NULL,
                'purchase_order_id' => 2,
                'created_at' => '2025-01-22 15:04:16',
                'updated_at' => '2025-01-22 15:04:16',
            ),
            2 => 
            array (
                'id' => 3,
                'quantity' => 2,
                'unit_price' => 0,
                'sub_total' => 0,
                'observation' => '',
                'product_id' => 4266591,
                'product_replace_id' => NULL,
                'purchase_order_id' => 3,
                'created_at' => '2025-01-22 17:52:21',
                'updated_at' => '2025-01-22 17:52:21',
            ),
            3 => 
            array (
                'id' => 4,
                'quantity' => 7,
                'unit_price' => 0,
                'sub_total' => 0,
                'observation' => '',
                'product_id' => 4266544,
                'product_replace_id' => NULL,
                'purchase_order_id' => 4,
                'created_at' => '2025-01-22 17:54:01',
                'updated_at' => '2025-01-22 17:54:01',
            ),
            4 => 
            array (
                'id' => 6,
                'quantity' => 2,
                'unit_price' => 10000,
                'sub_total' => 20000,
                'observation' => NULL,
                'product_id' => 4266586,
                'product_replace_id' => NULL,
                'purchase_order_id' => 5,
                'created_at' => '2025-01-22 17:56:55',
                'updated_at' => '2025-01-22 17:58:45',
            ),
            5 => 
            array (
                'id' => 7,
                'quantity' => 1,
                'unit_price' => 500000,
                'sub_total' => 500000,
                'observation' => 'prueba',
                'product_id' => 4266547,
                'product_replace_id' => NULL,
                'purchase_order_id' => 5,
                'created_at' => '2025-01-22 17:58:37',
                'updated_at' => '2025-01-22 17:58:37',
            ),
        ));
        
        
    }
}