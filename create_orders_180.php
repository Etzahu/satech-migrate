<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseProvider;
use App\Models\Product;

// Configuración
$purchaserUserId = 180;
$companyId = 2;
$numberOfOrders = 40;

// Obtener una requisición existente para la company_id 2
$requisition = PurchaseRequisition::where('company_id', $companyId)->first();
if (!$requisition) {
    echo "❌ No se encontró una requisición para company_id: {$companyId}\n";
    echo "Creando una requisición de prueba...\n";
    $requisition = PurchaseRequisition::create([
        'folio' => 'TEST-' . now()->format('YmdHis'),
        'status' => 'aprobado por gerente solicitante',
        'company_id' => $companyId,
        'requestor_id' => $purchaserUserId,
        'approval_chain_id' => 1,
        'department_id' => 1,
        'approval_management_date' => now(),
    ]);
}

// Obtener el proveedor ID 427
$providerId = 427;
$provider = PurchaseProvider::find($providerId);
if (!$provider) {
    echo "❌ No se encontró el proveedor con ID {$providerId}\n";
    exit(1);
}

// Obtener un producto existente para los items
$product = Product::first();
if (!$product) {
    echo "❌ No se encontró ningún producto en la base de datos\n";
    exit(1);
}

// Configurar la sesión para el folio
session([
    'company_id' => $companyId,
    'company_acronym' => 'T'
]);

echo "🚀 Creando {$numberOfOrders} órdenes de compra en borrador...\n";
echo "   Comprador: ID {$purchaserUserId}\n";
echo "   Compañía: ID {$companyId}\n";
echo "   Proveedor: {$provider->name} (ID {$providerId})\n";
echo "   Producto: {$product->name} (ID {$product->id})\n";
echo "   Requisición: {$requisition->folio} (ID {$requisition->id})\n\n";

$created = 0;
$errors = 0;

for ($i = 1; $i <= $numberOfOrders; $i++) {
    try {
        DB::beginTransaction();

        $order = PurchaseOrder::create([
            'currency' => 'MXN',
            'type_payment' => 'PUE - Pago en una sola exhibición',
            'form_payment' => 'Transferencia bancaria',
            'condition_payment' => ['Pago contra entrega'],
            'quote_folio' => '0',
            'use_cfdi' => '601-General de ley personas morales',
            'shipping_method' => 'Entrega en almacén',
            'tax_iva' => 16,
            'discount' => 0,
            'retention_iva' => 0,
            'retention_isr' => 0,
            'retention_another' => 0,
            'initial_delivery_date' => now()->addDays(7),
            'final_delivery_date' => now()->addDays(14),
            'delivery_address' => 'Dirección de entrega principal',
            'documentation_delivery' => [
                ['name' => 'Orden de compra'],
                ['name' => 'Factura']
            ],
            'observations' => 'Esta orden está apartada',
            'provider_id' => $providerId,
            'provider_contact_id' => null,
            'purchaser_user_id' => $purchaserUserId,
            'company_id' => $companyId,
            'requisition_id' => $requisition->id,
            'status' => 'borrador',
        ]);

        // Crear al menos un item para la orden
        PurchaseOrderItem::create([
            'purchase_order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 0,
            'unit_price' => 0,
            'sub_total' => 0,
            'observation' => 'Item de prueba ' . $i,
        ]);

        DB::commit();
        $created++;
        echo "✅ Orden #{$i} creada: {$order->folio} (ID: {$order->id})\n";
    } catch (\Exception $e) {
        DB::rollBack();
        $errors++;
        echo "❌ Error al crear orden #{$i}: " . $e->getMessage() . "\n";
    }
}

echo "\n" . str_repeat('=', 60) . "\n";
echo "✨ Proceso completado\n";
echo "   Órdenes creadas exitosamente: {$created}\n";
echo "   Errores: {$errors}\n";
echo str_repeat('=', 60) . "\n";
