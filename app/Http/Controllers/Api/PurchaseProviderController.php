<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PurchaseProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PurchaseProviderController extends Controller
{
    /**
     * Obtener todos los proveedores
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $providers = PurchaseProvider::with('contacts', 'userRequest', 'userApprove')
                ->orderBy('created_at', 'desc')
                ->get();

            $providersData = $providers->map(function ($provider) {
                return [
                    'id' => $provider->id,
                    'rfc' => $provider->rfc,
                    'company_name' => $provider->company_name,
                    'status' => $provider->status,
                    'address' => [
                        'street' => $provider->street,
                        'number' => $provider->number,
                        'neighborhood' => $provider->neighborhood,
                        'municipality' => $provider->municipality,
                        'state' => $provider->state,
                        'country' => $provider->country,
                        'cp' => $provider->cp,
                    ],
                    'banking' => [
                        'bank' => $provider->bank,
                        'bank_account' => $provider->bank_account,
                        'bank_account_number' => $provider->bank_account_number,
                    ],
                    'web_company' => $provider->web_company,
                    'approval_chain' => $provider->approval_chain,
                    'contacts_count' => $provider->contacts->count(),
                    'created_by' => $provider->userRequest->name ?? null,
                    'approved_by' => $provider->userApprove->name ?? null,
                    'created_at' => $provider->created_at,
                    'updated_at' => $provider->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'providers' => $providersData,
                    'total' => $providers->count()
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los proveedores',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo proveedor
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            // Información general (requeridos)
            'rfc' => 'required|string|max:30|unique:purchase_providers,rfc',
            'company_name' => 'required|string|max:255|unique:purchase_providers,company_name',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            
            // Información opcional
            'cp' => 'nullable|string|max:10',
            'web_company' => 'nullable|string|max:255|url',
            
            // Información bancaria
            'bank' => 'nullable|string|max:50',
            'bank_account' => 'nullable|string',
            'bank_account_number' => 'nullable|string',
            'approval_chain' => 'nullable|string|in:normal,especial',
            
            // ID del usuario que solicita (debe existir en la tabla users)
            'user_request_id' => 'required|exists:users,id',
            
            // Contactos (opcional, array de contactos)
            'contacts' => 'nullable|array',
            'contacts.*.name' => 'required_with:contacts|string|max:255',
            'contacts.*.job' => 'required_with:contacts|string|max:255',
            'contacts.*.email' => 'required_with:contacts|email|max:255',
            'contacts.*.cell_phone' => 'required_with:contacts|string|max:20',
            'contacts.*.phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Preparar datos del proveedor
            $providerData = [
                'rfc' => str($request->rfc)->trim()->upper()->toString(),
                'company_name' => str($request->company_name)->squish()->toString(),
                'street' => $request->street,
                'number' => $request->number,
                'neighborhood' => $request->neighborhood,
                'municipality' => $request->municipality,
                'state' => $request->state,
                'country' => $request->country,
                'cp' => $request->cp ?? 'N/A',
                'web_company' => $request->web_company,
                'bank' => $request->bank ?? 'N/A',
                'bank_account' => $request->bank_account ?? '0',
                'bank_account_number' => $request->bank_account_number ?? '0',
                'approval_chain' => $request->approval_chain ?? 'normal',
                'user_request_id' => $request->user_request_id,
                'user_approve_id' => $request->user_request_id, // Por defecto el mismo usuario
                'status' => 'borrador', // Estado inicial
            ];

            // Crear el proveedor
            $provider = PurchaseProvider::create($providerData);

            // Transicionar estados según la lógica existente
            $provider->status()->transitionTo('revisión');
            $provider->status()->transitionTo('aprobado');

            // Crear contactos si se proporcionaron
            if ($request->has('contacts') && is_array($request->contacts)) {
                foreach ($request->contacts as $contactData) {
                    $provider->contacts()->create([
                        'name' => $contactData['name'],
                        'job' => $contactData['job'],
                        'email' => $contactData['email'],
                        'cell_phone' => $contactData['cell_phone'],
                        'phone' => $contactData['phone'] ?? '',
                    ]);
                }
            }

            // Recargar el proveedor con sus relaciones
            $provider->load('contacts', 'userRequest', 'userApprove');

            return response()->json([
                'success' => true,
                'message' => 'Proveedor creado exitosamente',
                'data' => [
                    'provider' => [
                        'id' => $provider->id,
                        'rfc' => $provider->rfc,
                        'company_name' => $provider->company_name,
                        'status' => $provider->status,
                        'address' => [
                            'street' => $provider->street,
                            'number' => $provider->number,
                            'neighborhood' => $provider->neighborhood,
                            'municipality' => $provider->municipality,
                            'state' => $provider->state,
                            'country' => $provider->country,
                            'cp' => $provider->cp,
                        ],
                        'banking' => [
                            'bank' => $provider->bank,
                            'bank_account' => $provider->bank_account,
                            'bank_account_number' => $provider->bank_account_number,
                        ],
                        'web_company' => $provider->web_company,
                        'approval_chain' => $provider->approval_chain,
                        'contacts' => $provider->contacts,
                        'created_by' => $provider->userRequest->name ?? null,
                        'created_at' => $provider->created_at,
                        'updated_at' => $provider->updated_at,
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el proveedor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener información de un proveedor
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $provider = PurchaseProvider::with('contacts', 'userRequest', 'userApprove')->find($id);

            if (!$provider) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proveedor no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'provider' => [
                        'id' => $provider->id,
                        'rfc' => $provider->rfc,
                        'company_name' => $provider->company_name,
                        'status' => $provider->status,
                        'address' => [
                            'street' => $provider->street,
                            'number' => $provider->number,
                            'neighborhood' => $provider->neighborhood,
                            'municipality' => $provider->municipality,
                            'state' => $provider->state,
                            'country' => $provider->country,
                            'cp' => $provider->cp,
                        ],
                        'banking' => [
                            'bank' => $provider->bank,
                            'bank_account' => $provider->bank_account,
                            'bank_account_number' => $provider->bank_account_number,
                        ],
                        'web_company' => $provider->web_company,
                        'approval_chain' => $provider->approval_chain,
                        'contacts' => $provider->contacts,
                        'created_by' => $provider->userRequest->name ?? null,
                        'approved_by' => $provider->userApprove->name ?? null,
                        'created_at' => $provider->created_at,
                        'updated_at' => $provider->updated_at,
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el proveedor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
