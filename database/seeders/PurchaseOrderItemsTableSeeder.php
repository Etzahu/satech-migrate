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
                'quantity' => 1,
                'unit_price' => 500000,
                'sub_total' => 500000,
                'observation' => 'Suscipit nulla quo d',
                'product_id' => 1,
                'product_replace_id' => NULL,
                'purchase_order_id' => 1,
                'created_at' => '2025-01-09 17:56:55',
                'updated_at' => '2025-01-09 17:57:44',
            ),
        ));
        
        
    }
}