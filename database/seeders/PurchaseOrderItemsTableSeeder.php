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
                'quantity' => 8,
                'unit_price' => 5500,
                'sub_total' => 44000,
                'observation' => 'Sit esse duis commo',
                'product_id' => 1,
                'product_replace_id' => NULL,
                'purchase_order_id' => 1,
                'created_at' => '2024-12-10 20:08:18',
                'updated_at' => '2024-12-16 14:48:26',
            ),
            1 => 
            array (
                'id' => 2,
                'quantity' => 8,
                'unit_price' => 5500,
                'sub_total' => 44000,
                'observation' => NULL,
                'product_id' => 2,
                'product_replace_id' => NULL,
                'purchase_order_id' => 1,
                'created_at' => '2024-12-11 14:57:38',
                'updated_at' => '2024-12-16 14:49:05',
            ),
            2 => 
            array (
                'id' => 3,
                'quantity' => 5,
                'unit_price' => 0,
                'sub_total' => 0,
                'observation' => '',
                'product_id' => 1,
                'product_replace_id' => NULL,
                'purchase_order_id' => 2,
                'created_at' => '2024-12-11 15:38:05',
                'updated_at' => '2024-12-11 15:38:05',
            ),
            3 => 
            array (
                'id' => 4,
                'quantity' => 2,
                'unit_price' => 0,
                'sub_total' => 0,
                'observation' => '',
                'product_id' => 2,
                'product_replace_id' => NULL,
                'purchase_order_id' => 2,
                'created_at' => '2024-12-11 15:38:05',
                'updated_at' => '2024-12-11 15:38:05',
            ),
        ));
        
        
    }
}