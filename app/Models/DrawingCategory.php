<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrawingCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code'
    ];

    public function subDrawingCategories()
    {
        return $this->hasMany(SubDrawingCategory::class);
    }
}
