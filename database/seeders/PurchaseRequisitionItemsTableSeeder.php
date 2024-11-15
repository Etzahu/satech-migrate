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
                'quantity_requested' => 5,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 5,
                'observation' => 'Fuga Aperiam voluptates temporibus quia molestiae velit eos',
                'user_warehouse_id' => NULL,
                'requisition_id' => 1,
                'product_id' => 1,
                'created_at' => '2024-11-14 16:32:06',
                'updated_at' => '2024-11-14 16:32:06',
            ),
            1 => 
            array (
                'id' => 2,
                'quantity_requested' => 2,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 2,
                'observation' => 'Maxime qui tempora voluptate aliqua Velit est doloremque neque nemo voluptate nihil quae ullam',
                'user_warehouse_id' => NULL,
                'requisition_id' => 1,
                'product_id' => 2,
                'created_at' => '2024-11-14 16:32:15',
                'updated_at' => '2024-11-14 16:32:15',
            ),
        ));
        
        
    }
}