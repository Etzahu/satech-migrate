<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RequisitionItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('requisition_items')->delete();
        
        
        
    }
}