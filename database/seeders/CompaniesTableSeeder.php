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
                'name' => 'GPT Ingeniería Y Manufactura, S.A. de C.V.',
                'short_name' => 'GPT Services',
                'acronym' => 'G',
                'rfc' => 'GIM190219UB2',
                'street' => 'Av. Santa Monica',
                'number' => '33',
                'neighborhood' => 'Col. El Mirador',
                'municipality' => 'Tlalnepantla de Baz',
                'state' => 'Estado de Mexico',
                'country' => 'Mexico',
                'cp' => '54080',
                'created_at' => '2024-12-03 08:59:39',
                'updated_at' => '2024-12-03 08:59:39',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'TECHENERGY CONTROL, S.A. de C.V.',
                'short_name' => 'TECHENERGY',
                'acronym' => 'T',
                'rfc' => 'TEC140522JM4',
                'street' => 'Av. Santa Monica',
                'number' => '33',
                'neighborhood' => 'Col. El Mirador',
                'municipality' => 'Tlalnepantla de Baz',
                'state' => 'Estado de Mexico',
                'country' => 'Mexico',
                'cp' => '54080',
                'created_at' => '2024-12-03 08:59:39',
                'updated_at' => '2024-12-03 08:59:39',
            ),
        ));


    }
}
