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
                'folio' => 'G-ISW25-002',
                'currency' => 'MXN',
                'type_payment' => 'PUE - Pago en una sola exhibición',
                'discount' => 0,
                'form_payment' => 'transferencia',
                'term_payment' => '30 días',
                'condition_payment' => 'Sint maxime alias of',
                'quote_folio' => 'Sapiente sed dolore ',
                'use_cfdi' => '105-Dados, troqueles, moldes, matrices y herramental',
                'shipping_method' => 'Tenetur cumque place',
                'tax_iva' => 0,
                'retention_iva' => '0.000',
                'retention_isr' => '0.000',
                'retention_another' => '0.000',
                'initial_delivery_date' => '2025-01-22',
                'final_delivery_date' => '2025-01-24',
                'delivery_address' => 'Almacén, Av. Santa Mónica No.33, Col El Mirador, Tlalnepantla de Baz, Estado de México 54080.',
                'observations' => 'test',
                'documentation_delivery' => '[{"name": "Copia de remisión y/o Factura"}, {"name": "Orden de compra"}, {"name": "Certificados de calidad"}]',
                'status' => 'aprobado por gerente solicitante',
                'provider_id' => 297,
                'provider_contact_id' => 205,
                'purchaser_user_id' => 274,
                'company_id' => 1,
                'requisition_id' => 4,
                'created_at' => '2025-01-21 17:18:31',
                'updated_at' => '2025-01-21 18:06:11',
            ),
        ));
        
        
    }
}