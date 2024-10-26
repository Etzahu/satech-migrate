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
                'name' => 'aceros',
                'code' => 'AC',
                'created_at' => '2024-10-22 20:11:25',
                'updated_at' => '2024-10-22 20:11:25',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'activo fijo',
                'code' => 'AF',
                'created_at' => '2024-10-22 20:11:40',
                'updated_at' => '2024-10-22 20:11:40',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'combustibles',
                'code' => 'CB',
                'created_at' => '2024-10-22 20:11:59',
                'updated_at' => '2024-10-22 20:11:59',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'consumibles',
                'code' => 'CN',
                'created_at' => '2024-10-22 20:12:22',
                'updated_at' => '2024-10-22 20:12:22',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'equipo de medición',
                'code' => 'EM',
                'created_at' => '2024-10-22 20:12:33',
                'updated_at' => '2024-10-22 20:12:33',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'fittings',
                'code' => 'FT',
                'created_at' => '2024-10-22 20:12:44',
                'updated_at' => '2024-10-22 20:12:44',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'gases',
                'code' => 'GS',
                'created_at' => '2024-10-22 20:12:55',
                'updated_at' => '2024-10-22 20:12:55',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'herramientas',
                'code' => 'HR',
                'created_at' => '2024-10-22 20:13:04',
                'updated_at' => '2024-10-22 20:13:04',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'mobiliario',
                'code' => 'MB',
                'created_at' => '2024-10-22 20:13:15',
                'updated_at' => '2024-10-22 20:13:15',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'pinturas',
                'code' => 'PT',
                'created_at' => '2024-10-22 20:13:25',
                'updated_at' => '2024-10-22 20:13:25',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'pipe & conection',
                'code' => 'PC',
                'created_at' => '2024-10-22 20:13:36',
                'updated_at' => '2024-10-22 20:13:36',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'químico',
                'code' => 'QM',
                'created_at' => '2024-10-22 20:13:45',
                'updated_at' => '2024-10-23 14:29:20',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'recubrimientos',
                'code' => 'RC',
                'created_at' => '2024-10-22 20:13:57',
                'updated_at' => '2024-10-22 20:13:57',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'servicios',
                'code' => 'SV',
                'created_at' => '2024-10-22 20:14:09',
                'updated_at' => '2024-10-22 20:14:09',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'soldadura',
                'code' => 'SL',
                'created_at' => '2024-10-22 20:14:15',
                'updated_at' => '2024-10-22 20:14:15',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'tornillería y esparrago',
                'code' => 'TR',
                'created_at' => '2024-10-22 20:14:27',
                'updated_at' => '2024-10-22 20:14:27',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'válvulas',
                'code' => 'VV',
                'created_at' => '2024-10-22 20:14:36',
                'updated_at' => '2024-10-22 20:14:36',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'arrendamiento',
                'code' => 'AR',
                'created_at' => '2024-10-23 15:01:52',
                'updated_at' => '2024-10-23 15:01:52',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'pago de servicios',
                'code' => 'PS',
                'created_at' => '2024-10-23 15:02:19',
                'updated_at' => '2024-10-23 15:02:19',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'equipo',
                'code' => 'EQ',
                'created_at' => '2024-10-23 15:02:47',
                'updated_at' => '2024-10-23 15:02:47',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'consumibles it',
                'code' => 'IT',
                'created_at' => '2024-10-23 15:03:06',
                'updated_at' => '2024-10-23 15:03:06',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'refacciones',
                'code' => 'RF',
                'created_at' => '2024-10-23 15:03:42',
                'updated_at' => '2024-10-23 15:03:42',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'flotilla',
                'code' => 'FL',
                'created_at' => '2024-10-23 15:04:02',
                'updated_at' => '2024-10-23 15:04:02',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'cafeteria',
                'code' => 'CF',
                'created_at' => '2024-10-23 15:04:34',
                'updated_at' => '2024-10-23 15:04:34',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'limpieza',
                'code' => 'LM',
                'created_at' => '2024-10-23 15:05:11',
                'updated_at' => '2024-10-23 15:05:11',
            ),
        ));
        
        
    }
}