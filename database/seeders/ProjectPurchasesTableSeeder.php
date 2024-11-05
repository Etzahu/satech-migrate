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
                'code' => 'NP-001-2024',
                'name' => 'PROYECTO TEST',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2024-11-01 16:09:45',
                'updated_at' => '2024-11-01 16:09:45',
            ),
        ));
        
        
    }
}