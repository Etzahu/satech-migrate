<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'id' => 36,
                'migration' => '0001_01_01_000000_create_users_table',
                'batch' => 1,
            ),
            1 => 
            array (
                'id' => 37,
                'migration' => '0001_01_01_000001_create_cache_table',
                'batch' => 1,
            ),
            2 => 
            array (
                'id' => 38,
                'migration' => '0001_01_01_000002_create_jobs_table',
                'batch' => 1,
            ),
            3 => 
            array (
                'id' => 40,
                'migration' => '2024_10_06_001145_create_drawing_categories_table',
                'batch' => 1,
            ),
            4 => 
            array (
                'id' => 41,
                'migration' => '2024_10_06_001206_create_sub_drawing_categories_table',
                'batch' => 1,
            ),
            5 => 
            array (
                'id' => 42,
                'migration' => '2024_10_06_025139_create_drawings_table',
                'batch' => 1,
            ),
            6 => 
            array (
                'id' => 43,
                'migration' => '2024_10_02_165911_create_permission_tables',
                'batch' => 2,
            ),
            7 => 
            array (
                'id' => 44,
                'migration' => '2024_10_07_202623_create_project_dn_np_cps_table',
                'batch' => 3,
            ),
        ));
        
        
    }
}