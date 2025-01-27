<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\StateMachines\CatalogStatusStateMachine;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;


class Product extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    use HasStateMachines;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'status',
        'company_id',
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

    // protected static function booted(): void
    // {
    //     static::addGlobalScope('company', function (Builder $builder) {
    //         $builder->where('company_id', session()->get('company_id'));
    //     });
    // }

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
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
}
