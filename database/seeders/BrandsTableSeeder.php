<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('brands')->delete();
        
        \DB::table('brands')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Sin marca',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'DIXON',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'LIMPRO',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'SIEMENS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'CRAFTSMAN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'TRUPER',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'DEWALT',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'HYDAC',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'MILLER',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'TWILIGHT',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'TTC',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'DENSO',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'WALWORTH',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'COMPLET',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'COMEX',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'FESTER',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'PERKINS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'URREA',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'HONDA',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'TILLMAN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'GOO GONE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'LINCOLN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'SURTEK',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'DeFelsko',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'VERTEX',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'NCH',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'HARRIS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'ULINE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'BOSCH',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'WELDFIT ',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'WELD500',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'MSA',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'ANSELL',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'ALLIED MACHINE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'STANLEY',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'PETERSEN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'ROSHFRANS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'MAGNAFLUX',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'AUSTROMEX',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'GARLOCK',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'SAYER LACK',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'PARKER',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'TECHNIC',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => '3M',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'SAWYER',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'INFRA',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'FANDELI',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'CONCOA',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'ATW',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'MULLER',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'Zebra ZD220',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'FLANGE WIZARD',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'WalkON',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'CONTINENTAL',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'MASTER',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'ENERPAC',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'HOC XTREME',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'PHILLIPS 66',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'CLEVELAND',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'INCOR',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'BAR',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'LOCTITE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'DELL',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'MET-L-CHEK',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'SCOTT',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'IVECO',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'CHEM OIL	',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'MAKITA',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'SOLVO KLEEN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'GOLDEN EAGLE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'TOP TOTAL',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'MILWUAKEE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'FLUXE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'RALOY',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'METATRON',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'CRIOGAS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'REDIMIX',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'VINIMEX',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'GPT',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'SMARTBITT',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'VOLTECK',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'ALPHA ESTEVEZ',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'NISSAN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'MOTORCRAFT',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'AC DELCO',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'THORSMAN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'ECOM',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'DURALAST',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'TENAZIT',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'WAGNER',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'EAGLE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'CONDUMEX',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'SHELL',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'DONALDSON',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'MASTERCUT',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'JACOBS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'WESTERN DIGITAL',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'JOHNSON',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'BARDHAL',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'BenQ',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'SAMSUNG',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'CADENA',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'NICHOLSON',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'MATHEY DEARMAN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'CORTEC',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'DRILLCO',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'VISE GRIP',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'SKF',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'CHEVROLET',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'FORD',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'COSASCO ',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'FAG',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'TIMKEN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'SQUARE D',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'JAGUAR',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'AMEC',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'REDLINE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'SEALWELD',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'HECORT',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'JGA JOGGING ARM',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'STARRET',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'HONEYWELL',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'FRAM',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'ABC',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'SCHNEIDER',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'TECHNOLITE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'TAMEX',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'LOCTITE 567',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'GRESEN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'GEARTEK',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            130 => 
            array (
                'id' => 131,
                'name' => 'MARTIN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            131 => 
            array (
                'id' => 132,
                'name' => 'GATES',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            132 => 
            array (
                'id' => 133,
                'name' => 'TOOLMEX',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            133 => 
            array (
                'id' => 134,
                'name' => 'KENNAMETAL',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            134 => 
            array (
                'id' => 135,
                'name' => 'MITUTOYO',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            135 => 
            array (
                'id' => 136,
                'name' => 'TOLSEN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            136 => 
            array (
                'id' => 137,
                'name' => 'XL CARBIDE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            137 => 
            array (
                'id' => 138,
                'name' => 'CARGOLIFT',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            138 => 
            array (
                'id' => 139,
                'name' => 'RIDGID',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            139 => 
            array (
                'id' => 140,
                'name' => 'REED',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            140 => 
            array (
                'id' => 141,
                'name' => 'HYSTAR',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            141 => 
            array (
                'id' => 142,
                'name' => 'CARBTOOLS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            142 => 
            array (
                'id' => 143,
                'name' => 'REGO',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            143 => 
            array (
                'id' => 144,
                'name' => 'NKS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            144 => 
            array (
                'id' => 145,
                'name' => 'PRESTONE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            145 => 
            array (
                'id' => 146,
                'name' => 'MIKELS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            146 => 
            array (
                'id' => 147,
                'name' => 'GENERAL',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            147 => 
            array (
                'id' => 148,
                'name' => 'FOCKET',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            148 => 
            array (
                'id' => 149,
                'name' => 'XTREME-PC',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            149 => 
            array (
                'id' => 150,
                'name' => 'IGLOO',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            150 => 
            array (
                'id' => 151,
                'name' => 'DUMORE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            151 => 
            array (
                'id' => 152,
                'name' => 'WESTON',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            152 => 
            array (
                'id' => 153,
                'name' => 'PRINCE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            153 => 
            array (
                'id' => 154,
                'name' => 'ASA HYDRAULIK',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            154 => 
            array (
                'id' => 155,
                'name' => 'LINK-BELT',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            155 => 
            array (
                'id' => 156,
                'name' => 'MUNICH',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            156 => 
            array (
                'id' => 157,
                'name' => 'CANON',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            157 => 
            array (
                'id' => 158,
                'name' => 'HP',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            158 => 
            array (
                'id' => 159,
                'name' => 'KLEIN TOOLS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            159 => 
            array (
                'id' => 160,
                'name' => 'CROSBY',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            160 => 
            array (
                'id' => 161,
                'name' => 'RHINO',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            161 => 
            array (
                'id' => 162,
                'name' => 'BISON',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            162 => 
            array (
                'id' => 163,
                'name' => 'ARMANO',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            163 => 
            array (
                'id' => 164,
                'name' => 'COMPU CONTABLE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            164 => 
            array (
                'id' => 165,
                'name' => 'MYTEK',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            165 => 
            array (
                'id' => 166,
                'name' => 'APS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            166 => 
            array (
                'id' => 167,
                'name' => 'SERV MULT CORP',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            167 => 
            array (
                'id' => 168,
                'name' => 'TOTALPLAY',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            168 => 
            array (
                'id' => 169,
                'name' => 'DERMACARE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            169 => 
            array (
                'id' => 170,
                'name' => 'NEMESIS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            170 => 
            array (
                'id' => 171,
                'name' => 'BLACK STALLION',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            171 => 
            array (
                'id' => 172,
                'name' => 'LAPCO',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            172 => 
            array (
                'id' => 173,
                'name' => 'SHAVIV',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            173 => 
            array (
                'id' => 174,
                'name' => 'YAMIRU',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            174 => 
            array (
                'id' => 175,
                'name' => 'FIXITFAST',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            175 => 
            array (
                'id' => 176,
                'name' => 'SILIMEX',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            176 => 
            array (
                'id' => 177,
                'name' => 'AUTODESK',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            177 => 
            array (
                'id' => 178,
                'name' => 'HIKVISION',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            178 => 
            array (
                'id' => 179,
                'name' => 'JYRSA',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            179 => 
            array (
                'id' => 180,
                'name' => 'HYTORC',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            180 => 
            array (
                'id' => 181,
                'name' => 'CLE-LINE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            181 => 
            array (
                'id' => 182,
                'name' => 'LEVITON',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            182 => 
            array (
                'id' => 183,
                'name' => 'CROUSE HINDS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            183 => 
            array (
                'id' => 184,
                'name' => 'QUICKUN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            184 => 
            array (
                'id' => 185,
                'name' => 'DOGOTOOLS',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            185 => 
            array (
                'id' => 186,
                'name' => 'NUBOSOFT',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            186 => 
            array (
                'id' => 187,
                'name' => 'HYUNDAI',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            187 => 
            array (
                'id' => 188,
                'name' => 'GALGO',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            188 => 
            array (
                'id' => 189,
                'name' => 'IRWIN',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            189 => 
            array (
                'id' => 190,
                'name' => 'FLUKE',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            190 => 
            array (
                'id' => 191,
                'name' => 'PRETUL',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            191 => 
            array (
                'id' => 192,
                'name' => 'FLUX',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            192 => 
            array (
                'id' => 193,
                'name' => 'EATON',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            193 => 
            array (
                'id' => 194,
                'name' => 'HUBBELL',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            194 => 
            array (
                'id' => 195,
                'name' => 'RAWELT',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            195 => 
            array (
                'id' => 196,
                'name' => 'H-DISELEV',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            196 => 
            array (
                'id' => 197,
                'name' => 'R&M',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            197 => 
            array (
                'id' => 198,
                'name' => 'DRL SUP CASTRS ',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
            198 => 
            array (
                'id' => 199,
                'name' => 'IDP',
                'created_at' => '2025-01-27 16:07:12',
                'updated_at' => '2025-01-27 16:07:12',
            ),
        ));
        
        
    }
}