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
                'name' => 'laptop',
                'code' => 'IT0070001',
                'brand_id' => 2,
                'unit_id' => 47,
                'category_id' => 21,
                'category_family_id' => 245,
                'created_at' => '2024-11-01 16:10:10',
                'updated_at' => '2024-12-18 15:52:13',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'impresora epson',
                'code' => 'IT0070002',
                'brand_id' => NULL,
                'unit_id' => 47,
                'category_id' => 21,
                'category_family_id' => 245,
                'created_at' => '2024-11-01 16:10:38',
                'updated_at' => '2024-11-01 16:10:38',
            ),
        ));
        
        
    }
}