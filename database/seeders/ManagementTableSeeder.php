<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ManagementTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('management')->delete();
        
        \DB::table('management')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Administración y Finanzas',
                'acronym' => 'ADM',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Compras',
                'acronym' => 'COM',
                'responsible_id' => 180,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Contratos',
                'acronym' => 'CON',
                'responsible_id' => 168,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Dirección de Operaciones',
                'acronym' => 'DOP',
                'responsible_id' => 36,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Dirección General',
                'acronym' => 'DG',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-12-17 18:01:41',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Gerencia de Contratos',
                'acronym' => 'GCON',
                'responsible_id' => 168,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Gerencia de Ingeniería Manufactura y Mantenimiento',
                'acronym' => 'MTTO',
                'responsible_id' => 19,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Gerencia de Operaciones',
                'acronym' => 'GOP',
                'responsible_id' => 46,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Gerencia de Servicios Generales y Almacén',
                'acronym' => 'SG',
                'responsible_id' => 331,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Gerencia de Soldadura',
                'acronym' => 'ISW',
                'responsible_id' => 14,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
        ));
        
        
    }
}