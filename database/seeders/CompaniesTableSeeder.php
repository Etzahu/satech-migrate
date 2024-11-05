<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('companies')->delete();
        
        \DB::table('companies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'GPT SERVICES',
                'acronym' => 'G',
                'rfc' => '1234',
                'address' => 'Av Sta Monica 33, El Mirador, 54080 Tlalnepantla, Méx',
                'created_at' => '2024-10-15 16:42:31',
                'updated_at' => '2024-10-15 16:42:31',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'TECHENERGY',
                'acronym' => 'T',
                'rfc' => '000',
                'address' => 'Av Sta Monica 33, El Mirador, 54080 Tlalnepantla, Méx',
                'created_at' => '2024-10-15 16:46:48',
                'updated_at' => '2024-10-15 16:46:48',
            ),
        ));
        
        
    }
}