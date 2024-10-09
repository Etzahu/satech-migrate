<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DrawingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('drawings')->delete();
        
        \DB::table('drawings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'folio' => '1',
                'drawing_category_id' => 3,
                'sub_drawing_category_id' => 40,
                'user_id' => 53,
                'created_at' => '2024-10-06 03:57:10',
                'updated_at' => '2024-10-06 03:57:10',
            ),
            1 => 
            array (
                'id' => 2,
                'folio' => 'GPT-04-430-0001',
                'drawing_category_id' => 4,
                'sub_drawing_category_id' => 18,
                'user_id' => 67,
                'created_at' => '2024-10-06 05:00:22',
                'updated_at' => '2024-10-06 05:00:22',
            ),
            2 => 
            array (
                'id' => 3,
                'folio' => 'GPT-03-120-0002',
                'drawing_category_id' => 3,
                'sub_drawing_category_id' => 40,
                'user_id' => 40,
                'created_at' => '2024-10-06 05:02:07',
                'updated_at' => '2024-10-06 05:02:07',
            ),
            3 => 
            array (
                'id' => 4,
                'folio' => 'GPT-04-330-0001',
                'drawing_category_id' => 4,
                'sub_drawing_category_id' => 17,
                'user_id' => 53,
                'created_at' => '2024-10-07 19:18:00',
                'updated_at' => '2024-10-07 19:18:00',
            ),
            4 => 
            array (
                'id' => 5,
                'folio' => 'GPT-04-330-0002',
                'drawing_category_id' => 4,
                'sub_drawing_category_id' => 17,
                'user_id' => 53,
                'created_at' => '2024-10-07 19:18:32',
                'updated_at' => '2024-10-07 19:18:32',
            ),
        ));
        
        
    }
}