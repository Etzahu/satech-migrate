<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'unit_id',
        'category_id',
        'category_family_id',
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

    public function unit(): BelongsTo
    {
        return $this->belongsTo(MeasureUnit::class,'unit_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_family_id');
    }
}
