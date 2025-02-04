<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\StateMachines\PurchaseRequisitionStateMachine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;

class PurchaseRequisition extends Model implements HasMedia
{
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
                    'devuelto por comprador'
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
            ->has('responsiblePurchaseOrder')
            ->OrWhere('status', 'aprobado por DG')
            ->where('company_id', session()->get('company_id'))
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
