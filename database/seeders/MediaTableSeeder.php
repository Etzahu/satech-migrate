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
                'model_id' => 1,
                'uuid' => '6d6bf7d8-5aa4-49e2-844a-934625aa7941',
                'collection_name' => 'technical_data_sheets',
                'name' => 'Comida de fin de año 2024',
                'file_name' => '01JFDMD2QAV2AXZ95KNW9H7FBH.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 129990,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'generated_conversions' => '[]',
                'responsive_images' => '[]',
                'order_column' => 2,
                'created_at' => '2024-12-18 19:37:33',
                'updated_at' => '2024-12-18 19:37:33',
            ),
            2 => 
            array (
                'id' => 3,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'uuid' => 'e6c9629b-fcc5-481e-8e0b-747662ef16e6',
                'collection_name' => 'supports',
                'name' => 'Comida de fin de año 2024',
                'file_name' => '01JFDMD2RVS8WVAERY32SVFQQH.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 129990,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'generated_conversions' => '[]',
                'responsive_images' => '[]',
                'order_column' => 3,
                'created_at' => '2024-12-18 19:37:33',
                'updated_at' => '2024-12-18 19:37:33',
            ),
        ));
        
        
    }
}