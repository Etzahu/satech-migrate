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
                'unit_price' => 90000,
                'sub_total' => 180000,
                'observation' => 'Veniam eiusmod quas',
                'product_id' => 2,
                'product_replace_id' => NULL,
                'purchase_order_id' => 1,
                'created_at' => '2025-01-06 16:08:41',
                'updated_at' => '2025-01-06 16:10:05',
            ),
            1 => 
            array (
                'id' => 2,
                'quantity' => 2,
                'unit_price' => 50000,
                'sub_total' => 100000,
                'observation' => 'Debitis id incidunt',
                'product_id' => 1,
                'product_replace_id' => NULL,
                'purchase_order_id' => 2,
                'created_at' => '2025-01-06 16:15:30',
                'updated_at' => '2025-01-06 16:15:50',
            ),
        ));
        
        
    }
}