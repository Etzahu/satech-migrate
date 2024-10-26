<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectPurchasesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('project_purchases')->delete();
        
        \DB::table('project_purchases')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'NP-003/24',
                'name' => 'ADECUACIÓN INFRAESTRUCTURA TMBD',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2024-10-24 20:01:01',
                'updated_at' => '2024-10-24 20:01:01',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'NP-057/24',
                'name' => 'SERVICIO DE HT 36" X 8" REF. TULA, MAQUIALSA',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2024-10-24 20:01:21',
                'updated_at' => '2024-10-24 20:01:21',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'NP-040/24',
                'name' => 'PROYECTO BAÑOS HT 6" X 6" TEXMELUCAN PUEBLA',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2024-10-24 20:01:38',
                'updated_at' => '2024-10-24 20:01:38',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'NP-047/24 DLS 22"',
                'name' => 'AZCAPOTZALCO CDMX',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2024-10-24 20:01:59',
                'updated_at' => '2024-10-24 20:01:59',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'NP-007/24',
                'name' => 'MANTENIMIENTO MENSUAL JULIO 2024',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2024-10-24 20:02:16',
                'updated_at' => '2024-10-24 20:02:16',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'NP-001-24',
            'name' => 'OBTURACIÓN 48" X16", 36" X 16" (MONOBOYAS)',
                'status' => 1,
                'company_id' => 1,
                'created_at' => '2024-10-24 20:02:33',
                'updated_at' => '2024-10-24 20:02:33',
            ),
        ));
        
        
    }
}