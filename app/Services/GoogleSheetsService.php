<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\PurchaseOrder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Facades\Sheets;

class GoogleSheetsService
{
    /**
     * ID del spreadsheet principal
     */
    protected string $spreadsheetId;

    /**
     * Constructor del servicio
     */
    public function __construct(string $spreadsheetId = null)
    {
        $this->spreadsheetId = $spreadsheetId ?? config('google.default_spreadsheet_id', '1ha_45TdVN7odz-64yKlXlvjXD66O5zfXG7HKeamFJfU');
    }

    /**
     * Procesa el formulario del HistoryResource según el tipo de exportación seleccionado
     *
     * @param array $formData Datos del formulario (incluyendo type_save, columns, fechas, etc.)
     * @return array|Collection Resultado según el tipo de exportación
     */
    public function processOrdersReport(array $formData)
    {
        try {
            // Determinar el tipo de exportación
            $exportType = $formData['type_save'] ?? 'excel';

            if ($exportType === 'sheets') {
                return $this->processGoogleSheetsExport($formData);
            } else {
                return $this->processExcelExport($formData);
            }
        } catch (Exception $e) {
            Log::error('Error al procesar reporte de órdenes en GoogleSheetsService', [
                'method' => 'processOrdersReport',
                'form_data' => $formData,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception("Error al procesar reporte de órdenes: " . $e->getMessage());
        }
    }

    /**
     * Procesa la exportación específica para Google Sheets
     *
     * @param array $formData
     * @return array
     */
    protected function processGoogleSheetsExport(array $formData): array
    {
        try {
            // 1. Generar colección de órdenes basada en los filtros del formulario
            $orders = $this->generateOrdersCollection($formData);

            if ($orders->isEmpty()) {
                throw new Exception('No se encontraron registros para el rango de fechas especificado');
            }

            // 2. Obtener datos del usuario autenticado
            $user = auth()->user();
            $userSheetName = $this->generateBuyerInitials($user->name);

            // 3. Validar/crear hoja del usuario con encabezados dinámicos
            $this->ensureUserSheetExists($userSheetName, $formData['columns']);

            // 4. Procesar órdenes y filtrar columnas seleccionadas
            $ordersData = $this->prepareOrdersData($orders, $formData['columns']);

            // 5. Insertar datos en la hoja
            $this->insertOrdersData($userSheetName, $ordersData);

            // 6. Retornar información del resultado
            return [
                'success' => true,
                'user_sheet' => $userSheetName,
                'user_name' => $user->name,
                'spreadsheet_url' => "https://docs.google.com/spreadsheets/d/{$this->spreadsheetId}",
                'date_range' => Carbon::parse($formData['created_start'])->format('d/m/Y') . ' - ' . Carbon::parse($formData['created_end'])->format('d/m/Y'),
                'total_orders' => $orders->count(),
                'export_type' => 'sheets'
            ];
        } catch (Exception $e) {
            Log::error('Error al procesar exportación a Google Sheets en GoogleSheetsService', [
                'method' => 'processGoogleSheetsExport',
                'form_data' => $formData,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception("Error al procesar exportación a Google Sheets: " . $e->getMessage());
        }
    }

    /**
     * Procesa la exportación para Excel (sin interacción con Google Sheets)
     *
     * @param array $formData
     * @return Collection
     */
    protected function processExcelExport(array $formData): Collection
    {
        try {
            // 1. Generar colección de órdenes basada en los filtros del formulario
            $orders = $this->generateOrdersCollection($formData);

            if ($orders->isEmpty()) {
                throw new Exception('No se encontraron registros para el rango de fechas especificado');
            }

            // 2. Procesar órdenes y filtrar columnas seleccionadas (sin Google Sheets)
            $ordersData = $this->prepareOrdersData($orders, $formData['columns']);

            // 3. Retornar collection para su uso con FastExcel
            return collect($ordersData);
        } catch (Exception $e) {
            Log::error('Error al procesar exportación a Excel en GoogleSheetsService', [
                'method' => 'processExcelExport',
                'form_data' => $formData,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception("Error al procesar exportación a Excel: " . $e->getMessage());
        }
    }

    /**
     * Genera la colección de órdenes basada en los filtros del formulario
     *
     * @param array $formData
     * @return Collection
     */
    protected function generateOrdersCollection(array $formData): Collection
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $formData['created_start'])->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $formData['created_end'])->endOfDay();

        $query = PurchaseOrder::with(['requisition.project', 'provider', 'company', 'purchaser', 'providerContact', 'items.product'])
            ->where('company_id', session()->get('company_id'))
            ->whereBetween('created_at', [$startDate, $endDate]);

        // Aplicar filtros opcionales
        if (!empty($formData['buyers'])) {
            $query->whereIn('purchaser_user_id', $formData['buyers']);
        }

        if (!empty($formData['type_purchase'])) {
            $query->whereHas('items.product', function ($q) use ($formData) {
                $q->whereIn('type_purchase', $formData['type_purchase']);
            });
        }

        return $query->get();
    }

    /**
     * Genera las iniciales del usuario a partir de su nombre completo
     *
     * @param string $userName Nombre completo del usuario
     * @return string Iniciales del usuario
     */
    public function generateBuyerInitials(string $userName): string
    {
        $words = explode(' ', trim($userName));
        $initials = 'reporte-ordenes-';

        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }

        return $initials;
    }

    /**
     * Verifica si existe la hoja del usuario, si no existe la crea
     * Si existe, limpia todos los datos antes de cargar nuevos
     *
     * @param string $userSheetName
     * @param array $selectedColumns Columnas seleccionadas por el usuario
     * @return bool
     */
    protected function ensureUserSheetExists(string $userSheetName, array $selectedColumns = []): bool
    {
        try {
            if (!$this->sheetExists($userSheetName)) {
                // Crear encabezados dinámicos basados en las columnas seleccionadas
                $dynamicHeaders = ['Fecha Carga']; // Siempre incluir fecha de carga
                $dynamicHeaders = array_merge($dynamicHeaders, $selectedColumns);

                $this->createSheet($userSheetName, $dynamicHeaders);
            } else {
                // Si la hoja ya existe, limpiar todos los datos
                $this->clearSheetData($userSheetName);

                // Actualizar encabezados según las columnas seleccionadas
                $dynamicHeaders = ['Fecha Carga'];
                $dynamicHeaders = array_merge($dynamicHeaders, $selectedColumns);
                $this->updateSheetHeaders($userSheetName, $dynamicHeaders);
            }

            return true;
        } catch (Exception $e) {
            Log::error('Error al crear/verificar hoja del usuario en GoogleSheetsService', [
                'method' => 'ensureUserSheetExists',
                'user_sheet_name' => $userSheetName,
                'selected_columns' => $selectedColumns,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception("Error al crear/verificar hoja del usuario '$userSheetName': " . $e->getMessage());
        }
    }

    /**
     * Limpia todos los datos de una hoja, manteniendo solo los encabezados
     *
     * @param string $sheetName
     * @return bool
     */
    protected function clearSheetData(string $sheetName): bool
    {
        try {
            // Obtener todas las filas de la hoja
            $allData = Sheets::spreadsheet($this->spreadsheetId)
                ->sheet($sheetName)
                ->get();

            if ($allData->count() > 1) {
                // Si hay más de una fila (encabezados + datos), limpiar desde la fila 2 en adelante
                $lastRow = $allData->count();
                $lastColumn = $this->getColumnLetter(count($allData->first()));

                // Limpiar el rango desde A2 hasta la última celda con datos
                Sheets::spreadsheet($this->spreadsheetId)
                    ->sheet($sheetName)
                    ->range("A2:{$lastColumn}{$lastRow}")
                    ->clear();
            }

            return true;
        } catch (Exception $e) {
            Log::error('Error al limpiar datos de la hoja en GoogleSheetsService', [
                'method' => 'clearSheetData',
                'sheet_name' => $sheetName,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception("Error al limpiar datos de la hoja '$sheetName': " . $e->getMessage());
        }
    }

    /**
     * Prepara los datos de las órdenes (método base compartido)
     *
     * @param Collection $orders
     * @param array $selectedColumns
     * @return array
     */
    protected function prepareOrdersData(Collection $orders, array $selectedColumns): array
    {
        $ordersData = [];

        foreach ($orders as $order) {
            $service = new \App\Services\OrderCalculationService($order->id);

            // Datos completos de la orden
            $fullOrderData = [
                'fecha de creacion' => $order->created_at->format('d-m-Y'),
                'comprador' => $order->purchaser->name,
                'folio' => $order->folio,
                'proveedor' => $order->provider->company_name,
                'subtotal' => $service->getSubtotalItems(true),
                'total' => $service->getTotal(true),
                'partidas' => $this->formatOrderItems($order),
                'moneda' => $order->currency,
                'proyecto' => "({$order->requisition->project->code}){$order->requisition->project->name}",
                'tipo de pago' => $order->type_payment,
                'forma de pago' => $order->form_payment,
                'condiciones de pago' => $this->formatConditionPayment($order),
                'folio de cotización' => $order->quote_folio,
                'uso de CFDI' => $order->use_cfdi,
                'método de envío' => $order->shipping_method,
                'descuento por proveedor' => $order->discount,
                'descuento' => $service->getDiscountProvider(true),
                'iva' => $service->getTaxIva(true),
                'retención de IVA' => $service->getRetentionIva(true),
                'retención de ISR' => $service->getRetentionIsr(true),
                'fecha de entrega inicial' => $order->initial_delivery_date,
                'fecha de entrega final' => $order->final_delivery_date,
                'dirección de entrega' => $order->delivery_address,
                'documentación de entrega' => $this->formatDocumentation($order),
                'observaciones' => $order->observations,
                'contacto de proveedor' => $order->providerContact->cell_phone ?? '',
                'empresa' => $order->company->name,
                'requisición' => $order->requisition->folio,
                'estatus' => $order->status,
            ];

            // Agregar fecha de carga actual
            $rowData = [now()->format('d-m-Y H:i:s')]; // Fecha de carga

            // Filtrar solo las columnas seleccionadas
            foreach ($selectedColumns as $column) {
                $rowData[] = $fullOrderData[$column] ?? '';
            }

            $ordersData[] = $rowData;
        }

        return $ordersData;
    }

    /**
     * Inserta los datos de las órdenes en la hoja del usuario
     * OPTIMIZADO: Inserta todos los datos en una sola llamada API
     *
     * @param string $userSheetName
     * @param array $ordersData
     * @return bool
     */
    protected function insertOrdersData(string $userSheetName, array $ordersData): bool
    {
        try {
            if (empty($ordersData)) {
                return true;
            }

            // OPTIMIZACIÓN: Insertar todos los datos en una sola llamada API
            // En lugar de 50+ requests, solo 1 request
            Sheets::spreadsheet($this->spreadsheetId)
                ->sheet($userSheetName)
                ->range('A2') // Comenzar desde la fila 2 (después de encabezados)
                ->update($ordersData);

            return true;
        } catch (Exception $e) {
            Log::error('Error al insertar órdenes en la hoja en GoogleSheetsService', [
                'method' => 'insertOrdersData',
                'user_sheet_name' => $userSheetName,
                'orders_count' => count($ordersData),
                'spreadsheet_id' => $this->spreadsheetId,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception("Error al insertar órdenes en la hoja '$userSheetName': " . $e->getMessage());
        }
    }

    /**
     * Actualiza los encabezados de la hoja según las columnas seleccionadas
     *
     * @param string $sheetName
     * @param array $headers
     * @return bool
     */
    protected function updateSheetHeaders(string $sheetName, array $headers): bool
    {
        try {
            // Actualizar encabezados en la primera fila
            Sheets::spreadsheet($this->spreadsheetId)
                ->sheet($sheetName)
                ->range('A1:' . $this->getColumnLetter(count($headers)) . '1')
                ->update([$headers]);

            return true;
        } catch (Exception $e) {
            Log::error('Error al actualizar encabezados en GoogleSheetsService', [
                'method' => 'updateSheetHeaders',
                'sheet_name' => $sheetName,
                'headers' => $headers,
                'spreadsheet_id' => $this->spreadsheetId,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            // Si falla, continuar sin actualizar encabezados
            return false;
        }
    }

    /**
     * Convierte un número de columna a letra de Excel (A, B, C, ..., AA, AB, etc.)
     *
     * @param int $columnNumber
     * @return string
     */
    protected function getColumnLetter(int $columnNumber): string
    {
        $letter = '';
        while ($columnNumber > 0) {
            $columnNumber--;
            $letter = chr($columnNumber % 26 + 65) . $letter;
            $columnNumber = intval($columnNumber / 26);
        }
        return $letter;
    }

    // === MÉTODOS DE UTILIDAD ===

    /**
     * Verifica si una hoja existe en el spreadsheet
     */
    public function sheetExists(string $sheetName): bool
    {
        try {
            $sheets = Sheets::spreadsheet($this->spreadsheetId)->sheetList();
            return in_array($sheetName, $sheets);
        } catch (Exception $e) {
            Log::error('Error al verificar si la hoja existe en GoogleSheetsService', [
                'method' => 'sheetExists',
                'sheet_name' => $sheetName,
                'spreadsheet_id' => $this->spreadsheetId,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception("Error al verificar si la hoja existe: " . $e->getMessage());
        }
    }

    /**
     * Crea una nueva hoja en el spreadsheet
     */
    public function createSheet(string $sheetName, array $headers = []): bool
    {
        try {
            Sheets::spreadsheet($this->spreadsheetId)->addSheet($sheetName);

            if (!empty($headers)) {
                $this->addHeaders($sheetName, $headers);
            }

            return true;
        } catch (Exception $e) {
            Log::error('Error al crear nueva hoja en GoogleSheetsService', [
                'method' => 'createSheet',
                'sheet_name' => $sheetName,
                'headers_count' => count($headers),
                'spreadsheet_id' => $this->spreadsheetId,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception("Error al crear la hoja '$sheetName': " . $e->getMessage());
        }
    }

    /**
     * Agrega encabezados a una hoja
     */
    public function addHeaders(string $sheetName, array $headers): bool
    {
        try {
            Sheets::spreadsheet($this->spreadsheetId)
                ->sheet($sheetName)
                ->range('A1')
                ->update([$headers]);

            return true;
        } catch (Exception $e) {
            Log::error('Error al agregar encabezados en GoogleSheetsService', [
                'method' => 'addHeaders',
                'sheet_name' => $sheetName,
                'headers' => $headers,
                'spreadsheet_id' => $this->spreadsheetId,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception("Error al agregar encabezados a la hoja '$sheetName': " . $e->getMessage());
        }
    }

    /**
     * Formatea los items de una orden
     */
    protected function formatOrderItems(PurchaseOrder $order): string
    {
        $result = '';
        $items = $order->items;

        foreach ($items as $item) {
            $result .= "{$item->product->name} ({$item->product->type_purchase})\n";
        }

        return trim($result);
    }

    /**
     * Formatea las condiciones de pago
     */
    protected function formatConditionPayment(PurchaseOrder $order): string
    {
        if (blank($order->condition_payment)) {
            return 'N/A';
        }

        if (is_array($order->condition_payment)) {
            return implode(',', array_column($order->condition_payment, 'concept'));
        }

        return $order->condition_payment;
    }

    /**
     * Formatea la documentación de entrega
     */
    protected function formatDocumentation(PurchaseOrder $order): string
    {
        if (blank($order->documentation_delivery)) {
            return 'N/A';
        }

        return implode(',', array_column($order->documentation_delivery, 'name'));
    }

    /**
     * Obtiene el spreadsheet ID actual
     */
    public function getSpreadsheetId(): string
    {
        return $this->spreadsheetId;
    }
}
