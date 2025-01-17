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
        ));
        
        
    }
}