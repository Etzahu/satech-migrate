<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDrawingCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'drawing_category_id',
    ];

    public function drawingCategory()
    {
        return $this->belongsTo(DrawingCategory::class);
    }
}
