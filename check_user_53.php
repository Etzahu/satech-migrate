<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\PurchaseRequisition;

// Buscar cadenas donde el usuario 53 es reviewer
$chains = PurchaseRequisitionApprovalChain::where('reviewer_id', 53)->get();

echo "========================================\n";
echo "Usuario ID 53 como REVIEWER\n";
echo "========================================\n\n";

echo "Cadenas donde usuario 53 es reviewer: " . $chains->count() . "\n";
echo "IDs: " . $chains->pluck('id')->implode(', ') . "\n\n";

$totalPending = 0;

foreach ($chains as $chain) {
  $pending = $chain->requisitions()->where('status', 'revisión')->count();
  echo "Cadena #{$chain->id}: {$pending} requisiciones pendientes\n";

  if ($pending > 0) {
    $requisitions = $chain->requisitions()->where('status', 'revisión')->get();
    foreach ($requisitions as $req) {
      echo "  - Folio: {$req->folio}, Fecha: {$req->created_at->format('Y-m-d')}\n";
    }
  }
  $totalPending += $pending;
}

echo "\n========================================\n";
echo "TOTAL PENDIENTES: {$totalPending}\n";
echo "========================================\n";
