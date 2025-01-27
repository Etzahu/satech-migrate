<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MeasureUnitsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('measure_units')->delete();
        
        \DB::table('measure_units')->insert(array (
            0 => 
            array (
                'id' => 1,
            'name' => 'Bote (16 kg)',
            'acronym' => 'Bote (16 Kg)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            1 => 
            array (
                'id' => 2,
            'name' => 'Bote (19 litros)',
            'acronym' => 'Bote (19 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            2 => 
            array (
                'id' => 3,
            'name' => 'Bote (40 litros)',
            'acronym' => 'Bote (40 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Caja',
                'acronym' => 'Cj',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-12 00:27:24',
            ),
            4 => 
            array (
                'id' => 5,
            'name' => 'Cubeta(10 litros)',
            'acronym' => 'Cubeta(10 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            5 => 
            array (
                'id' => 6,
            'name' => 'Cubeta (1O kg)',
            'acronym' => 'Cubeta (10 Kg)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Equipo',
                'acronym' => 'Eq',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            7 => 
            array (
                'id' => 8,
            'name' => 'Garrafón (20 litros)',
            'acronym' => 'Garrafón (20 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            8 => 
            array (
                'id' => 9,
            'name' => 'Garrafón (9.5 litros)',
            'acronym' => 'Garrafón (9.5 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Hora',
                'acronym' => 'Hr',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Inch',
                'acronym' => 'Inch',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Juego',
                'acronym' => 'Jg',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-12 00:29:38',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Kg',
                'acronym' => 'Kg',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Kit',
                'acronym' => 'Kit',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Ltrs',
                'acronym' => 'Ltrs',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'M',
                'acronym' => 'Mtr',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'm2',
                'acronym' => 'M2',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'ml',
                'acronym' => 'Mtl',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Pieza',
                'acronym' => 'Pz',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Prueba',
                'acronym' => 'Prb',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'SRV',
                'acronym' => 'Servicio',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Tambo 206 lts',
                'acronym' => 'Tambo 206 Lts',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            22 => 
            array (
                'id' => 23,
            'name' => 'Tanque (10 lt)',
            'acronym' => 'Tanque (10 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            23 => 
            array (
                'id' => 24,
            'name' => 'Tanque (20 lt)',
            'acronym' => 'Tanque (20 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            24 => 
            array (
                'id' => 25,
            'name' => 'Tanque (45 lt)',
            'acronym' => 'Tanque (45 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            25 => 
            array (
                'id' => 26,
            'name' => 'Tanque (50 lt)',
            'acronym' => 'Tanque (50 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Tanque 5 Kilos',
            'acronym' => 'Tanque (5 Kg)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Botella',
                'acronym' => 'Bta',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Juegos',
                'acronym' => 'Jgo',
                'created_at' => '2025-01-12 00:29:53',
                'updated_at' => '2025-01-12 00:29:53',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Par',
                'acronym' => 'Par',
                'created_at' => '2025-01-12 00:30:37',
                'updated_at' => '2025-01-12 00:30:37',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Litro',
                'acronym' => 'Lt',
                'created_at' => '2025-01-12 00:31:16',
                'updated_at' => '2025-01-12 00:31:16',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Kilos',
                'acronym' => 'Kilos',
                'created_at' => '2025-01-27 09:22:25',
                'updated_at' => '2025-01-27 09:22:25',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Mts',
                'acronym' => 'Mts',
                'created_at' => '2025-01-27 09:30:34',
                'updated_at' => '2025-01-27 09:30:34',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'P/Montacargas',
                'acronym' => 'P/Montacargas',
                'created_at' => '2025-01-27 09:30:54',
                'updated_at' => '2025-01-27 09:30:54',
            ),
        ));
        
        
    }
}