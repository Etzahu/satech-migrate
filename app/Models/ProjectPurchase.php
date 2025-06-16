<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\StateMachines\StatusPurchaseProjectMachine;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;

class ProjectPurchase extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasStateMachines;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'project_purchases';
    protected $fillable = [
        'name',
        'code',
        'status',
        'company_id',
        'requester_id',
        'registered_user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
    ];

    public $stateMachines = [
        'status' => StatusPurchaseProjectMachine::class
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'project_purchase_category');
    }
    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
    public function managements()
    {
        return $this->belongsToMany(Management::class, 'management_project_restrictions');
    }
}
