<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;
    use HasPanelShield;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'profile_image',
        'puesto',
        'active',
        'management_id',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@gptservices.com');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function management()
    {
        return $this->belongsTo(Management::class, 'management_id', 'id');
    }

    public function approvalChainsPurchaseRequisition()
    {
        return $this->hasMany(PurchaseRequisitionApprovalChain::class, 'requester_id');
    }

    /**
     * Usuarios con alguno de los roles indicados.
     *
     * Alternativa al scope `role()` de Spatie, que lanza RoleDoesNotExist
     * cuando el rol todavía no existe en la base —por ejemplo si la migración
     * que lo crea no corrió en ese entorno—. Aquí un rol inexistente
     * simplemente no aporta a nadie, que es lo que quiere quien arma una lista
     * de destinatarios o de permitidos.
     *
     * @param  string|array<int, string>  $role
     */
    public function scopeWithRole(Builder $query, string|array $role): Builder
    {
        return $query->whereHas('roles', fn (Builder $q) => $q->whereIn('name', (array) $role));
    }

    /**
     * Retira todos los roles del usuario y deja constancia en el log de cuáles
     * tenía, para poder devolvérselos si regresa.
     *
     * Se usa al darlo de baja: un usuario inactivo ya no firma, y con el rol
     * puesto seguía apareciendo en las listas que buscan a alguien con ese
     * rol (por ejemplo, el revisor que propone "Verificar órdenes").
     *
     * @return array<int, string> Nombres de los roles retirados
     */
    public function revokeAllRoles(): array
    {
        // Se recargan: la relación en memoria puede no reflejar lo que otro
        // paso guardó después, como la casilla de roles del formulario.
        $roles = $this->load('roles')->getRoleNames()->all();

        if ($roles === []) {
            return [];
        }

        $this->syncRoles([]);

        Log::info('Roles retirados al dar de baja al usuario', [
            'user_id' => $this->getKey(),
            'name' => $this->name,
            'roles' => $roles,
        ]);

        return $roles;
    }

    public function reviewerChainsPR(): HasMany
    {
        return $this->hasMany(PurchaseRequisitionApprovalChain::class, 'reviewer_id');
    }

    public function approverChainsPR(): HasMany
    {
        return $this->hasMany(PurchaseRequisitionApprovalChain::class, 'approver_id');
    }

    public function authorizerChainsPR(): HasMany
    {
        return $this->hasMany(PurchaseRequisitionApprovalChain::class, 'authorizer_id');
    }
}
