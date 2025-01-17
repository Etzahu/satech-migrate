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
                'id' => 2,
                'quantity' => 1,
                'unit_price' => 100000,
                'sub_total' => 100000,
                'observation' => 'Anim mollitia tenetu',
                'product_id' => 4266546,
                'product_replace_id' => NULL,
                'purchase_order_id' => 2,
                'created_at' => '2025-01-13 18:06:22',
                'updated_at' => '2025-01-13 19:10:37',
            ),
            1 => 
            array (
                'id' => 3,
                'quantity' => 2,
                'unit_price' => 10000,
                'sub_total' => 20000,
                'observation' => 'Perferendis amet es',
                'product_id' => 4266546,
                'product_replace_id' => NULL,
                'purchase_order_id' => 2,
                'created_at' => '2025-01-13 19:15:15',
                'updated_at' => '2025-01-13 19:15:15',
            ),
            2 => 
            array (
                'id' => 4,
                'quantity' => 1,
                'unit_price' => 20000,
                'sub_total' => 20000,
                'observation' => 'pp',
                'product_id' => 4266548,
                'product_replace_id' => NULL,
                'purchase_order_id' => 2,
                'created_at' => '2025-01-13 20:14:25',
                'updated_at' => '2025-01-13 20:14:25',
            ),
            3 => 
            array (
                'id' => 5,
                'quantity' => 1,
                'unit_price' => 80000,
                'sub_total' => 80000,
                'observation' => 'Non quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volupNon quod porro volup',
                'product_id' => 4266545,
                'product_replace_id' => NULL,
                'purchase_order_id' => 3,
                'created_at' => '2025-01-15 15:37:20',
                'updated_at' => '2025-01-15 15:37:20',
            ),
        ));
        
        
    }
}