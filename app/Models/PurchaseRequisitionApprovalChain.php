<?php

namespace App\Models;

use LaravelArchivable\Archivable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseRequisitionApprovalChain extends Model
{
    use HasFactory;
     use Archivable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'requester_id',
        'reviewer_id',
        'approver_id',
        'authorizer_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'requester_id' => 'integer',
        'reviewer_id' => 'integer',
        'approver_id' => 'integer',
        'authorizer_id' => 'integer',
    ];


    public function requisitions(): HasMany
    {
        return $this->hasMany(PurchaseRequisition::class, 'approval_chain_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
    public function authorizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'authorizer_id');
    }

    /**
     * Actualiza un rol específico en la cadena de aprobación
     *
     * @param string $role 'reviewer', 'approver', o 'authorizer'
     * @param int $newUserId ID del nuevo usuario
     * @return bool
     */
    public function updateApprovalRole(string $role, int $newUserId): bool
    {
        $field = $role . '_id';

        if (!in_array($field, ['reviewer_id', 'approver_id', 'authorizer_id'])) {
            return false;
        }

        $this->{$field} = $newUserId;
        return $this->save();
    }

    /**
     * Verifica si algún usuario en la cadena está inactivo (soft deleted)
     *
     * @return array Roles con usuarios inactivos
     */
    public function getInactiveUsers(): array
    {
        $inactive = [];

        $this->load('reviewer', 'approver', 'authorizer');

        if ($this->reviewer && $this->reviewer->trashed()) {
            $inactive['reviewer'] = $this->reviewer_id;
        }
        if ($this->approver && $this->approver->trashed()) {
            $inactive['approver'] = $this->approver_id;
        }
        if ($this->authorizer && $this->authorizer->trashed()) {
            $inactive['authorizer'] = $this->authorizer_id;
        }

        return $inactive;
    }

    /**
     * Cuenta las requisiciones pendientes para esta cadena
     *
     * @return int
     */
    public function getPendingRequisitionsCount(): int
    {
        return $this->requisitions()
            ->whereIn('status', [
                'revisión',
                'aprobado por revisor',
                'aprobado por gerencia',
                'revisión por almacén'
            ])
            ->count();
    }
}
