<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Management extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'management';
    protected $fillable = [
        'name',
        'acronym',
        'restriction_requisition',
        'responsible_id',
        'purchase_order_flow',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'responsible_id' => 'integer',
        'purchase_order_flow' => 'boolean',
    ];

    public function projects()
    {
        return $this->belongsToMany(ProjectPurchase::class, 'management_project_restrictions');
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'management_id');
    }

    /**
     * Reglas del nivel informativo de esta gerencia.
     *
     * Se mantienen desde el relation manager de ManagementResource: cambiar
     * quién está informado no debe requerir un despliegue.
     */
    public function informedRules(): HasMany
    {
        return $this->hasMany(ManagementInformedRule::class);
    }
}
