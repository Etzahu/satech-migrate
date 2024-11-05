<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectPurchaseCategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('project_purchase_category')->delete();
        
        \DB::table('project_purchase_category')->insert(array (
            0 => 
            array (
                'id' => 1,
                'project_purchase_id' => 1,
                'category_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'project_purchase_id' => 1,
                'category_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'project_purchase_id' => 1,
                'category_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'project_purchase_id' => 1,
                'category_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'project_purchase_id' => 1,
                'category_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'project_purchase_id' => 1,
                'category_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'project_purchase_id' => 1,
                'category_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'project_purchase_id' => 1,
                'category_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'project_purchase_id' => 1,
                'category_id' => 10,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'project_purchase_id' => 1,
                'category_id' => 11,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'project_purchase_id' => 1,
                'category_id' => 12,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'project_purchase_id' => 1,
                'category_id' => 13,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'project_purchase_id' => 1,
                'category_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'project_purchase_id' => 1,
                'category_id' => 15,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'project_purchase_id' => 1,
                'category_id' => 16,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'project_purchase_id' => 1,
                'category_id' => 17,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}