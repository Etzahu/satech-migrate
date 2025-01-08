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
                'folio' => 'G-SC25-002',
                'currency' => 'MXN',
                'type_payment' => 'PPD - Pago en parcialidades o diferido',
                'discount' => 0,
                'form_payment' => 'transferencia',
                'term_payment' => '15 días',
                'condition_payment' => 'Eos dolore in enim ',
                'quote_folio' => 'Ut voluptas et odit ',
                'use_cfdi' => '102-Mobiliario y equipo de oficina por inversiones',
                'shipping_method' => 'Nostrum consequatur ',
                'tax_iva' => 8,
                'retention_iva' => '0.000',
                'retention_isr' => '0.000',
                'retention_another' => '0.000',
                'initial_delivery_date' => '2025-01-07',
                'final_delivery_date' => '2025-01-08',
                'observations' => 'Voluptatum tenetur o',
                'status' => 'aprobada para emisión',
                'provider_id' => 3,
                'purchaser_user_id' => 199,
                'company_id' => 1,
                'requisition_id' => 2,
                'created_at' => '2025-01-06 16:08:19',
                'updated_at' => '2025-01-06 17:53:09',
            ),
            1 => 
            array (
                'id' => 2,
                'folio' => 'G-SC25-003',
                'currency' => 'USD',
                'type_payment' => 'PUE - Pago en una sola exhibición',
                'discount' => 10000,
                'form_payment' => 'transferencia',
                'term_payment' => '15 días',
                'condition_payment' => 'Quo ducimus qui est',
                'quote_folio' => 'Nobis cupidatat dolo',
                'use_cfdi' => '106-Comunicaciones telefónicas',
                'shipping_method' => 'Sed minim dolores si',
                'tax_iva' => 8,
                'retention_iva' => '9.000',
                'retention_isr' => '9.000',
                'retention_another' => '0.000',
                'initial_delivery_date' => '2025-01-14',
                'final_delivery_date' => '2025-01-29',
                'observations' => 'Assumenda eveniet v',
                'status' => 'aprobado por DG nivel 1',
                'provider_id' => 3,
                'purchaser_user_id' => 199,
                'company_id' => 1,
                'requisition_id' => 1,
                'created_at' => '2025-01-06 16:15:18',
                'updated_at' => '2025-01-06 17:19:42',
            ),
        ));
        
        
    }
}