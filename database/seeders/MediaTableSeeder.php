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
                'uuid' => 'b926a7b0-3675-4daf-9e69-4c3d4af5e8c5',
                'collection_name' => 'technical_data_sheets',
                'name' => 'OC Tech',
                'file_name' => '01JGY5G6DF6NAP41NPERV4C43P.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 740032,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'generated_conversions' => '[]',
                'responsive_images' => '[]',
                'order_column' => 1,
                'created_at' => '2025-01-06 15:59:54',
                'updated_at' => '2025-01-06 15:59:54',
            ),
            1 => 
            array (
                'id' => 2,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 1,
                'uuid' => 'ff9c8b2c-032a-4ea9-92fe-acac24d39f56',
                'collection_name' => 'supports',
                'name' => 'OC Tech',
                'file_name' => '01JGY5G6EJ2F90HD8R283RQ3ZH.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 740032,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'generated_conversions' => '[]',
                'responsive_images' => '[]',
                'order_column' => 2,
                'created_at' => '2025-01-06 15:59:54',
                'updated_at' => '2025-01-06 15:59:54',
            ),
            2 => 
            array (
                'id' => 3,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'uuid' => '11d0a132-fc97-4485-a334-bb7fa2f1d496',
                'collection_name' => 'technical_data_sheets',
            'name' => 'Estimacion de costo de proyectos para  Grupo Walworth (2)',
                'file_name' => '01JGY5K4SMQAG7TCKR1EYW75AX.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 68574,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'generated_conversions' => '[]',
                'responsive_images' => '[]',
                'order_column' => 1,
                'created_at' => '2025-01-06 16:01:30',
                'updated_at' => '2025-01-06 16:01:30',
            ),
            3 => 
            array (
                'id' => 4,
                'model_type' => 'App\\Models\\PurchaseRequisition',
                'model_id' => 2,
                'uuid' => 'd0b04158-6985-4ee6-90a1-02d9378ba5eb',
                'collection_name' => 'supports',
            'name' => 'Estimacion de costo de proyectos para  Grupo Walworth (2)',
                'file_name' => '01JGY5K4TEJTA7ZJSRQATXGS8P.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 68574,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'generated_conversions' => '[]',
                'responsive_images' => '[]',
                'order_column' => 2,
                'created_at' => '2025-01-06 16:01:30',
                'updated_at' => '2025-01-06 16:01:30',
            ),
        ));
        
        
    }
}