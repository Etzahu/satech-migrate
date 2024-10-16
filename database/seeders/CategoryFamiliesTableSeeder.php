<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryFamiliesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('category_families')->delete();
        
        \DB::table('category_families')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'ppp',
                'code' => 'ppp',
                'category_id' => 1,
                'created_at' => '2024-10-16 14:08:03',
                'updated_at' => '2024-10-16 14:08:03',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'laptop',
                'code' => 'dd',
                'category_id' => 1,
                'created_at' => '2024-10-16 16:17:18',
                'updated_at' => '2024-10-16 16:17:18',
            ),
        ));
        
        
    }
}