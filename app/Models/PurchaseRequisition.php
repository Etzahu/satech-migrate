<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseRequisition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'folio',
        'request_user_id',
        'date_delivery',
        'delivery_address',
        'type',
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

    public function requestUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvalChain(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisitionApprovalChain::class);
    }
}
