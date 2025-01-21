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
                'folio' => 'G-ISW-2025-0001',
                'confidential' => 0,
                'motive' => 'Sapiente mollit quos nostrum qui saepe pariatur Ad quasi eum dolore cum natus',
                'observation' => 'Elit enim in magni molestiae beatae voluptas quis et maiores qui in id dolor aliquip quod a corporis itaque facilis',
                'date_delivery' => '2025-01-22',
                'delivery_address' => 'Eveniet molestiae sunt impedit veniam pariatur Et voluptatibus fugit qui commodo consequatur',
                'status' => 'comprador asignado',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 2,
                'approval_chain_id' => 2,
                'assign_user_id' => 298,
                'created_at' => '2025-01-21 16:01:12',
                'updated_at' => '2025-01-21 16:41:24',
            ),
            1 => 
            array (
                'id' => 2,
                'folio' => 'G-ISW-2025-0002',
                'confidential' => 0,
                'motive' => 'Iste ex harum autem omnis laboris non et non eum possimus nulla harum sed saepe nulla amet incidunt ratione ut',
                'observation' => 'Laboriosam nisi quis quos quis possimus consectetur minim ab pariatur Commodo minim eum qui dolorem accusamus irure',
                'date_delivery' => '2025-01-22',
                'delivery_address' => 'Et eius tempora eius molestiae',
                'status' => 'comprador asignado',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 4,
                'approval_chain_id' => 2,
                'assign_user_id' => 298,
                'created_at' => '2025-01-21 16:03:57',
                'updated_at' => '2025-01-21 16:41:10',
            ),
            2 => 
            array (
                'id' => 3,
                'folio' => 'G-ISW-2025-0003',
                'confidential' => 0,
                'motive' => 'Ut obcaecati id in eu omnis est',
                'observation' => 'Non consequat Et ullam qui cupiditate eos accusamus est optio cupiditate minim sunt nisi',
                'date_delivery' => '2025-01-22',
                'delivery_address' => 'Voluptatibus commodi ea suscipit earum cum consequuntur quae',
                'status' => 'comprador asignado',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 4,
                'approval_chain_id' => 2,
                'assign_user_id' => 274,
                'created_at' => '2025-01-21 16:17:39',
                'updated_at' => '2025-01-21 16:39:05',
            ),
            3 => 
            array (
                'id' => 4,
                'folio' => 'G-ISW-2025-0004',
                'confidential' => 0,
                'motive' => 'Necessitatibus possimus et eius autem voluptatem voluptatem provident nihil suscipit voluptatem tempor',
                'observation' => 'Rem aut quibusdam vel architecto quasi dolorum molestias nostrum sint nihil culpa in sit reprehenderit',
                'date_delivery' => '2025-01-23',
                'delivery_address' => 'Deleniti sed earum saepe occaecat',
                'status' => 'comprador asignado',
                'status_order' => NULL,
                'company_id' => 1,
                'project_id' => 3,
                'approval_chain_id' => 2,
                'assign_user_id' => 274,
                'created_at' => '2025-01-21 16:25:11',
                'updated_at' => '2025-01-21 16:37:06',
            ),
        ));
        
        
    }
}