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
                'name' => 'metros',
                'acronym' => 'm',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'centímetros',
                'acronym' => 'cm',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'milímetros',
                'acronym' => 'mm',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'kilómetros',
                'acronym' => 'km',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'gramos',
                'acronym' => 'g',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'kilogramos',
                'acronym' => 'kg',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'toneladas',
                'acronym' => 't',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'litros',
                'acronym' => 'L',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'mililitros',
                'acronym' => 'mL',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'pulgadas',
                'acronym' => 'in',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'pies',
                'acronym' => 'ft',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'yardas',
                'acronym' => 'yd',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'millas',
                'acronym' => 'mi',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'millas náuticas',
                'acronym' => 'nmi',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'segundos',
                'acronym' => 's',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'minutos',
                'acronym' => 'min',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'horas',
                'acronym' => 'h',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'días',
                'acronym' => 'd',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'semanas',
                'acronym' => 'wk',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'años',
                'acronym' => 'y',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'julios',
                'acronym' => 'J',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'calorías',
                'acronym' => 'cal',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'vatios',
                'acronym' => 'W',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'kilovatios',
                'acronym' => 'kW',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'voltios',
                'acronym' => 'V',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'amperios',
                'acronym' => 'A',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'ohmios',
                'acronym' => 'Ω',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'newtons',
                'acronym' => 'N',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'pascales',
                'acronym' => 'Pa',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'barras',
                'acronym' => 'bar',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'atmósferas',
                'acronym' => 'atm',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'hectáreas',
                'acronym' => 'ha',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'acres',
                'acronym' => 'ac',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'litros por kilómetro',
                'acronym' => 'L/km',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'kilómetros por hora',
                'acronym' => 'km/h',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'metros por segundo',
                'acronym' => 'm/s',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'grados Celsius',
                'acronym' => '°C',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'grados Fahrenheit',
                'acronym' => '°F',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'kelvin',
                'acronym' => 'K',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'radianes',
                'acronym' => 'rad',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'hercios',
                'acronym' => 'Hz',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'lúmenes',
                'acronym' => 'lm',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'lux',
                'acronym' => 'lx',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'becquerel',
                'acronym' => 'Bq',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'grays',
                'acronym' => 'Gy',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'sieverts',
                'acronym' => 'Sv',
                'created_at' => '2024-10-16 15:22:02',
                'updated_at' => '2024-10-16 15:22:02',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'pieza',
                'acronym' => 'pza',
                'created_at' => '2024-10-16 16:16:35',
                'updated_at' => '2024-10-16 16:16:35',
            ),
        ));
        
        
    }
}