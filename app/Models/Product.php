<?php

namespace App\Models;

use App\StateMachines\CatalogStatusStateMachine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;


class Product extends Model
{
    use HasFactory;
    Use HasStateMachines;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'status',
        'brand_id',
        'unit_id',
        'category_id',
        'category_family_id',
        'requester_id',
        'registered_user_id'
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
        'status' => CatalogStatusStateMachine::class
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(MeasureUnit::class,'unit_id');
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
