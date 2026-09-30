<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Recordatorio de lo que cada persona tiene pendiente por revisar.
 *
 * El aviso de cada nivel sale una sola vez, cuando el documento llega. Si
 * quien debe firmar lo deja pasar, nadie se lo vuelve a decir y la orden o la
 * requisición se queda quieta. Aquí se junta, por persona, todo lo que espera
 * su respuesta en cualquier nivel del flujo, para mandárselo en un solo correo.
 *
 * Quién responde cada nivel lo decide FlowHealthService, igual que en la
 * revisión diaria del flujo; aquí solo se reparte entre quienes pueden
 * actuar. Se deja fuera:
 *
 *  - Lo que está en cancha del comprador o del solicitante: no espera una
 *    revisión, espera que lo trabajen.
 *  - Lo que espera a un rol sin titular activo o a una cuenta inactiva: no hay
 *    a quién recordárselo, y ya lo avisa `purchases:flow-health`.
 *  - Lo que llegó al nivel hace menos de `min_days`: el aviso original acaba
 *    de salir.
 */
class PendingReviewReminderService
{
    /**
     * Estados de la orden que esperan una revisión, con lo que le toca hacer a
     * quien la recibe y la bandeja donde la encuentra.
     *
     * @var array<string, array{action: string, route: string}>
     */
    public const ORDER_LEVELS = [
        'revisión gerente de compras' => ['action' => 'Revisar', 'route' => 'filament.compras.resources.admin.ordenes.view'],
        'aprobado por gerente de compras' => ['action' => 'Aprobar', 'route' => 'filament.compras.resources.ordenes.revisar.view'],
        'aprobado por gerente solicitante' => ['action' => 'Autorizar', 'route' => 'filament.compras.resources.ordenes.aprobar.view'],
        'aprobado por DG nivel 1' => ['action' => 'Liberar', 'route' => 'filament.compras.resources.ordenes.liberar.view'],
        'liberado por dirección administrativa' => ['action' => 'Autorizar por monto', 'route' => 'filament.compras.resources.ordenes.autorizar.view'],
        'revision por dirección general' => ['action' => 'Autorizar ruta especial', 'route' => 'filament.compras.resources.ordenes.aprobar-especial.view'],
    ];

    /**
     * Estados de la requisición que esperan una revisión.
     *
     * @var array<string, array{action: string, route: string}>
     */
    public const REQUISITION_LEVELS = [
        'revisión por almacén' => ['action' => 'Revisar existencias', 'route' => 'filament.compras.resources.requisiciones.revisar.almacen.view'],
        'revisión' => ['action' => 'Revisar', 'route' => 'filament.compras.resources.requisiciones-revisar.view'],
        'aprobado por revisor' => ['action' => 'Aprobar', 'route' => 'filament.compras.resources.requisiciones-aprobar.view'],
        'aprobado por gerencia' => ['action' => 'Autorizar', 'route' => 'filament.compras.resources.requisiciones-autorizar.view'],
        'aprobado por DG' => ['action' => 'Asignar comprador', 'route' => 'filament.compras.resources.requisiciones.admin.asignacion.view'],
    ];

    public function __construct(
        private FlowHealthService $flowHealth,
        private StalledOrderService $stalled,
    ) {}

    /**
     * Lo que hay que recordar hoy.
     *
     * @return array{reminders: array<int, array{user: User, items: array<int, array<string, mixed>>}>, unattended: array<int, array<string, mixed>>}
     */
    public function reminders(): array
    {
        return $this->build($this->pendingOrders(), $this->pendingRequisitions());
    }

    /**
     * @return Collection<int, PurchaseOrder>
     */
    public function pendingOrders(): Collection
    {
        return PurchaseOrder::query()
            ->whereIn('status', array_keys(self::ORDER_LEVELS))
            ->with([
                'company',
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
            ->with([
                'company',
                'approvalChain.requester',
                'approvalChain.reviewer',
                'approvalChain.approver',
                'approvalChain.authorizer',
            ])
            ->get();
    }

    /**
     * Reparte los pendientes que se le pasen entre quienes deben responderlos.
     *
     * `reminders` trae un recordatorio por persona, con sus pendientes
     * agrupables por empresa y del más antiguo al más reciente. `unattended`,
     * lo que no tiene a nadie activo que lo reciba.
     *
     * @param  Collection<int, PurchaseOrder>  $orders
     * @param  Collection<int, PurchaseRequisition>  $requisitions
     * @return array{reminders: array<int, array{user: User, items: array<int, array<string, mixed>>}>, unattended: array<int, array<string, mixed>>}
     */
    public function build(Collection $orders, Collection $requisitions): array
    {
        $minDays = (int) config('purchases.reminders.min_days', 1);

        $pending = $orders
            ->filter(fn (PurchaseOrder $order) => array_key_exists($order->status, self::ORDER_LEVELS))
            ->map(fn (PurchaseOrder $order) => [$order, $this->flowHealth->orderResponder($order)])
            ->concat($requisitions
                ->filter(fn (PurchaseRequisition $requisition) => array_key_exists($requisition->status, self::REQUISITION_LEVELS))
                ->map(fn (PurchaseRequisition $requisition) => [$requisition, $this->flowHealth->requisitionResponder($requisition)]))
            // En ese estado no espera a nadie: el nivel no aplica y avanza solo.
            ->reject(fn (array $entry) => $entry[1] === null)
            ->map(fn (array $entry) => [$this->describe($entry[0]), $entry[1]])
            ->filter(fn (array $entry) => $entry[0]['days'] >= $minDays);

        $roleHolders = $pending
            ->map(fn (array $entry) => $entry[1]['role'])
            ->filter()
            ->unique()
            ->mapWithKeys(fn (string $role) => [$role => User::withRole($role)->where('active', 1)->get()]);

        $reminders = [];
        $unattended = [];

        foreach ($pending as [$item, $responder]) {
            $recipients = ($responder['role'] !== null ? $roleHolders[$responder['role']] : collect([$responder['person']]))
                ->filter(fn (?User $user) => $user?->active && filled($user->email));

            if ($recipients->isEmpty()) {
                $unattended[] = $item;

                continue;
            }

            foreach ($recipients as $user) {
                $reminders[$user->id]['user'] ??= $user;
                $reminders[$user->id]['items'][] = $item;
            }
        }

        return [
            'reminders' => collect($reminders)
                ->map(fn (array $reminder) => [
                    'user' => $reminder['user'],
                    'items' => collect($reminder['items'])
                        ->sortBy([['company', 'asc'], ['days', 'desc']])
                        ->values()
                        ->all(),
                ])
                ->sortBy(fn (array $reminder) => $reminder['user']->name)
                ->values()
                ->all(),
            'unattended' => $unattended,
        ];
    }

    /**
     * @return array{type: string, folio: string, action: string, requester: ?string, company: ?string, days: int, url: string}
     */
    private function describe(PurchaseOrder|PurchaseRequisition $model): array
    {
        $isOrder = $model instanceof PurchaseOrder;
        $level = $isOrder ? self::ORDER_LEVELS[$model->status] : self::REQUISITION_LEVELS[$model->status];
        $chain = $isOrder ? $model->requisition?->approvalChain : $model->approvalChain;

        return [
            'type' => $isOrder ? 'Orden' : 'Requisición',
            'folio' => (string) $model->folio,
            'action' => $level['action'],
            'requester' => $chain?->requester?->name,
            'company' => $model->company?->short_name ?: $model->company?->name,
            'days' => $this->stalled->diasDetenida($model),
            'url' => route($level['route'], $model),
        ];
    }
}
