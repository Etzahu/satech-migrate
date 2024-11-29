<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderContact extends Model
{
    protected $fillable = [
        'name',
        'job',
        'email',
        'cell_phone',
        'phone',
        'provider_id',
    ];
    public function provider()
    {
        return $this->belongsTo(PurchaseProvider::class,'provider_id');
    }
}
