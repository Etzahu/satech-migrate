<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\PurchaseRequisitionCreationService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\StateMachines\PurchaseRequisitionStateMachine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\DeletedModels\Models\Concerns\KeepsDeletedModels;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;

class PurchaseRequisition extends Model implements HasMedia, Auditable
{
    use SoftDeletes, CascadeSoftDeletes;
    use \OwenIt\Auditing\Auditable;
    use HasStateMachines;
    use InteractsWithMedia;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'purchase_requisitions';
    protected $fillable = [
        'folio',
        'date_delivery',
        'delivery_address',
        'category',
        'motive',
        'priority',
        'type',
        'term_payment',
        'confidential',
        'observation',
        'status',
        'company_id',
        'project_id',
        'assign_user_id',
        'approval_chain_id',
    ];
    protected $auditInclude = [
        'date_delivery',
        'delivery_address',
        'motive',
        'priority',
        'type',
        'term_payment',
        'confidential',
        'observation',
        'company_id',
        'project_id',
        'assign_user_id',
        'approval_chain_id',
    ];
    protected $cascadeDeletes = ['items'];
    protected $dates = ['deleted_at'];
    protected $casts = [
        'id' => 'integer',
        'request_user_id' => 'integer',
        'date_delivery' => 'date',
        'approval_chain_id' => 'integer',
        'assign_user_id' => 'integer',
        'confidential' => 'boolean',
    ];

    public $stateMachines = [
        'status' => PurchaseRequisitionStateMachine::class,
    ];
    public static $estadosProgreso = [
        'borrador' => 0,
        'cadena reasignada' => 0,
        'revisión por almacén' => 20,
        'revisión' => 40,
        'aprobado por revisor' => 60,
        'aprobado por gerencia' => 80,
        'aprobado por DG' => 90,
        'comprador asignado' => 95,
        'comprador reasignado' => 95,
        'cerrada' => 100,
        'cancelado por revisor' => 0,
        'cancelado por gerencia' => 0,
        'cancelado por DG' => 0,
        'devuelto por revisor' => 40,
        'devuelto por gerencia' => 40,
        'devuelto por DG' => 40,
        'devuelto por almacén' => 20,
        'devuelto por comprador' => 40,
        'devuelto por gerente de compras' => 40,
    ];

    public function getProgresoAttribute()
    {
        return self::$estadosProgreso[$this->status] ?? 0;
    }

    public function getRevisionDates()
    {
        $revisiones = [
            'revisión por almacén',
            'revisión',
            'aprobado por revisor',
            'aprobado por gerencia',
            'aprobado por DG',
            'comprador asignado',
            'comprador reasignado'
        ];

        if (session()->get('company_id') == 2) {
            if ($this->category == 'servicio') {
                // unset($revisiones['revisión por almacén']);
                unset($revisiones[0]);
            }
        }

        // Encontrar la última devolución o reasignación que reinicia el ciclo
        $ultimaDevolucion = $this->status()->history()
            ->where('field', 'status')
            ->whereIn('to', [
                'devuelto por almacén',
                'devuelto por revisor',
                'devuelto por gerencia',
                'devuelto por DG',
                'devuelto por gerente de compras',
                'devuelto por comprador',
                'cadena reasignada'
            ])
            ->orderBy('created_at', 'desc')
            ->first();

        $fechas = [];
        foreach ($revisiones as $revision) {
            $query = $this->status()->history()
                ->where('field', 'status')
                ->where('to', $revision)
                ->orderBy('created_at', 'desc'); // Última entrada a la revisión

            // Si hay una devolución, filtrar por registros posteriores a ella
            if ($ultimaDevolucion) {
                $query->where('created_at', '>', $ultimaDevolucion->created_at);
            }

            $registro = $query->first();
            $fechas[$revision] = $registro ? $registro->created_at : null;
        }
        return $fechas;
    }

    public function getProgressAttribute()
    {
        $progress = [];
        /**
           'revisión por almacén',
            'revisión',
            'aprobado por revisor',
            'aprobado por gerencia',
            'aprobado por DG',
            'comprador asignado',
            'comprador reasignado'
         */
        $data = $this->getRevisionDates();
        if (session()->get('company_id') == 2) { //ID 1:GPT IM
            if ($this->category == 'servicio') {
                $progress = [
                    'requester' => ['title' => 'Solicita', 'name' => $this->approvalChain->requester->name, 'date' => $data['revisión']],
                    'reviewer' => ['title' => 'Revisa', 'name' => $this->approvalChain->reviewer->name, 'date' => $data['aprobado por revisor']],
                    'approver' => ['title' => 'Aprueba', 'name' => $this->approvalChain->approver->name, 'date' => $data['aprobado por gerencia']],
                    'authorizer' => ['title' => 'Autoriza', 'name' => $this->approvalChain->authorizer->name, 'date' => $data['aprobado por DG']],
                    'purchaser' => ['title' => 'Comprador', 'name' => (filled($this->purchaser) ? $this->purchaser->name : 'Sin asignar'), 'date' => $data['comprador asignado']],
                ];
            }
            if ($this->category == 'proveeduria') {
                $progress = [
                    'requester' => ['title' => 'Solicita', 'name' => $this->approvalChain->requester->name, 'date' => $data['revisión por almacén']],
                    'warehouse' => ['title' => 'Almacén', 'name' => 'N/A', 'date' => $data['revisión']],
                    'reviewer' => ['title' => 'Revisa', 'name' => $this->approvalChain->reviewer->name, 'date' => $data['aprobado por revisor']],
                    'approver' => ['title' => 'Aprueba', 'name' => $this->approvalChain->approver->name, 'date' => $data['aprobado por gerencia']],
                    'authorizer' => ['title' => 'Autoriza', 'name' => $this->approvalChain->authorizer->name, 'date' => $data['aprobado por DG']],
                    'purchaser' => ['title' => 'Comprador', 'name' => (filled($this->purchaser) ? $this->purchaser->name : 'Sin asignar'), 'date' => $data['comprador asignado']],
                ];
            }

            if (blank($this->category)) {
                $progress = [
                    'requester' => ['title' => 'Solicita', 'name' => $this->approvalChain->requester->name, 'date' => $data['revisión por almacén']],
                    'warehouse' => ['title' => 'Almacén', 'name' => 'N/A', 'date' => $data['revisión']],
                    'reviewer' => ['title' => 'Revisa', 'name' => $this->approvalChain->reviewer->name, 'date' => $data['aprobado por revisor']],
                    'approver' => ['title' => 'Aprueba', 'name' => $this->approvalChain->approver->name, 'date' => $data['aprobado por gerencia']],
                    'authorizer' => ['title' => 'Autoriza', 'name' => $this->approvalChain->authorizer->name, 'date' => $data['aprobado por DG']],
                    'purchaser' => ['title' => 'Comprador', 'name' => (filled($this->purchaser) ? $this->purchaser->name : 'Sin asignar'), 'date' => $data['comprador asignado']],
                ];
            }
        }
        if (session()->get('company_id') == 1) { //ID 1:GPT IM
            $progress = [
                'requester' => ['title' => 'Solicita', 'name' => $this->approvalChain->requester->name, 'date' => $data['revisión por almacén']],
                'warehouse' => ['title' => 'Almacén', 'name' => 'N/A', 'date' => $data['revisión']],
                'reviewer' => ['title' => 'Revisa', 'name' => $this->approvalChain->reviewer->name, 'date' => $data['aprobado por revisor']],
                'approver' => ['title' => 'Aprueba', 'name' => $this->approvalChain->approver->name, 'date' => $data['aprobado por gerencia']],
                'authorizer' => ['title' => 'Autoriza', 'name' => $this->approvalChain->authorizer->name, 'date' => $data['aprobado por DG']],
                'purchaser' => ['title' => 'Comprador', 'name' => (filled($this->purchaser) ? $this->purchaser->name : 'Sin asignar'), 'date' => $data['comprador asignado']],
            ];
        }

        return $progress;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function approvalChain(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisitionApprovalChain::class, 'approval_chain_id');
    }
    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectPurchase::class, 'project_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseRequisitionItem::class, 'requisition_id');
    }

    public function responsiblePurchaseOrder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assign_user_id');
    }
    public function orders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'requisition_id');
    }
    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assign_user_id');
    }
    // SCOPES
    public function scopeMyRequisitions(Builder $query)
    {
        return $query
            ->whereIn('approval_chain_id', auth()->user()->approvalChainsPurchaseRequisition->pluck('id')->toArray())
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }
    public function scopeMyRequisitionsDraft(Builder $query)
    {
        return $query
            ->whereIn('approval_chain_id', auth()->user()->approvalChainsPurchaseRequisition->pluck('id')->toArray())
            ->where('company_id', session()->get('company_id'))
            ->whereIn('status', [
                'borrador',
                'devuelto por almacén',
                'devuelto por revisor',
                'devuelto por gerencia',
                'devuelto por DG',
                'devuelto por comprador',
                'devuelto por gerente de compras',
                'cadena reasignada'
            ])
            ->orderBy('id', 'desc');
    }
    public function scopeReviewWarehouse(Builder $query)
    {
        return $query->where('status', 'revisión por almacén')
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }
    public function scopeReview(Builder $query)
    {
        return $query->where('status', 'revisión')
            ->whereIn('approval_chain_id', auth()->user()->reviewerChainsPR->pluck('id')->toArray())
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }
    public function scopeApprove(Builder $query)
    {
        return $query->where('status', 'aprobado por revisor')
            ->whereIn('approval_chain_id', auth()->user()->approverChainsPR->pluck('id')->toArray())
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }
    public function scopeAuthorize(Builder $query)
    {
        return $query->where('status', 'aprobado por gerencia')
            ->whereIn('approval_chain_id', auth()->user()->authorizerChainsPR->pluck('id')->toArray())
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }
    public function scopeReadyAssing(Builder $query)
    {
        return $query
            ->where('company_id', session()->get('company_id'))
            ->where(function ($query) {
                $query->where('status', 'aprobado por DG')
                    ->orWhereNotNull('assign_user_id'); // Si "comprador" no es NULL (está lleno)
            })
            ->orderBy('id', 'desc');
    }
    public function scopeReadyAssingCount(Builder $query)
    {
        return $query
            ->where('status', 'aprobado por DG')
            ->where('company_id', session()->get('company_id'))
            ->count();
    }
    public function scopeMyAssing(Builder $query)
    {
        return $query
            ->where('assign_user_id', auth()->user()->id)
            // ->OrWhere('status', 'aprobado por DG')
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }

    /**
     * Reasigna la cadena de aprobación de esta requisición
     *
     * @param int $newApprovalChainId ID de la nueva cadena de aprobación
     * @param bool $resetToStart Si es true, regresa la requisición al estado inicial
     * @return bool
     */
    public function reassignApprovalChain(int $newApprovalChainId, bool $resetToStart = false): bool
    {
        $oldChainId = $this->approval_chain_id;
        $this->approval_chain_id = $newApprovalChainId;

        if ($resetToStart) {
            $this->resetToInitialState($oldChainId);
        }

        return $this->save();
    }

    /**
     * Regresa la requisición al estado inicial según su categoría
     *
     * @param int|null $oldChainId ID de la cadena anterior para el historial
     * @return void
     */
    public function resetToInitialState(?int $oldChainId = null): void
    {
        // Usar estado 'cadena reasignada' para indicar que hubo un cambio de cadena
        $this->status()->transitionTo('cadena reasignada', [
            'old_chain_id' => $oldChainId
        ]);
    }

    /**
     * Reasigna la cadena y resetea al inicio del proceso
     * Este es un método de conveniencia que combina reasignación y reseteo
     *
     * @param int $newApprovalChainId ID de la nueva cadena de aprobación
     * @return bool
     */
    public function reassignAndReset(int $newApprovalChainId): bool
    {
        return $this->reassignApprovalChain($newApprovalChainId, true);
    }

    /**
     * Verifica si la requisición está bloqueada por un usuario inactivo
     *
     * @return bool
     */
    public function isBlockedByInactiveUser(): bool
    {
        // Solo verificar si está en estados de aprobación pendiente
        $pendingStates = [
            'revisión',
            'aprobado por revisor',
            'aprobado por gerencia'
        ];

        if (!in_array($this->status, $pendingStates)) {
            return false;
        }

        $this->load('approvalChain.reviewer', 'approvalChain.approver', 'approvalChain.authorizer');

        // Verificar según el estado actual
        switch ($this->status) {
            case 'revisión':
                return $this->approvalChain->reviewer?->trashed() ?? false;
            case 'aprobado por revisor':
                return $this->approvalChain->approver?->trashed() ?? false;
            case 'aprobado por gerencia':
                return $this->approvalChain->authorizer?->trashed() ?? false;
            default:
                return false;
        }
    }

    /**
     * Obtiene el usuario que actualmente debería revisar/aprobar esta requisición
     *
     * @return User|null
     */
    public function getCurrentApprover(): ?User
    {
        $this->load('approvalChain.reviewer', 'approvalChain.approver', 'approvalChain.authorizer');

        return match ($this->status) {
            'revisión' => $this->approvalChain->reviewer,
            'aprobado por revisor' => $this->approvalChain->approver,
            'aprobado por gerencia' => $this->approvalChain->authorizer,
            default => null,
        };
    }

    /**
     * Scope para requisiciones bloqueadas por usuarios inactivos
     */
    public function scopeBlockedByInactiveUsers(Builder $query)
    {
        return $query->whereIn('status', [
            'revisión',
            'aprobado por revisor',
            'aprobado por gerencia'
        ])
            ->where('company_id', session()->get('company_id'))
            ->whereHas('approvalChain', function ($q) {
                $q->where(function ($subQ) {
                    // Requisiciones en revisión con reviewer eliminado
                    $subQ->whereHas('reviewer', function ($userQ) {
                        $userQ->onlyTrashed();
                    })->whereIn('purchase_requisitions.status', ['revisión']);
                })
                    ->orWhere(function ($subQ) {
                        // Requisiciones aprobadas por revisor con approver eliminado
                        $subQ->whereHas('approver', function ($userQ) {
                            $userQ->onlyTrashed();
                        })->whereIn('purchase_requisitions.status', ['aprobado por revisor']);
                    })
                    ->orWhere(function ($subQ) {
                        // Requisiciones aprobadas por gerencia con authorizer eliminado
                        $subQ->whereHas('authorizer', function ($userQ) {
                            $userQ->onlyTrashed();
                        })->whereIn('purchase_requisitions.status', ['aprobado por gerencia']);
                    });
            });
    }
}
