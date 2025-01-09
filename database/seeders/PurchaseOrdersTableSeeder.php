<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseOrdersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_orders')->delete();
        
        \DB::table('purchase_orders')->insert(array (
            0 => 
            array (
                'id' => 1,
                'folio' => 'G-SG25-002',
                'currency' => 'MXN',
                'type_payment' => 'PPD - Pago en parcialidades o diferido',
                'discount' => 10000,
                'form_payment' => 'efectivo',
                'term_payment' => 'contado',
                'condition_payment' => 'Rerum magna voluptas',
                'quote_folio' => 'Illo et porro ducimu',
                'use_cfdi' => '105-Dados, troqueles, moldes, matrices y herramental',
                'shipping_method' => 'Nostrud error pariat',
                'tax_iva' => 8,
                'retention_iva' => '5.000',
                'retention_isr' => '5.000',
                'retention_another' => '0.000',
                'initial_delivery_date' => '2025-01-10',
                'final_delivery_date' => '2025-01-10',
                'observations' => 'Harum anim non sint',
                'status' => 'aprobado por gerente solicitante',
                'provider_id' => 297,
                'purchaser_user_id' => 199,
                'company_id' => 1,
                'requisition_id' => 1,
                'created_at' => '2025-01-09 17:55:50',
                'updated_at' => '2025-01-09 18:04:57',
            ),
        ));
        
        
    }
}