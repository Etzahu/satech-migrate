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
                'name' => 'Administración y Contabilidad',
                'acronym' => 'ADM',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Almacén',
                'acronym' => 'ALM',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Calidad, Seguridad y Medio Ambiente',
                'acronym' => 'QHSE',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Compras',
                'acronym' => 'COM',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Ingeniería - Manufactura',
                'acronym' => 'ING',
                'responsible_id' => 19,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-12-17 18:01:41',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Mantenimiento',
                'acronym' => 'MTTO',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Marketing',
                'acronym' => 'MKT',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Región Sur',
                'acronym' => 'GRS',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Norte Región Centro',
                'acronym' => 'GRC',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Planeación',
                'acronym' => 'CP',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Recursos Humanos',
                'acronym' => 'RH',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Servicios Generales',
                'acronym' => 'SG',
                'responsible_id' => 331,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-12-17 16:12:00',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Ventas',
                'acronym' => 'VEN',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:23',
                'updated_at' => '2024-10-15 17:42:23',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Soldadura',
                'acronym' => 'ISW',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:24',
                'updated_at' => '2024-10-15 17:42:24',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Servicios Complementarios',
                'acronym' => 'SC',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:24',
                'updated_at' => '2024-10-15 17:42:24',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Servicios Técnicos',
                'acronym' => 'ST',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:24',
                'updated_at' => '2024-10-15 17:42:24',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Informática',
                'acronym' => 'IT',
                'responsible_id' => 106,
                'created_at' => '2024-10-15 17:42:24',
                'updated_at' => '2024-10-15 17:42:24',
            ),
        ));
        
        
    }
}