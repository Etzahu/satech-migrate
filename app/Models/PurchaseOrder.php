<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\StateMachines\PurchaseOrderStateMachine;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;

class PurchaseOrder extends Model implements HasMedia
{
    use HasStateMachines;
    use InteractsWithMedia;

    protected $fillable = [
        'folio',
        'currency',
        'type_payment',
        'form_payment',
        'priority',
        'type',
        'term_payment',
        'condition_payment',
        'quote_folio',
        'use_cfdi',
        'shipping_method',
        'tax_iva',
        'discount',
        'retention_iva',
        'retention_isr',
        'retention_another',
        'initial_delivery_date',
        'final_delivery_date',
        'delivery_address',
        'documentation_delivery',
        'observations',
        'provider_id',
        'provider_contact_id',
        'purchaser_user_id',
        'company_id',
        'requisition_id',
        'status'
    ];
    public $stateMachines = [
        'status' => PurchaseOrderStateMachine::class
    ];
    protected function casts(): array
    {
        return [
            'documentation_delivery' => 'array'
        ];
    }


    public function requisition(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisition::class, 'requisition_id');
    }
    public function provider(): BelongsTo
    {
        return $this->belongsTo(PurchaseProvider::class, 'provider_id');
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function providerContact(): BelongsTo
    {
        return $this->belongsTo(ProviderContact::class, 'provider_contact_id', 'id');
    }
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id');
    }
    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'purchaser_user_id');
    }

    public function scopeMyRequisitions(Builder $query)
    {
        if (auth()->user()) {
            return $query
                ->where('purchaser_user_id', auth()->user()->id)
                ->where('company_id', session()->get('company_id'))
                ->orderBy('id', 'desc');
        }
    }
    public function scopeReviewManagement(Builder $query)
    {
        if (auth()->user()) {
            return $query->withWhereHas('requisition.approvalChain', function ($query) {
                $query->where('approver_id', auth()->user()->id);
            })
                ->where('status', 'aprobado por gerente de compras')
                ->where('company_id', session()->get('company_id'))
                ->orderBy('id', 'desc');
        }
    }
    public function scopeApprove(Builder $query)
    {
        return $query
            ->withWhereHas('requisition', function ($query) {
                $query->whereIn('approval_chain_id', auth()->user()->authorizerChainsPR->pluck('id')->unique()->toArray());
            })
            ->where('status', 'aprobado por gerente solicitante')
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }
    public function scopeAuthorize(Builder $query)
    {
        return $query
        
            ->where('status', 'aprobado por DG nivel 1')
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }
}
