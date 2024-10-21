<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectPurchasesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('project_purchases')->delete();
        
        \DB::table('project_purchases')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'BRADY PATRICK',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2024-10-17 18:51:55',
                'updated_at' => '2024-10-17 18:51:55',
            ),
        ));
        
        
    }
}