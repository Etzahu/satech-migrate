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
                'folio' => 'G-VEN24-002',
                'currency' => 'MXN',
                'type_payment' => 'PUE - Pago en una sola exhibición',
                'discount' => 0,
                'form_payment' => 'transferencia',
                'term_payment' => '30 días',
                'condition_payment' => 'Rerum magna voluptas',
                'quote_folio' => 'Consectetur tempor ',
                'use_cfdi' => '107-Comunicaciones satelitales',
                'shipping_method' => 'Ut labore ab sit di',
                'tax_iva' => 16,
                'retention_iva' => '10.666',
                'retention_isr' => '1.250',
                'retention_another' => '0.000',
                'initial_delivery_date' => '2024-12-11',
                'final_delivery_date' => '2024-12-12',
                'observations' => 'Qui laboriosam aut ',
                'status' => 'borrador',
                'provider_id' => 3,
                'purchaser_user_id' => 274,
                'company_id' => 1,
                'requisition_id' => 1,
                'created_at' => '2024-12-10 20:07:56',
                'updated_at' => '2024-12-16 15:13:46',
            ),
            1 => 
            array (
                'id' => 2,
                'folio' => 'G-VEN24-003',
                'currency' => 'MXN',
                'type_payment' => 'PPD - Pago en parcialidades o diferido',
                'discount' => 6200,
                'form_payment' => 'transferencia',
                'term_payment' => '45 días',
                'condition_payment' => 'Tenetur qui sit ut a',
                'quote_folio' => 'Excepteur cum asperi',
                'use_cfdi' => '108-Otra maquinaria y equipo',
                'shipping_method' => 'Porro amet enim nob',
                'tax_iva' => 0,
                'retention_iva' => '70.000',
                'retention_isr' => '96.000',
                'retention_another' => '64.000',
                'initial_delivery_date' => '2024-12-11',
                'final_delivery_date' => '2024-12-12',
                'observations' => 'Voluptas vel aliquid',
                'status' => 'aprobado por gerente solicitante',
                'provider_id' => 3,
                'purchaser_user_id' => 274,
                'company_id' => 1,
                'requisition_id' => 1,
                'created_at' => '2024-12-11 15:37:13',
                'updated_at' => '2024-12-17 19:43:08',
            ),
        ));
        
        
    }
}