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
        ));
        
        
    }
}