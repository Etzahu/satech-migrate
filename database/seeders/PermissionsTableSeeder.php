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
            66 => 
            array (
                'id' => 67,
                'name' => 'publish_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-18 18:01:38',
                'updated_at' => '2024-10-18 18:01:38',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'view_reviewer_warehouse_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-18 18:01:38',
                'updated_at' => '2024-10-18 18:01:38',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'view_reviewer_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-18 18:01:38',
                'updated_at' => '2024-10-18 18:01:38',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'view_approver_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-18 18:01:38',
                'updated_at' => '2024-10-18 18:01:38',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'view_reviewer_dg_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-10-18 18:01:38',
                'updated_at' => '2024-10-18 18:01:38',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'view_management',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'view_any_management',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'create_management',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'update_management',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'restore_management',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'restore_any_management',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'replicate_management',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'reorder_management',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'delete_management',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'delete_any_management',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'force_delete_management',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'force_delete_any_management',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'view_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'view_any_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'create_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'update_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'restore_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'restore_any_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'replicate_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'reorder_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'delete_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'delete_any_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'force_delete_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'force_delete_any_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'view_product',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'view_any_product',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'create_product',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'update_product',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'restore_product',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'restore_any_product',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'replicate_product',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'reorder_product',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'delete_product',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'delete_any_product',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'force_delete_product',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'force_delete_any_product',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'view_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'view_any_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'create_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'update_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'restore_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'restore_any_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'replicate_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'reorder_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'delete_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'delete_any_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'force_delete_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'force_delete_any_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'view_project::usage',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'view_any_project::usage',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'create_project::usage',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'update_project::usage',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'restore_project::usage',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'restore_any_project::usage',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'replicate_project::usage',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'reorder_project::usage',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'delete_project::usage',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'delete_any_project::usage',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'force_delete_project::usage',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            130 => 
            array (
                'id' => 131,
                'name' => 'force_delete_any_project::usage',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            131 => 
            array (
                'id' => 132,
                'name' => 'view_purchase::requisition::approval::chain',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            132 => 
            array (
                'id' => 133,
                'name' => 'view_any_purchase::requisition::approval::chain',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            133 => 
            array (
                'id' => 134,
                'name' => 'create_purchase::requisition::approval::chain',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            134 => 
            array (
                'id' => 135,
                'name' => 'update_purchase::requisition::approval::chain',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            135 => 
            array (
                'id' => 136,
                'name' => 'restore_purchase::requisition::approval::chain',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            136 => 
            array (
                'id' => 137,
                'name' => 'restore_any_purchase::requisition::approval::chain',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            137 => 
            array (
                'id' => 138,
                'name' => 'replicate_purchase::requisition::approval::chain',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            138 => 
            array (
                'id' => 139,
                'name' => 'reorder_purchase::requisition::approval::chain',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            139 => 
            array (
                'id' => 140,
                'name' => 'delete_purchase::requisition::approval::chain',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            140 => 
            array (
                'id' => 141,
                'name' => 'delete_any_purchase::requisition::approval::chain',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            141 => 
            array (
                'id' => 142,
                'name' => 'force_delete_purchase::requisition::approval::chain',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            142 => 
            array (
                'id' => 143,
                'name' => 'force_delete_any_purchase::requisition::approval::chain',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            143 => 
            array (
                'id' => 144,
                'name' => 'view_tax',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            144 => 
            array (
                'id' => 145,
                'name' => 'view_any_tax',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            145 => 
            array (
                'id' => 146,
                'name' => 'create_tax',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            146 => 
            array (
                'id' => 147,
                'name' => 'update_tax',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            147 => 
            array (
                'id' => 148,
                'name' => 'restore_tax',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            148 => 
            array (
                'id' => 149,
                'name' => 'restore_any_tax',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            149 => 
            array (
                'id' => 150,
                'name' => 'replicate_tax',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            150 => 
            array (
                'id' => 151,
                'name' => 'reorder_tax',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            151 => 
            array (
                'id' => 152,
                'name' => 'delete_tax',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            152 => 
            array (
                'id' => 153,
                'name' => 'delete_any_tax',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            153 => 
            array (
                'id' => 154,
                'name' => 'force_delete_tax',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            154 => 
            array (
                'id' => 155,
                'name' => 'force_delete_any_tax',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            155 => 
            array (
                'id' => 156,
                'name' => 'view_category',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            156 => 
            array (
                'id' => 157,
                'name' => 'view_any_category',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            157 => 
            array (
                'id' => 158,
                'name' => 'create_category',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            158 => 
            array (
                'id' => 159,
                'name' => 'update_category',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            159 => 
            array (
                'id' => 160,
                'name' => 'restore_category',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            160 => 
            array (
                'id' => 161,
                'name' => 'restore_any_category',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            161 => 
            array (
                'id' => 162,
                'name' => 'replicate_category',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            162 => 
            array (
                'id' => 163,
                'name' => 'reorder_category',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            163 => 
            array (
                'id' => 164,
                'name' => 'delete_category',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            164 => 
            array (
                'id' => 165,
                'name' => 'delete_any_category',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            165 => 
            array (
                'id' => 166,
                'name' => 'force_delete_category',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            166 => 
            array (
                'id' => 167,
                'name' => 'force_delete_any_category',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            167 => 
            array (
                'id' => 168,
                'name' => 'view_category::family',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            168 => 
            array (
                'id' => 169,
                'name' => 'view_any_category::family',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            169 => 
            array (
                'id' => 170,
                'name' => 'create_category::family',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            170 => 
            array (
                'id' => 171,
                'name' => 'update_category::family',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            171 => 
            array (
                'id' => 172,
                'name' => 'restore_category::family',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            172 => 
            array (
                'id' => 173,
                'name' => 'restore_any_category::family',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            173 => 
            array (
                'id' => 174,
                'name' => 'replicate_category::family',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            174 => 
            array (
                'id' => 175,
                'name' => 'reorder_category::family',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            175 => 
            array (
                'id' => 176,
                'name' => 'delete_category::family',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            176 => 
            array (
                'id' => 177,
                'name' => 'delete_any_category::family',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            177 => 
            array (
                'id' => 178,
                'name' => 'force_delete_category::family',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            178 => 
            array (
                'id' => 179,
                'name' => 'force_delete_any_category::family',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            179 => 
            array (
                'id' => 180,
                'name' => 'view_company',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            180 => 
            array (
                'id' => 181,
                'name' => 'view_any_company',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            181 => 
            array (
                'id' => 182,
                'name' => 'create_company',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            182 => 
            array (
                'id' => 183,
                'name' => 'update_company',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            183 => 
            array (
                'id' => 184,
                'name' => 'restore_company',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            184 => 
            array (
                'id' => 185,
                'name' => 'restore_any_company',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            185 => 
            array (
                'id' => 186,
                'name' => 'replicate_company',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            186 => 
            array (
                'id' => 187,
                'name' => 'reorder_company',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            187 => 
            array (
                'id' => 188,
                'name' => 'delete_company',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            188 => 
            array (
                'id' => 189,
                'name' => 'delete_any_company',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            189 => 
            array (
                'id' => 190,
                'name' => 'force_delete_company',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            190 => 
            array (
                'id' => 191,
                'name' => 'force_delete_any_company',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            191 => 
            array (
                'id' => 192,
                'name' => 'view_project::dn::np::cp',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            192 => 
            array (
                'id' => 193,
                'name' => 'view_any_project::dn::np::cp',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            193 => 
            array (
                'id' => 194,
                'name' => 'create_project::dn::np::cp',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            194 => 
            array (
                'id' => 195,
                'name' => 'update_project::dn::np::cp',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            195 => 
            array (
                'id' => 196,
                'name' => 'restore_project::dn::np::cp',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            196 => 
            array (
                'id' => 197,
                'name' => 'restore_any_project::dn::np::cp',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            197 => 
            array (
                'id' => 198,
                'name' => 'replicate_project::dn::np::cp',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            198 => 
            array (
                'id' => 199,
                'name' => 'reorder_project::dn::np::cp',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            199 => 
            array (
                'id' => 200,
                'name' => 'delete_project::dn::np::cp',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            200 => 
            array (
                'id' => 201,
                'name' => 'delete_any_project::dn::np::cp',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            201 => 
            array (
                'id' => 202,
                'name' => 'force_delete_project::dn::np::cp',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            202 => 
            array (
                'id' => 203,
                'name' => 'force_delete_any_project::dn::np::cp',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:26',
                'updated_at' => '2024-10-21 02:37:26',
            ),
            203 => 
            array (
                'id' => 204,
                'name' => 'view_shield::role',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:27',
                'updated_at' => '2024-10-21 02:37:27',
            ),
            204 => 
            array (
                'id' => 205,
                'name' => 'view_any_shield::role',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:27',
                'updated_at' => '2024-10-21 02:37:27',
            ),
            205 => 
            array (
                'id' => 206,
                'name' => 'create_shield::role',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:27',
                'updated_at' => '2024-10-21 02:37:27',
            ),
            206 => 
            array (
                'id' => 207,
                'name' => 'update_shield::role',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:27',
                'updated_at' => '2024-10-21 02:37:27',
            ),
            207 => 
            array (
                'id' => 208,
                'name' => 'delete_shield::role',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:27',
                'updated_at' => '2024-10-21 02:37:27',
            ),
            208 => 
            array (
                'id' => 209,
                'name' => 'delete_any_shield::role',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:37:27',
                'updated_at' => '2024-10-21 02:37:27',
            ),
            209 => 
            array (
                'id' => 210,
                'name' => 'view_p::r::review::ware::house',
                'guard_name' => 'web',
                'created_at' => '2024-11-01 15:20:39',
                'updated_at' => '2024-11-01 15:20:39',
            ),
            210 => 
            array (
                'id' => 211,
                'name' => 'view_any_p::r::review::ware::house',
                'guard_name' => 'web',
                'created_at' => '2024-11-01 15:20:39',
                'updated_at' => '2024-11-01 15:20:39',
            ),
            211 => 
            array (
                'id' => 212,
                'name' => 'create_p::r::review::ware::house',
                'guard_name' => 'web',
                'created_at' => '2024-11-01 15:20:39',
                'updated_at' => '2024-11-01 15:20:39',
            ),
            212 => 
            array (
                'id' => 213,
                'name' => 'update_p::r::review::ware::house',
                'guard_name' => 'web',
                'created_at' => '2024-11-01 15:20:39',
                'updated_at' => '2024-11-01 15:20:39',
            ),
            213 => 
            array (
                'id' => 214,
                'name' => 'restore_p::r::review::ware::house',
                'guard_name' => 'web',
                'created_at' => '2024-11-01 15:20:39',
                'updated_at' => '2024-11-01 15:20:39',
            ),
            214 => 
            array (
                'id' => 215,
                'name' => 'restore_any_p::r::review::ware::house',
                'guard_name' => 'web',
                'created_at' => '2024-11-01 15:20:39',
                'updated_at' => '2024-11-01 15:20:39',
            ),
            215 => 
            array (
                'id' => 216,
                'name' => 'replicate_p::r::review::ware::house',
                'guard_name' => 'web',
                'created_at' => '2024-11-01 15:20:39',
                'updated_at' => '2024-11-01 15:20:39',
            ),
            216 => 
            array (
                'id' => 217,
                'name' => 'reorder_p::r::review::ware::house',
                'guard_name' => 'web',
                'created_at' => '2024-11-01 15:20:39',
                'updated_at' => '2024-11-01 15:20:39',
            ),
            217 => 
            array (
                'id' => 218,
                'name' => 'delete_p::r::review::ware::house',
                'guard_name' => 'web',
                'created_at' => '2024-11-01 15:20:39',
                'updated_at' => '2024-11-01 15:20:39',
            ),
            218 => 
            array (
                'id' => 219,
                'name' => 'delete_any_p::r::review::ware::house',
                'guard_name' => 'web',
                'created_at' => '2024-11-01 15:20:39',
                'updated_at' => '2024-11-01 15:20:39',
            ),
            219 => 
            array (
                'id' => 220,
                'name' => 'force_delete_p::r::review::ware::house',
                'guard_name' => 'web',
                'created_at' => '2024-11-01 15:20:39',
                'updated_at' => '2024-11-01 15:20:39',
            ),
            220 => 
            array (
                'id' => 221,
                'name' => 'force_delete_any_p::r::review::ware::house',
                'guard_name' => 'web',
                'created_at' => '2024-11-01 15:20:39',
                'updated_at' => '2024-11-01 15:20:39',
            ),
            221 => 
            array (
                'id' => 222,
                'name' => 'view_p::r::review',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:22',
                'updated_at' => '2024-11-04 15:33:22',
            ),
            222 => 
            array (
                'id' => 223,
                'name' => 'view_any_p::r::review',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:22',
                'updated_at' => '2024-11-04 15:33:22',
            ),
            223 => 
            array (
                'id' => 224,
                'name' => 'create_p::r::review',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:22',
                'updated_at' => '2024-11-04 15:33:22',
            ),
            224 => 
            array (
                'id' => 225,
                'name' => 'update_p::r::review',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:22',
                'updated_at' => '2024-11-04 15:33:22',
            ),
            225 => 
            array (
                'id' => 226,
                'name' => 'restore_p::r::review',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:22',
                'updated_at' => '2024-11-04 15:33:22',
            ),
            226 => 
            array (
                'id' => 227,
                'name' => 'restore_any_p::r::review',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:22',
                'updated_at' => '2024-11-04 15:33:22',
            ),
            227 => 
            array (
                'id' => 228,
                'name' => 'replicate_p::r::review',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:22',
                'updated_at' => '2024-11-04 15:33:22',
            ),
            228 => 
            array (
                'id' => 229,
                'name' => 'reorder_p::r::review',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:22',
                'updated_at' => '2024-11-04 15:33:22',
            ),
            229 => 
            array (
                'id' => 230,
                'name' => 'delete_p::r::review',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:22',
                'updated_at' => '2024-11-04 15:33:22',
            ),
            230 => 
            array (
                'id' => 231,
                'name' => 'delete_any_p::r::review',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:22',
                'updated_at' => '2024-11-04 15:33:22',
            ),
            231 => 
            array (
                'id' => 232,
                'name' => 'force_delete_p::r::review',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:22',
                'updated_at' => '2024-11-04 15:33:22',
            ),
            232 => 
            array (
                'id' => 233,
                'name' => 'force_delete_any_p::r::review',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:22',
                'updated_at' => '2024-11-04 15:33:22',
            ),
            233 => 
            array (
                'id' => 234,
                'name' => 'view_p::r::approval',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:24',
                'updated_at' => '2024-11-04 15:33:24',
            ),
            234 => 
            array (
                'id' => 235,
                'name' => 'view_any_p::r::approval',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:24',
                'updated_at' => '2024-11-04 15:33:24',
            ),
            235 => 
            array (
                'id' => 236,
                'name' => 'create_p::r::approval',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:24',
                'updated_at' => '2024-11-04 15:33:24',
            ),
            236 => 
            array (
                'id' => 237,
                'name' => 'update_p::r::approval',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:24',
                'updated_at' => '2024-11-04 15:33:24',
            ),
            237 => 
            array (
                'id' => 238,
                'name' => 'restore_p::r::approval',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:24',
                'updated_at' => '2024-11-04 15:33:24',
            ),
            238 => 
            array (
                'id' => 239,
                'name' => 'restore_any_p::r::approval',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:24',
                'updated_at' => '2024-11-04 15:33:24',
            ),
            239 => 
            array (
                'id' => 240,
                'name' => 'replicate_p::r::approval',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:24',
                'updated_at' => '2024-11-04 15:33:24',
            ),
            240 => 
            array (
                'id' => 241,
                'name' => 'reorder_p::r::approval',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:24',
                'updated_at' => '2024-11-04 15:33:24',
            ),
            241 => 
            array (
                'id' => 242,
                'name' => 'delete_p::r::approval',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:24',
                'updated_at' => '2024-11-04 15:33:24',
            ),
            242 => 
            array (
                'id' => 243,
                'name' => 'delete_any_p::r::approval',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:24',
                'updated_at' => '2024-11-04 15:33:24',
            ),
            243 => 
            array (
                'id' => 244,
                'name' => 'force_delete_p::r::approval',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:24',
                'updated_at' => '2024-11-04 15:33:24',
            ),
            244 => 
            array (
                'id' => 245,
                'name' => 'force_delete_any_p::r::approval',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:24',
                'updated_at' => '2024-11-04 15:33:24',
            ),
            245 => 
            array (
                'id' => 246,
                'name' => 'view_p::r::approval::d::g',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:26',
                'updated_at' => '2024-11-04 15:33:26',
            ),
            246 => 
            array (
                'id' => 247,
                'name' => 'view_any_p::r::approval::d::g',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:26',
                'updated_at' => '2024-11-04 15:33:26',
            ),
            247 => 
            array (
                'id' => 248,
                'name' => 'create_p::r::approval::d::g',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:26',
                'updated_at' => '2024-11-04 15:33:26',
            ),
            248 => 
            array (
                'id' => 249,
                'name' => 'update_p::r::approval::d::g',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:26',
                'updated_at' => '2024-11-04 15:33:26',
            ),
            249 => 
            array (
                'id' => 250,
                'name' => 'restore_p::r::approval::d::g',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:26',
                'updated_at' => '2024-11-04 15:33:26',
            ),
            250 => 
            array (
                'id' => 251,
                'name' => 'restore_any_p::r::approval::d::g',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:26',
                'updated_at' => '2024-11-04 15:33:26',
            ),
            251 => 
            array (
                'id' => 252,
                'name' => 'replicate_p::r::approval::d::g',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:26',
                'updated_at' => '2024-11-04 15:33:26',
            ),
            252 => 
            array (
                'id' => 253,
                'name' => 'reorder_p::r::approval::d::g',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:26',
                'updated_at' => '2024-11-04 15:33:26',
            ),
            253 => 
            array (
                'id' => 254,
                'name' => 'delete_p::r::approval::d::g',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:26',
                'updated_at' => '2024-11-04 15:33:26',
            ),
            254 => 
            array (
                'id' => 255,
                'name' => 'delete_any_p::r::approval::d::g',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:26',
                'updated_at' => '2024-11-04 15:33:26',
            ),
            255 => 
            array (
                'id' => 256,
                'name' => 'force_delete_p::r::approval::d::g',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:26',
                'updated_at' => '2024-11-04 15:33:26',
            ),
            256 => 
            array (
                'id' => 257,
                'name' => 'force_delete_any_p::r::approval::d::g',
                'guard_name' => 'web',
                'created_at' => '2024-11-04 15:33:26',
                'updated_at' => '2024-11-04 15:33:26',
            ),
            257 => 
            array (
                'id' => 258,
                'name' => 'view_review_warehouse_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-11-05 18:53:37',
                'updated_at' => '2024-11-05 18:53:37',
            ),
            258 => 
            array (
                'id' => 259,
                'name' => 'view_review_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-11-05 20:49:43',
                'updated_at' => '2024-11-05 20:49:43',
            ),
            259 => 
            array (
                'id' => 260,
                'name' => 'view_approve_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-11-05 20:49:43',
                'updated_at' => '2024-11-05 20:49:43',
            ),
            260 => 
            array (
                'id' => 261,
                'name' => 'view_approve_dg_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-11-05 20:49:43',
                'updated_at' => '2024-11-05 20:49:43',
            ),
            261 => 
            array (
                'id' => 262,
                'name' => 'view_p::r::admin::assing',
                'guard_name' => 'web',
                'created_at' => '2024-11-21 17:19:16',
                'updated_at' => '2024-11-21 17:19:16',
            ),
            262 => 
            array (
                'id' => 263,
                'name' => 'view_any_p::r::admin::assing',
                'guard_name' => 'web',
                'created_at' => '2024-11-21 17:19:16',
                'updated_at' => '2024-11-21 17:19:16',
            ),
            263 => 
            array (
                'id' => 264,
                'name' => 'update_p::r::admin::assing',
                'guard_name' => 'web',
                'created_at' => '2024-11-21 17:19:16',
                'updated_at' => '2024-11-21 17:19:16',
            ),
            264 => 
            array (
                'id' => 265,
                'name' => 'view_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2024-12-03 16:17:03',
                'updated_at' => '2024-12-03 16:17:03',
            ),
            265 => 
            array (
                'id' => 266,
                'name' => 'view_any_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2024-12-03 16:17:03',
                'updated_at' => '2024-12-03 16:17:03',
            ),
            266 => 
            array (
                'id' => 267,
                'name' => 'create_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2024-12-03 16:17:03',
                'updated_at' => '2024-12-03 16:17:03',
            ),
            267 => 
            array (
                'id' => 268,
                'name' => 'update_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2024-12-03 16:17:03',
                'updated_at' => '2024-12-03 16:17:03',
            ),
            268 => 
            array (
                'id' => 269,
                'name' => 'restore_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2024-12-03 16:17:03',
                'updated_at' => '2024-12-03 16:17:03',
            ),
            269 => 
            array (
                'id' => 270,
                'name' => 'restore_any_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2024-12-03 16:17:03',
                'updated_at' => '2024-12-03 16:17:03',
            ),
            270 => 
            array (
                'id' => 271,
                'name' => 'replicate_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2024-12-03 16:17:03',
                'updated_at' => '2024-12-03 16:17:03',
            ),
            271 => 
            array (
                'id' => 272,
                'name' => 'reorder_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2024-12-03 16:17:03',
                'updated_at' => '2024-12-03 16:17:03',
            ),
            272 => 
            array (
                'id' => 273,
                'name' => 'delete_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2024-12-03 16:17:03',
                'updated_at' => '2024-12-03 16:17:03',
            ),
            273 => 
            array (
                'id' => 274,
                'name' => 'delete_any_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2024-12-03 16:17:03',
                'updated_at' => '2024-12-03 16:17:03',
            ),
            274 => 
            array (
                'id' => 275,
                'name' => 'force_delete_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2024-12-03 16:17:03',
                'updated_at' => '2024-12-03 16:17:03',
            ),
            275 => 
            array (
                'id' => 276,
                'name' => 'force_delete_any_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2024-12-03 16:17:03',
                'updated_at' => '2024-12-03 16:17:03',
            ),
            276 => 
            array (
                'id' => 277,
                'name' => 'assing_purchase::requisition',
                'guard_name' => 'web',
                'created_at' => '2024-12-03 16:45:52',
                'updated_at' => '2024-12-03 16:45:52',
            ),
            277 => 
            array (
                'id' => 278,
                'name' => 'view_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2024-12-16 18:59:20',
                'updated_at' => '2024-12-16 18:59:20',
            ),
            278 => 
            array (
                'id' => 279,
                'name' => 'view_any_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2024-12-16 18:59:20',
                'updated_at' => '2024-12-16 18:59:20',
            ),
            279 => 
            array (
                'id' => 280,
                'name' => 'create_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2024-12-16 18:59:20',
                'updated_at' => '2024-12-16 18:59:20',
            ),
            280 => 
            array (
                'id' => 281,
                'name' => 'update_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2024-12-16 18:59:20',
                'updated_at' => '2024-12-16 18:59:20',
            ),
            281 => 
            array (
                'id' => 282,
                'name' => 'delete_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2024-12-16 18:59:20',
                'updated_at' => '2024-12-16 18:59:20',
            ),
            282 => 
            array (
                'id' => 283,
                'name' => 'delete_any_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2024-12-16 18:59:20',
                'updated_at' => '2024-12-16 18:59:20',
            ),
            283 => 
            array (
                'id' => 284,
                'name' => 'view_approve-level-1_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2024-12-16 18:59:21',
                'updated_at' => '2024-12-16 18:59:21',
            ),
            284 => 
            array (
                'id' => 285,
                'name' => 'view_approve_level-2_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2024-12-16 18:59:21',
                'updated_at' => '2024-12-16 18:59:21',
            ),
            285 => 
            array (
                'id' => 286,
                'name' => 'view_approve-level-3_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2024-12-16 18:59:21',
                'updated_at' => '2024-12-16 18:59:21',
            ),
            286 => 
            array (
                'id' => 287,
                'name' => 'view_approve_level-4_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2024-12-16 18:59:21',
                'updated_at' => '2024-12-16 18:59:21',
            ),
            287 => 
            array (
                'id' => 288,
                'name' => 'view_brand',
                'guard_name' => 'web',
                'created_at' => '2024-12-18 15:54:34',
                'updated_at' => '2024-12-18 15:54:34',
            ),
            288 => 
            array (
                'id' => 289,
                'name' => 'view_any_brand',
                'guard_name' => 'web',
                'created_at' => '2024-12-18 15:54:34',
                'updated_at' => '2024-12-18 15:54:34',
            ),
            289 => 
            array (
                'id' => 290,
                'name' => 'create_brand',
                'guard_name' => 'web',
                'created_at' => '2024-12-18 15:54:34',
                'updated_at' => '2024-12-18 15:54:34',
            ),
            290 => 
            array (
                'id' => 291,
                'name' => 'update_brand',
                'guard_name' => 'web',
                'created_at' => '2024-12-18 15:54:34',
                'updated_at' => '2024-12-18 15:54:34',
            ),
            291 => 
            array (
                'id' => 292,
                'name' => 'restore_brand',
                'guard_name' => 'web',
                'created_at' => '2024-12-18 15:54:34',
                'updated_at' => '2024-12-18 15:54:34',
            ),
            292 => 
            array (
                'id' => 293,
                'name' => 'restore_any_brand',
                'guard_name' => 'web',
                'created_at' => '2024-12-18 15:54:34',
                'updated_at' => '2024-12-18 15:54:34',
            ),
            293 => 
            array (
                'id' => 294,
                'name' => 'replicate_brand',
                'guard_name' => 'web',
                'created_at' => '2024-12-18 15:54:34',
                'updated_at' => '2024-12-18 15:54:34',
            ),
            294 => 
            array (
                'id' => 295,
                'name' => 'reorder_brand',
                'guard_name' => 'web',
                'created_at' => '2024-12-18 15:54:34',
                'updated_at' => '2024-12-18 15:54:34',
            ),
            295 => 
            array (
                'id' => 296,
                'name' => 'delete_brand',
                'guard_name' => 'web',
                'created_at' => '2024-12-18 15:54:34',
                'updated_at' => '2024-12-18 15:54:34',
            ),
            296 => 
            array (
                'id' => 297,
                'name' => 'delete_any_brand',
                'guard_name' => 'web',
                'created_at' => '2024-12-18 15:54:34',
                'updated_at' => '2024-12-18 15:54:34',
            ),
            297 => 
            array (
                'id' => 298,
                'name' => 'force_delete_brand',
                'guard_name' => 'web',
                'created_at' => '2024-12-18 15:54:34',
                'updated_at' => '2024-12-18 15:54:34',
            ),
            298 => 
            array (
                'id' => 299,
                'name' => 'force_delete_any_brand',
                'guard_name' => 'web',
                'created_at' => '2024-12-18 15:54:34',
                'updated_at' => '2024-12-18 15:54:34',
            ),
        ));
        
        
    }
}