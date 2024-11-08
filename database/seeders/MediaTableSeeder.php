<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MediaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('media')->delete();
        
        \DB::table('media')->insert(array (
            0 => 
            array (
                'id' => 1,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'uuid' => '98cf6cd1-3d7d-4a7a-970e-ca8ba6f40787',
                'collection_name' => 'additional_documents',
                'name' => 'Folio_480',
                'file_name' => '01JADX5QZ97VB7ZE6ZCF5D943C.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 30801,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'generated_conversions' => '[]',
                'responsive_images' => '[]',
                'order_column' => 1,
                'created_at' => '2024-10-17 18:52:21',
                'updated_at' => '2024-10-17 18:52:21',
            ),
            1 => 
            array (
                'id' => 2,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'uuid' => 'c06da53d-9424-4b51-84fc-4be787a3be5a',
                'collection_name' => 'technical_data_sheets',
            'name' => 'Estimacion de costo de proyectos para  Grupo Walworth (2)',
                'file_name' => '01JBW3GQE8077E59ZJKW8YWBB4.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 68574,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'generated_conversions' => '[]',
                'responsive_images' => '[]',
                'order_column' => 1,
                'created_at' => '2024-11-04 17:28:16',
                'updated_at' => '2024-11-04 17:28:16',
            ),
            2 => 
            array (
                'id' => 3,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'uuid' => 'ab800888-0e0c-419e-9209-6da043fabfd5',
                'collection_name' => 'supports',
                'name' => 'Prueba de impresion',
                'file_name' => '01JBW3GQFZV7G13V9A1SBXFP51.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 182871,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'generated_conversions' => '[]',
                'responsive_images' => '[]',
                'order_column' => 2,
                'created_at' => '2024-11-04 17:28:16',
                'updated_at' => '2024-11-04 17:28:16',
            ),
        ));
        
        
    }
}