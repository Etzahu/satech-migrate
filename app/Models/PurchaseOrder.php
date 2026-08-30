<?php

namespace App\Models;

use App\Services\PurchaseOrderChainResolver;
use App\Services\PurchaseOrderFlowService;
use App\StateMachines\PurchaseOrderStateMachine;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PurchaseOrder extends Model implements Auditable, HasMedia
{
    use HasStateMachines;
    use InteractsWithMedia;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $fillable = [
        'folio',
        'currency',
        'type_payment',
        'form_payment',
        'condition_payment',
        'quote_folio',
        'use_cfdi',
        'shipping_method',
        'tax_iva',
        'discount',
        'retention_iva',
        'retention_isr',
        'retention_another',
        'delivery_days',
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
        'status',
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
        'delivery_days',
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
        'status',
    ];

    public $stateMachines = [
        'status' => PurchaseOrderStateMachine::class,
    ];

    protected $casts = [
        'documentation_delivery' => 'array',
        'condition_payment' => 'array',

    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $ticket->folio = session()->get('company_acronym').self::generateFolioNumber().'/'.now()->format('y');
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

    /**
     * Bandeja del nivel 2 (aprueba la orden).
     *
     * Quién actúa lo decide PurchaseOrderChainResolver, no esta consulta: en
     * los cinco departamentos operativos lo resuelve el rol y en el resto de la
     * empresa la cadena. El listado, canAccess() y el botón leen de ahí para
     * que no puedan contradecirse.
     */
    public function scopeReviewManagement(Builder $query)
    {
        return app(PurchaseOrderChainResolver::class)
            ->applyApproverScope($query, auth()->user())
            ->where('status', 'aprobado por gerente de compras')
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }

    /**
     * Bandeja del nivel 3 (autoriza la orden).
     */
    public function scopeApprove(Builder $query)
    {
        return app(PurchaseOrderChainResolver::class)
            ->applyAuthorizerScope($query, auth()->user())
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

    /**
     * Bandeja de Dirección Administrativa: órdenes esperando liberación.
     *
     * El nivel aplica a toda la empresa, así que no filtra por cadena; el rol
     * `libera_orden_compra` es la fuente de verdad y canAccess() usa el mismo.
     */
    public function scopeRelease(Builder $query)
    {
        return $query
            ->where('status', 'aprobado por DG nivel 1')
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }

    /**
     * Bandeja del nivel de monto (Dirección General CA), ahora al final del
     * flujo: solo ve órdenes que Dirección Administrativa ya liberó.
     */
    public function scopeAuthorize(Builder $query)
    {
        return $query
            ->where('status', 'liberado por dirección administrativa')
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }

    /**
     * Roles que ocupa el usuario dentro de la cadena de aprobación de esta orden.
     *
     * Devuelve TODOS los que casan, no el primero: una misma persona ocupa dos
     * casillas de la cadena con frecuencia —el solicitante suele ser también el
     * revisor, y en cuatro cadenas Alan Anaya aprueba y autoriza—, y quedarse
     * con el primero le escondía el botón de los niveles posteriores.
     *
     * La cadena es la única fuente de verdad sobre quién actúa en cada nivel:
     * los listados, el acceso a la sección y los botones de respuesta deben
     * leerla desde aquí para que no puedan contradecirse entre sí.
     *
     * @return array<int, string> Subconjunto de PurchaseRequisitionApprovalChain::ROLES
     */
    public function chainRolesFor(?User $user = null): array
    {
        $user ??= auth()->user();
        $chain = $this->requisition?->approvalChain;

        if (! $user || ! $chain) {
            return [];
        }

        $roles = [];

        foreach (PurchaseRequisitionApprovalChain::ROLES as $role) {
            if ($chain->{$role.'_id'} !== null && (int) $chain->{$role.'_id'} === (int) $user->id) {
                $roles[] = $role;
            }
        }

        return $roles;
    }

    /**
     * Nombre del primer usuario que tiene el rol, o null si no hay ninguno.
     *
     * Se usa whereHas en vez del scope User::role() de Spatie porque ese scope
     * lanza RoleDoesNotExist cuando el rol todavía no existe en la base —por
     * ejemplo si la migración que lo crea no se ha corrido en ese entorno—, y
     * un `?->` no protege de una excepción. Pasó de verdad: al reponer la base
     * sin la migración del nivel de liberación, el PDF y la ficha de la
     * requisición devolvían 500.
     */
    public static function firstUserWithRole(string $role): ?string
    {
        return User::whereHas('roles', fn ($query) => $query->where('name', $role))->value('name');
    }

    /**
     * ¿El usuario participa en la cadena de esta orden, en cualquier nivel?
     */
    public function participatesInChain(?User $user = null): bool
    {
        return $this->chainRolesFor($user) !== [];
    }

    /**
     * ¿El usuario es quien debe aprobar esta orden en el nivel del gerente solicitante?
     */
    public function isChainApprover(?User $user = null): bool
    {
        return in_array('approver', $this->chainRolesFor($user), true);
    }

    /**
     * ¿El usuario es quien debe autorizar esta orden en el nivel de DG 1?
     */
    public function isChainAuthorizer(?User $user = null): bool
    {
        return in_array('authorizer', $this->chainRolesFor($user), true);
    }

    /**
     * Registro del histórico de cada nivel del ciclo vigente, o null si el
     * nivel todavía no se firmó.
     *
     * @return array<string, mixed>
     */
    public function getRevisionRecords(): array
    {
        $revisions = [
            'revisión gerente de compras',
            'aprobado por gerente de compras',
            'aprobado por gerente solicitante',
            'aprobado por DG nivel 1',
            'liberado por dirección administrativa',
            'aprobado por DG nivel 2',
            // 'autorizada para proveedor'
        ];

        // Encontrar la última devolución o reasignación que reinicia el ciclo
        $ultimaDevolucion = $this->status()->history()
            ->where('field', 'status')
            ->whereIn('to', [
                'devuelto por gerente de compras',
                'devuelto por gerente solicitante',
                'devuelto por DG nivel 1',
                'devuelto por DG nivel 2',
                'devuelto por liberación', // Devolución de Dirección Administrativa
                'devuelto por administrador', // Estado que reinicia el ciclo cuando admin devuelve la orden
                'reabierta para edición',
                'requisición reasignada', // Estado que reinicia el ciclo al cambiar de requisición
                'cadena reasignada', // Nuevo estado que reinicia el ciclo al cambiar de cadena
            ])
            ->orderBy('created_at', 'desc')
            ->first();

        $registros = [];
        foreach ($revisions as $revision) {
            $query = $this->status()->history()
                ->where('field', 'status')
                ->where('to', $revision)
                ->orderBy('created_at', 'desc'); // Última entrada a la revisión

            // Si hay una devolución, filtrar por registros posteriores a ella
            if ($ultimaDevolucion) {
                $query->where('created_at', '>', $ultimaDevolucion->created_at);
            }

            $registros[$revision] = $query->first();
        }

        return $registros;
    }

    /**
     * Fecha en que se firmó cada nivel del ciclo vigente, o null si sigue
     * pendiente.
     */
    public function getRevisionDates()
    {
        return array_map(
            fn ($registro) => $registro?->created_at,
            $this->getRevisionRecords()
        );
    }

    /**
     * Quién firmó cada nivel, según el histórico.
     *
     * Se lee de `state_histories.responsible_id` y no de la cadena ni del rol
     * vigente: los niveles 2 y 3 de los cinco departamentos operativos dejaron
     * de resolverse por cadena en la Fase D1, y los que se resuelven por rol
     * cambian de titular con el tiempo —Allier reemplazó a Carlos Alonso—. En
     * los dos casos, mirar la configuración de hoy imprime a la persona
     * equivocada en un PDF de hace un año.
     *
     * Resuelve los cinco niveles con una sola consulta.
     *
     * @param  array<string, mixed>  $registros
     * @return array<string, string|null>
     */
    private function signersOf(array $registros): array
    {
        $ids = collect($registros)->pluck('responsible_id')->filter()->unique();

        $nombres = $ids->isEmpty()
            ? collect()
            : User::whereIn('id', $ids)->pluck('name', 'id');

        return array_map(
            fn ($registro) => $registro?->responsible_id
                ? ($nombres[$registro->responsible_id] ?? null)
                : null,
            $registros
        );
    }

    public function getProgressAttribute()
    {

        // Ver firstUserWithRole(): ni un rol vacío ni un rol inexistente deben
        // tumbar el PDF ni el infolist. El paso se pinta sin nombre, igual que
        // ya se comporta un paso sin fecha.
        $purchaseManager = static::firstUserWithRole('gerente_compras');
        $releaser = static::firstUserWithRole('libera_orden_compra');
        $dgLevel2 = static::firstUserWithRole('autoriza_nivel-2-orden_compra');

        $registros = $this->getRevisionRecords();
        $data = array_map(fn ($registro) => $registro?->created_at, $registros);

        // Cada nivel se firma con quien lo firmó de verdad; si sigue pendiente,
        // con quien tiene que firmarlo hoy.
        $firmante = $this->signersOf($registros);
        $resolver = app(PurchaseOrderChainResolver::class);

        $progress = [];
        $progress = [
            'purchaser' => ['title' => 'Comprador', 'name' => $this->purchaser?->name, 'job-pdf' => 'Comprador', 'date' => $data['revisión gerente de compras']],
            'reviewer' => ['title' => 'Revisa', 'name' => $firmante['aprobado por gerente de compras'] ?? $purchaseManager, 'job-pdf' => 'Gerente de compras', 'date' => $data['aprobado por gerente de compras']],
            'approver' => ['title' => 'Aprueba', 'name' => $firmante['aprobado por gerente solicitante'] ?? $resolver->approverName($this), 'job-pdf' => 'Gerente solicitante', 'date' => $data['aprobado por gerente solicitante']],
            'authorizer-1' => ['title' => 'Autoriza', 'name' => $firmante['aprobado por DG nivel 1'] ?? $resolver->authorizerName($this) ?? 'N/A', 'job-pdf' => 'Dirección general', 'date' => $data['aprobado por DG nivel 1']],
            'releaser' => ['title' => 'Libera', 'name' => $firmante['liberado por dirección administrativa'] ?? $releaser, 'job-pdf' => 'Dirección administrativa', 'date' => $data['liberado por dirección administrativa']],
            'authorizer-2' => ['title' => 'Autoriza', 'name' => $firmante['aprobado por DG nivel 2'] ?? $dgLevel2, 'job-pdf' => 'Dirección general CA', 'date' => $data['aprobado por DG nivel 2']],
        ];

        // El nivel de monto es la última aprobación y solo aplica a las órdenes
        // que superan el límite; el resto no lleva esa firma.
        if (! (new PurchaseOrderFlowService)->requiresAmountApproval($this)) {
            unset($progress['authorizer-2']);
        }

        // El nivel de liberación no existía antes de ago-2026. En una orden ya
        // autorizada que nunca pasó por él, el paso se oculta en vez de quedar
        // como "Sin respuesta" para siempre; las que siguen en curso sí lo ven,
        // porque van a pasar por ahí.
        if ($this->status === 'autorizada para proveedor' && ! $data['liberado por dirección administrativa']) {
            unset($progress['releaser']);
        }

        return $progress;
    }

    public function getRevisionSpecialDates()
    {
        $revisions = [
            'revision por dirección general',
            'autorizada para proveedor',
        ];

        // Encontrar la última devolución que reinicia el ciclo
        $ultimaDevolucion = $this->status()->history()
            ->where('field', 'status')
            ->whereIn('to', [
                'devuelto por dirección general',
                'devuelto por administrador', // Estado que reinicia el ciclo cuando admin devuelve la orden
                'reabierta para edición',
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
            'purchaser' => [
                'title' => 'Comprador',
                'name' => isset($data['revision por dirección general']) ? $data['revision por dirección general']->responsible->name : null,
                'job-pdf' => 'Comprador',
                'date' => isset($data['revision por dirección general']) ? $data['revision por dirección general']->created_at : null,
            ],
            'authorizer' => [
                'title' => 'Autoriza',
                // Quien firmó según el histórico; si aún no se autoriza, quien
                // tiene la facultad. Antes iba el nombre literal.
                'name' => (isset($data['autorizada para proveedor']) ? $data['autorizada para proveedor']->responsible?->name : null)
                    ?? static::firstUserWithRole('aprueba_orden_especial'),
                'job-pdf' => 'Dirección general',
                'date' => isset($data['autorizada para proveedor']) ? $data['autorizada para proveedor']->created_at : null,
            ],
        ];

        return $progress;
    }

    /**
     * Reasignar la orden a una nueva requisición (cambiando la cadena de aprobación)
     * y regresar al estado inicial del flujo de aprobación
     *
     * @param  int  $newRequisitionId  ID de la nueva requisición
     */
    public function reassignRequisition(int $newRequisitionId): void
    {
        $oldRequisitionId = $this->requisition_id;

        // Actualizar la requisición
        $this->update([
            'requisition_id' => $newRequisitionId,
        ]);

        // Resetear al estado inicial
        $this->resetToInitialState($oldRequisitionId);
    }

    /**
     * Resetear la orden al estado inicial del flujo
     *
     * @param  int|null  $oldRequisitionId  ID de la requisición anterior (para auditoría)
     */
    protected function resetToInitialState(?int $oldRequisitionId = null): void
    {
        // Transicionar a un estado que indica el cambio de requisición
        $this->status()->transitionTo('requisición reasignada', [
            'old_requisition_id' => $oldRequisitionId,
            'new_requisition_id' => $this->requisition_id,
        ]);
    }

    /**
     * Método de conveniencia que combina reasignar y resetear
     */
    public function reassignAndReset(int $newRequisitionId): void
    {
        $this->reassignRequisition($newRequisitionId);
    }

    /**
     * Verificar si la orden está bloqueada por un usuario inactivo en la cadena
     */
    public function checkForInactiveUsers(): array
    {
        $issues = [];

        if (! $this->requisition || ! $this->requisition->approvalChain) {
            return ['error' => 'No tiene requisición o cadena de aprobación asignada'];
        }

        $chain = $this->requisition->approvalChain;

        // Verificar aprobador (gerente solicitante)
        if ($chain->approver && ! $chain->approver->is_active) {
            $issues['approver'] = [
                'user_id' => $chain->approver->id,
                'user_name' => $chain->approver->name,
                'role' => 'Aprobador (Gerente Solicitante)',
                'status' => $this->status,
            ];
        }

        // Verificar autorizador (DG)
        if ($chain->authorizer && ! $chain->authorizer->is_active) {
            $issues['authorizer'] = [
                'user_id' => $chain->authorizer->id,
                'user_name' => $chain->authorizer->name,
                'role' => 'Autorizador (Dirección General)',
                'status' => $this->status,
            ];
        }

        return $issues;
    }
}
