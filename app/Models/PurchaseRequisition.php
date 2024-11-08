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
use Asantibanez\LaravelEloquentStateMachines\Models\StateHistory;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;

class PurchaseRequisition extends Model implements HasMedia
{
    Use HasStateMachines;
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
        'observation',
        'status',
        'company_id',
        'project_id',
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
    ];

    public $stateMachines = [
        'status' => PurchaseRequisitionStateMachine::class
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
    public function scopeMyRequisitions(Builder $query)
    {

        if (auth()->user()) {
            // return $query->whereIn('status', [
            //     'borrador',
            //     'devuelto por revisor',
            //     'devuelto por gerencia',
            //     'devuelto por DG'
            // ])
            return $query
                ->whereIn('approval_chain_id', auth()->user()->approvalChainsPurchaseRequisition->pluck('id')->toArray())
                ->where('company_id', session()->get('company_id'))
                ->orderBy('id', 'desc');
        }
    }
    public function scopeMyRequisitionsDraft(Builder $query)
    {
        if (auth()->user()) {
            return $query
                ->whereIn('approval_chain_id', auth()->user()->approvalChainsPurchaseRequisition->pluck('id')->toArray())
                ->where('company_id', session()->get('company_id'))
                ->where('status', 'borrador')
                ->orderBy('id', 'desc');
        }
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
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }
    public function scopeApprove(Builder $query)
    {
        return $query->where('status', 'aprobado por revisor')
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }
    public function scopeApproveDG(Builder $query)
    {
        return $query->where('status', 'aprobado por gerencia')
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }


}
