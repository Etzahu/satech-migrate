<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\HasOne;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable  implements FilamentUser
{
    use HasFactory, Notifiable;
    use HasRoles;
    use HasPanelShield;

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
    public function managementResponsible()
    {
        return $this->hasOne(Management::class, 'responsible_id');
    }
    public function approvalChainsPurchaseRequisition()
    {
        return $this->hasMany(PurchaseRequisitionApprovalChain::class, 'requester_id');
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
    public function scopeApprovers()
    {
        $management = Management::all()->pluck('responsible_id')->unique();
        return $this->whereIn('id', $management);
    }
}
