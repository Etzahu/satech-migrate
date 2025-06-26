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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
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

        // Encontrar la última devolución que reinicia el ciclo
        $ultimaDevolucion = $this->status()->history()
            ->where('field', 'status')
            ->whereIn('to', [
                'devuelto por comprador',
                'devuelto por gerente de compras',
                'devuelto por DG',
                'devuelto por gerencia',
                'devuelto por revisor',
                'devuelto por almacén'
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
            $fechas[$revision] = $registro ? $registro->created_at->format('d-m-Y') : null;
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

            if (blank($this->category) ) {
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
                'devuelto por gerente de compras'
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
}
