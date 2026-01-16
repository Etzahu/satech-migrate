<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Product;
use App\Models\ProjectPurchase;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\PurchaseRequisitionItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Rap2hpoutre\FastExcel\FastExcel;

class PurchaseRequisitionImport
{
    protected array $errors = [];
    protected array $warnings = [];
    protected int $successCount = 0;
    protected int $errorCount = 0;

    /**
     * Importa requisiciones desde un archivo Excel
     *
     * @param string $filePath Ruta del archivo Excel
     * @param int $companyId ID de la empresa actual
     * @return array Resultado de la importación
     */
    public function import(string $filePath, int $companyId): array
    {
        $this->errors = [];
        $this->warnings = [];
        $this->successCount = 0;
        $this->errorCount = 0;

        try {
            $rows = (new FastExcel)->import($filePath);

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +2 porque Excel empieza en 1 y hay header

                try {
                    DB::beginTransaction();

                    $validatedData = $this->validateRow($row, $rowNumber, $companyId);

                    if (!$validatedData) {
                        $this->errorCount++;
                        DB::rollBack();
                        continue;
                    }

                    $this->createRequisition($validatedData, $companyId);

                    $this->successCount++;
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->errors[] = "Fila {$rowNumber}: Error al crear requisición - {$e->getMessage()}";
                    $this->errorCount++;
                }
            }

            return [
                'success' => $this->errorCount === 0,
                'successCount' => $this->successCount,
                'errorCount' => $this->errorCount,
                'errors' => $this->errors,
                'warnings' => $this->warnings,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'successCount' => 0,
                'errorCount' => 1,
                'errors' => ["Error al procesar el archivo: {$e->getMessage()}"],
                'warnings' => [],
            ];
        }
    }

    /**
     * Valida una fila del Excel
     *
     * @param array $row
     * @param int $rowNumber
     * @param int $companyId
     * @return array|null
     */
    protected function validateRow(array $row, int $rowNumber, int $companyId): ?array
    {
        // Definir las reglas de validación
        $rules = [
            'fecha_entrega' => 'required|date',
            'direccion_entrega' => 'required|string|max:500',
            'categoria' => ['required', Rule::in(['servicio', 'proveeduria'])],
            'motivo' => 'required|string|max:600',
            'prioridad' => ['required', Rule::in(['baja', 'media', 'alta'])],
            'tipo' => ['required', Rule::in(['compra', 'servicio'])],
            'terminos_pago' => 'nullable|string|max:255',
            'confidencial' => 'nullable|boolean',
            'observaciones' => 'nullable|string|max:600',
            'codigo_proyecto' => 'required|string',
            'id_cadena_aprobacion' => 'required|integer',
        ];

        // Normalizar keys del array (minúsculas y sin espacios)
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            $normalizedKey = strtolower(trim(str_replace(' ', '_', $key)));
            $normalizedRow[$normalizedKey] = $value;
        }

        $validator = Validator::make($normalizedRow, $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->errors[] = "Fila {$rowNumber}: {$error}";
            }
            return null;
        }

        // Validar que exista el proyecto
        $project = ProjectPurchase::where('code', $normalizedRow['codigo_proyecto'])
            ->where('company_id', $companyId)
            ->first();

        if (!$project) {
            $this->errors[] = "Fila {$rowNumber}: No se encontró el proyecto con código '{$normalizedRow['codigo_proyecto']}'";
            return null;
        }

        // Validar que exista la cadena de aprobación
        $approvalChain = PurchaseRequisitionApprovalChain::find($normalizedRow['id_cadena_aprobacion']);

        if (!$approvalChain) {
            $this->errors[] = "Fila {$rowNumber}: No se encontró la cadena de aprobación con ID '{$normalizedRow['id_cadena_aprobacion']}'";
            return null;
        }

        return [
            'date_delivery' => $normalizedRow['fecha_entrega'],
            'delivery_address' => $normalizedRow['direccion_entrega'],
            'category' => $normalizedRow['categoria'],
            'motive' => $normalizedRow['motivo'],
            'priority' => $normalizedRow['prioridad'],
            'type' => $normalizedRow['tipo'],
            'term_payment' => $normalizedRow['terminos_pago'] ?? null,
            'confidential' => filter_var($normalizedRow['confidencial'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'observation' => $normalizedRow['observaciones'] ?? '',
            'project_id' => $project->id,
            'approval_chain_id' => $approvalChain->id,
        ];
    }

    /**
     * Crea una requisición de compra
     *
     * @param array $data
     * @param int $companyId
     * @return PurchaseRequisition
     */
    protected function createRequisition(array $data, int $companyId): PurchaseRequisition
    {
        // Generar folio
        $lastRequisition = PurchaseRequisition::where('company_id', $companyId)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastRequisition ? ((int) substr($lastRequisition->folio, -5)) + 1 : 1;
        $folio = 'REQ-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        // Crear la requisición
        $requisition = PurchaseRequisition::create([
            'folio' => $folio,
            'date_delivery' => $data['date_delivery'],
            'delivery_address' => $data['delivery_address'],
            'category' => $data['category'],
            'motive' => $data['motive'],
            'priority' => $data['priority'],
            'type' => $data['type'],
            'term_payment' => $data['term_payment'],
            'confidential' => $data['confidential'],
            'observation' => $data['observation'],
            'status' => 'borrador',
            'company_id' => $companyId,
            'project_id' => $data['project_id'],
            'approval_chain_id' => $data['approval_chain_id'],
        ]);

        return $requisition;
    }

    /**
     * Obtiene los errores de la importación
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Obtiene las advertencias de la importación
     *
     * @return array
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }
}
