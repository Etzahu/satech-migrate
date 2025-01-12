<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModelHasRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('model_has_roles')->delete();
        
        \DB::table('model_has_roles')->insert(array (
            0 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            1 => 
            array (
                'role_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            2 => 
            array (
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            3 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            4 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            5 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            6 => 
            array (
                'role_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            7 => 
            array (
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            8 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            9 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            10 => 
            array (
                'role_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            11 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            12 => 
            array (
                'role_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            13 => 
            array (
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            14 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            15 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            16 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            17 => 
            array (
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            18 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            19 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            20 => 
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            21 => 
            array (
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            22 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            23 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            24 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            25 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            26 => 
            array (
                'role_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            27 => 
            array (
                'role_id' => 8,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            28 => 
            array (
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            29 => 
            array (
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            30 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 114,
            ),
            31 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 120,
            ),
            32 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 120,
            ),
            33 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 131,
            ),
            34 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 132,
            ),
            35 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 137,
            ),
            36 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 137,
            ),
            37 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 152,
            ),
            38 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 152,
            ),
            39 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 157,
            ),
            40 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 157,
            ),
            41 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 158,
            ),
            42 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 158,
            ),
            43 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 166,
            ),
            44 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 166,
            ),
            45 => 
            array (
                'role_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 168,
            ),
            46 => 
            array (
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 168,
            ),
            47 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 180,
            ),
            48 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 180,
            ),
            49 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 191,
            ),
            50 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 193,
            ),
            51 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 193,
            ),
            52 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 199,
            ),
            53 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 199,
            ),
            54 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 199,
            ),
            55 => 
            array (
                'role_id' => 10,
                'model_type' => 'App\\Models\\User',
                'model_id' => 199,
            ),
            56 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 200,
            ),
            57 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 200,
            ),
            58 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 205,
            ),
            59 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 205,
            ),
            60 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 212,
            ),
            61 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 212,
            ),
            62 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 223,
            ),
            63 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 227,
            ),
            64 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 227,
            ),
            65 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 230,
            ),
            66 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 240,
            ),
            67 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 240,
            ),
            68 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 249,
            ),
            69 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 250,
            ),
            70 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 250,
            ),
            71 => 
            array (
                'role_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 250,
            ),
            72 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 253,
            ),
            73 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 253,
            ),
            74 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 257,
            ),
            75 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 260,
            ),
            76 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 264,
            ),
            77 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 264,
            ),
            78 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 266,
            ),
            79 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 266,
            ),
            80 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 268,
            ),
            81 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 268,
            ),
            82 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 269,
            ),
            83 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 269,
            ),
            84 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 270,
            ),
            85 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 270,
            ),
            86 => 
            array (
                'role_id' => 10,
                'model_type' => 'App\\Models\\User',
                'model_id' => 274,
            ),
            87 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 287,
            ),
            88 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 292,
            ),
            89 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 293,
            ),
            90 => 
            array (
                'role_id' => 10,
                'model_type' => 'App\\Models\\User',
                'model_id' => 298,
            ),
            91 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 301,
            ),
            92 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 303,
            ),
            93 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 304,
            ),
            94 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 304,
            ),
            95 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 307,
            ),
            96 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 307,
            ),
            97 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 309,
            ),
            98 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 313,
            ),
            99 => 
            array (
                'role_id' => 13,
                'model_type' => 'App\\Models\\User',
                'model_id' => 315,
            ),
            100 => 
            array (
                'role_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 331,
            ),
            101 => 
            array (
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 331,
            ),
        ));
        
        
    }
}