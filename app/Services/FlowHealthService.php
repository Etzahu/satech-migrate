<?php

namespace App\Services;

use App\Models\Management;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

/**
 * Revisión diaria de los niveles del flujo que nadie puede responder.
 *
 * `orders:report-stalled` y `requisitions:detect-blocked` ya detectan esto,
 * pero solo si alguien los corre a mano. Cuando el único titular de
 * `autoriza_orden_compra` dejó la empresa, trece órdenes se detuvieron sin que
 * nadie recibiera un correo: el aviso al autorizador sale a una lista vacía.
 *
 * Separa dos causas porque se corrigen distinto:
 *
 *  - **Rol sin titular activo.** El nivel se resuelve por rol y nadie activo lo
 *    tiene. Se corrige asignando el rol, así que se avisa siempre y con todo
 *    lo que espera, sin importar la antigüedad. Cubre también el caso en que
 *    se le quita el rol a alguien, que no pasa por ninguna baja.
 *  - **Cuenta inactiva.** El nivel lo responde una persona —la de la cadena o
 *    el comprador— y su cuenta ya no está activa. Se corrige cambiando la
 *    cadena o reasignando. Lo que lleva más de `idle_days` sin moverse se da
 *    por abandonado y ya no se avisa: son pendientes de gente que se fue hace
 *    meses y que nadie va a retomar.
 */
class FlowHealthService
{
    /**
     * Roles que responden un nivel sin pasar por la cadena, con lo que cubren.
     *
     * @var array<string, string>
     */
    public const FLOW_ROLES = [
        'gerente_compras' => 'Revisa órdenes y asigna comprador a requisiciones',
        PurchaseOrderChainResolver::APPROVER_ROLE => 'Aprueba órdenes de los departamentos operativos',
        PurchaseOrderChainResolver::AUTHORIZER_ROLE => 'Autoriza órdenes de los departamentos operativos',
        'libera_orden_compra' => 'Libera órdenes (Dirección Administrativa)',
        'autoriza_nivel-2-orden_compra' => 'Autoriza órdenes por monto (Dirección General)',
        'aprueba_orden_especial' => 'Autoriza órdenes de ruta especial',
        'revisa_almacen_requisicion_compra' => 'Revisa requisiciones en almacén',
    ];

    /**
     * Roles que solo intervienen si alguna gerencia usa el flujo por rol.
     *
     * @var array<int, string>
     */
    private const ROLE_FLOW_ROLES = [
        PurchaseOrderChainResolver::APPROVER_ROLE,
        PurchaseOrderChainResolver::AUTHORIZER_ROLE,
    ];

    /**
     * Estados de la orden que esperan la firma de un nivel.
     *
     * @var array<string, string>
     */
    private const ORDER_LEVELS = [
        'revisión gerente de compras' => 'Revisa',
        'aprobado por gerente de compras' => 'Aprueba',
        'aprobado por gerente solicitante' => 'Autoriza',
        'aprobado por DG nivel 1' => 'Libera',
        'liberado por dirección administrativa' => 'Autoriza por monto',
        'revision por dirección general' => 'Autoriza ruta especial',
    ];

    /**
     * Estados de la requisición en los que alguien tiene que actuar.
     *
     * @var array<string, string>
     */
    private const REQUISITION_LEVELS = [
        'revisión por almacén' => 'Almacén',
        'revisión' => 'Revisa',
        'aprobado por revisor' => 'Aprueba',
        'aprobado por gerencia' => 'Autoriza',
        'aprobado por DG' => 'Asigna comprador',
        'comprador asignado' => 'Comprador',
        'comprador reasignado' => 'Comprador',
    ];

    public function __construct(
        private StalledOrderService $stalled,
        private PurchaseOrderChainResolver $resolver,
    ) {}

    /**
     * Lo que hay que corregir hoy. Las dos listas vacías significan que todos
     * los niveles tienen a alguien activo que los responda.
     *
     * @return array{vacant_roles: array<int, array{role: string, label: string, url: ?string, items: array<int, array<string, mixed>>}>, inactive: array<int, array{name: string, user_id: ?int, items: array<int, array<string, mixed>>}>}
     */
    public function report(): array
    {
        return $this->build($this->pendingOrders(), $this->pendingRequisitions());
    }

    /**
     * A quién le llegan los avisos de operación: este reporte y las fallas de
     * la página de Salud. Los correos configurados o, si no hay, los
     * super_admin activos.
     *
     * @return array<int, string>
     */
    public function alertRecipients(): array
    {
        $configured = config('purchases.flow_alerts.recipients', []);

        if ($configured !== []) {
            return $configured;
        }

        return User::withRole('super_admin')
            ->where('active', 1)
            ->pluck('email')
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @return Collection<int, PurchaseOrder>
     */
    public function pendingOrders(): Collection
    {
        return PurchaseOrder::query()
            ->whereIn('status', [...array_keys(self::ORDER_LEVELS), ...StalledOrderService::EN_CANCHA_DEL_COMPRADOR])
            ->with([
                'purchaser',
                'requisition.approvalChain.requester.management',
                'requisition.approvalChain.approver',
                'requisition.approvalChain.authorizer',
            ])
            ->get();
    }

    /**
     * @return Collection<int, PurchaseRequisition>
     */
    public function pendingRequisitions(): Collection
    {
        return PurchaseRequisition::query()
            ->whereIn('status', array_keys(self::REQUISITION_LEVELS))
            ->with(['purchaser', 'approvalChain.reviewer', 'approvalChain.approver', 'approvalChain.authorizer'])
            ->withCount('orders')
            ->get();
    }

    /**
     * Arma el reporte a partir de los pendientes que se le pasen.
     *
     * @param  Collection<int, PurchaseOrder>  $orders
     * @param  Collection<int, PurchaseRequisition>  $requisitions
     * @return array{vacant_roles: array<int, array{role: string, label: string, url: ?string, items: array<int, array<string, mixed>>}>, inactive: array<int, array{name: string, user_id: ?int, items: array<int, array<string, mixed>>}>}
     */
    public function build(Collection $orders, Collection $requisitions): array
    {
        $vacantRoles = $this->vacantRoles();
        $idleDays = (int) config('purchases.flow_alerts.idle_days', 30);

        $waitingOnRole = [];
        $waitingOnInactive = [];

        $pending = $orders
            ->map(fn (PurchaseOrder $order) => [$order, $this->orderResponder($order)])
            ->concat($requisitions->map(fn (PurchaseRequisition $requisition) => [$requisition, $this->requisitionResponder($requisition)]));

        foreach ($pending as [$model, $responder]) {
            if ($responder === null) {
                continue;
            }

            if ($responder['role'] !== null) {
                if (array_key_exists($responder['role'], $vacantRoles)) {
                    $waitingOnRole[$responder['role']][] = $this->describe($model);
                }

                continue;
            }

            $person = $responder['person'];

            if ($person?->active) {
                continue;
            }

            $item = $this->describe($model);

            if ($item['days'] > $idleDays) {
                continue;
            }

            $key = $person ? 'user-'.$person->id : 'nadie';
            $waitingOnInactive[$key]['name'] ??= $person?->name ?? 'Sin responsable asignado';
            $waitingOnInactive[$key]['user_id'] ??= $person?->id;
            $waitingOnInactive[$key]['items'][] = $item;
        }

        return [
            'vacant_roles' => collect($vacantRoles)
                ->map(fn (string $label, string $role) => [
                    'role' => $role,
                    'label' => $label,
                    'url' => $this->roleUrl($role),
                    'items' => $this->oldestFirst($waitingOnRole[$role] ?? []),
                ])
                ->values()
                ->all(),
            'inactive' => collect($waitingOnInactive)
                ->map(fn (array $group) => [
                    'name' => $group['name'],
                    'user_id' => $group['user_id'],
                    'items' => $this->oldestFirst($group['items']),
                ])
                ->values()
                ->all(),
        ];
    }

    /**
     * Roles del flujo que no tiene nadie activo, con lo que cubre cada uno.
     *
     * @return array<string, string>
     */
    public function vacantRoles(): array
    {
        $roleFlowInUse = Management::where('purchase_order_flow', 1)->exists();

        return collect(self::FLOW_ROLES)
            ->reject(fn (string $label, string $role) => ! $roleFlowInUse && in_array($role, self::ROLE_FLOW_ROLES, true))
            ->reject(fn (string $label, string $role) => User::withRole($role)->where('active', 1)->exists())
            ->all();
    }

    /**
     * Quién responde el nivel en el que está la orden: un rol del flujo o una
     * persona. Null si en ese estado no espera a nadie.
     *
     * @return array{role: ?string, person: ?User}|null
     */
    public function orderResponder(PurchaseOrder $order): ?array
    {
        if (in_array($order->status, StalledOrderService::EN_CANCHA_DEL_COMPRADOR, true)) {
            return ['role' => null, 'person' => $order->purchaser];
        }

        $chain = $order->requisition?->approvalChain;
        $roleFlow = $this->resolver->usesRoleFlow($order);

        return match ($order->status) {
            'revisión gerente de compras' => ['role' => 'gerente_compras', 'person' => null],
            'aprobado por gerente de compras' => $roleFlow
                ? ['role' => PurchaseOrderChainResolver::APPROVER_ROLE, 'person' => null]
                : ['role' => null, 'person' => $chain?->approver],
            'aprobado por gerente solicitante' => $roleFlow
                ? ['role' => PurchaseOrderChainResolver::AUTHORIZER_ROLE, 'person' => null]
                : ['role' => null, 'person' => $chain?->authorizer],
            'aprobado por DG nivel 1' => ['role' => 'libera_orden_compra', 'person' => null],
            // Sin monto que aprobar, la liberación ya era el último paso.
            'liberado por dirección administrativa' => (new PurchaseOrderFlowService)->requiresAmountApproval($order)
                ? ['role' => 'autoriza_nivel-2-orden_compra', 'person' => null]
                : null,
            'revision por dirección general' => ['role' => 'aprueba_orden_especial', 'person' => null],
            default => null,
        };
    }

    /**
     * Quién tiene que actuar sobre la requisición, o null si no espera a nadie.
     *
     * @return array{role: ?string, person: ?User}|null
     */
    public function requisitionResponder(PurchaseRequisition $requisition): ?array
    {
        $chain = $requisition->approvalChain;

        return match ($requisition->status) {
            'revisión por almacén' => ['role' => 'revisa_almacen_requisicion_compra', 'person' => null],
            'revisión' => ['role' => null, 'person' => $chain?->reviewer],
            'aprobado por revisor' => ['role' => null, 'person' => $chain?->approver],
            // Sin autorizador en la cadena, el nivel no existe y la requisición avanza sola.
            'aprobado por gerencia' => filled($chain?->authorizer_id)
                ? ['role' => null, 'person' => $chain->authorizer]
                : null,
            'aprobado por DG' => ['role' => 'gerente_compras', 'person' => null],
            // Con órdenes ya creadas, lo pendiente sigue en las órdenes.
            'comprador asignado', 'comprador reasignado' => $this->hasOrders($requisition)
                ? null
                : ['role' => null, 'person' => $requisition->purchaser],
            default => null,
        };
    }

    /**
     * @return array{type: string, folio: string, level: string, days: int, url: string}
     */
    private function describe(PurchaseOrder|PurchaseRequisition $model): array
    {
        if ($model instanceof PurchaseOrder) {
            return [
                'type' => 'Orden',
                'folio' => (string) $model->folio,
                'level' => self::ORDER_LEVELS[$model->status] ?? 'Comprador',
                'days' => $this->stalled->diasDetenida($model),
                'url' => route('filament.compras.resources.admin.ordenes.view', $model),
            ];
        }

        return [
            'type' => 'Requisición',
            'folio' => (string) $model->folio,
            'level' => self::REQUISITION_LEVELS[$model->status],
            'days' => $this->stalled->diasDetenida($model),
            'url' => route('filament.compras.resources.requisiciones-historial.view', $model),
        ];
    }

    private function hasOrders(PurchaseRequisition $requisition): bool
    {
        return (int) ($requisition->orders_count ?? $requisition->orders()->count()) > 0;
    }

    private function roleUrl(string $role): ?string
    {
        $role = Role::where('name', $role)->first();

        return $role ? route('filament.compras.resources.shield.roles.view', $role) : null;
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     * @return array<int, array<string, mixed>>
     */
    private function oldestFirst(array $items): array
    {
        return collect($items)->sortByDesc('days')->values()->all();
    }
}
