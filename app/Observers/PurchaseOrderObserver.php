<?php

namespace App\Observers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderSheetConfig;
use App\Services\GoogleSheetsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PurchaseOrderObserver
{
    /**
     * Handle the PurchaseOrder "updated" event.
     * Automáticamente actualiza Google Sheets cuando se modifica una orden
     */
    public function updated(PurchaseOrder $purchaseOrder): void
    {
        try {
            // Ejecutar en background para no bloquear la operación principal
            dispatch(function () use ($purchaseOrder) {
                $this->updateGoogleSheetsForAllUsers($purchaseOrder);
            })->afterResponse();
        } catch (\Exception $e) {
            Log::error('Error al intentar actualizar Google Sheets desde Observer', [
                'purchase_order_id' => $purchaseOrder->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Actualiza el reporte en Google Sheets para todos los usuarios con configuración activa
     */
    protected function updateGoogleSheetsForAllUsers(PurchaseOrder $purchaseOrder): void
    {
        try {
            // Obtener todas las configuraciones activas
            $activeConfigs = PurchaseOrderSheetConfig::where('is_active', true)
                ->with('user')
                ->get();

            if ($activeConfigs->isEmpty()) {
                Log::info('No hay configuraciones activas para exportar a Google Sheets');
                return;
            }

            foreach ($activeConfigs as $config) {
                try {
                    $this->updateGoogleSheetsForUser($purchaseOrder, $config);
                } catch (\Exception $e) {
                    Log::error('Error al actualizar Google Sheets para usuario específico', [
                        'user_id' => $config->user_id,
                        'user_name' => $config->user->name ?? 'Unknown',
                        'error' => $e->getMessage()
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error al procesar configuraciones de Google Sheets', [
                'purchase_order_id' => $purchaseOrder->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Actualiza Google Sheets para un usuario específico según su configuración
     */
    protected function updateGoogleSheetsForUser(PurchaseOrder $purchaseOrder, PurchaseOrderSheetConfig $config): void
    {
        // Calcular rango de fechas según configuración
        if ($config->date_range_type === 'days') {
            $startDate = now()->subDays($config->days_range)->format('Y-m-d');
            $endDate = now()->format('Y-m-d');
        } else {
            // En rango personalizado, la fecha de inicio es la configurada y la fecha final es siempre hoy
            $startDate = $config->custom_start_date?->format('Y-m-d') ?? now()->subDays(30)->format('Y-m-d');
            $endDate = now()->format('Y-m-d');
        }

        // Preparar datos del formulario según configuración del usuario
        $formData = [
            'type_save' => 'sheets',
            'columns' => $config->columns ?? PurchaseOrderSheetConfig::defaultColumns(),
            'created_start' => $startDate,
            'created_end' => $endDate,
            'buyers' => $config->buyers ?? [],
            'type_purchase' => $config->type_purchase ?? [],
        ];

        $sheetsService = new GoogleSheetsService();
        $result = $sheetsService->processOrdersReport($formData);

        Log::info('Google Sheets actualizado automáticamente para usuario', [
            'user_id' => $config->user_id,
            'user_name' => $config->user->name ?? 'Unknown',
            'purchase_order_id' => $purchaseOrder->id,
            'folio' => $purchaseOrder->folio,
            'total_orders_updated' => $result['total_orders'] ?? 0
        ]);
    }

    /**
     * Handle the PurchaseOrder "created" event.
     * También actualiza cuando se crea una nueva orden
     */
    public function created(PurchaseOrder $purchaseOrder): void
    {
        try {
            // Ejecutar en background
            dispatch(function () use ($purchaseOrder) {
                $this->updateGoogleSheetsForAllUsers($purchaseOrder);
            })->afterResponse();
        } catch (\Exception $e) {
            Log::error('Error al intentar actualizar Google Sheets desde Observer (created)', [
                'purchase_order_id' => $purchaseOrder->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
