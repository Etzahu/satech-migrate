<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProviderEvaluation extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'type',
        'status',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(ProviderEvaluationResponse::class);
    }

    public function totalScore(): int
    {
        return (int) $this->responses->sum('score');
    }

    public function isCompleted(): bool
    {
        return $this->responses->isNotEmpty()
            && $this->responses->every(fn ($r) => $r->answered_at !== null);
    }

    public function markCompletedIfAllAnswered(): void
    {
        if ($this->isCompleted()) {
            $this->update(['status' => 'completed']);
        }
    }
}
