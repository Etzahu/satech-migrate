<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'insumos',
                'code' => 'XX',
                'created_at' => '2024-10-16 14:02:50',
                'updated_at' => '2024-10-16 14:19:08',
            ),
        ));
        
        
    }
}