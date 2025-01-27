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
                'type_payment' => 'PUE - Pago en una sola exhibición',
                'discount' => 0,
                'form_payment' => 'efectivo',
                'term_payment' => '15 días',
                'condition_payment' => 'Facere consequatur ',
                'quote_folio' => 'Perferendis consecte',
                'use_cfdi' => '105-Dados, troqueles, moldes, matrices y herramental',
                'shipping_method' => 'Maiores possimus qu',
                'tax_iva' => 8,
                'retention_iva' => '0.000',
                'retention_isr' => '0.000',
                'retention_another' => '0.000',
                'initial_delivery_date' => '2025-01-26',
                'final_delivery_date' => '2025-01-28',
                'delivery_address' => 'Almacén, Av. Santa Mónica No.33, Col El Mirador, Tlalnepantla de Baz, Estado de México 54080.',
                'observations' => '.',
                'documentation_delivery' => '[{"name": "Copia de remisión y/o Factura"}, {"name": "Orden de compra"}, {"name": "Certificados de calidad"}]',
                'status' => 'borrador',
                'provider_id' => 299,
                'provider_contact_id' => 208,
                'purchaser_user_id' => 274,
                'company_id' => 1,
                'requisition_id' => 1,
                'created_at' => '2025-01-26 04:14:05',
                'updated_at' => '2025-01-26 04:14:05',
            ),
        ));
        
        
    }
}