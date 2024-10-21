<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StateHistoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('state_histories')->delete();
        
        \DB::table('state_histories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => NULL,
                'to' => 'borrador',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"id": {"new": 1, "old": null}, "type": {"new": "In aliquid quo accusamus exercitation fugiat tempo", "old": null}, "folio": {"new": "G-ISW-2024-0001", "old": null}, "status": {"new": "borrador", "old": null}, "company_id": {"new": 1, "old": null}, "created_at": {"new": "2024-10-17 18:52:21", "old": null}, "project_id": {"new": "1", "old": null}, "updated_at": {"new": "2024-10-17 18:52:21", "old": null}, "date_delivery": {"new": "2016-04-14 00:00:00", "old": null}, "delivery_address": {"new": "Modi beatae nisi nemo labore sequi dolores qui dignissimos incidunt tempora architecto ex", "old": null}, "approval_chain_id": {"new": 1, "old": null}}',
                'created_at' => '2024-10-17 18:52:21',
                'updated_at' => '2024-10-17 18:52:21',
            ),
            1 => 
            array (
                'id' => 2,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'field' => 'status',
                'from' => NULL,
                'to' => 'borrador',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"id": {"new": 2, "old": null}, "type": {"new": "Explicabo Qui nulla voluptatum ex in nihil dolore", "old": null}, "folio": {"new": "G-SG-2024-0002", "old": null}, "status": {"new": "borrador", "old": null}, "company_id": {"new": 1, "old": null}, "created_at": {"new": "2024-10-21 01:12:03", "old": null}, "project_id": {"new": "1", "old": null}, "updated_at": {"new": "2024-10-21 01:12:03", "old": null}, "date_delivery": {"new": "2022-11-21 00:00:00", "old": null}, "delivery_address": {"new": "Ullamco labore exercitation elit consequuntur dolorem aut aut similique sit eum aut duis in molestiae distinctio", "old": null}, "approval_chain_id": {"new": 2, "old": null}}',
                'created_at' => '2024-10-21 01:12:04',
                'updated_at' => '2024-10-21 01:12:04',
            ),
        ));
        
        
    }
}