<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('products')->delete();
        
        \DB::table('products')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'dell',
                'code' => 'IT0070001',
                'brand_id' => NULL,
                'unit_id' => 19,
                'category_id' => 21,
                'category_family_id' => 245,
                'created_at' => '2025-01-09 17:32:28',
                'updated_at' => '2025-01-09 17:32:28',
            ),
        ));
        
        
    }
}