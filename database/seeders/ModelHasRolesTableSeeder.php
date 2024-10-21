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
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            1 => 
            array (
                'role_id' => 8,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            2 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 199,
            ),
            3 => 
            array (
                'role_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 250,
            ),
        ));
        
        
    }
}