<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('brands')->delete();
        
        \DB::table('brands')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Aline Parker',
                'created_at' => '2024-12-18 15:34:20',
                'updated_at' => '2024-12-18 15:34:20',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Sin marca',
                'created_at' => '2024-12-18 15:46:18',
                'updated_at' => '2024-12-18 15:46:18',
            ),
        ));
        
        
    }
}