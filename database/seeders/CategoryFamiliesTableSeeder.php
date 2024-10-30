<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryFamiliesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('category_families')->delete();
        
        \DB::table('category_families')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Cabeza obturadora',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Cilindro obturador',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Housing',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Unidad de poder',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Cortador',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Broca',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Sostenedor',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Adaptador',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Tapinadora',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Unidad de poder',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Diesel',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 3,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Gasolina',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 3,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Elemento de sello',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Abrazadera',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Anillo',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Junta',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Envolvente',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Globos',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Rodamientos',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Sellos',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Empaques',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Trapo',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Marcadores',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Pegamentos',
                'code' => '012',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Silicon',
                'code' => '013',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Flexometro',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 5,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Vernier',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 5,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Manómetro',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 5,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Escuadras',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 5,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Goniometro',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 5,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Micrómetro',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 5,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Hot Tap Fitting',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 6,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Line Stop Fitting',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 6,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => '3-Way Tee',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 6,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Angled Fitting',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 6,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Double Hub Fitting',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 6,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Spherical Fitting',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 6,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Gas LP',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 7,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Acetileno',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 7,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Oxigeno',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 7,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Nitrogeno',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 7,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Detector de metales',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Detector de gas',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Pulidor',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Taladro',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Llaves de torqueo',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Cabezales para torqueo',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Lámpara',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'Polipasto',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'Banco de trabajo',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'Mesa divisora',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Gabinete',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Cilindro obturador',
                'code' => '012',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'Mesa de trabajo',
                'code' => '013',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'Divisora',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'Mesa',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'Librero',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'Cajonera',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'Escritorio',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'Estante',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'Gabinete',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'Pizarrón',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'Silla',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'Minisplit',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'Ventilador',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'Aerosol',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 10,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'Prime',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 10,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'Acrilica',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 10,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'Tuberia',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'Tapón',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'Codo',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'Niple',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'Nipolet',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'Cople',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'Reducción',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'Sockolet',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'Threadolet',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'Tee de flujo',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'Weldolet',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'Tinher',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 12,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'Removedor',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 12,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'Grasas',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 12,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'Aceites Solubles',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 12,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'Xylan',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 13,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'Cadminizado',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 13,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'Pavonado',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 13,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'Anodizados',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 13,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'Cromado',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 13,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'Niquelado',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 13,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'PND',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'PH',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'Transferencia de Calor',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'Dictamen',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'Pruebas FAT',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'Pruebas SAT',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'Calibración',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'Mantenimiento maquinaría',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'Fabricación',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'Fundición',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'Corte',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'Traslados',
                'code' => '012',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'Recarga extintores',
                'code' => '013',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'Pruebas extintores',
                'code' => '014',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'Grúa',
                'code' => '015',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'Titán',
                'code' => '016',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'Obra civil',
                'code' => '017',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'Maquinado',
                'code' => '018',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'Erosinado',
                'code' => '019',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'Relevado de esfuerzos',
                'code' => '020',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'Matto máquina de soldar',
                'code' => '021',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'Matto compresor',
                'code' => '022',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'Matto Torno',
                'code' => '023',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'Matto Fresadora',
                'code' => '024',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'Matto Mandriladora',
                'code' => '025',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'Biselado',
                'code' => '026',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'Matto instalaciones',
                'code' => '027',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'Discos',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 15,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'Cardas',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 15,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'Electrodos',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 15,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'Hexagonal',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'Allen',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'Gota',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'Cilindrico',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'Cabeza Plana',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'Punta Perro',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'Redondo',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'Esparrago',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'Bola',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'Trunnion',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'Compuerta',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            130 => 
            array (
                'id' => 131,
                'name' => 'Sándwich',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            131 => 
            array (
                'id' => 132,
                'name' => 'Mariposa',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            132 => 
            array (
                'id' => 133,
                'name' => 'Check',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            133 => 
            array (
                'id' => 134,
                'name' => 'Bloqueo y purga',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            134 => 
            array (
                'id' => 135,
                'name' => 'Aguja',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            135 => 
            array (
                'id' => 136,
                'name' => 'Globo',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            136 => 
            array (
                'id' => 137,
                'name' => 'Retención',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            137 => 
            array (
                'id' => 138,
                'name' => 'Macho',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            138 => 
            array (
                'id' => 139,
                'name' => 'Hidráulica',
                'code' => '012',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2024-10-27 21:20:00',
                'updated_at' => '2024-10-27 21:20:00',
            ),
            139 => 
            array (
                'id' => 140,
                'name' => 'Placa',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 1,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            140 => 
            array (
                'id' => 141,
                'name' => 'Barras',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 1,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            141 => 
            array (
                'id' => 142,
                'name' => 'Diesel',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 3,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            142 => 
            array (
                'id' => 143,
                'name' => 'Gasolina',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 3,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            143 => 
            array (
                'id' => 144,
                'name' => 'Elemento de sello',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            144 => 
            array (
                'id' => 145,
                'name' => 'Abrazadera',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            145 => 
            array (
                'id' => 146,
                'name' => 'Anillo',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            146 => 
            array (
                'id' => 147,
                'name' => 'Junta',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            147 => 
            array (
                'id' => 148,
                'name' => 'Envolvente',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            148 => 
            array (
                'id' => 149,
                'name' => 'Globos',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            149 => 
            array (
                'id' => 150,
                'name' => 'Rodamientos',
                'code' => '007',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            150 => 
            array (
                'id' => 151,
                'name' => 'Sellos',
                'code' => '008',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            151 => 
            array (
                'id' => 152,
                'name' => 'Empaques',
                'code' => '009',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            152 => 
            array (
                'id' => 153,
                'name' => 'Trapo',
                'code' => '010',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            153 => 
            array (
                'id' => 154,
                'name' => 'Marcadores',
                'code' => '011',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            154 => 
            array (
                'id' => 155,
                'name' => 'Pegamentos',
                'code' => '012',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            155 => 
            array (
                'id' => 156,
                'name' => 'Silicon',
                'code' => '013',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            156 => 
            array (
                'id' => 157,
                'name' => 'Flexometro',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 5,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            157 => 
            array (
                'id' => 158,
                'name' => 'Vernier',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 5,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            158 => 
            array (
                'id' => 159,
                'name' => 'Manómetro',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 5,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            159 => 
            array (
                'id' => 160,
                'name' => 'Escuadras',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 5,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            160 => 
            array (
                'id' => 161,
                'name' => 'Goniometro',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 5,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            161 => 
            array (
                'id' => 162,
                'name' => 'Micrómetro',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 5,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            162 => 
            array (
                'id' => 163,
                'name' => 'Gas LP',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 7,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            163 => 
            array (
                'id' => 164,
                'name' => 'Acetileno',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 7,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            164 => 
            array (
                'id' => 165,
                'name' => 'Oxigeno',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 7,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            165 => 
            array (
                'id' => 166,
                'name' => 'Nitrogeno',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 7,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            166 => 
            array (
                'id' => 167,
                'name' => 'Detector de metales',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            167 => 
            array (
                'id' => 168,
                'name' => 'Detector de gas',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            168 => 
            array (
                'id' => 169,
                'name' => 'Pulidor',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            169 => 
            array (
                'id' => 170,
                'name' => 'Taladro',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            170 => 
            array (
                'id' => 171,
                'name' => 'Llaves de torqueo',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            171 => 
            array (
                'id' => 172,
                'name' => 'Cabezales para torqueo',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            172 => 
            array (
                'id' => 173,
                'name' => 'Lámpara',
                'code' => '007',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            173 => 
            array (
                'id' => 174,
                'name' => 'Polipasto',
                'code' => '008',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            174 => 
            array (
                'id' => 175,
                'name' => 'Banco de trabajo',
                'code' => '009',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            175 => 
            array (
                'id' => 176,
                'name' => 'Mesa divisora',
                'code' => '010',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            176 => 
            array (
                'id' => 177,
                'name' => 'Gabinete',
                'code' => '011',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            177 => 
            array (
                'id' => 178,
                'name' => 'Cilindro obturador',
                'code' => '012',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            178 => 
            array (
                'id' => 179,
                'name' => 'Mesa de trabajo',
                'code' => '013',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            179 => 
            array (
                'id' => 180,
                'name' => 'Aerosol',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 10,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            180 => 
            array (
                'id' => 181,
                'name' => 'Prime',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 10,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            181 => 
            array (
                'id' => 182,
                'name' => 'Acrilica',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 10,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            182 => 
            array (
                'id' => 183,
                'name' => 'Tuberia',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            183 => 
            array (
                'id' => 184,
                'name' => 'Tapón',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            184 => 
            array (
                'id' => 185,
                'name' => 'Codo',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            185 => 
            array (
                'id' => 186,
                'name' => 'Niple',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            186 => 
            array (
                'id' => 187,
                'name' => 'Nipolet',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            187 => 
            array (
                'id' => 188,
                'name' => 'Cople',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            188 => 
            array (
                'id' => 189,
                'name' => 'Reducción',
                'code' => '007',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            189 => 
            array (
                'id' => 190,
                'name' => 'Sockolet',
                'code' => '008',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            190 => 
            array (
                'id' => 191,
                'name' => 'Threadolet',
                'code' => '009',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            191 => 
            array (
                'id' => 192,
                'name' => 'Tee de flujo',
                'code' => '010',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            192 => 
            array (
                'id' => 193,
                'name' => 'Weldolet',
                'code' => '011',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            193 => 
            array (
                'id' => 194,
                'name' => 'Tinher',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            194 => 
            array (
                'id' => 195,
                'name' => 'Removedor',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            195 => 
            array (
                'id' => 196,
                'name' => 'Grasas',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            196 => 
            array (
                'id' => 197,
                'name' => 'Aceites Solubles',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            197 => 
            array (
                'id' => 198,
                'name' => 'Discos',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 15,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            198 => 
            array (
                'id' => 199,
                'name' => 'Cardas',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 15,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            199 => 
            array (
                'id' => 200,
                'name' => 'Electrodos',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 15,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            200 => 
            array (
                'id' => 201,
                'name' => 'Hexagonal',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            201 => 
            array (
                'id' => 202,
                'name' => 'Allen',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            202 => 
            array (
                'id' => 203,
                'name' => 'Gota',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            203 => 
            array (
                'id' => 204,
                'name' => 'Cilindrico',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            204 => 
            array (
                'id' => 205,
                'name' => 'Cabeza Plana',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            205 => 
            array (
                'id' => 206,
                'name' => 'Punta Perro',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            206 => 
            array (
                'id' => 207,
                'name' => 'Redondo',
                'code' => '007',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            207 => 
            array (
                'id' => 208,
                'name' => 'Esparrago',
                'code' => '008',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2024-10-27 21:20:17',
                'updated_at' => '2024-10-27 21:20:17',
            ),
            208 => 
            array (
                'id' => 209,
                'name' => 'Diesel',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 3,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            209 => 
            array (
                'id' => 210,
                'name' => 'Gasolina',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 3,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            210 => 
            array (
                'id' => 211,
                'name' => 'Divisora',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            211 => 
            array (
                'id' => 212,
                'name' => 'Mesa',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            212 => 
            array (
                'id' => 213,
                'name' => 'Librero',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            213 => 
            array (
                'id' => 214,
                'name' => 'Cajonera',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            214 => 
            array (
                'id' => 215,
                'name' => 'Escritorio',
                'code' => '005',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            215 => 
            array (
                'id' => 216,
                'name' => 'Estante',
                'code' => '006',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            216 => 
            array (
                'id' => 217,
                'name' => 'Gabinete',
                'code' => '007',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            217 => 
            array (
                'id' => 218,
                'name' => 'Pizarrón',
                'code' => '008',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            218 => 
            array (
                'id' => 219,
                'name' => 'Silla',
                'code' => '009',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            219 => 
            array (
                'id' => 220,
                'name' => 'Minisplit',
                'code' => '010',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            220 => 
            array (
                'id' => 221,
                'name' => 'Ventilador',
                'code' => '011',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            221 => 
            array (
                'id' => 222,
                'name' => 'Aerosol',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 10,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            222 => 
            array (
                'id' => 223,
                'name' => 'Prime',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 10,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            223 => 
            array (
                'id' => 224,
                'name' => 'Acrilica',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 10,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            224 => 
            array (
                'id' => 225,
                'name' => 'Tinher',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 12,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            225 => 
            array (
                'id' => 226,
                'name' => 'Removedor',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 12,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            226 => 
            array (
                'id' => 227,
                'name' => 'Grasas',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 12,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            227 => 
            array (
                'id' => 228,
                'name' => 'Aceites Solubles',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 12,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            228 => 
            array (
                'id' => 229,
                'name' => 'Pago de Renta',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 18,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            229 => 
            array (
                'id' => 230,
                'name' => 'Airbnb',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 18,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            230 => 
            array (
                'id' => 231,
                'name' => 'CFE',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 19,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            231 => 
            array (
                'id' => 232,
                'name' => 'Agua',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 19,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            232 => 
            array (
                'id' => 233,
                'name' => 'Telefonia',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 19,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            233 => 
            array (
                'id' => 234,
                'name' => 'Impresoras',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 19,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            234 => 
            array (
                'id' => 235,
                'name' => 'Lap Top',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 20,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            235 => 
            array (
                'id' => 236,
                'name' => 'Impresora',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 20,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            236 => 
            array (
                'id' => 237,
                'name' => 'Monitor',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 20,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            237 => 
            array (
                'id' => 238,
                'name' => 'Camara',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 20,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            238 => 
            array (
                'id' => 239,
                'name' => 'Cargador',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            239 => 
            array (
                'id' => 240,
                'name' => 'Cable',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            240 => 
            array (
                'id' => 241,
                'name' => 'HD',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            241 => 
            array (
                'id' => 242,
                'name' => 'SSD',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            242 => 
            array (
                'id' => 243,
                'name' => 'Teclado',
                'code' => '005',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            243 => 
            array (
                'id' => 244,
                'name' => 'Mouse',
                'code' => '006',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            244 => 
            array (
                'id' => 245,
                'name' => 'Servidor',
                'code' => '007',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-28 16:33:58',
            ),
            245 => 
            array (
                'id' => 246,
                'name' => 'Tarjetas',
                'code' => '008',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            246 => 
            array (
                'id' => 247,
                'name' => 'Chapas',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            247 => 
            array (
                'id' => 248,
                'name' => 'Herrajes',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            248 => 
            array (
                'id' => 249,
                'name' => 'Tuberia Cobre',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            249 => 
            array (
                'id' => 250,
                'name' => 'Tuberia PVC',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            250 => 
            array (
                'id' => 251,
                'name' => 'Tuberia Galvanizada',
                'code' => '005',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            251 => 
            array (
                'id' => 252,
                'name' => 'Accesorios Cobre',
                'code' => '006',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            252 => 
            array (
                'id' => 253,
                'name' => 'Accesirios PVC',
                'code' => '007',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            253 => 
            array (
                'id' => 254,
                'name' => 'Accesorios Galvanizados',
                'code' => '008',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            254 => 
            array (
                'id' => 255,
                'name' => 'Laminas',
                'code' => '009',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            255 => 
            array (
                'id' => 256,
                'name' => 'Lamparas',
                'code' => '010',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            256 => 
            array (
                'id' => 257,
                'name' => 'Cable',
                'code' => '011',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            257 => 
            array (
                'id' => 258,
                'name' => 'Alambres',
                'code' => '012',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            258 => 
            array (
                'id' => 259,
                'name' => 'Tornillos',
                'code' => '013',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            259 => 
            array (
                'id' => 260,
                'name' => 'Clavos',
                'code' => '014',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            260 => 
            array (
                'id' => 261,
                'name' => 'Accesorios de Baño',
                'code' => '015',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            261 => 
            array (
                'id' => 262,
                'name' => 'Mantenimiento Vehicular',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            262 => 
            array (
                'id' => 263,
                'name' => 'Mantenimiento Montacargas',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            263 => 
            array (
                'id' => 264,
                'name' => 'Mantenimiento Grua',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            264 => 
            array (
                'id' => 265,
                'name' => 'Refacciones Automotices',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            265 => 
            array (
                'id' => 266,
                'name' => 'Reparacion y Pintura',
                'code' => '005',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            266 => 
            array (
                'id' => 267,
                'name' => 'Reparacion Mecanica',
                'code' => '006',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            267 => 
            array (
                'id' => 268,
                'name' => 'Llantas',
                'code' => '007',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            268 => 
            array (
                'id' => 269,
                'name' => 'Lubricante',
                'code' => '008',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            269 => 
            array (
                'id' => 270,
                'name' => 'Liquidos',
                'code' => '009',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            270 => 
            array (
                'id' => 271,
                'name' => 'Baterias',
                'code' => '010',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            271 => 
            array (
                'id' => 272,
                'name' => 'Accesorios',
                'code' => '011',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            272 => 
            array (
                'id' => 273,
                'name' => 'Café',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 24,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            273 => 
            array (
                'id' => 274,
                'name' => 'Azucar',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 24,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            274 => 
            array (
                'id' => 275,
                'name' => 'Leche en Polvo',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 24,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            275 => 
            array (
                'id' => 276,
                'name' => 'Refrescos',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 24,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            276 => 
            array (
                'id' => 277,
                'name' => 'Aguas',
                'code' => '005',
                'type' => 'Servicios generales',
                'category_id' => 24,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            277 => 
            array (
                'id' => 278,
                'name' => 'Galletas',
                'code' => '006',
                'type' => 'Servicios generales',
                'category_id' => 24,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            278 => 
            array (
                'id' => 279,
                'name' => 'Papel',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            279 => 
            array (
                'id' => 280,
                'name' => 'Jerga',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            280 => 
            array (
                'id' => 281,
                'name' => 'Limpiadores',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            281 => 
            array (
                'id' => 282,
                'name' => 'Escobas',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            282 => 
            array (
                'id' => 283,
                'name' => 'Trapeadores',
                'code' => '005',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            283 => 
            array (
                'id' => 284,
                'name' => 'Tambos',
                'code' => '006',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
            284 => 
            array (
                'id' => 285,
                'name' => 'Bolsas',
                'code' => '007',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2024-10-27 21:20:30',
                'updated_at' => '2024-10-27 21:20:30',
            ),
        ));
        
        
    }
}