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
                'status' => 'autorizada para proveedor',
                'provider_id' => 297,
                'provider_contact_id' => 205,
                'purchaser_user_id' => 274,
                'company_id' => 1,
                'requisition_id' => 4,
                'created_at' => '2025-01-21 17:18:31',
                'updated_at' => '2025-01-21 18:41:36',
            ),
            1 => 
            array (
                'id' => 2,
                'folio' => 'G-ISW25-003',
                'currency' => 'MXN',
                'type_payment' => 'PUE - Pago en una sola exhibición',
                'discount' => 0,
                'form_payment' => 'transferencia',
                'term_payment' => '30 días',
                'condition_payment' => 'Hic rem ipsa aliqua',
                'quote_folio' => 'Sapiente perferendis',
                'use_cfdi' => '101-Construcciones',
                'shipping_method' => 'Aut dicta architecto',
                'tax_iva' => 16,
                'retention_iva' => '0.000',
                'retention_isr' => '0.000',
                'retention_another' => '0.000',
                'initial_delivery_date' => '2025-01-23',
                'final_delivery_date' => '2025-01-24',
                'delivery_address' => 'Almacén, Av. Santa Mónica No.33, Col El Mirador, Tlalnepantla de Baz, Estado de México 54080.',
                'observations' => 'test',
                'documentation_delivery' => '[{"name": "Copia de remisión y/o Factura"}, {"name": "Orden de compra"}, {"name": "Certificados de calidad"}]',
                'status' => 'aprobado por gerente solicitante',
                'provider_id' => 299,
                'provider_contact_id' => 208,
                'purchaser_user_id' => 274,
                'company_id' => 1,
                'requisition_id' => 4,
                'created_at' => '2025-01-22 15:04:00',
                'updated_at' => '2025-01-22 15:07:36',
            ),
            2 => 
            array (
                'id' => 3,
                'folio' => 'G-ISW25-004',
                'currency' => 'MXN',
                'type_payment' => 'PUE - Pago en una sola exhibición',
                'discount' => 0,
                'form_payment' => 'efectivo',
                'term_payment' => '60 días',
                'condition_payment' => 'Alias adipisci eum e',
                'quote_folio' => 'Ad a dignissimos quo',
                'use_cfdi' => '104-Equipo de cómputo y accesorios',
                'shipping_method' => 'Quos porro praesenti',
                'tax_iva' => 8,
                'retention_iva' => '0.000',
                'retention_isr' => '0.000',
                'retention_another' => '0.000',
                'initial_delivery_date' => '2025-01-23',
                'final_delivery_date' => '2025-01-23',
                'delivery_address' => 'Almacén, Av. Santa Mónica No.33, Col El Mirador, Tlalnepantla de Baz, Estado de México 54080.',
                'observations' => 'prueba',
                'documentation_delivery' => '[{"name": "Copia de remisión y/o Factura"}, {"name": "Orden de compra"}, {"name": "Certificados de calidad"}]',
                'status' => 'borrador',
                'provider_id' => 297,
                'provider_contact_id' => 205,
                'purchaser_user_id' => 274,
                'company_id' => 1,
                'requisition_id' => 4,
                'created_at' => '2025-01-22 17:49:47',
                'updated_at' => '2025-01-22 17:49:47',
            ),
            3 => 
            array (
                'id' => 4,
                'folio' => 'G-ISW25-005',
                'currency' => 'MXN',
                'type_payment' => 'PPD - Pago en parcialidades o diferido',
                'discount' => 0,
                'form_payment' => 'efectivo',
                'term_payment' => '45 días',
                'condition_payment' => 'Eiusmod necessitatib',
                'quote_folio' => 'Et in omnis ut magna',
                'use_cfdi' => '102-Mobiliario y equipo de oficina por inversiones',
                'shipping_method' => 'Commodi dolore perfe',
                'tax_iva' => 16,
                'retention_iva' => '0.000',
                'retention_isr' => '0.000',
                'retention_another' => '0.000',
                'initial_delivery_date' => '2025-01-23',
                'final_delivery_date' => '2025-01-24',
                'delivery_address' => 'Almacén, Av. Santa Mónica No.33, Col El Mirador, Tlalnepantla de Baz, Estado de México 54080.',
                'observations' => 'prueba',
                'documentation_delivery' => '[{"name": "Copia de remisión y/o Factura"}, {"name": "Orden de compra"}, {"name": "Certificados de calidad"}]',
                'status' => 'borrador',
                'provider_id' => 297,
                'provider_contact_id' => 205,
                'purchaser_user_id' => 274,
                'company_id' => 1,
                'requisition_id' => 3,
                'created_at' => '2025-01-22 17:53:44',
                'updated_at' => '2025-01-22 17:53:44',
            ),
            4 => 
            array (
                'id' => 5,
                'folio' => 'G-ISW25-006',
                'currency' => 'MXN',
                'type_payment' => 'PUE - Pago en una sola exhibición',
                'discount' => 0,
                'form_payment' => 'efectivo',
                'term_payment' => 'contado',
                'condition_payment' => 'Quos maiores dolor p',
                'quote_folio' => 'Rerum adipisicing la',
                'use_cfdi' => 'G03-Gastos en general',
                'shipping_method' => 'Dolorem eiusmod inci',
                'tax_iva' => 8,
                'retention_iva' => '0.000',
                'retention_isr' => '0.000',
                'retention_another' => '0.000',
                'initial_delivery_date' => '2025-01-23',
                'final_delivery_date' => '2025-01-24',
                'delivery_address' => 'Almacén, Av. Santa Mónica No.33, Col El Mirador, Tlalnepantla de Baz, Estado de México 54080.',
                'observations' => 'p',
                'documentation_delivery' => '[{"name": "Copia de remisión y/o Factura"}, {"name": "Orden de compra"}, {"name": "Certificados de calidad"}]',
                'status' => 'aprobado por DG nivel 1',
                'provider_id' => 297,
                'provider_contact_id' => 205,
                'purchaser_user_id' => 274,
                'company_id' => 1,
                'requisition_id' => 3,
                'created_at' => '2025-01-22 17:55:00',
                'updated_at' => '2025-01-22 18:10:29',
            ),
        ));
        
        
    }
}