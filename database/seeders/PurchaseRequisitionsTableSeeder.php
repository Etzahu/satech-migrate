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
                'folio' => 'G-SG-2025-0001',
                'confidential' => 0,
                'motive' => 'Aliquid aperiam exce',
                'priority' => 'baja',
                'type' => 'compra',
                'observation' => '.',
                'date_delivery' => '2025-02-01',
                'delivery_address' => 'Mollitia harum harum',
                'status' => 'comprador asignado',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 2,
                'approval_chain_id' => 2,
                'assign_user_id' => 274,
                'created_at' => '2025-01-25 01:21:59',
                'updated_at' => '2025-01-25 01:34:25',
            ),
            1 => 
            array (
                'id' => 2,
                'folio' => 'G-SG-2025-0002',
                'confidential' => 0,
                'motive' => 'Itaque vel voluptati',
                'priority' => 'baja',
                'type' => 'compra',
                'observation' => '.',
                'date_delivery' => '2025-01-26',
                'delivery_address' => 'Fugit quae et nesci',
                'status' => 'revisión',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 5,
                'approval_chain_id' => 2,
                'assign_user_id' => NULL,
                'created_at' => '2025-01-25 02:41:51',
                'updated_at' => '2025-01-25 02:46:11',
            ),
            2 => 
            array (
                'id' => 3,
                'folio' => 'G-ING-2025-0001',
                'confidential' => 0,
                'motive' => 'Consequuntur aut omn',
                'priority' => 'baja',
                'type' => 'cotización',
                'observation' => '.',
                'date_delivery' => '2025-01-28',
                'delivery_address' => 'Ipsam voluptas quibu',
                'status' => 'revisión',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 4,
                'approval_chain_id' => 51,
                'assign_user_id' => NULL,
                'created_at' => '2025-01-25 02:59:23',
                'updated_at' => '2025-01-25 03:00:03',
            ),
            3 => 
            array (
                'id' => 4,
                'folio' => 'G-ING-2025-0002',
                'confidential' => 0,
                'motive' => 'Ut et nisi veniam e',
                'priority' => 'baja',
                'type' => 'compra',
                'observation' => 'p',
                'date_delivery' => '2025-01-28',
                'delivery_address' => 'Molestias accusantiu',
                'status' => 'borrador',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 4,
                'approval_chain_id' => 51,
                'assign_user_id' => NULL,
                'created_at' => '2025-01-25 03:07:13',
                'updated_at' => '2025-01-25 03:07:13',
            ),
            4 => 
            array (
                'id' => 5,
                'folio' => 'G-SG-2025-0003',
                'confidential' => 0,
                'motive' => 'Aut aliquid maxime n',
                'priority' => 'baja',
                'type' => 'compra',
                'observation' => 'Sin observaciones',
                'date_delivery' => '2025-01-25',
                'delivery_address' => 'Ullam praesentium au',
                'status' => 'aprobado por DG',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 5,
                'approval_chain_id' => 2,
                'assign_user_id' => NULL,
                'created_at' => '2025-01-25 04:28:41',
                'updated_at' => '2025-01-25 04:34:04',
            ),
        ));
        
        
    }
}