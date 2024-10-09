<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DrawingCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('drawing_categories')->delete();
        
        \DB::table('drawing_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'DIAGRAMA HT',
                'code' => '01',
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'DIAGRAMA LS',
                'code' => '02',
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'DIAGRAMA DRILL',
                'code' => '03',
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'MAPEO DE SOLDADURAS',
                'code' => '04',
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'INGENIERIA',
                'code' => '05',
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'PLANOS ESPECIALES',
                'code' => '06',
                'created_at' => '2024-10-05 18:43:21',
                'updated_at' => '2024-10-05 18:43:21',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'pppp',
                'code' => '9898',
                'created_at' => '2024-10-07 13:53:15',
                'updated_at' => '2024-10-07 13:53:15',
            ),
        ));
        
        
    }
}