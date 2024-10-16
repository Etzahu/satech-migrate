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
                'id' => 3,
                'name' => 'laptop',
                'code' => 'XXdd2000',
                'unit_id' => 47,
                'category_id' => 1,
                'category_family_id' => 2,
                'created_at' => '2024-10-16 17:05:42',
                'updated_at' => '2024-10-16 17:14:30',
            ),
        ));
        
        
    }
}