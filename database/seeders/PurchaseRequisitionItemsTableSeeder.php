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
                'quantity_requested' => 2,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 2,
                'observation' => 'Enim omnis labore dolor deleniti aute dolorem sequi pariatur Cupidatat proident do repellendus Obcaecati',
                'user_warehouse_id' => NULL,
                'requisition_id' => 1,
                'product_id' => 1,
                'created_at' => '2025-01-06 16:00:19',
                'updated_at' => '2025-01-06 16:00:19',
            ),
            1 => 
            array (
                'id' => 2,
                'quantity_requested' => 2,
                'quantity_warehouse' => 0,
                'quantity_purchase' => 2,
                'observation' => 'Laboris iure nobis dignissimos culpa dicta ipsam doloribus doloribus optio in sed',
                'user_warehouse_id' => NULL,
                'requisition_id' => 2,
                'product_id' => 2,
                'created_at' => '2025-01-06 16:01:46',
                'updated_at' => '2025-01-06 16:01:46',
            ),
        ));
        
        
    }
}