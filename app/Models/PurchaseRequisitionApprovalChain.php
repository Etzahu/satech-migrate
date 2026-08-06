<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseRequisitionApprovalChain extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'requester_id',
        'reviewer_id',
        'approver_id',
        'authorizer_id',
        'archived_at',
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
        'archived_at' => 'datetime',
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
     * @param  string  $role  'reviewer', 'approver', o 'authorizer'
     * @param  int  $newUserId  ID del nuevo usuario
     */
    public function updateApprovalRole(string $role, int $newUserId): bool
    {
        $field = $role.'_id';

        if (! in_array($field, ['reviewer_id', 'approver_id', 'authorizer_id'])) {
            return false;
        }

        $this->{$field} = $newUserId;

        return $this->save();
    }

    /**
     * Roles de la cadena que participan en el flujo de aprobación.
     *
     * @var array<int, string>
     */
    public const ROLES = ['requester', 'reviewer', 'approver', 'authorizer'];

    /**
     * Verifica si algún usuario en la cadena está inactivo (active = 0) o fue eliminado
     *
     * @return array Roles con usuarios inactivos
     */
    public function getInactiveUsers(): array
    {
        $inactive = [];

        $this->loadMissing(self::ROLES);

        foreach (self::ROLES as $role) {
            $user = $this->{$role};

            if (! $user || ! $user->active) {
                $inactive[$role] = $this->{$role.'_id'};
            }
        }

        return $inactive;
    }

    public function hasInactiveUsers(): bool
    {
        return ! empty($this->getInactiveUsers());
    }

    /**
     * Apagado manual: el administrador retira la cadena de circulación sin
     * borrarla, para conservar el historial de las requisiciones que la usaron.
     */
    public function isArchived(): bool
    {
        return filled($this->archived_at);
    }

    public function isSelectable(): bool
    {
        return ! $this->isArchived() && ! $this->hasInactiveUsers();
    }

    /**
     * Motivo por el que la cadena no puede usarse, o null si sí puede.
     * Se muestra al solicitante para que entienda por qué debe elegir otra.
     */
    public function unavailabilityReason(): ?string
    {
        if ($this->isArchived()) {
            return 'Esta cadena fue desactivada por el administrador.';
        }

        if ($inactive = $this->getInactiveUsers()) {
            $names = collect($inactive)
                ->keys()
                ->map(fn (string $role) => $this->{$role}?->name ?? 'usuario eliminado')
                ->implode(', ');

            return "Participantes inactivos en esta cadena: {$names}.";
        }

        return null;
    }

    /**
     * Cadenas cuyos cuatro participantes están activos.
     */
    public function scopeFullyActive(Builder $query): Builder
    {
        foreach (self::ROLES as $role) {
            $query->whereHas($role, fn (Builder $q) => $q->where('active', 1));
        }

        return $query;
    }

    public function scopeArchived(Builder $query): Builder
    {
        return $query->whereNotNull('archived_at');
    }

    public function scopeNotArchived(Builder $query): Builder
    {
        return $query->whereNull('archived_at');
    }

    /**
     * Cadenas que pueden asignarse a una requisición: ni archivadas por el
     * administrador ni con participantes dados de baja.
     */
    public function scopeSelectable(Builder $query): Builder
    {
        return $query->fullyActive()->notArchived();
    }

    /**
     * Cadenas con al menos un participante inactivo o inexistente.
     */
    public function scopeWithInactiveUsers(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            foreach (self::ROLES as $role) {
                $query->orWhereDoesntHave($role)
                    ->orWhereHas($role, fn (Builder $q) => $q->where('active', 0));
            }
        });
    }

    /**
     * Cadenas con requisiciones relacionadas (incluidas las eliminadas).
     */
    public function scopeInUse(Builder $query): Builder
    {
        return $query->whereHas('requisitions', fn (Builder $q) => $q->withTrashed());
    }

    /**
     * Cadenas sin ninguna requisición relacionada, por lo tanto eliminables.
     */
    public function scopeUnused(Builder $query): Builder
    {
        return $query->whereDoesntHave('requisitions', fn (Builder $q) => $q->withTrashed());
    }

    /**
     * Cuenta las requisiciones pendientes para esta cadena
     */
    public function getPendingRequisitionsCount(): int
    {
        return $this->requisitions()
            ->whereIn('status', [
                'revisión',
                'aprobado por revisor',
                'aprobado por gerencia',
                'revisión por almacén',
            ])
            ->count();
    }
}
