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
                'name' => 'view_purchase::requisition::requester',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:50:26',
                'updated_at' => '2025-01-20 13:50:26',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'view_any_purchase::requisition::requester',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:50:26',
                'updated_at' => '2025-01-20 13:50:26',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'create_purchase::requisition::requester',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:50:26',
                'updated_at' => '2025-01-20 13:50:26',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'update_purchase::requisition::requester',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:50:26',
                'updated_at' => '2025-01-20 13:50:26',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'delete_purchase::requisition::requester',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:50:26',
                'updated_at' => '2025-01-20 13:50:26',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'delete_any_purchase::requisition::requester',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:50:26',
                'updated_at' => '2025-01-20 13:50:26',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'view_review_warehouse_purchase::requisition::requester',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:50:26',
                'updated_at' => '2025-01-20 13:50:26',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'view_review_purchase::requisition::requester',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:50:26',
                'updated_at' => '2025-01-20 13:50:26',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'view_approve_purchase::requisition::requester',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:50:26',
                'updated_at' => '2025-01-20 13:50:26',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'view_authorize_purchase::requisition::requester',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:50:26',
                'updated_at' => '2025-01-20 13:50:26',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'view_assing_purchase::requisition::requester',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:50:26',
                'updated_at' => '2025-01-20 13:50:26',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'view_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:52:36',
                'updated_at' => '2025-01-20 13:52:36',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'view_any_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:52:36',
                'updated_at' => '2025-01-20 13:52:36',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'create_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:52:36',
                'updated_at' => '2025-01-20 13:52:36',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'update_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:52:36',
                'updated_at' => '2025-01-20 13:52:36',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'delete_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:52:36',
                'updated_at' => '2025-01-20 13:52:36',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'delete_any_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:52:36',
                'updated_at' => '2025-01-20 13:52:36',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'view_approve-level-1_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:52:36',
                'updated_at' => '2025-01-20 13:52:36',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'view_approve_level-2_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:52:36',
                'updated_at' => '2025-01-20 13:52:36',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'view_approve-level-3_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:52:36',
                'updated_at' => '2025-01-20 13:52:36',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'view_approve_level-4_purchase::order::purchaser',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:52:36',
                'updated_at' => '2025-01-20 13:52:36',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'view_brand',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'view_any_brand',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'create_brand',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'update_brand',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'restore_brand',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'restore_any_brand',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'replicate_brand',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'reorder_brand',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'delete_brand',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'delete_any_brand',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'force_delete_brand',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'force_delete_any_brand',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'view_category',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'view_any_category',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'create_category',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'update_category',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'restore_category',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'restore_any_category',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'replicate_category',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'reorder_category',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'delete_category',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'delete_any_category',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'force_delete_category',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'force_delete_any_category',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'view_company',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'view_any_company',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'create_company',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'update_company',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'restore_company',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'restore_any_company',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'replicate_company',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'reorder_company',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'delete_company',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'delete_any_company',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'force_delete_company',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'force_delete_any_company',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'view_management',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'view_any_management',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'create_management',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'update_management',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'restore_management',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'restore_any_management',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'replicate_management',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'reorder_management',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'delete_management',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'delete_any_management',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'force_delete_management',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'force_delete_any_management',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'view_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'view_any_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'create_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'update_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'restore_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'restore_any_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'replicate_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'reorder_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'delete_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'delete_any_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'force_delete_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'force_delete_any_measure::unit',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'view_product',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'view_any_product',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'create_product',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'update_product',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'restore_product',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'restore_any_product',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'replicate_product',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'reorder_product',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'delete_product',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'delete_any_product',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'force_delete_product',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'force_delete_any_product',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'view_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'view_any_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'create_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'update_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'restore_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'restore_any_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'replicate_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'reorder_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'delete_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'delete_any_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'force_delete_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'force_delete_any_project::purchase',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'view_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'view_any_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'create_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'update_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'restore_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'restore_any_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'replicate_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'reorder_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'delete_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'delete_any_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'force_delete_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'force_delete_any_purchase::provider',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'view_purchase::requisition::chain',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'view_any_purchase::requisition::chain',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'create_purchase::requisition::chain',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'update_purchase::requisition::chain',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'restore_purchase::requisition::chain',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'restore_any_purchase::requisition::chain',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'replicate_purchase::requisition::chain',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'reorder_purchase::requisition::chain',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'delete_purchase::requisition::chain',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'delete_any_purchase::requisition::chain',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'force_delete_purchase::requisition::chain',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'force_delete_any_purchase::requisition::chain',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'view_tax',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            130 => 
            array (
                'id' => 131,
                'name' => 'view_any_tax',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            131 => 
            array (
                'id' => 132,
                'name' => 'create_tax',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            132 => 
            array (
                'id' => 133,
                'name' => 'update_tax',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            133 => 
            array (
                'id' => 134,
                'name' => 'restore_tax',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            134 => 
            array (
                'id' => 135,
                'name' => 'restore_any_tax',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            135 => 
            array (
                'id' => 136,
                'name' => 'replicate_tax',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            136 => 
            array (
                'id' => 137,
                'name' => 'reorder_tax',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            137 => 
            array (
                'id' => 138,
                'name' => 'delete_tax',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            138 => 
            array (
                'id' => 139,
                'name' => 'delete_any_tax',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            139 => 
            array (
                'id' => 140,
                'name' => 'force_delete_tax',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            140 => 
            array (
                'id' => 141,
                'name' => 'force_delete_any_tax',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            141 => 
            array (
                'id' => 142,
                'name' => 'view_user',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            142 => 
            array (
                'id' => 143,
                'name' => 'view_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            143 => 
            array (
                'id' => 144,
                'name' => 'create_user',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            144 => 
            array (
                'id' => 145,
                'name' => 'update_user',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            145 => 
            array (
                'id' => 146,
                'name' => 'restore_user',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            146 => 
            array (
                'id' => 147,
                'name' => 'restore_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            147 => 
            array (
                'id' => 148,
                'name' => 'replicate_user',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            148 => 
            array (
                'id' => 149,
                'name' => 'reorder_user',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            149 => 
            array (
                'id' => 150,
                'name' => 'delete_user',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            150 => 
            array (
                'id' => 151,
                'name' => 'delete_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            151 => 
            array (
                'id' => 152,
                'name' => 'force_delete_user',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            152 => 
            array (
                'id' => 153,
                'name' => 'force_delete_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-01-20 13:53:17',
                'updated_at' => '2025-01-20 13:53:17',
            ),
            153 => 
            array (
                'id' => 154,
                'name' => 'view_shield::role',
                'guard_name' => 'web',
                'created_at' => '2025-01-21 13:37:31',
                'updated_at' => '2025-01-21 13:37:31',
            ),
            154 => 
            array (
                'id' => 155,
                'name' => 'view_any_shield::role',
                'guard_name' => 'web',
                'created_at' => '2025-01-21 13:37:31',
                'updated_at' => '2025-01-21 13:37:31',
            ),
            155 => 
            array (
                'id' => 156,
                'name' => 'create_shield::role',
                'guard_name' => 'web',
                'created_at' => '2025-01-21 13:37:31',
                'updated_at' => '2025-01-21 13:37:31',
            ),
            156 => 
            array (
                'id' => 157,
                'name' => 'update_shield::role',
                'guard_name' => 'web',
                'created_at' => '2025-01-21 13:37:31',
                'updated_at' => '2025-01-21 13:37:31',
            ),
            157 => 
            array (
                'id' => 158,
                'name' => 'delete_shield::role',
                'guard_name' => 'web',
                'created_at' => '2025-01-21 13:37:31',
                'updated_at' => '2025-01-21 13:37:31',
            ),
            158 => 
            array (
                'id' => 159,
                'name' => 'delete_any_shield::role',
                'guard_name' => 'web',
                'created_at' => '2025-01-21 13:37:31',
                'updated_at' => '2025-01-21 13:37:31',
            ),
            159 => 
            array (
                'id' => 160,
                'name' => 'view_purchase::requisition::history',
                'guard_name' => 'web',
                'created_at' => '2025-01-27 17:19:04',
                'updated_at' => '2025-01-27 17:19:04',
            ),
            160 => 
            array (
                'id' => 161,
                'name' => 'view_any_purchase::requisition::history',
                'guard_name' => 'web',
                'created_at' => '2025-01-27 17:19:04',
                'updated_at' => '2025-01-27 17:19:04',
            ),
            161 => 
            array (
                'id' => 162,
                'name' => 'create_purchase::requisition::history',
                'guard_name' => 'web',
                'created_at' => '2025-01-27 17:19:04',
                'updated_at' => '2025-01-27 17:19:04',
            ),
            162 => 
            array (
                'id' => 163,
                'name' => 'update_purchase::requisition::history',
                'guard_name' => 'web',
                'created_at' => '2025-01-27 17:19:04',
                'updated_at' => '2025-01-27 17:19:04',
            ),
            163 => 
            array (
                'id' => 164,
                'name' => 'restore_purchase::requisition::history',
                'guard_name' => 'web',
                'created_at' => '2025-01-27 17:19:04',
                'updated_at' => '2025-01-27 17:19:04',
            ),
            164 => 
            array (
                'id' => 165,
                'name' => 'restore_any_purchase::requisition::history',
                'guard_name' => 'web',
                'created_at' => '2025-01-27 17:19:04',
                'updated_at' => '2025-01-27 17:19:04',
            ),
            165 => 
            array (
                'id' => 166,
                'name' => 'replicate_purchase::requisition::history',
                'guard_name' => 'web',
                'created_at' => '2025-01-27 17:19:04',
                'updated_at' => '2025-01-27 17:19:04',
            ),
            166 => 
            array (
                'id' => 167,
                'name' => 'reorder_purchase::requisition::history',
                'guard_name' => 'web',
                'created_at' => '2025-01-27 17:19:04',
                'updated_at' => '2025-01-27 17:19:04',
            ),
            167 => 
            array (
                'id' => 168,
                'name' => 'delete_purchase::requisition::history',
                'guard_name' => 'web',
                'created_at' => '2025-01-27 17:19:04',
                'updated_at' => '2025-01-27 17:19:04',
            ),
            168 => 
            array (
                'id' => 169,
                'name' => 'delete_any_purchase::requisition::history',
                'guard_name' => 'web',
                'created_at' => '2025-01-27 17:19:04',
                'updated_at' => '2025-01-27 17:19:04',
            ),
            169 => 
            array (
                'id' => 170,
                'name' => 'force_delete_purchase::requisition::history',
                'guard_name' => 'web',
                'created_at' => '2025-01-27 17:19:04',
                'updated_at' => '2025-01-27 17:19:04',
            ),
            170 => 
            array (
                'id' => 171,
                'name' => 'force_delete_any_purchase::requisition::history',
                'guard_name' => 'web',
                'created_at' => '2025-01-27 17:19:04',
                'updated_at' => '2025-01-27 17:19:04',
            ),
            171 => 
            array (
                'id' => 172,
                'name' => 'view_request::catalog',
                'guard_name' => 'web',
                'created_at' => '2025-01-27 17:19:04',
                'updated_at' => '2025-01-27 17:19:04',
            ),
        ));
        
        
    }
}