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
        'observations',
        'provider_id',
        'purchaser_user_id',
        'company_id',
        'requisition_id',
        'status'
    ];
    public $stateMachines = [
        'status' => PurchaseOrderStateMachine::class
    ];
    public function requisition(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisition::class, 'requisition_id');
    }
    public function provider(): BelongsTo
    {
        return $this->belongsTo(PurchaseProvider::class, 'provider_id');
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
        if (auth()->user()) {
            return $query
                ->where('company_id', session()->get('company_id'))
                ->orderBy('id', 'desc');
        }
    }
}
