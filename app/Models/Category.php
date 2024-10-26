<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function families()
    {
        return $this->hasMany(CategoryFamily::class, 'category_id');
    }
    public function projectPurchases(): BelongsToMany
    {
        return $this->belongsToMany(ProjectPurchase::class, 'project_purchase_category');
    }
}
