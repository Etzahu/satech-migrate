<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\PurchaseRequisition;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Facades\Sheets;

class GoogleSheetsRequisitionService
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
  public function processRequisitionsReport(array $formData)
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
      Log::error('Error al procesar reporte de requisiciones en GoogleSheetsRequisitionService', [
        'method' => 'processRequisitionsReport',
        'form_data' => $formData,
        'error' => $e->getMessage(),
        'user_id' => auth()->id(),
        'trace' => $e->getTraceAsString()
      ]);

      throw new Exception("Error al procesar reporte de requisiciones: " . $e->getMessage());
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
      // 1. Generar colección de requisiciones basada en los filtros del formulario
      $requisitions = $this->generateRequisitionsCollection($formData);

      if ($requisitions->isEmpty()) {
        throw new Exception('No se encontraron registros para el rango de fechas especificado');
      }

      // 2. Obtener datos del usuario autenticado
      $user = auth()->user();
      $userSheetName = $this->generateUserInitials($user->name);

      // 3. Validar/crear hoja del usuario con encabezados dinámicos
      $this->ensureUserSheetExists($userSheetName, $formData['columns']);

      // 4. Procesar requisiciones y filtrar columnas seleccionadas
      $requisitionsData = $this->prepareRequisitionsData($requisitions, $formData['columns']);

      // 5. Insertar datos en la hoja
      $this->insertRequisitionsData($userSheetName, $requisitionsData);

      // 6. Retornar información del resultado
      return [
        'success' => true,
        'user_sheet' => $this->sanitizeUtf8($userSheetName),
        'user_name' => $this->sanitizeUtf8($user->name),
        'spreadsheet_url' => "https://docs.google.com/spreadsheets/d/{$this->spreadsheetId}",
        'date_range' => Carbon::parse($formData['created_start'])->format('d/m/Y') . ' - ' . Carbon::parse($formData['created_end'])->format('d/m/Y'),
        'total_requisitions' => $requisitions->count(),
        'export_type' => 'sheets'
      ];
    } catch (Exception $e) {
      Log::error('Error al procesar exportación a Google Sheets en GoogleSheetsRequisitionService', [
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
      // 1. Generar colección de requisiciones basada en los filtros del formulario
      $requisitions = $this->generateRequisitionsCollection($formData);

      if ($requisitions->isEmpty()) {
        throw new Exception('No se encontraron registros para el rango de fechas especificado');
      }

      // 2. Procesar requisiciones y filtrar columnas seleccionadas (sin Google Sheets)
      $requisitionsData = $this->prepareRequisitionsData($requisitions, $formData['columns']);

      // 3. Retornar collection para su uso con FastExcel
      return collect($requisitionsData);
    } catch (Exception $e) {
      Log::error('Error al procesar exportación a Excel en GoogleSheetsRequisitionService', [
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
   * Genera la colección de requisiciones basada en los filtros del formulario
   *
   * @param array $formData
   * @return Collection
   */
  protected function generateRequisitionsCollection(array $formData): Collection
  {
    $startDate = Carbon::createFromFormat('Y-m-d', $formData['created_start'])->startOfDay();
    $endDate = Carbon::createFromFormat('Y-m-d', $formData['created_end'])->endOfDay();

    $query = PurchaseRequisition::with(['company', 'project', 'approvalChain.requester', 'purchaser', 'items.product'])
      ->where('company_id', session()->get('company_id'))
      ->whereBetween('created_at', [$startDate, $endDate]);

    // Aplicar filtro de sin órdenes si está seleccionado
    if (!empty($formData['without_orders']) && $formData['without_orders']) {
      $query->whereDoesntHave('orders')
        ->whereIn('status', ['comprador asignado', 'comprador reasignado']);
    }

    return $query->get();
  }

  /**
   * Genera las iniciales del usuario a partir de su nombre completo
   *
   * @param string $userName Nombre completo del usuario
   * @return string Iniciales del usuario
   */
  public function generateUserInitials(string $userName): string
  {
    // Asegurar que el nombre esté en UTF-8
    $userName = mb_convert_encoding($userName, 'UTF-8', 'auto');
    $words = explode(' ', trim($userName));
    $initials = 'reporte-requisiciones-';

    foreach ($words as $word) {
      if (!empty($word)) {
        // Usar mb_substr para caracteres UTF-8
        $initials .= mb_strtoupper(mb_substr($word, 0, 1, 'UTF-8'), 'UTF-8');
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
      Log::error('Error al crear/verificar hoja del usuario en GoogleSheetsRequisitionService', [
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
      Log::error('Error al limpiar datos de la hoja en GoogleSheetsRequisitionService', [
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
   * Prepara los datos de las requisiciones (método base compartido)
   *
   * @param Collection $requisitions
   * @param array $selectedColumns
   * @return array
   */
  protected function prepareRequisitionsData(Collection $requisitions, array $selectedColumns): array
  {
    $requisitionsData = [];

    foreach ($requisitions as $requisition) {
      // Datos completos de la requisición - asegurar codificación UTF-8
      $fullRequisitionData = [
        'folio' => $this->sanitizeUtf8($requisition->folio ?? ''),
        'prioridad' => $this->sanitizeUtf8($requisition->priority ?? ''),
        'motivo' => $this->sanitizeUtf8($requisition->motive ?? ''),
        'tipo' => $this->sanitizeUtf8($requisition->type ?? ''),
        'observaciones' => $this->sanitizeUtf8($requisition->observation ?? ''),
        'partidas' => $this->sanitizeUtf8($this->formatRequisitionItems($requisition)),
        'fecha de entrega' => $requisition->date_delivery?->format('d-m-Y') ?? 'N/A',
        'dirección de entrega' => $this->sanitizeUtf8($requisition->delivery_address ?? ''),
        'estatus' => $this->sanitizeUtf8($requisition->status ?? ''),
        'empresa' => $this->sanitizeUtf8($requisition->company->name ?? ''),
        'proyecto' => $this->sanitizeUtf8($requisition->project->name ?? ''),
        'solicitante' => $this->sanitizeUtf8($requisition->approvalChain->requester->name ?? ''),
        'comprador' => $this->sanitizeUtf8($requisition->purchaser?->name ?? 'Sin asignar'),
        'fecha de creacion' => $requisition->created_at->format('d-m-Y'),
      ];

      // Agregar fecha de carga actual
      $rowData = [now()->format('d-m-Y H:i:s')]; // Fecha de carga

      // Filtrar solo las columnas seleccionadas
      foreach ($selectedColumns as $column) {
        $rowData[] = $fullRequisitionData[$column] ?? '';
      }

      $requisitionsData[] = $rowData;
    }

    return $requisitionsData;
  }

  /**
   * Inserta los datos de las requisiciones en la hoja del usuario
   * OPTIMIZADO: Inserta todos los datos en una sola llamada API
   *
   * @param string $userSheetName
   * @param array $requisitionsData
   * @return bool
   */
  protected function insertRequisitionsData(string $userSheetName, array $requisitionsData): bool
  {
    try {
      if (empty($requisitionsData)) {
        return true;
      }

      // OPTIMIZACIÓN: Insertar todos los datos en una sola llamada API
      // En lugar de múltiples requests, solo 1 request
      Sheets::spreadsheet($this->spreadsheetId)
        ->sheet($userSheetName)
        ->range('A2') // Comenzar desde la fila 2 (después de encabezados)
        ->update($requisitionsData);

      return true;
    } catch (Exception $e) {
      Log::error('Error al insertar requisiciones en la hoja en GoogleSheetsRequisitionService', [
        'method' => 'insertRequisitionsData',
        'user_sheet_name' => $userSheetName,
        'requisitions_count' => count($requisitionsData),
        'spreadsheet_id' => $this->spreadsheetId,
        'error' => $e->getMessage(),
        'user_id' => auth()->id(),
        'trace' => $e->getTraceAsString()
      ]);

      throw new Exception("Error al insertar requisiciones en la hoja '$userSheetName': " . $e->getMessage());
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
      Log::error('Error al actualizar encabezados en GoogleSheetsRequisitionService', [
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
      Log::error('Error al verificar si la hoja existe en GoogleSheetsRequisitionService', [
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
      Log::error('Error al crear nueva hoja en GoogleSheetsRequisitionService', [
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
      Log::error('Error al agregar encabezados en GoogleSheetsRequisitionService', [
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
   * Formatea los items de una requisición
   */
  protected function formatRequisitionItems(PurchaseRequisition $requisition): string
  {
    $result = '';
    $items = $requisition->items;

    foreach ($items as $item) {
      $productName = $this->sanitizeUtf8($item->product->name ?? '');
      $productType = $this->sanitizeUtf8($item->product->type_purchase ?? '');
      $result .= "{$productName} ({$productType})\n";
    }

    return trim($result);
  }

  /**
   * Sanitiza y asegura que el texto esté en UTF-8 correctamente codificado
   *
   * @param string $text
   * @return string
   */
  protected function sanitizeUtf8(string $text): string
  {
    // Convertir a UTF-8 si no lo está
    $text = mb_convert_encoding($text, 'UTF-8', 'auto');

    // Remover caracteres de control excepto los básicos (tab, nueva línea, carriage return)
    $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $text);

    // Asegurar que sea UTF-8 válido
    if (!mb_check_encoding($text, 'UTF-8')) {
      $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8//IGNORE');
    }

    return $text;
  }

  /**
   * Obtiene el spreadsheet ID actual
   */
  public function getSpreadsheetId(): string
  {
    return $this->spreadsheetId;
  }
}
