<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\StateMachines\StatusPurchaseProviderMachine;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;

class PurchaseProvider extends Model implements HasMedia
{
    use HasStateMachines;
    use InteractsWithMedia;
    protected $fillable = [
        'rfc',
        'company_name',
        'street',
        'number',
        'neighborhood',
        'municipality',
        'state',
        'country',
        'cp',
        'web_company',
        'bank',
        'bank_account',
        'bank_account_number',
        'approval_chain',
        'status',
        'user_request_id',
        'user_approve_id',
    ];

    public $stateMachines = [
        'status' => StatusPurchaseProviderMachine::class,
    ];

    public function userRequest()
    {
        return $this->belongsTo(User::class, 'user_request_id');
    }
    public function userApprove()
    {
        return $this->belongsTo(User::class, 'user_approve_id');
    }
    public function contacts()
    {
        return $this->hasMany(ProviderContact::class, 'provider_id');
    }
}
