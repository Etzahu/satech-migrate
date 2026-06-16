<?php

namespace App\Models;

use App\Enums\ProviderEvaluationQuestion;
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
}
