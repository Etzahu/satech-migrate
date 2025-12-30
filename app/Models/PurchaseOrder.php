<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Services\OrderCalculationService;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\StateMachines\PurchaseOrderStateMachine;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;

class PurchaseOrder extends Model implements HasMedia, Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasStateMachines;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'folio',
        'currency',
        'type_payment',
        'form_payment',
        // 'term_payment',
        'condition_payment',
        'quote_folio',
        'use_cfdi',
        'shipping_method',
        'tax_iva',
        'discount',
        'retention_iva',
        'retention_isr',
        'retention_another',
        'initial_delivery_date',
        'final_delivery_date',
        'delivery_address',
        'documentation_delivery',
        'observations',
        'provider_id',
        'provider_contact_id',
        'purchaser_user_id',
        'company_id',
        'requisition_id',
        'status'
    ];
    protected $auditInclude = [
        'folio',
        'currency',
        'type_payment',
        'form_payment',
        // 'term_payment' se unifico term payment y condition_payment,
        'condition_payment',
        'quote_folio',
        'use_cfdi',
        'shipping_method',
        'tax_iva',
        'discount',
        'retention_iva',
        'retention_isr',
        'retention_another',
        'initial_delivery_date',
        'final_delivery_date',
        'delivery_address',
        'documentation_delivery',
        'observations',
        'provider_id',
        'provider_contact_id',
        'purchaser_user_id',
        'company_id',
        'requisition_id',
        'status'
    ];
    public $stateMachines = [
        'status' => PurchaseOrderStateMachine::class
    ];

    protected $casts = [
        'documentation_delivery' => 'array',
        'condition_payment' => 'array',

    ];




    public static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $ticket->folio = session()->get('company_acronym') . self::generateFolioNumber() . '/' . now()->format('y');
        });
    }
    private static function generateFolioNumber()
    {
        $count = self::withTrashed()
            ->where('company_id', session()->get('company_id'))
            ->whereYear('created_at', now()->year)
            ->count();
        if (filled($count)) {
            return str_pad($count + 1, 2, '0', STR_PAD_LEFT);
        } else {
            return '01';
        }
    }
    public function requisition(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisition::class, 'requisition_id');
    }
    public function provider(): BelongsTo
    {
        return $this->belongsTo(PurchaseProvider::class, 'provider_id');
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function providerContact(): BelongsTo
    {
        return $this->belongsTo(ProviderContact::class, 'provider_contact_id', 'id');
    }
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id');
    }
    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'purchaser_user_id');
    }
    public function scopeMyRequisitions(Builder $query)
    {
        if (auth()->user()) {
            return $query
                ->where('purchaser_user_id', auth()->user()->id)
                ->where('company_id', session()->get('company_id'))
                ->orderBy('id', 'desc');
        }
    }
    public function scopeReviewManagement(Builder $query)
    {
        if (auth()->user()) {
            return $query->withWhereHas('requisition.approvalChain', function ($query) {
                $query->where('approver_id', auth()->user()->id);
            })
                ->where('status', 'aprobado por gerente de compras')
                ->where('company_id', session()->get('company_id'))
                ->orderBy('id', 'desc');
        }
    }
    public function scopeApprove(Builder $query)
    {
        return $query
            ->withWhereHas('requisition', function ($query) {
                $query->whereIn('approval_chain_id', auth()->user()->authorizerChainsPR->pluck('id')->unique()->toArray());
            })
            ->where('status', 'aprobado por gerente solicitante')
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }
    public function scopeApproveSpecial(Builder $query)
    {
        return $query
            ->where('status', 'revision por dirección general')
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }
    public function scopeAuthorize(Builder $query)
    {
        return $query

            ->where('status', 'aprobado por DG nivel 1')
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }

    public function getRevisionDates()
    {
        $revisions = [
            'revisión gerente de compras',
            'aprobado por gerente de compras',
            'aprobado por gerente solicitante',
            'aprobado por DG nivel 1',
            'aprobado por DG nivel 2',
            // 'autorizada para proveedor'
        ];

        $service = new OrderCalculationService($this->id);

        // Encontrar la última devolución o reasignación que reinicia el ciclo
        $ultimaDevolucion = $this->status()->history()
            ->where('field', 'status')
            ->whereIn('to', [
                'devuelto por gerente de compras',
                'devuelto por gerente solicitante',
                'devuelto por DG nivel 1',
                'devuelto por DG nivel 2',
                'reabierta para edición',
                'requisición reasignada' // Nuevo estado que reinicia el ciclo
            ])
            ->orderBy('created_at', 'desc')
            ->first();

        $fechas = [];
        foreach ($revisions as $revision) {
            $query = $this->status()->history()
                ->where('field', 'status')
                ->where('to', $revision)
                ->orderBy('created_at', 'desc'); // Última entrada a la revisión

            // Si hay una devolución, filtrar por registros posteriores a ella
            if ($ultimaDevolucion) {
                $query->where('created_at', '>', $ultimaDevolucion->created_at);
            }

            $registro = $query->first();
            $fechas[$revision] = $registro ? $registro->created_at : null;
        }
        return $fechas;
    }
    public function getProgressAttribute()
    {

        $purchaseManager =  User::role('gerente_compras')->first()->name;
        $dgLevel2 =  User::role('autoriza_nivel-2-orden_compra')->first()->name;

        $data = $this->getRevisionDates();

        $service = new OrderCalculationService($this->id);

        $progress = [];
        $progress = [
            'purchaser' => ['title' => 'Comprador', 'name' => $this->purchaser?->name, 'job-pdf' => 'Comprador', 'date' => $data['revisión gerente de compras']],
            'reviewer' => ['title' => 'Revisa', 'name' => $purchaseManager, 'job-pdf' => 'Gerente de compras', 'date' => $data['aprobado por gerente de compras']],
            'approver' => ['title' => 'Aprueba', 'name' => $this->requisition->approvalChain->approver->name, 'job-pdf' => 'Gerente solicitante', 'date' => $data['aprobado por gerente solicitante']],
            'authorizer-1' => ['title' => 'Autoriza', 'name' => $this->requisition->approvalChain->authorizer->name, 'job-pdf' => 'Dirección general', 'date' => $data['aprobado por DG nivel 1']],
            'authorizer-2' => ['title' => 'Autoriza', 'name' => $dgLevel2, 'job-pdf' => 'Dirección general CA', 'date' => $data['aprobado por DG nivel 2']]
        ];
        if ($service->isOrderTotalBetweenLimits()) {
            unset($progress['authorizer-2']);
        }

        if (in_array($this->provider->id, [427, 425, 332])) {
            unset($progress['authorizer-2']);
        }
        $test = ['uno' => 1, 'dos' => 2];
        return $progress;
    }

    public function getRevisionSpecialDates()
    {
        $revisions = [
            'revision por dirección general',
            'autorizada para proveedor'
        ];

        $service = new OrderCalculationService($this->id);
        // Encontrar la última devolución que reinicia el ciclo
        $ultimaDevolucion = $this->status()->history()
            ->where('field', 'status')
            ->whereIn('to', [
                'devuelto por dirección general',
                'reabierta para edición'
            ])
            ->orderBy('created_at', 'desc')
            ->first();

        $fechas = [];
        foreach ($revisions as $revision) {
            $query = $this->status()->history()
                ->where('field', 'status')
                ->where('to', $revision)
                ->orderBy('created_at', 'desc'); // Última entrada a la revisión

            // Si hay una devolución, filtrar por registros posteriores a ella
            if ($ultimaDevolucion) {
                $query->where('created_at', '>', $ultimaDevolucion->created_at);
            }

            $registro = $query->first();
            $fechas[$revision] = $registro ? $registro : null;
        }
        return $fechas;
    }
    public function getProgressSpecialAttribute()
    {

        $data = $this->getRevisionSpecialDates();
        $progress = [];
        $progress = [
            'purchaser' =>
            [
                'title' => 'Comprador',
                'name' => isset($data['revision por dirección general']) ? $data['revision por dirección general']->responsible->name : null,
                'job-pdf' => 'Comprador',
                'date' => isset($data['revision por dirección general']) ? $data['revision por dirección general']->created_at : null
            ],
            'authorizer' => [
                'title' => 'Autoriza',
                'name' => 'Denise Marisol Reyes Ramírez',
                'job-pdf' => 'Dirección general',
                'date' => isset($data['autorizada para proveedor']) ? $data['autorizada para proveedor']->created_at : null
            ],
        ];
        return $progress;
    }

    /**
     * Reasignar la orden a una nueva requisición (cambiando la cadena de aprobación)
     * y regresar al estado inicial del flujo de aprobación
     *
     * @param int $newRequisitionId ID de la nueva requisición
     * @return void
     */
    public function reassignRequisition(int $newRequisitionId): void
    {
        $oldRequisitionId = $this->requisition_id;

        // Actualizar la requisición
        $this->update([
            'requisition_id' => $newRequisitionId
        ]);

        // Resetear al estado inicial
        $this->resetToInitialState($oldRequisitionId);
    }

    /**
     * Resetear la orden al estado inicial del flujo
     *
     * @param int|null $oldRequisitionId ID de la requisición anterior (para auditoría)
     * @return void
     */
    protected function resetToInitialState(?int $oldRequisitionId = null): void
    {
        // Transicionar a un estado que indica el cambio de requisición
        $this->status()->transitionTo('requisición reasignada', [
            'old_requisition_id' => $oldRequisitionId,
            'new_requisition_id' => $this->requisition_id
        ]);
    }

    /**
     * Método de conveniencia que combina reasignar y resetear
     *
     * @param int $newRequisitionId
     * @return void
     */
    public function reassignAndReset(int $newRequisitionId): void
    {
        $this->reassignRequisition($newRequisitionId);
    }

    /**
     * Verificar si la orden está bloqueada por un usuario inactivo en la cadena
     *
     * @return array
     */
    public function checkForInactiveUsers(): array
    {
        $issues = [];

        if (!$this->requisition || !$this->requisition->approvalChain) {
            return ['error' => 'No tiene requisición o cadena de aprobación asignada'];
        }

        $chain = $this->requisition->approvalChain;

        // Verificar aprobador (gerente solicitante)
        if ($chain->approver && !$chain->approver->is_active) {
            $issues['approver'] = [
                'user_id' => $chain->approver->id,
                'user_name' => $chain->approver->name,
                'role' => 'Aprobador (Gerente Solicitante)',
                'status' => $this->status
            ];
        }

        // Verificar autorizador (DG)
        if ($chain->authorizer && !$chain->authorizer->is_active) {
            $issues['authorizer'] = [
                'user_id' => $chain->authorizer->id,
                'user_name' => $chain->authorizer->name,
                'role' => 'Autorizador (Dirección General)',
                'status' => $this->status
            ];
        }

        return $issues;
    }
}
