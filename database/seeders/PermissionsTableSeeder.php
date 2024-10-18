<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'view_role',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'view_any_role',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'create_role',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'update_role',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'delete_role',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'delete_any_role',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'view_user',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'view_any_user',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'create_user',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'update_user',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'restore_user',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'restore_any_user',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'replicate_user',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'reorder_user',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'delete_user',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'delete_any_user',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'force_delete_user',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'force_delete_any_user',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'view_drawing',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'view_any_drawing',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'create_drawing',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'update_drawing',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'restore_drawing',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'restore_any_drawing',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'replicate_drawing',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'reorder_drawing',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'delete_drawing',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'delete_any_drawing',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'force_delete_drawing',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'force_delete_any_drawing',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'view_drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'view_any_drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'create_drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'update_drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'restore_drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'restore_any_drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'replicate_drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'reorder_drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'delete_drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'delete_any_drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'force_delete_drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'force_delete_any_drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'view_sub::drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'view_any_sub::drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'create_sub::drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'update_sub::drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'restore_sub::drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'restore_any_sub::drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'replicate_sub::drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'reorder_sub::drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'delete_sub::drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'delete_any_sub::drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'force_delete_sub::drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'force_delete_any_sub::drawing::category',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'view_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 18:33:14',
                'updated_at' => '2024-10-17 18:33:14',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'view_any_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 18:33:14',
                'updated_at' => '2024-10-17 18:33:14',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'create_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 18:33:14',
                'updated_at' => '2024-10-17 18:33:14',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'update_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 18:33:14',
                'updated_at' => '2024-10-17 18:33:14',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'restore_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 18:33:14',
                'updated_at' => '2024-10-17 18:33:14',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'restore_any_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 18:33:14',
                'updated_at' => '2024-10-17 18:33:14',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'replicate_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 18:33:14',
                'updated_at' => '2024-10-17 18:33:14',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'reorder_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 18:33:14',
                'updated_at' => '2024-10-17 18:33:14',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'delete_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 18:33:14',
                'updated_at' => '2024-10-17 18:33:14',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'delete_any_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 18:33:14',
                'updated_at' => '2024-10-17 18:33:14',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'force_delete_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 18:33:14',
                'updated_at' => '2024-10-17 18:33:14',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'force_delete_any_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-17 18:33:14',
                'updated_at' => '2024-10-17 18:33:14',
            ),
        ));
        
        
    }
}