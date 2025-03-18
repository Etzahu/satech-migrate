<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseRequisitionItem extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $table = 'purchase_requisition_items';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity_requested',
        'quantity_purchase',
        'quantity_warehouse',
        'observation',
        'user_warehouse_id',
        'requisition_id',
        'product_id',
    ];
    protected $auditInclude = [
        'quantity_requested',
        'quantity_purchase',
        'quantity_warehouse',
        'observation',
        'user_warehouse_id',
        'requisition_id',
        'product_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'requisition_id' => 'integer',
        'product_id' => 'integer',
    ];

    public function requisition(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisition::class, 'requisition_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function userWarehouse(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_warehouse_id','id');
    }
}
