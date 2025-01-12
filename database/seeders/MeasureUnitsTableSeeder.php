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
                'name' => 'Bote 16 Kg',
            'acronym' => 'Bote (16 Kg)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Bote 19 Litros',
            'acronym' => 'Bote (19 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Bote 40 Litros',
            'acronym' => 'Bote (40 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'caja',
                'acronym' => 'Cj',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-12 00:27:24',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Cubeta 10 Litros',
            'acronym' => 'Cubeta(10 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Cubeta 10 Kilos',
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
                'name' => 'Garrafon 20 Litros',
            'acronym' => 'Garrafón (20 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Garrafon 9.5 Litros',
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
                'name' => 'Pulgada',
                'acronym' => 'Inch',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'juego',
                'acronym' => 'Jg',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-12 00:29:38',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Kilogramo',
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
                'name' => 'Litros',
                'acronym' => 'Lts',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Metro',
                'acronym' => 'Mtr',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Metro Cuadrado',
                'acronym' => 'M2',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Metro lineal',
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
                'name' => 'Servicio',
                'acronym' => 'Srv',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Tambo 206 Litros',
                'acronym' => 'Tambo 206 Lts',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Tanque 10 Litros',
            'acronym' => 'Tanque (10 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Tanque  20 Litros',
            'acronym' => 'Tanque (20 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Tanque 45 Litros',
            'acronym' => 'Tanque (45 Lts)',
                'created_at' => '2025-01-08 19:10:13',
                'updated_at' => '2025-01-08 19:10:13',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Tanque 50 Litros',
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
                'name' => 'juegos',
                'acronym' => 'Jgo',
                'created_at' => '2025-01-12 00:29:53',
                'updated_at' => '2025-01-12 00:29:53',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'par',
                'acronym' => 'Par',
                'created_at' => '2025-01-12 00:30:37',
                'updated_at' => '2025-01-12 00:30:37',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'litro',
                'acronym' => 'Lt',
                'created_at' => '2025-01-12 00:31:16',
                'updated_at' => '2025-01-12 00:31:16',
            ),
        ));
        
        
    }
}