<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drawing extends Model
{
    use HasFactory;
    protected $fillable = [
        'folio',
        'drawing_category_id',
        'sub_drawing_category_id',
        'user_id',
    ];

    public function responsible(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function drawingCategory(){
        return $this->belongsTo(DrawingCategory::class);
    }
    public function subDrawingCategory(){
        return $this->belongsTo(SubDrawingCategory::class);
    }
}
