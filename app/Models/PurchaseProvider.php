<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\StateMachines\StatusPurchaseProviderMachine;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;

class PurchaseProvider extends Model
{
    Use HasStateMachines;
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
        'status',
        'user_request_id',
        'user_approve_id',
    ];

    public $stateMachines = [
        'status' => StatusPurchaseProviderMachine::class,
    ];

    public function UserRequest()
    {
        return $this->belongsTo(User::class, 'user_request_id');
    }
    public function UserApprove()
    {
        return $this->belongsTo(User::class, 'user_approve_id');
    }
    public function contacts()
    {
        return $this->hasMany(ProviderContact::class, 'provider_id');
    }
}
