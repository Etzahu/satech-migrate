<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'migration' => '0001_01_01_000000_create_users_table',
                'batch' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'migration' => '0001_01_01_000001_create_cache_table',
                'batch' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'migration' => '0001_01_01_000002_create_jobs_table',
                'batch' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'migration' => '2024_10_02_165911_create_permission_tables',
                'batch' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'migration' => '2024_10_06_001145_create_drawing_categories_table',
                'batch' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'migration' => '2024_10_06_001206_create_sub_drawing_categories_table',
                'batch' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'migration' => '2024_10_06_025139_create_drawings_table',
                'batch' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'migration' => '2024_10_07_202623_create_project_dn_np_cps_table',
                'batch' => 1,
            ),
            8 => 
            array (
                'id' => 9,
                'migration' => '2024_10_10_145943_create_companies_table',
                'batch' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'migration' => '2024_10_10_145944_create_taxes_table',
                'batch' => 1,
            ),
            10 => 
            array (
                'id' => 11,
                'migration' => '2024_10_10_145945_create_management_table',
                'batch' => 1,
            ),
            11 => 
            array (
                'id' => 12,
                'migration' => '2024_10_10_145946_create_purchase_requisition_approval_chains_table',
                'batch' => 1,
            ),
            12 => 
            array (
                'id' => 13,
                'migration' => '2024_10_14_180506_create_categories_table',
                'batch' => 1,
            ),
            13 => 
            array (
                'id' => 14,
                'migration' => '2024_10_14_180507_create_category_families_table',
                'batch' => 1,
            ),
            14 => 
            array (
                'id' => 15,
                'migration' => '2024_10_14_180507_create_measure_units_table',
                'batch' => 1,
            ),
            15 => 
            array (
                'id' => 16,
                'migration' => '2024_10_14_180508_create_products_table',
                'batch' => 1,
            ),
            16 => 
            array (
                'id' => 17,
                'migration' => '2024_10_14_180508_create_project_purchases_table',
                'batch' => 1,
            ),
            17 => 
            array (
                'id' => 18,
                'migration' => '2024_10_14_180509_create_project_purchase_category_table',
                'batch' => 1,
            ),
            18 => 
            array (
                'id' => 19,
                'migration' => '2024_10_14_180509_create_purchase_requisitions_table',
                'batch' => 1,
            ),
            19 => 
            array (
                'id' => 20,
                'migration' => '2024_10_14_180510_create_purchase_requisition_items_table',
                'batch' => 1,
            ),
            20 => 
            array (
                'id' => 21,
                'migration' => '2024_10_16_202949_create_pending_transitions_table',
                'batch' => 1,
            ),
            21 => 
            array (
                'id' => 22,
                'migration' => '2024_10_16_202949_create_state_histories_table',
                'batch' => 1,
            ),
            22 => 
            array (
                'id' => 23,
                'migration' => '2024_10_17_181443_create_media_table',
                'batch' => 1,
            ),
            23 => 
            array (
                'id' => 24,
                'migration' => '2024_11_20_182543_create_notifications_table',
                'batch' => 1,
            ),
            24 => 
            array (
                'id' => 25,
                'migration' => '2024_11_21_152453_create_purchase_providers_table',
                'batch' => 1,
            ),
            25 => 
            array (
                'id' => 26,
                'migration' => '2024_11_21_152454_create_provider_contacts_table',
                'batch' => 1,
            ),
            26 => 
            array (
                'id' => 27,
                'migration' => '2024_11_21_152455_create_purchase_orders_table',
                'batch' => 1,
            ),
            27 => 
            array (
                'id' => 28,
                'migration' => '2024_11_21_152456_create_purchase_order_items_table',
                'batch' => 1,
            ),
        ));
        
        
    }
}