<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseRequisitionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_requisitions')->delete();
        
        \DB::table('purchase_requisitions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'folio' => 'G-SC-2025-0001',
                'confidential' => 0,
                'motive' => 'Autem consectetur in vitae consequatur qui dolorem',
                'observation' => 'Quis voluptatum quo aliquid nisi quos dolor est voluptatum ab',
                'date_delivery' => '2025-01-07',
                'delivery_address' => 'Fugiat eos quis sit iusto sit odit ut',
                'status' => 'comprador asignado',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 1,
                'approval_chain_id' => 2,
                'assign_user_id' => 199,
                'created_at' => '2025-01-06 15:59:54',
                'updated_at' => '2025-01-06 16:05:54',
            ),
            1 => 
            array (
                'id' => 2,
                'folio' => 'G-SC-2025-0002',
                'confidential' => 0,
                'motive' => 'Amet sint et laborum Tempor consectetur iure ut error et impedit excepturi explicabo Fuga Veniam ipsa eaque aliqua Rem',
                'observation' => 'Perspiciatis dolor neque veniam est fuga Exercitation nihil reiciendis fuga Vel dolor',
                'date_delivery' => '2025-01-07',
                'delivery_address' => 'Sint eum labore ut ad recusandae Id aliquid lorem laborum cupidatat nulla neque nisi incidunt laborum',
                'status' => 'comprador asignado',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 1,
                'approval_chain_id' => 2,
                'assign_user_id' => 199,
                'created_at' => '2025-01-06 16:01:30',
                'updated_at' => '2025-01-06 16:05:42',
            ),
        ));
        
        
    }
}