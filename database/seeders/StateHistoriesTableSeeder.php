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
                'changed_attributes' => '{"id": {"new": 1, "old": null}, "folio": {"new": "G-SC-2025-0001", "old": null}, "motive": {"new": "Autem consectetur in vitae consequatur qui dolorem", "old": null}, "status": {"new": "borrador", "old": null}, "company_id": {"new": 1, "old": null}, "created_at": {"new": "2025-01-06 15:59:54", "old": null}, "project_id": {"new": "1", "old": null}, "updated_at": {"new": "2025-01-06 15:59:54", "old": null}, "observation": {"new": "Quis voluptatum quo aliquid nisi quos dolor est voluptatum ab", "old": null}, "confidential": {"new": false, "old": null}, "date_delivery": {"new": "2025-01-07 00:00:00", "old": null}, "delivery_address": {"new": "Fugiat eos quis sit iusto sit odit ut", "old": null}, "approval_chain_id": {"new": 2, "old": null}}',
                'created_at' => '2025-01-06 15:59:54',
                'updated_at' => '2025-01-06 15:59:54',
            ),
            1 => 
            array (
                'id' => 2,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => 'borrador',
                'to' => 'revisión por almacén',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "revisión por almacén", "old": "borrador"}}',
                'created_at' => '2025-01-06 16:00:57',
                'updated_at' => '2025-01-06 16:00:57',
            ),
            2 => 
            array (
                'id' => 3,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'field' => 'status',
                'from' => NULL,
                'to' => 'borrador',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"id": {"new": 2, "old": null}, "folio": {"new": "G-SC-2025-0002", "old": null}, "motive": {"new": "Amet sint et laborum Tempor consectetur iure ut error et impedit excepturi explicabo Fuga Veniam ipsa eaque aliqua Rem", "old": null}, "status": {"new": "borrador", "old": null}, "company_id": {"new": 1, "old": null}, "created_at": {"new": "2025-01-06 16:01:30", "old": null}, "project_id": {"new": "1", "old": null}, "updated_at": {"new": "2025-01-06 16:01:30", "old": null}, "observation": {"new": "Perspiciatis dolor neque veniam est fuga Exercitation nihil reiciendis fuga Vel dolor", "old": null}, "confidential": {"new": false, "old": null}, "date_delivery": {"new": "2025-01-07 00:00:00", "old": null}, "delivery_address": {"new": "Sint eum labore ut ad recusandae Id aliquid lorem laborum cupidatat nulla neque nisi incidunt laborum", "old": null}, "approval_chain_id": {"new": 2, "old": null}}',
                'created_at' => '2025-01-06 16:01:30',
                'updated_at' => '2025-01-06 16:01:30',
            ),
            3 => 
            array (
                'id' => 4,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'field' => 'status',
                'from' => 'borrador',
                'to' => 'revisión por almacén',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "revisión por almacén", "old": "borrador"}}',
                'created_at' => '2025-01-06 16:01:52',
                'updated_at' => '2025-01-06 16:01:52',
            ),
            4 => 
            array (
                'id' => 5,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'field' => 'status',
                'from' => 'revisión por almacén',
                'to' => 'revisión',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "revisión", "old": "revisión por almacén"}}',
                'created_at' => '2025-01-06 16:02:05',
                'updated_at' => '2025-01-06 16:02:05',
            ),
            5 => 
            array (
                'id' => 6,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => 'revisión por almacén',
                'to' => 'revisión',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "revisión", "old": "revisión por almacén"}}',
                'created_at' => '2025-01-06 16:02:11',
                'updated_at' => '2025-01-06 16:02:11',
            ),
            6 => 
            array (
                'id' => 7,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'field' => 'status',
                'from' => 'revisión',
                'to' => 'aprobado por revisor',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "aprobado por revisor", "old": "revisión"}}',
                'created_at' => '2025-01-06 16:02:29',
                'updated_at' => '2025-01-06 16:02:29',
            ),
            7 => 
            array (
                'id' => 8,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => 'revisión',
                'to' => 'aprobado por revisor',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "aprobado por revisor", "old": "revisión"}}',
                'created_at' => '2025-01-06 16:02:36',
                'updated_at' => '2025-01-06 16:02:36',
            ),
            8 => 
            array (
                'id' => 9,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'field' => 'status',
                'from' => 'aprobado por revisor',
                'to' => 'aprobado por gerencia',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 331,
                'changed_attributes' => '{"status": {"new": "aprobado por gerencia", "old": "aprobado por revisor"}}',
                'created_at' => '2025-01-06 16:02:58',
                'updated_at' => '2025-01-06 16:02:58',
            ),
            9 => 
            array (
                'id' => 10,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => 'aprobado por revisor',
                'to' => 'aprobado por gerencia',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 331,
                'changed_attributes' => '{"status": {"new": "aprobado por gerencia", "old": "aprobado por revisor"}}',
                'created_at' => '2025-01-06 16:03:06',
                'updated_at' => '2025-01-06 16:03:06',
            ),
            10 => 
            array (
                'id' => 11,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'field' => 'status',
                'from' => 'aprobado por gerencia',
                'to' => 'aprobado por DG',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "aprobado por DG", "old": "aprobado por gerencia"}}',
                'created_at' => '2025-01-06 16:03:20',
                'updated_at' => '2025-01-06 16:03:20',
            ),
            11 => 
            array (
                'id' => 12,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => 'aprobado por gerencia',
                'to' => 'aprobado por DG',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "aprobado por DG", "old": "aprobado por gerencia"}}',
                'created_at' => '2025-01-06 16:03:26',
                'updated_at' => '2025-01-06 16:03:26',
            ),
            12 => 
            array (
                'id' => 13,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'field' => 'status',
                'from' => 'aprobado por DG',
                'to' => 'comprador asignado',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "comprador asignado", "old": "aprobado por DG"}}',
                'created_at' => '2025-01-06 16:05:42',
                'updated_at' => '2025-01-06 16:05:42',
            ),
            13 => 
            array (
                'id' => 14,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => 'aprobado por DG',
                'to' => 'comprador asignado',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "comprador asignado", "old": "aprobado por DG"}}',
                'created_at' => '2025-01-06 16:05:54',
                'updated_at' => '2025-01-06 16:05:54',
            ),
        ));
        
        
    }
}