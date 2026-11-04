<?php

namespace App\Models;

use App\StateMachines\CatalogStatusStateMachine;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LogicException;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use HasStateMachines;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'status',
        'type_purchase',
        'company_id',
        'brand_id',
        'unit_id',
        'category_id',
        'category_family_id',
        'requester_id',
        'registered_user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unit_id' => 'integer',
        'category_id' => 'integer',
    ];

    public $stateMachines = [
        'status' => CatalogStatusStateMachine::class,
    ];

    // protected static function booted(): void
    // {
    //     static::addGlobalScope('company', function (Builder $builder) {
    //         $builder->where('company_id', session()->get('company_id'));
    //     });
    // }

    /**
     * Las partidas de requisición y de orden de compra apuntan al producto con
     * ON DELETE CASCADE: borrar un producto usado borraría esas partidas. Esta
     * guarda cubre cualquier borrado, no solo el botón del catálogo.
     */
    protected static function booted(): void
    {
        static::deleting(function (Product $product): void {
            $purchaseLinesCount = $product->purchaseLinesCount();

            if ($purchaseLinesCount > 0) {
                throw new LogicException("El producto {$product->id} se usa en {$purchaseLinesCount} partidas de compra; borrarlo borraría también esas partidas.");
            }
        });
    }

    /**
     * Observación que Compras capturó al rechazar la solicitud; se guarda en el
     * historial de estatus como la `respuesta` de las demás aprobaciones.
     */
    public function rejectionReason(): ?string
    {
        if ($this->status !== 'rechazado') {
            return null;
        }

        return $this->status()->getCustomProperty('respuesta');
    }

    /**
     * Partidas de requisición (incluidas las que están en papelera) y de orden
     * de compra que usan este producto, como producto pedido o como reemplazo.
     */
    public function purchaseLinesCount(): int
    {
        return PurchaseRequisitionItem::withTrashed()->where('product_id', $this->id)->count()
            + PurchaseOrderItem::query()
                ->where(fn (Builder $query) => $query
                    ->where('product_id', $this->id)
                    ->orWhere('product_replace_id', $this->id))
                ->count();
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(MeasureUnit::class, 'unit_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function categoryFamily(): BelongsTo
    {
        return $this->belongsTo(CategoryFamily::class, 'category_family_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
}
