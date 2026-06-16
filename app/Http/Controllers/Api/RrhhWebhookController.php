<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Rrhh\EmployeeSyncService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RrhhWebhookController extends Controller
{
    public function __construct(protected EmployeeSyncService $sync) {}

    /**
     * Recibe un webhook de colaboradores de rrhh. La firma ya fue
     * validada por el middleware; aquí solo se valida la forma del
     * sobre y se delega la sincronización al servicio.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'event' => ['required', 'string', 'in:employee.created,employee.updated,employee.deleted'],
            'data' => ['required', 'array'],
            'data.employee_id' => ['required', 'integer'],
        ]);

        $this->sync->handle($request->input('event'), $request->input('data'));

        return response()->json(['status' => 'ok'], 200);
    }
}
