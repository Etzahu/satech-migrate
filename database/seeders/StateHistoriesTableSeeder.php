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
                'changed_attributes' => '{"id": {"new": 1, "old": null}, "folio": {"new": "G-VEN-2024-0001", "old": null}, "motive": {"new": "Fugiat libero consectetur pariatur Odit nesciunt sunt occaecat totam officia corrupti aut voluptatem Laboriosam vel dolorem cupiditate", "old": null}, "status": {"new": "borrador", "old": null}, "company_id": {"new": 1, "old": null}, "created_at": {"new": "2024-11-11 19:26:55", "old": null}, "project_id": {"new": "1", "old": null}, "updated_at": {"new": "2024-11-11 19:26:55", "old": null}, "observation": {"new": "Rerum omnis quis est quis magnam cumque illo amet ut quo laborum officia", "old": null}, "date_delivery": {"new": "2024-11-20 00:00:00", "old": null}, "delivery_address": {"new": "Reprehenderit consequuntur adipisci sed sequi facilis", "old": null}, "approval_chain_id": {"new": 1, "old": null}}',
                'created_at' => '2024-11-11 19:26:55',
                'updated_at' => '2024-11-11 19:26:55',
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
                'created_at' => '2024-11-11 19:32:46',
                'updated_at' => '2024-11-11 19:32:46',
            ),
            2 => 
            array (
                'id' => 3,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => 'revisión por almacén',
                'to' => 'revisión',
                'custom_properties' => '{"respuesta": "Quia numquam molesti"}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "revisión", "old": "revisión por almacén"}}',
                'created_at' => '2024-11-12 15:09:55',
                'updated_at' => '2024-11-12 15:09:55',
            ),
            3 => 
            array (
                'id' => 4,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'field' => 'status',
                'from' => NULL,
                'to' => 'borrador',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"id": {"new": 2, "old": null}, "folio": {"new": "G-VEN-2024-0002", "old": null}, "motive": {"new": "Ad veniam necessitatibus voluptas totam voluptatem magna consequatur deserunt perspiciatis ab voluptate est deleniti quasi molestiae accusantium", "old": null}, "status": {"new": "borrador", "old": null}, "company_id": {"new": 1, "old": null}, "created_at": {"new": "2024-11-12 15:13:26", "old": null}, "project_id": {"new": "1", "old": null}, "updated_at": {"new": "2024-11-12 15:13:26", "old": null}, "observation": {"new": "Aspernatur minima ducimus esse nisi aliqua Non", "old": null}, "date_delivery": {"new": "2024-11-13 00:00:00", "old": null}, "delivery_address": {"new": "Et qui voluptatem Qui iste nulla minim veritatis do qui similique at est non", "old": null}, "approval_chain_id": {"new": 2, "old": null}}',
                'created_at' => '2024-11-12 15:13:26',
                'updated_at' => '2024-11-12 15:13:26',
            ),
            4 => 
            array (
                'id' => 5,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'field' => 'status',
                'from' => 'borrador',
                'to' => 'revisión por almacén',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "revisión por almacén", "old": "borrador"}}',
                'created_at' => '2024-11-12 15:15:13',
                'updated_at' => '2024-11-12 15:15:13',
            ),
            5 => 
            array (
                'id' => 6,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => NULL,
                'to' => 'borrador',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"id": {"new": 1, "old": null}, "folio": {"new": "G-ALM-2024-0001", "old": null}, "motive": {"new": "Consequatur aliqua Temporibus harum deserunt qui quam provident fugiat repudiandae provident voluptates commodi iusto", "old": null}, "status": {"new": "borrador", "old": null}, "company_id": {"new": 1, "old": null}, "created_at": {"new": "2024-11-13 14:43:07", "old": null}, "project_id": {"new": "1", "old": null}, "updated_at": {"new": "2024-11-13 14:43:07", "old": null}, "observation": {"new": "Corporis amet eiusmod nostrum delectus ut", "old": null}, "confidential": {"new": true, "old": null}, "date_delivery": {"new": "2024-11-15 00:00:00", "old": null}, "delivery_address": {"new": "Expedita nostrum dolorem et ut quaerat ea impedit odit tempor ea a molestiae non ipsum aut eum", "old": null}}',
                'created_at' => '2024-11-13 14:43:07',
                'updated_at' => '2024-11-13 14:43:07',
            ),
            6 => 
            array (
                'id' => 7,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'field' => 'status',
                'from' => NULL,
                'to' => 'borrador',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"id": {"new": 2, "old": null}, "folio": {"new": "G-ALM-2024-0001", "old": null}, "motive": {"new": "Mollit minim exercitation et nihil excepturi cupidatat est aut", "old": null}, "status": {"new": "borrador", "old": null}, "company_id": {"new": 1, "old": null}, "created_at": {"new": "2024-11-13 14:43:43", "old": null}, "project_id": {"new": "1", "old": null}, "updated_at": {"new": "2024-11-13 14:43:43", "old": null}, "observation": {"new": "Repudiandae rerum earum illo voluptatem quisquam enim inventore hic excepteur eius magni voluptatem sequi", "old": null}, "confidential": {"new": false, "old": null}, "date_delivery": {"new": "2024-11-28 00:00:00", "old": null}, "delivery_address": {"new": "Sit quaerat eos obcaecati inventore quae labore eiusmod aut iste", "old": null}, "approval_chain_id": {"new": 1, "old": null}}',
                'created_at' => '2024-11-13 14:43:43',
                'updated_at' => '2024-11-13 14:43:43',
            ),
            7 => 
            array (
                'id' => 8,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 3,
                'field' => 'status',
                'from' => NULL,
                'to' => 'borrador',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"id": {"new": 3, "old": null}, "folio": {"new": "G-ALM-2024-0002", "old": null}, "motive": {"new": "Cillum quia error sit in", "old": null}, "status": {"new": "borrador", "old": null}, "company_id": {"new": 1, "old": null}, "created_at": {"new": "2024-11-13 14:48:20", "old": null}, "project_id": {"new": "1", "old": null}, "updated_at": {"new": "2024-11-13 14:48:20", "old": null}, "observation": {"new": "Omnis consequatur soluta eos aut", "old": null}, "confidential": {"new": true, "old": null}, "date_delivery": {"new": "2024-11-15 00:00:00", "old": null}, "delivery_address": {"new": "Commodo consectetur corrupti sed ut cillum rerum proident voluptate et qui sit iure perferendis sint ullam dolore eos pariatur", "old": null}, "approval_chain_id": {"new": 1, "old": null}}',
                'created_at' => '2024-11-13 14:48:20',
                'updated_at' => '2024-11-13 14:48:20',
            ),
            8 => 
            array (
                'id' => 9,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 3,
                'field' => 'status',
                'from' => 'borrador',
                'to' => 'aprobado por revisor',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "aprobado por revisor", "old": "borrador"}}',
                'created_at' => '2024-11-13 15:31:13',
                'updated_at' => '2024-11-13 15:31:13',
            ),
            9 => 
            array (
                'id' => 10,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 3,
                'field' => 'status',
                'from' => 'aprobado por revisor',
                'to' => 'aprobado por gerencia',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 331,
                'changed_attributes' => '{"status": {"new": "aprobado por gerencia", "old": "aprobado por revisor"}}',
                'created_at' => '2024-11-13 16:16:54',
                'updated_at' => '2024-11-13 16:16:54',
            ),
            10 => 
            array (
                'id' => 11,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 3,
                'field' => 'status',
                'from' => 'aprobado por gerencia',
                'to' => 'aprobado por DG',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "aprobado por DG", "old": "aprobado por gerencia"}}',
                'created_at' => '2024-11-13 17:03:49',
                'updated_at' => '2024-11-13 17:03:49',
            ),
            11 => 
            array (
                'id' => 12,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 3,
                'field' => 'status',
                'from' => 'aprobado por gerencia',
                'to' => 'aprobado por DG',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "aprobado por DG", "old": "aprobado por gerencia"}}',
                'created_at' => '2024-11-13 17:05:17',
                'updated_at' => '2024-11-13 17:05:17',
            ),
            12 => 
            array (
                'id' => 13,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 3,
                'field' => 'status',
                'from' => 'aprobado por gerencia',
                'to' => 'aprobado por DG',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "aprobado por DG", "old": "aprobado por gerencia"}}',
                'created_at' => '2024-11-13 17:05:52',
                'updated_at' => '2024-11-13 17:05:52',
            ),
            13 => 
            array (
                'id' => 14,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 3,
                'field' => 'status',
                'from' => 'aprobado por gerencia',
                'to' => 'aprobado por DG',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "aprobado por DG", "old": "aprobado por gerencia"}}',
                'created_at' => '2024-11-13 17:06:07',
                'updated_at' => '2024-11-13 17:06:07',
            ),
            14 => 
            array (
                'id' => 15,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => NULL,
                'to' => 'borrador',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"id": {"new": 1, "old": null}, "folio": {"new": "G-ALM-2024-0001", "old": null}, "motive": {"new": "Non aut tempora et ut in iure voluptas debitis hic ut facilis molestiae nulla", "old": null}, "status": {"new": "borrador", "old": null}, "company_id": {"new": 1, "old": null}, "created_at": {"new": "2024-11-14 16:31:09", "old": null}, "project_id": {"new": "1", "old": null}, "updated_at": {"new": "2024-11-14 16:31:09", "old": null}, "observation": {"new": "Aliquid sapiente iusto iusto praesentium ut in ut quia sed vel voluptates sunt voluptas", "old": null}, "confidential": {"new": false, "old": null}, "date_delivery": {"new": "2024-11-15 00:00:00", "old": null}, "delivery_address": {"new": "Quis suscipit molestiae officia natus dolore tempor soluta nulla aspernatur omnis", "old": null}, "approval_chain_id": {"new": 1, "old": null}}',
                'created_at' => '2024-11-14 16:31:09',
                'updated_at' => '2024-11-14 16:31:09',
            ),
            15 => 
            array (
                'id' => 16,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => 'borrador',
                'to' => 'revisión por almacén',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "revisión por almacén", "old": "borrador"}}',
                'created_at' => '2024-11-14 16:34:35',
                'updated_at' => '2024-11-14 16:34:35',
            ),
            16 => 
            array (
                'id' => 17,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => 'revisión por almacén',
                'to' => 'revisión',
                'custom_properties' => '{"respuesta": "Voluptate a consequa"}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 250,
                'changed_attributes' => '{"status": {"new": "revisión", "old": "revisión por almacén"}}',
                'created_at' => '2024-11-14 16:35:19',
                'updated_at' => '2024-11-14 16:35:19',
            ),
            17 => 
            array (
                'id' => 18,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => 'revisión',
                'to' => 'aprobado por revisor',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 152,
                'changed_attributes' => '{"status": {"new": "aprobado por revisor", "old": "revisión"}}',
                'created_at' => '2024-11-14 16:35:50',
                'updated_at' => '2024-11-14 16:35:50',
            ),
            18 => 
            array (
                'id' => 19,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => 'aprobado por revisor',
                'to' => 'aprobado por gerencia',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 331,
                'changed_attributes' => '{"status": {"new": "aprobado por gerencia", "old": "aprobado por revisor"}}',
                'created_at' => '2024-11-14 16:36:12',
                'updated_at' => '2024-11-14 16:36:12',
            ),
            19 => 
            array (
                'id' => 20,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => 'aprobado por gerencia',
                'to' => 'aprobado por DG',
                'custom_properties' => '{"respuesta": null}',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 106,
                'changed_attributes' => '{"status": {"new": "aprobado por DG", "old": "aprobado por gerencia"}}',
                'created_at' => '2024-11-14 16:36:33',
                'updated_at' => '2024-11-14 16:36:33',
            ),
            20 => 
            array (
                'id' => 21,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'field' => 'status',
                'from' => 'aprobado por DG',
                'to' => 'comprador asignado',
                'custom_properties' => '[]',
                'responsible_type' => 'App\\Models\\User',
                'responsible_id' => 199,
                'changed_attributes' => '{"status": {"new": "comprador asignado", "old": "aprobado por DG"}}',
                'created_at' => '2024-11-21 17:09:20',
                'updated_at' => '2024-11-21 17:09:20',
            ),
        ));
        
        
    }
}