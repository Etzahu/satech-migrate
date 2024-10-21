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
        ));
        
        
    }
}