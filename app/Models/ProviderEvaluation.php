<?php

namespace App\Models;

use App\Services\ProviderEvaluationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

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

    /**
     * Pending responses the user has to answer: their own plus the unassigned
     * (pool) ones for a role they hold.
     *
     * @return Collection<int, ProviderEvaluationResponse>
     */
    public function pendingResponsesFor(?User $user): Collection
    {
        if (! $user) {
            return collect();
        }

        $poolRoles = ProviderEvaluationService::poolRolesFor($user);

        return $this->responses
            ->whereNull('answered_at')
            ->filter(fn (ProviderEvaluationResponse $response) => $response->respondent_id === $user->id
                || ($response->respondent_id === null && in_array($response->respondent_role, $poolRoles, true)))
            ->values();
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
