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
                'id' => 2,
                'folio' => 'G-SG25-002',
                'currency' => 'MXN',
                'type_payment' => 'PUE - Pago en una sola exhibición',
                'discount' => 0,
                'form_payment' => 'transferencia',
                'term_payment' => '15 días',
                'condition_payment' => 'Deserunt non dolorem',
                'quote_folio' => 'Distinctio At illum',
                'use_cfdi' => 'G02-Devoluciones y descuentos sobre compras',
                'shipping_method' => 'Nostrud fuga Vel no',
                'tax_iva' => 0,
                'retention_iva' => '0.000',
                'retention_isr' => '0.000',
                'retention_another' => '0.000',
                'initial_delivery_date' => '2025-01-14',
                'final_delivery_date' => '2025-01-16',
                'delivery_address' => '',
                'documentation_delivery' => '',
                'observations' => '.',
                'status' => 'aprobada para emisión',
                'provider_id' => 295,
                'provider_contact_id' => 413,
                'purchaser_user_id' => 199,
                'company_id' => 1,
                'requisition_id' => 2,
                'created_at' => '2025-01-13 15:34:08',
                'updated_at' => '2025-01-14 13:40:06',
            ),
            1 => 
            array (
                'id' => 3,
                'folio' => 'G-SG25-003',
                'currency' => 'MXN',
                'type_payment' => 'PPD - Pago en parcialidades o diferido',
                'discount' => 0,
                'form_payment' => 'transferencia',
                'term_payment' => '60 días',
                'condition_payment' => 'Eu quis occaecat est',
                'quote_folio' => 'Ea dolore qui anim s',
                'use_cfdi' => 'G03-Gastos en general',
                'shipping_method' => 'Excepteur soluta omn',
                'tax_iva' => 16,
                'retention_iva' => '0.000',
                'retention_isr' => '0.000',
                'retention_another' => '0.000',
                'initial_delivery_date' => '2025-01-16',
                'final_delivery_date' => '2025-01-17',
                'delivery_address' => '',
                'documentation_delivery' => '',
                'observations' => 'Pariatur Nesciunt ',
                'status' => 'borrador',
                'provider_id' => 343,
                'provider_contact_id' => 433,
                'purchaser_user_id' => 199,
                'company_id' => 1,
                'requisition_id' => 2,
                'created_at' => '2025-01-15 15:36:55',
                'updated_at' => '2025-01-15 15:36:55',
            ),
            2 => 
            array (
                'id' => 4,
                'folio' => 'G-SG25-004',
                'currency' => 'MXN',
                'type_payment' => 'PUE - Pago en una sola exhibición',
                'discount' => 0,
                'form_payment' => 'transferencia',
                'term_payment' => 'contado',
                'condition_payment' => 'Aliquam nisi et eu e',
                'quote_folio' => 'Sunt sit ab aute et ',
                'use_cfdi' => '105-Dados, troqueles, moldes, matrices y herramental',
                'shipping_method' => 'Sed quam facilis vol',
                'tax_iva' => 16,
                'retention_iva' => '0.000',
                'retention_isr' => '0.000',
                'retention_another' => '0.000',
                'initial_delivery_date' => '1971-10-06',
                'final_delivery_date' => '2014-01-23',
                'delivery_address' => 'Vitae aliquid non ra',
                'documentation_delivery' => '[{"name":"Serena Weaver"},{"name":"pp"}]',
                'observations' => 'Non sed quas dolor v',
                'status' => 'borrador',
                'provider_id' => 311,
                'provider_contact_id' => 246,
                'purchaser_user_id' => 199,
                'company_id' => 1,
                'requisition_id' => 2,
                'created_at' => '2025-01-17 20:03:47',
                'updated_at' => '2025-01-17 20:03:47',
            ),
        ));
        
        
    }
}