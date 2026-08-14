<?php

namespace App\Models;

use App\Enums\ProviderEvaluationQuestion;
use App\Services\ProviderEvaluationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderEvaluationResponse extends Model
{
    protected $fillable = [
        'provider_evaluation_id',
        'question',
        'respondent_role',
        'respondent_id',
        'selected_option',
        'score',
        'answered_at',
    ];

    protected function casts(): array
    {
        return [
            'answered_at' => 'datetime',
            'score' => 'integer',
        ];
    }

    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(ProviderEvaluation::class, 'provider_evaluation_id');
    }

    public function respondent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'respondent_id');
    }

    public function questionEnum(): ProviderEvaluationQuestion
    {
        return ProviderEvaluationQuestion::from($this->question);
    }

    public function isPending(): bool
    {
        return $this->answered_at === null;
    }

    /**
     * Responses the user is responsible for: the ones assigned to them plus the
     * unassigned (pool) ones belonging to a role they hold.
     */
    public function scopeForRespondent(Builder $query, ?User $user): Builder
    {
        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        $poolRoles = ProviderEvaluationService::poolRolesFor($user);

        return $query->where(function (Builder $query) use ($user, $poolRoles) {
            $query->where('respondent_id', $user->id);

            if ($poolRoles !== []) {
                $query->orWhere(fn (Builder $pool) => $pool
                    ->whereNull('respondent_id')
                    ->whereIn('respondent_role', $poolRoles));
            }
        });
    }
}
