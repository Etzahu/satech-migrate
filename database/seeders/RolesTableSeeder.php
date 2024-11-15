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
            3 => 
            array (
                'id' => 4,
                'name' => 'solicitante_requisicion_compra',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 01:20:15',
                'updated_at' => '2024-10-21 01:20:15',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'revisor_requisicion_compra',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 01:20:35',
                'updated_at' => '2024-10-21 01:20:35',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'autorizador_requisicion_compra',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 01:20:59',
                'updated_at' => '2024-10-21 01:20:59',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'revisor_almacen_requisicion_compra',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 01:21:16',
                'updated_at' => '2024-10-21 01:21:16',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'director_general_requisicion_compra',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 01:21:31',
                'updated_at' => '2024-10-21 01:21:31',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'administrador_compras',
                'guard_name' => 'web',
                'created_at' => '2024-10-21 02:34:11',
                'updated_at' => '2024-10-21 02:34:11',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'comprador',
                'guard_name' => 'web',
                'created_at' => '2024-11-13 19:02:20',
                'updated_at' => '2024-11-13 19:02:20',
            ),
        ));
        
        
    }
}