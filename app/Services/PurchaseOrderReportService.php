<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\SheetCollection;

class PurchaseOrderReportService
{
  /**
   * Servicio de Google Sheets
   */
  protected GoogleSheetsService $googleSheetsService;

  /**
   * Servicio de cálculos de órdenes
   */
  protected OrderCalculationService $calculationService;

  /**
   * Constructor del servicio
   */
  public function __construct()
  {
    $this->googleSheetsService = new GoogleSheetsService();
    $this->calculationService = new OrderCalculationService();
  }

  /**
   * Genera el reporte de órdenes de compra según los parámetros del formulario
   *
   * @param array $data Datos del formulario (type_save, columns, fechas, buyers, type_purchase)
   * @return array Resultado con los datos del reporte
   * @throws Exception
   */
  public function generateReport(array $data): array
  {
    try {
      $exportType = $data['type_save'] ?? 'excel';

      if ($exportType === 'sheets') {
        return $this->generateGoogleSheetsReport($data);
      } else {
        return $this->generateExcelReport($data);
      }
    } catch (Exception $e) {
      Log::error('Error al generar reporte de órdenes', [
        'method' => 'generateReport',
        'data' => $data,
        'error' => $e->getMessage(),
        'user_id' => auth()->id(),
        'trace' => $e->getTraceAsString()
      ]);

      throw new Exception("Error al generar reporte: " . $e->getMessage());
    }
  }

  /**
   * Genera el reporte en Google Sheets
   *
   * @param array $data
   * @return array
   * @throws Exception
   */
  protected function generateGoogleSheetsReport(array $data): array
  {
    try {
      $result = $this->googleSheetsService->processOrdersReport($data);

      return [
        'type' => 'sheets',
        'success' => true,
        'data' => $result
      ];
    } catch (Exception $e) {
      Log::error('Error al generar reporte en Google Sheets', [
        'method' => 'generateGoogleSheetsReport',
        'data' => $data,
        'error' => $e->getMessage(),
        'user_id' => auth()->id()
      ]);

      throw $e;
    }
  }

  /**
   * Genera el reporte en formato Excel
   *
   * @param array $data
   * @return array
   * @throws Exception
   */
  protected function generateExcelReport(array $data): array
  {
    try {
      $startDate = Carbon::createFromFormat('Y-m-d', $data['created_start'])->startOfDay();
      $endDate = Carbon::createFromFormat('Y-m-d', $data['created_end'])->endOfDay();

      // Obtener datos de órdenes procesados por el servicio de Google Sheets
      $ordersData = $this->googleSheetsService->processOrdersReport($data);

      // Obtener los modelos para generar la hoja de items (partidas)
      $models = $this->getFilteredOrders($startDate, $endDate, $data);
      $itemsData = $this->prepareItemsData($models);

      // Crear las hojas del Excel
      $sheets = new SheetCollection([
        'ordenes' => $ordersData,
        'partidas' => $itemsData
      ]);

      // Generar nombre del archivo
      $fileName = $this->generateFileName($startDate, $endDate);

      return [
        'type' => 'excel',
        'success' => true,
        'sheets' => $sheets,
        'filename' => $fileName,
        'start_date' => $startDate,
        'end_date' => $endDate
      ];
    } catch (Exception $e) {
      Log::error('Error al generar reporte Excel', [
        'method' => 'generateExcelReport',
        'data' => $data,
        'error' => $e->getMessage(),
        'user_id' => auth()->id()
      ]);

      throw new Exception("Error al generar reporte Excel: " . $e->getMessage());
    }
  }

  /**
   * Obtiene las órdenes filtradas según los criterios del formulario
   *
   * @param Carbon $startDate
   * @param Carbon $endDate
   * @param array $data
   * @return \Illuminate\Database\Eloquent\Collection
   */
  protected function getFilteredOrders(Carbon $startDate, Carbon $endDate, array $data)
  {
    $query = PurchaseOrder::with(['requisition', 'provider', 'company', 'purchaser'])
      ->where('company_id', session()->get('company_id'))
      ->whereBetween('created_at', [$startDate, $endDate]);

    // Aplicar filtros opcionales
    if (filled($data['buyers'])) {
      $query->whereIn('purchaser_user_id', $data['buyers']);
    }

    if (filled($data['type_purchase'])) {
      $query->whereHas('items.product', function ($q) use ($data) {
        $q->whereIn('type_purchase', $data['type_purchase']);
      });
    }

    return $query->get();
  }

  /**
   * Prepara los datos de los items (partidas) para la segunda hoja del Excel
   *
   * @param \Illuminate\Database\Eloquent\Collection $orders
   * @return array
   */
  protected function prepareItemsData($orders): array
  {
    $items = $orders->pluck('items')->flatten();
    $dataItems = [];

    foreach ($items as $item) {
      $currency = $item->purchase->currency;
      $dataItems[] = [
        'Orden' => $item->purchase->folio,
        'Requisicion' => $item->purchase->requisition->folio,
        'Cantidad' => $item->quantity,
        'Precio unitario' => $this->calculationService->brickFormatter($item->unit_price, $currency),
        'Subtotal' => $this->calculationService->brickFormatter($item->sub_total, $currency),
        'Producto-Servicio' => $item->product->name,
        'Tipo' => $item->product->type_purchase,
        'Observaciones' => $item->observation
      ];
    }

    return $dataItems;
  }

  /**
   * Genera el nombre del archivo Excel
   *
   * @param Carbon $startDate
   * @param Carbon $endDate
   * @return string
   */
  protected function generateFileName(Carbon $startDate, Carbon $endDate): string
  {
    return "ordenes de compra {$startDate->format('d-m-Y')} {$endDate->format('d-m-Y')}.xlsx";
  }
}
