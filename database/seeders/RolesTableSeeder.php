<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'super_admin',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 01:17:55',
                'updated_at' => '2024-10-07 01:17:55',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'admin_ing_panel',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 15:59:19',
                'updated_at' => '2024-10-07 15:59:19',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'user_ing',
                'guard_name' => 'web',
                'created_at' => '2024-10-07 16:00:17',
                'updated_at' => '2024-10-07 16:01:00',
            ),
        ));
        
        
    }
}