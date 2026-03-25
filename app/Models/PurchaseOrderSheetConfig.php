<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrderSheetConfig extends Model
{
    protected $fillable = [
        'user_id',
        'columns',
        'days_range',
        'custom_start_date',
        'date_range_type',
        'buyers',
        'type_purchase',
        'is_active',
    ];

    protected $casts = [
        'columns' => 'array',
        'buyers' => 'array',
        'type_purchase' => 'array',
        'is_active' => 'boolean',
        'custom_start_date' => 'date',
    ];

    /**
     * Relación con el usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener columnas por defecto
     */
    public static function defaultColumns(): array
    {
        return [
            'fecha de creacion',
            'comprador',
            'folio',
            'proveedor',
            'subtotal',
            'total',
            'partidas',
            'moneda',
            'proyecto',
            'estatus'
        ];
    }

    /**
     * Obtener o crear configuración para un usuario
     */
    public static function getOrCreateForUser(int $userId): self
    {
        return static::firstOrCreate(
            ['user_id' => $userId],
            [
                'columns' => static::defaultColumns(),
                'days_range' => 30,
                'date_range_type' => 'days',
                'is_active' => true,
            ]
        );
    }
}
