<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectsDnNpCpTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('projects_dn_np_cp')->delete();
        
        \DB::table('projects_dn_np_cp')->insert(array (
            0 => 
            array (
                'id' => 393,
                'name' => 'DN-003/24 Adecuación Infraestructura TMBD',
                'type' => 'DN',
                'client' => 'DIAVAZ',
                'created_at' => '2024-07-03 05:46:47',
                'updated_at' => '2024-07-03 05:46:47',
            ),
            1 => 
            array (
                'id' => 394,
                'name' => 'DN-057/24 Servicio de HT 36" x 8" Ref. Tula, Maquialsa',
                'type' => 'DN',
                'client' => 'MAQUIALSA',
                'created_at' => '2024-07-03 05:49:19',
                'updated_at' => '2024-07-03 05:49:19',
            ),
            2 => 
            array (
                'id' => 395,
                'name' => 'DN-040/24 Proyecto Baños HT 6" x 6" Texmelucan Puebla',
                'type' => 'DN',
                'client' => 'IGASAMEX',
                'created_at' => '2024-07-03 05:49:59',
                'updated_at' => '2024-07-03 05:49:59',
            ),
            3 => 
            array (
                'id' => 396,
                'name' => 'DN-047/24 DLS 22" Azcapotzalco CDMX',
                'type' => 'DN',
                'client' => 'NATURGY',
                'created_at' => '2024-07-03 05:50:14',
                'updated_at' => '2024-07-03 05:50:14',
            ),
            4 => 
            array (
                'id' => 397,
                'name' => 'NP-007/24 Mantenimiento Mensual Julio 2024',
                'type' => 'NP',
                'client' => 'GPT SERVICES',
                'created_at' => '2024-07-03 05:51:25',
                'updated_at' => '2024-07-03 05:51:25',
            ),
            5 => 
            array (
                'id' => 398,
            'name' => 'DN-001-24 OBTURACIÓN 48" x16", 36" x 16" (MONOBOYAS)',
                'type' => 'DN',
                'client' => 'DIAVAZ',
                'created_at' => '2024-07-09 02:04:03',
                'updated_at' => '2024-07-09 05:00:57',
            ),
        ));
        
        
    }
}