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
                'quantity' => 1,
                'observation' => 'para nuevo',
                'requisition_id' => 1,
                'product_id' => 1,
                'created_at' => '2024-11-01 16:14:13',
                'updated_at' => '2024-11-01 16:14:13',
            ),
            1 => 
            array (
                'id' => 2,
                'quantity' => 9,
                'observation' => 'Eos culpa eius sed in ullam aute',
                'requisition_id' => 1,
                'product_id' => 2,
                'created_at' => '2024-11-01 16:40:40',
                'updated_at' => '2024-11-01 16:40:40',
            ),
        ));
        
        
    }
}