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
                'name' => 'Placa',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 1,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Barras',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 1,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Cabeza obturadora',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Cilindro obturador',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Housing',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Unidad de poder',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Cortador',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Broca',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Sostenedor',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Adaptador',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Tapinadora',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Unidad de poder',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Sierra',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Inserto',
                'code' => '012',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Brida',
                'code' => '013',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Spool',
                'code' => '014',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Cancamo',
                'code' => '015',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Piedra',
                'code' => '016',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Contactor',
                'code' => '017',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Machuelo',
                'code' => '018',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Plato',
                'code' => '019',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Dado',
                'code' => '020',
                'type' => 'DN-NP',
                'category_id' => 2,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Diesel',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 3,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Gasolina',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 3,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Elemento de sello',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Abrazadera',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Anillo',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Junta',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Envolvente',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Globos',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Rodamientos',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Sellos',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Empaques',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Trapo',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Marcadores',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Pegamentos',
                'code' => '012',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Silicon',
                'code' => '013',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Puntas',
                'code' => '014',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Espatula',
                'code' => '015',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Cinta Teflon',
                'code' => '016',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Loctite',
                'code' => '017',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Seguros',
                'code' => '018',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Ingerto',
                'code' => '019',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Bisagra',
                'code' => '020',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Cadena',
                'code' => '021',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Cordón',
                'code' => '022',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Alambre',
                'code' => '023',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Birlo',
                'code' => '024',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'Rafia',
                'code' => '025',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'Resistol',
                'code' => '026',
                'type' => 'DN-NP',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'Flexometro',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 5,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Vernier',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 5,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Manómetro',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 5,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'Escuadras',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 5,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'Goniometro',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 5,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'Micrómetro',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 5,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'Indicador Nivel',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 5,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'Hot Tap Fitting',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 6,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'Line Stop Fitting',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 6,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => '3-Way Tee',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 6,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'Angled Fitting',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 6,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'Double Hub Fitting',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 6,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'Spherical Fitting',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 6,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'Resfuerzo Mecanico',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 6,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'Gas LP',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 7,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'Acetileno',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 7,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'Oxigeno',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 7,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'Nitrogeno',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 7,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'Detector de metales',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'Detector de gas',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'Pulidor',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'Taladro',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'Llaves de torqueo',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'Cabezales para torqueo',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'Lámpara',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'Polipasto',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'Banco de trabajo',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'Mesa divisora',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'Gabinete',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'Cilindro obturador',
                'code' => '012',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'Mesa de trabajo',
                'code' => '013',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'Pluma Hidraulica',
                'code' => '014',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'Esmeril',
                'code' => '015',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'Lijadora',
                'code' => '016',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'Bomba',
                'code' => '017',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'Nivel',
                'code' => '018',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'Machuelo',
                'code' => '019',
                'type' => 'DN-NP',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'Divisora',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'Mesa',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'Librero',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'Cajonera',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'Escritorio',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'Estante',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'Gabinete',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'Pizarrón',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'Silla',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'Minisplit',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'Ventilador',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'Aerosol',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 10,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'Prime',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 10,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'Acrilica',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 10,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'Tuberia',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'Tapón',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'Codo',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'Niple',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'Nipolet',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'Cople',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'Reducción',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'Sockolet',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'Threadolet',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'Tee',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'Weldolet',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'Conector',
                'code' => '012',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'Sockolet',
                'code' => '013',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'Adaptador',
                'code' => '014',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'Manguera',
                'code' => '015',
                'type' => 'DN-NP',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'Tinher',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'Removedor',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'Grasas',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'Aceites Solubles',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'Alcohol',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'Agua Desionizada',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'Particulas Magneticas',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'Xylan',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 13,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'Cadminizado',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 13,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'Pavonado',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 13,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'Anodizados',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 13,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'Cromado',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 13,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'Niquelado',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 13,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'PND',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            130 => 
            array (
                'id' => 131,
                'name' => 'PH',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            131 => 
            array (
                'id' => 132,
                'name' => 'Transferencia de Calor',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            132 => 
            array (
                'id' => 133,
                'name' => 'Dictamen',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            133 => 
            array (
                'id' => 134,
                'name' => 'Pruebas FAT',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            134 => 
            array (
                'id' => 135,
                'name' => 'Pruebas SAT',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            135 => 
            array (
                'id' => 136,
                'name' => 'Calibración',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            136 => 
            array (
                'id' => 137,
                'name' => 'Matto maquinaría',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            137 => 
            array (
                'id' => 138,
                'name' => 'Fabricación',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            138 => 
            array (
                'id' => 139,
                'name' => 'Fundición',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            139 => 
            array (
                'id' => 140,
                'name' => 'Corte',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            140 => 
            array (
                'id' => 141,
                'name' => 'Recolección / Traslados',
                'code' => '012',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            141 => 
            array (
                'id' => 142,
                'name' => 'Recarga extintores',
                'code' => '013',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            142 => 
            array (
                'id' => 143,
                'name' => 'Pruebas extintores',
                'code' => '014',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            143 => 
            array (
                'id' => 144,
                'name' => 'Grúa',
                'code' => '015',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            144 => 
            array (
                'id' => 145,
                'name' => 'Titán',
                'code' => '016',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            145 => 
            array (
                'id' => 146,
                'name' => 'Obra civil',
                'code' => '017',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            146 => 
            array (
                'id' => 147,
                'name' => 'Maquinado',
                'code' => '018',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            147 => 
            array (
                'id' => 148,
                'name' => 'Erosinado',
                'code' => '019',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            148 => 
            array (
                'id' => 149,
                'name' => 'Relevado de esfuerzos',
                'code' => '020',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            149 => 
            array (
                'id' => 150,
                'name' => 'Matto máquina de soldar',
                'code' => '021',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            150 => 
            array (
                'id' => 151,
                'name' => 'Matto compresor',
                'code' => '022',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            151 => 
            array (
                'id' => 152,
                'name' => 'Matto Torno',
                'code' => '023',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            152 => 
            array (
                'id' => 153,
                'name' => 'Matto Fresadora',
                'code' => '024',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            153 => 
            array (
                'id' => 154,
                'name' => 'Matto Mandriladora',
                'code' => '025',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            154 => 
            array (
                'id' => 155,
                'name' => 'Biselado',
                'code' => '026',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            155 => 
            array (
                'id' => 156,
                'name' => 'Matto instalaciones',
                'code' => '027',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            156 => 
            array (
                'id' => 157,
                'name' => 'Analisis',
                'code' => '028',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            157 => 
            array (
                'id' => 158,
                'name' => 'Matto Herramientas',
                'code' => '029',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            158 => 
            array (
                'id' => 159,
                'name' => 'Alineación y Balanceo',
                'code' => '030',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            159 => 
            array (
                'id' => 160,
                'name' => 'Aplicación Soldadura',
                'code' => '031',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            160 => 
            array (
                'id' => 161,
                'name' => 'Calificación Soldadores',
                'code' => '032',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            161 => 
            array (
                'id' => 162,
                'name' => 'Cementado',
                'code' => '033',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            162 => 
            array (
                'id' => 163,
                'name' => 'Colocación',
                'code' => '034',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            163 => 
            array (
                'id' => 164,
                'name' => 'Decapado',
                'code' => '035',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            164 => 
            array (
                'id' => 165,
                'name' => 'Diagnostico',
                'code' => '036',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            165 => 
            array (
                'id' => 166,
                'name' => 'Matto Valvulas',
                'code' => '037',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            166 => 
            array (
                'id' => 167,
                'name' => 'Memoria de Calculo',
                'code' => '038',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            167 => 
            array (
                'id' => 168,
                'name' => 'Pasivado',
                'code' => '039',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            168 => 
            array (
                'id' => 169,
                'name' => 'Prueba Laboratorio',
                'code' => '040',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            169 => 
            array (
                'id' => 170,
                'name' => 'Pulido',
                'code' => '041',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            170 => 
            array (
                'id' => 171,
                'name' => 'Punzonado',
                'code' => '042',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            171 => 
            array (
                'id' => 172,
                'name' => 'Radiografia',
                'code' => '043',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            172 => 
            array (
                'id' => 173,
                'name' => 'Rectificado',
                'code' => '044',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            173 => 
            array (
                'id' => 174,
                'name' => 'Rolado',
                'code' => '045',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            174 => 
            array (
                'id' => 175,
                'name' => 'Sandblasteo',
                'code' => '046',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            175 => 
            array (
                'id' => 176,
                'name' => 'Topografia',
                'code' => '047',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            176 => 
            array (
                'id' => 177,
                'name' => 'Ultrasonido',
                'code' => '048',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            177 => 
            array (
                'id' => 178,
                'name' => 'Verificación',
                'code' => '049',
                'type' => 'DN-NP',
                'category_id' => 14,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            178 => 
            array (
                'id' => 179,
                'name' => 'Discos',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 15,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            179 => 
            array (
                'id' => 180,
                'name' => 'Cardas',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 15,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            180 => 
            array (
                'id' => 181,
                'name' => 'Electrodos',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 15,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            181 => 
            array (
                'id' => 182,
                'name' => 'Cepillo',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 15,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            182 => 
            array (
                'id' => 183,
                'name' => 'Segueta',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 15,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            183 => 
            array (
                'id' => 184,
                'name' => 'Hexagonal',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            184 => 
            array (
                'id' => 185,
                'name' => 'Allen',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            185 => 
            array (
                'id' => 186,
                'name' => 'Gota',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            186 => 
            array (
                'id' => 187,
                'name' => 'Cilindrico',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            187 => 
            array (
                'id' => 188,
                'name' => 'Cabeza Plana',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            188 => 
            array (
                'id' => 189,
                'name' => 'Punta Perro',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            189 => 
            array (
                'id' => 190,
                'name' => 'Redondo',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            190 => 
            array (
                'id' => 191,
                'name' => 'Esparrago',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            191 => 
            array (
                'id' => 192,
                'name' => 'Rondana',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            192 => 
            array (
                'id' => 193,
                'name' => 'Tuerca',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            193 => 
            array (
                'id' => 194,
                'name' => 'Opresor',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            194 => 
            array (
                'id' => 195,
                'name' => 'Arandela',
                'code' => '012',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            195 => 
            array (
                'id' => 196,
                'name' => 'Tapon',
                'code' => '013',
                'type' => 'DN-NP',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            196 => 
            array (
                'id' => 197,
                'name' => 'Bola',
                'code' => '001',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            197 => 
            array (
                'id' => 198,
                'name' => 'Trunnion',
                'code' => '002',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            198 => 
            array (
                'id' => 199,
                'name' => 'Compuerta',
                'code' => '003',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            199 => 
            array (
                'id' => 200,
                'name' => 'Sándwich',
                'code' => '004',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            200 => 
            array (
                'id' => 201,
                'name' => 'Mariposa',
                'code' => '005',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            201 => 
            array (
                'id' => 202,
                'name' => 'Check',
                'code' => '006',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            202 => 
            array (
                'id' => 203,
                'name' => 'Bloqueo y purga',
                'code' => '007',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            203 => 
            array (
                'id' => 204,
                'name' => 'Aguja',
                'code' => '008',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            204 => 
            array (
                'id' => 205,
                'name' => 'Globo',
                'code' => '009',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            205 => 
            array (
                'id' => 206,
                'name' => 'Retención',
                'code' => '010',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            206 => 
            array (
                'id' => 207,
                'name' => 'Macho',
                'code' => '011',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            207 => 
            array (
                'id' => 208,
                'name' => 'Hidráulica',
                'code' => '012',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            208 => 
            array (
                'id' => 209,
                'name' => 'Alivio',
                'code' => '013',
                'type' => 'DN-NP',
                'category_id' => 17,
                'created_at' => '2025-01-12 02:58:09',
                'updated_at' => '2025-01-12 02:58:09',
            ),
            209 => 
            array (
                'id' => 210,
                'name' => 'Placa',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 1,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            210 => 
            array (
                'id' => 211,
                'name' => 'Barras',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 1,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            211 => 
            array (
                'id' => 212,
                'name' => 'Diesel',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 3,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            212 => 
            array (
                'id' => 213,
                'name' => 'Gasolina',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 3,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            213 => 
            array (
                'id' => 214,
                'name' => 'Elemento de sello',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            214 => 
            array (
                'id' => 215,
                'name' => 'Abrazadera',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            215 => 
            array (
                'id' => 216,
                'name' => 'Anillo',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            216 => 
            array (
                'id' => 217,
                'name' => 'Junta',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            217 => 
            array (
                'id' => 218,
                'name' => 'Envolvente',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            218 => 
            array (
                'id' => 219,
                'name' => 'Globos',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            219 => 
            array (
                'id' => 220,
                'name' => 'Rodamientos',
                'code' => '007',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            220 => 
            array (
                'id' => 221,
                'name' => 'Sellos',
                'code' => '008',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            221 => 
            array (
                'id' => 222,
                'name' => 'Empaques',
                'code' => '009',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            222 => 
            array (
                'id' => 223,
                'name' => 'Trapo',
                'code' => '010',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            223 => 
            array (
                'id' => 224,
                'name' => 'Marcadores',
                'code' => '011',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            224 => 
            array (
                'id' => 225,
                'name' => 'Pegamentos',
                'code' => '012',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            225 => 
            array (
                'id' => 226,
                'name' => 'Silicon',
                'code' => '013',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            226 => 
            array (
                'id' => 227,
                'name' => 'Graficas',
                'code' => '014',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            227 => 
            array (
                'id' => 228,
                'name' => 'Cinta',
                'code' => '015',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            228 => 
            array (
                'id' => 229,
                'name' => 'Candado',
                'code' => '016',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            229 => 
            array (
                'id' => 230,
                'name' => 'Baterias',
                'code' => '017',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            230 => 
            array (
                'id' => 231,
                'name' => 'Letras Golpe',
                'code' => '018',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            231 => 
            array (
                'id' => 232,
                'name' => 'Buril',
                'code' => '019',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            232 => 
            array (
                'id' => 233,
                'name' => 'Grapas',
                'code' => '020',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            233 => 
            array (
                'id' => 234,
                'name' => 'Ganchos',
                'code' => '021',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            234 => 
            array (
                'id' => 235,
                'name' => 'Linterna',
                'code' => '022',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            235 => 
            array (
                'id' => 236,
                'name' => 'Sanitizador',
                'code' => '023',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            236 => 
            array (
                'id' => 237,
                'name' => 'Manteca',
                'code' => '024',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            237 => 
            array (
                'id' => 238,
                'name' => 'Puntas',
                'code' => '025',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            238 => 
            array (
                'id' => 239,
                'name' => 'Pinceles',
                'code' => '026',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            239 => 
            array (
                'id' => 240,
                'name' => 'Navajas',
                'code' => '027',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            240 => 
            array (
                'id' => 241,
                'name' => 'Sinchos',
                'code' => '028',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            241 => 
            array (
                'id' => 242,
                'name' => 'Resorte',
                'code' => '029',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            242 => 
            array (
                'id' => 243,
                'name' => 'lampara',
                'code' => '030',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            243 => 
            array (
                'id' => 244,
                'name' => 'Llanta',
                'code' => '031',
                'type' => 'Stock',
                'category_id' => 4,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            244 => 
            array (
                'id' => 245,
                'name' => 'Flexometro',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 5,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            245 => 
            array (
                'id' => 246,
                'name' => 'Vernier',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 5,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            246 => 
            array (
                'id' => 247,
                'name' => 'Manómetro',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 5,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            247 => 
            array (
                'id' => 248,
                'name' => 'Escuadras',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 5,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            248 => 
            array (
                'id' => 249,
                'name' => 'Goniometro',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 5,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            249 => 
            array (
                'id' => 250,
                'name' => 'Micrómetro',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 5,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            250 => 
            array (
                'id' => 251,
                'name' => 'Gas LP',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 7,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            251 => 
            array (
                'id' => 252,
                'name' => 'Acetileno',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 7,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            252 => 
            array (
                'id' => 253,
                'name' => 'Oxigeno',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 7,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            253 => 
            array (
                'id' => 254,
                'name' => 'Nitrogeno',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 7,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            254 => 
            array (
                'id' => 255,
                'name' => 'Detector de metales',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            255 => 
            array (
                'id' => 256,
                'name' => 'Detector de gas',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            256 => 
            array (
                'id' => 257,
                'name' => 'Pulidor',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            257 => 
            array (
                'id' => 258,
                'name' => 'Taladro',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            258 => 
            array (
                'id' => 259,
                'name' => 'Llaves',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            259 => 
            array (
                'id' => 260,
                'name' => 'Cabezales para torqueo',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            260 => 
            array (
                'id' => 261,
                'name' => 'Lámpara',
                'code' => '007',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            261 => 
            array (
                'id' => 262,
                'name' => 'Polipasto',
                'code' => '008',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            262 => 
            array (
                'id' => 263,
                'name' => 'Banco de trabajo',
                'code' => '009',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            263 => 
            array (
                'id' => 264,
                'name' => 'Mesa divisora',
                'code' => '010',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            264 => 
            array (
                'id' => 265,
                'name' => 'Gabinete',
                'code' => '011',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            265 => 
            array (
                'id' => 266,
                'name' => 'Cilindro obturador',
                'code' => '012',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            266 => 
            array (
                'id' => 267,
                'name' => 'Mesa de trabajo',
                'code' => '013',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            267 => 
            array (
                'id' => 268,
                'name' => 'Extención',
                'code' => '014',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            268 => 
            array (
                'id' => 269,
                'name' => 'Andamio',
                'code' => '015',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            269 => 
            array (
                'id' => 270,
                'name' => 'Grifo',
                'code' => '016',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            270 => 
            array (
                'id' => 271,
                'name' => 'Aceitera',
                'code' => '017',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            271 => 
            array (
                'id' => 272,
                'name' => 'Temporizador',
                'code' => '018',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            272 => 
            array (
                'id' => 273,
                'name' => 'Regulador',
                'code' => '019',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            273 => 
            array (
                'id' => 274,
                'name' => 'Soplete',
                'code' => '020',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            274 => 
            array (
                'id' => 275,
                'name' => 'Motor',
                'code' => '021',
                'type' => 'Stock',
                'category_id' => 8,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            275 => 
            array (
                'id' => 276,
                'name' => 'Aerosol',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 10,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            276 => 
            array (
                'id' => 277,
                'name' => 'Prime',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 10,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            277 => 
            array (
                'id' => 278,
                'name' => 'Acrilica',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 10,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            278 => 
            array (
                'id' => 279,
                'name' => 'Tuberia',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            279 => 
            array (
                'id' => 280,
                'name' => 'Tapón',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            280 => 
            array (
                'id' => 281,
                'name' => 'Codo',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            281 => 
            array (
                'id' => 282,
                'name' => 'Niple',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            282 => 
            array (
                'id' => 283,
                'name' => 'Nipolet',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            283 => 
            array (
                'id' => 284,
                'name' => 'Cople',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            284 => 
            array (
                'id' => 285,
                'name' => 'Reducción',
                'code' => '007',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            285 => 
            array (
                'id' => 286,
                'name' => 'Sockolet',
                'code' => '008',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            286 => 
            array (
                'id' => 287,
                'name' => 'Threadolet',
                'code' => '009',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            287 => 
            array (
                'id' => 288,
                'name' => 'Tee',
                'code' => '010',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            288 => 
            array (
                'id' => 289,
                'name' => 'Weldolet',
                'code' => '011',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            289 => 
            array (
                'id' => 290,
                'name' => 'Nipolet',
                'code' => '012',
                'type' => 'Stock',
                'category_id' => 11,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            290 => 
            array (
                'id' => 291,
                'name' => 'Tinher',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            291 => 
            array (
                'id' => 292,
                'name' => 'Removedor',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            292 => 
            array (
                'id' => 293,
                'name' => 'Grasas',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            293 => 
            array (
                'id' => 294,
                'name' => 'Aceites Solubles',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            294 => 
            array (
                'id' => 295,
                'name' => 'Aflojatodo',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            295 => 
            array (
                'id' => 296,
                'name' => 'D-70',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            296 => 
            array (
                'id' => 297,
                'name' => 'Pintura P/Motor',
                'code' => '007',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            297 => 
            array (
                'id' => 298,
                'name' => 'Bentonita',
                'code' => '008',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            298 => 
            array (
                'id' => 299,
                'name' => 'Anticongelante',
                'code' => '009',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            299 => 
            array (
                'id' => 300,
                'name' => 'Lubricante',
                'code' => '010',
                'type' => 'Stock',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            300 => 
            array (
                'id' => 301,
                'name' => 'Discos',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 15,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            301 => 
            array (
                'id' => 302,
                'name' => 'Cardas',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 15,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            302 => 
            array (
                'id' => 303,
                'name' => 'Electrodos',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 15,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            303 => 
            array (
                'id' => 304,
                'name' => 'Cepillo',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 15,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            304 => 
            array (
                'id' => 305,
                'name' => 'Rueda Flap',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 15,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            305 => 
            array (
                'id' => 306,
                'name' => 'Mica',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 15,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            306 => 
            array (
                'id' => 307,
                'name' => 'Careta',
                'code' => '007',
                'type' => 'Stock',
                'category_id' => 15,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            307 => 
            array (
                'id' => 308,
                'name' => 'Kit Inspección',
                'code' => '008',
                'type' => 'Stock',
                'category_id' => 15,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            308 => 
            array (
                'id' => 309,
                'name' => 'Hexagonal',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            309 => 
            array (
                'id' => 310,
                'name' => 'Allen',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            310 => 
            array (
                'id' => 311,
                'name' => 'Gota',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            311 => 
            array (
                'id' => 312,
                'name' => 'Cilindrico',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            312 => 
            array (
                'id' => 313,
                'name' => 'Cabeza Plana',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            313 => 
            array (
                'id' => 314,
                'name' => 'Punta Perro',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            314 => 
            array (
                'id' => 315,
                'name' => 'Redondo',
                'code' => '007',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            315 => 
            array (
                'id' => 316,
                'name' => 'Esparrago',
                'code' => '008',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            316 => 
            array (
                'id' => 317,
                'name' => 'Opresor',
                'code' => '009',
                'type' => 'Stock',
                'category_id' => 16,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            317 => 
            array (
                'id' => 318,
                'name' => 'Casco',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 26,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            318 => 
            array (
                'id' => 319,
                'name' => 'Guantes',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 26,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            319 => 
            array (
                'id' => 320,
                'name' => 'Botas',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 26,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            320 => 
            array (
                'id' => 321,
                'name' => 'Camisa',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 26,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            321 => 
            array (
                'id' => 322,
                'name' => 'Pantalón',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 26,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            322 => 
            array (
                'id' => 323,
                'name' => 'Correa',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 26,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            323 => 
            array (
                'id' => 324,
                'name' => 'Carraca',
                'code' => '007',
                'type' => 'Stock',
                'category_id' => 26,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            324 => 
            array (
                'id' => 325,
                'name' => 'Lentes',
                'code' => '008',
                'type' => 'Stock',
                'category_id' => 26,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            325 => 
            array (
                'id' => 326,
                'name' => 'Mascarrila',
                'code' => '009',
                'type' => 'Stock',
                'category_id' => 26,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            326 => 
            array (
                'id' => 327,
                'name' => 'Filtros',
                'code' => '010',
                'type' => 'Stock',
                'category_id' => 26,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            327 => 
            array (
                'id' => 328,
                'name' => 'Overol',
                'code' => '011',
                'type' => 'Stock',
                'category_id' => 26,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            328 => 
            array (
                'id' => 329,
                'name' => 'Tapon Auditivo',
                'code' => '012',
                'type' => 'Stock',
                'category_id' => 26,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            329 => 
            array (
                'id' => 330,
                'name' => 'Cuadrado',
                'code' => '001',
                'type' => 'Stock',
                'category_id' => 27,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            330 => 
            array (
                'id' => 331,
                'name' => 'Angulo',
                'code' => '002',
                'type' => 'Stock',
                'category_id' => 27,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            331 => 
            array (
                'id' => 332,
                'name' => 'Lamina',
                'code' => '003',
                'type' => 'Stock',
                'category_id' => 27,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            332 => 
            array (
                'id' => 333,
                'name' => 'Marco',
                'code' => '004',
                'type' => 'Stock',
                'category_id' => 27,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            333 => 
            array (
                'id' => 334,
                'name' => 'Solera',
                'code' => '005',
                'type' => 'Stock',
                'category_id' => 27,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            334 => 
            array (
                'id' => 335,
                'name' => 'Viga',
                'code' => '006',
                'type' => 'Stock',
                'category_id' => 27,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            335 => 
            array (
                'id' => 336,
                'name' => 'Tubo',
                'code' => '007',
                'type' => 'Stock',
                'category_id' => 27,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            336 => 
            array (
                'id' => 337,
                'name' => 'PTR',
                'code' => '008',
                'type' => 'Stock',
                'category_id' => 27,
                'created_at' => '2025-01-12 02:58:49',
                'updated_at' => '2025-01-12 02:58:49',
            ),
            337 => 
            array (
                'id' => 338,
                'name' => 'Diesel',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 3,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            338 => 
            array (
                'id' => 339,
                'name' => 'Gasolina',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 3,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            339 => 
            array (
                'id' => 340,
                'name' => 'Divisora',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            340 => 
            array (
                'id' => 341,
                'name' => 'Mesa',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            341 => 
            array (
                'id' => 342,
                'name' => 'Librero',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            342 => 
            array (
                'id' => 343,
                'name' => 'Cajonera',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            343 => 
            array (
                'id' => 344,
                'name' => 'Escritorio',
                'code' => '005',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            344 => 
            array (
                'id' => 345,
                'name' => 'Estante',
                'code' => '006',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            345 => 
            array (
                'id' => 346,
                'name' => 'Gabinete',
                'code' => '007',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            346 => 
            array (
                'id' => 347,
                'name' => 'Pizarrón',
                'code' => '008',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            347 => 
            array (
                'id' => 348,
                'name' => 'Silla',
                'code' => '009',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            348 => 
            array (
                'id' => 349,
                'name' => 'Minisplit',
                'code' => '010',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            349 => 
            array (
                'id' => 350,
                'name' => 'Ventilador',
                'code' => '011',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            350 => 
            array (
                'id' => 351,
                'name' => 'Locker Metalico',
                'code' => '012',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            351 => 
            array (
                'id' => 352,
                'name' => 'Aerosol',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 10,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            352 => 
            array (
                'id' => 353,
                'name' => 'Prime',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 10,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            353 => 
            array (
                'id' => 354,
                'name' => 'Acrilica',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 10,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            354 => 
            array (
                'id' => 355,
                'name' => 'Tinher',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            355 => 
            array (
                'id' => 356,
                'name' => 'Removedor',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            356 => 
            array (
                'id' => 357,
                'name' => 'Grasas',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            357 => 
            array (
                'id' => 358,
                'name' => 'Aceites Solubles',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 12,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            358 => 
            array (
                'id' => 359,
                'name' => 'Pago de Renta',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 18,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            359 => 
            array (
                'id' => 360,
                'name' => 'Airbnb',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 18,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            360 => 
            array (
                'id' => 361,
                'name' => 'CFE',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 19,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            361 => 
            array (
                'id' => 362,
                'name' => 'Agua',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 19,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            362 => 
            array (
                'id' => 363,
                'name' => 'Telefonia',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 19,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            363 => 
            array (
                'id' => 364,
                'name' => 'Impresoras',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 19,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            364 => 
            array (
                'id' => 365,
                'name' => 'Lap Top',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 20,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            365 => 
            array (
                'id' => 366,
                'name' => 'Impresora',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 20,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            366 => 
            array (
                'id' => 367,
                'name' => 'Monitor',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 20,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            367 => 
            array (
                'id' => 368,
                'name' => 'Camara',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 20,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            368 => 
            array (
                'id' => 369,
                'name' => 'Cargador',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            369 => 
            array (
                'id' => 370,
                'name' => 'Cable',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            370 => 
            array (
                'id' => 371,
                'name' => 'HD',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            371 => 
            array (
                'id' => 372,
                'name' => 'SSD',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            372 => 
            array (
                'id' => 373,
                'name' => 'Teclado',
                'code' => '005',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            373 => 
            array (
                'id' => 374,
                'name' => 'Mouse',
                'code' => '006',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            374 => 
            array (
                'id' => 375,
                'name' => 'Servidor',
                'code' => '007',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            375 => 
            array (
                'id' => 376,
                'name' => 'Tarjetas',
                'code' => '008',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            376 => 
            array (
                'id' => 377,
                'name' => 'Ribbon',
                'code' => '009',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            377 => 
            array (
                'id' => 378,
                'name' => 'Camara',
                'code' => '010',
                'type' => 'Servicios generales',
                'category_id' => 21,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            378 => 
            array (
                'id' => 379,
                'name' => 'Chapas',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            379 => 
            array (
                'id' => 380,
                'name' => 'Herrajes',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            380 => 
            array (
                'id' => 381,
                'name' => 'Tuberia Cobre',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            381 => 
            array (
                'id' => 382,
                'name' => 'Tuberia PVC',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            382 => 
            array (
                'id' => 383,
                'name' => 'Tuberia Galvanizada',
                'code' => '005',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            383 => 
            array (
                'id' => 384,
                'name' => 'Accesorios Cobre',
                'code' => '006',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            384 => 
            array (
                'id' => 385,
                'name' => 'Accesirios PVC',
                'code' => '007',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            385 => 
            array (
                'id' => 386,
                'name' => 'Accesorios Galvanizados',
                'code' => '008',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            386 => 
            array (
                'id' => 387,
                'name' => 'Laminas',
                'code' => '009',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            387 => 
            array (
                'id' => 388,
                'name' => 'Lamparas',
                'code' => '010',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            388 => 
            array (
                'id' => 389,
                'name' => 'Cable',
                'code' => '011',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            389 => 
            array (
                'id' => 390,
                'name' => 'Alambres',
                'code' => '012',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            390 => 
            array (
                'id' => 391,
                'name' => 'Tornillos',
                'code' => '013',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            391 => 
            array (
                'id' => 392,
                'name' => 'Clavos',
                'code' => '014',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            392 => 
            array (
                'id' => 393,
                'name' => 'Accesorios de Baño',
                'code' => '015',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            393 => 
            array (
                'id' => 394,
                'name' => 'Banda',
                'code' => '016',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            394 => 
            array (
                'id' => 395,
                'name' => 'Catarina',
                'code' => '017',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            395 => 
            array (
                'id' => 396,
                'name' => 'Lima',
                'code' => '018',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            396 => 
            array (
                'id' => 397,
                'name' => 'Bandas',
                'code' => '019',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            397 => 
            array (
                'id' => 398,
                'name' => 'Interruptor',
                'code' => '020',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            398 => 
            array (
                'id' => 399,
                'name' => 'Chumacera',
                'code' => '021',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            399 => 
            array (
                'id' => 400,
                'name' => 'Buje',
                'code' => '022',
                'type' => 'Servicios generales',
                'category_id' => 22,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            400 => 
            array (
                'id' => 401,
                'name' => 'Mantenimiento Vehicular',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            401 => 
            array (
                'id' => 402,
                'name' => 'Mantenimiento Montacargas',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            402 => 
            array (
                'id' => 403,
                'name' => 'Mantenimiento Grua',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            403 => 
            array (
                'id' => 404,
                'name' => 'Refacciones Automotices',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            404 => 
            array (
                'id' => 405,
                'name' => 'Reparacion y Pintura',
                'code' => '005',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            405 => 
            array (
                'id' => 406,
                'name' => 'Reparacion Mecanica',
                'code' => '006',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            406 => 
            array (
                'id' => 407,
                'name' => 'Llantas',
                'code' => '007',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            407 => 
            array (
                'id' => 408,
                'name' => 'Lubricante',
                'code' => '008',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            408 => 
            array (
                'id' => 409,
                'name' => 'Liquidos',
                'code' => '009',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            409 => 
            array (
                'id' => 410,
                'name' => 'Baterias',
                'code' => '010',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            410 => 
            array (
                'id' => 411,
                'name' => 'Accesorios',
                'code' => '011',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            411 => 
            array (
                'id' => 412,
                'name' => 'Filtro',
                'code' => '012',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            412 => 
            array (
                'id' => 413,
                'name' => 'Soporte',
                'code' => '013',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            413 => 
            array (
                'id' => 414,
                'name' => 'Capuchon',
                'code' => '014',
                'type' => 'Servicios generales',
                'category_id' => 23,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            414 => 
            array (
                'id' => 415,
                'name' => 'Café',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 24,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            415 => 
            array (
                'id' => 416,
                'name' => 'Azucar',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 24,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            416 => 
            array (
                'id' => 417,
                'name' => 'Leche en Polvo',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 24,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            417 => 
            array (
                'id' => 418,
                'name' => 'Refrescos',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 24,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            418 => 
            array (
                'id' => 419,
                'name' => 'Aguas',
                'code' => '005',
                'type' => 'Servicios generales',
                'category_id' => 24,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            419 => 
            array (
                'id' => 420,
                'name' => 'Galletas',
                'code' => '006',
                'type' => 'Servicios generales',
                'category_id' => 24,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            420 => 
            array (
                'id' => 421,
                'name' => 'Papel',
                'code' => '001',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            421 => 
            array (
                'id' => 422,
                'name' => 'Jerga',
                'code' => '002',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            422 => 
            array (
                'id' => 423,
                'name' => 'Limpiadores',
                'code' => '003',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            423 => 
            array (
                'id' => 424,
                'name' => 'Escobas',
                'code' => '004',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            424 => 
            array (
                'id' => 425,
                'name' => 'Trapeadores',
                'code' => '005',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            425 => 
            array (
                'id' => 426,
                'name' => 'Tambos',
                'code' => '006',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            426 => 
            array (
                'id' => 427,
                'name' => 'Bolsas',
                'code' => '007',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            427 => 
            array (
                'id' => 428,
                'name' => 'Brocha',
                'code' => '008',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            428 => 
            array (
                'id' => 429,
                'name' => 'Rodillo',
                'code' => '009',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            429 => 
            array (
                'id' => 430,
                'name' => 'Lija',
                'code' => '010',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            430 => 
            array (
                'id' => 431,
                'name' => 'Fibra',
                'code' => '011',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            431 => 
            array (
                'id' => 432,
                'name' => 'Toalla',
                'code' => '012',
                'type' => 'Servicios generales',
                'category_id' => 25,
                'created_at' => '2025-01-12 02:59:03',
                'updated_at' => '2025-01-12 02:59:03',
            ),
            432 => 
            array (
                'id' => 433,
                'name' => 'Rack',
                'code' => '013',
                'type' => 'Servicios generales',
                'category_id' => 9,
                'created_at' => '2025-01-12 03:01:47',
                'updated_at' => '2025-01-12 03:01:47',
            ),
        ));
        
        
    }
}