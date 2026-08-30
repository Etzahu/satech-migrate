<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Regla del nivel informativo: quién ve —sin aprobar— los documentos de una
 * gerencia.
 *
 * `category` nula significa "todas las categorías". Una gerencia puede tener
 * varias reglas y todas las que casan se aplican a la vez: en Manufactura +
 * servicio son informativos el titular de la gerencia *y* Jennifer.
 *
 * Se consulta siempre a través de PurchaseInformedService, que es la fuente
 * única del nivel para bandejas, policies y correos.
 */
class ManagementInformedRule extends Model
{
    protected $table = 'management_informed_rules';

    protected $fillable = [
        'management_id',
        'category',
        'user_id',
    ];

    protected $casts = [
        'management_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function management(): BelongsTo
    {
        return $this->belongsTo(Management::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Reglas que aplican a un documento de la gerencia y categoría dadas.
     *
     * Una categoría nula en el documento solo casa con las reglas generales:
     * `category = null` en SQL nunca es verdadero, que es justo lo que se
     * quiere —una regla específica de servicio no debe capturar un documento
     * sin categoría—.
     */
    public function scopeMatching(Builder $query, int $managementId, ?string $category): Builder
    {
        return $query
            ->where('management_id', $managementId)
            ->where(fn (Builder $rule) => $rule
                ->whereNull('category')
                ->orWhere('category', $category));
    }
}
