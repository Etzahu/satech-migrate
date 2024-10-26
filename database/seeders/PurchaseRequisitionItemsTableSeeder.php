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
        
        
        
    }
}