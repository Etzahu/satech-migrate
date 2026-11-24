<?php

namespace App\Services;

use App\Mail\PurchaseOrder\Notification;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;

/**
 * Requisiciones ya aprobadas cuyas órdenes todavía tienen que pasar por la
 * cadena.
 *
 * La orden no tiene cadena propia: la aprueba y la autoriza la cadena de su
 * requisición. «Verificar requisiciones» solo movía las requisiciones que
 * esperaban revisión, aprobación o autorización, así que en una baja las que
 * ya tenían comprador se quedaban en la cadena vieja, y cada orden que salía
 * de ellas se detenía en Aprueba sin que el aviso le llegara a nadie. Pasó con
 * cuatro órdenes de arrendamiento en noviembre de 2026.
 *
 * Cambiar la cadena aquí no regresa la requisición al inicio, porque ya está
 * aprobada, ni reinicia sus órdenes: solo cambia quién firma lo que falta.
 */
class AssignedRequisitionChainService
{
    /**
     * Estados de la requisición en los que todavía puede generarse una orden.
     *
     * @var array<int, string>
     */
    public const ASSIGNED_STATUSES = [
        'aprobado por DG',
        'comprador asignado',
        'comprador reasignado',
    ];

    /**
     * Estados de la orden que ya dejaron atrás los niveles de la cadena.
     *
     * @var array<int, string>
     */
    public const ORDER_STATUSES_PAST_CHAIN = [
        'aprobado por DG nivel 1',
        'liberado por dirección administrativa',
        'aprobado por DG nivel 2',
        'autorizada para proveedor',
    ];

    public function __construct(private PurchaseOrderChainResolver $resolver) {}

    /**
     * Requisiciones asignadas, en la cadena del usuario como aprobador o
     * autorizador, que aún no tienen orden o tienen alguna que todavía va a
     * pasar por esos niveles.
     *
     * Las de gerencias con flujo por rol se quedan fuera: sus órdenes no las
     * firma la cadena.
     *
     * @return Collection<int, PurchaseRequisition>
     */
    public function pendingFor(User $user, ?int $companyId): Collection
    {
        return PurchaseRequisition::query()
            ->where('company_id', $companyId)
            ->whereIn('status', self::ASSIGNED_STATUSES)
            ->whereHas('approvalChain', fn (Builder $chain) => $chain->where(fn (Builder $participant) => $participant
                ->where('approver_id', $user->id)
                ->orWhere('authorizer_id', $user->id)))
            ->where(fn (Builder $query) => $query
                ->whereDoesntHave('orders', fn (Builder $orders) => $orders->where('status', 'not like', 'cancelado%'))
                ->orWhereHas('orders', fn (Builder $orders) => $this->stillInChain($orders)))
            ->with(['approvalChain.requester.management', 'company', 'orders'])
            ->orderBy('id')
            ->get()
            ->reject(fn (PurchaseRequisition $requisition) => $this->resolver->chainUsesRoleFlow($requisition->approvalChain))
            ->values();
    }

    /**
     * ¿La orden todavía va a pasar por la aprobación o la autorización?
     *
     * Una devuelta o reabierta vuelve a recorrer el flujo completo, así que
     * cuenta aunque hoy esté en manos del comprador.
     */
    public function isStillInChain(PurchaseOrder $order): bool
    {
        return ! in_array($order->status, self::ORDER_STATUSES_PAST_CHAIN, true)
            && ! str_starts_with((string) $order->status, 'cancelado');
    }

    /**
     * Cadenas a las que puede pasar la requisición: del mismo solicitante,
     * activas y con todos sus participantes activos.
     *
     * @return Collection<int, PurchaseRequisitionApprovalChain>
     */
    public function availableChains(PurchaseRequisition $requisition): Collection
    {
        return PurchaseRequisitionApprovalChain::query()
            ->with(['reviewer', 'approver', 'authorizer'])
            ->where('requester_id', $requisition->approvalChain?->requester_id)
            ->whereKeyNot($requisition->approval_chain_id)
            ->selectable()
            ->orderBy('id')
            ->get();
    }

    /**
     * Pasa la requisición a otra cadena sin tocar su estado ni el de sus
     * órdenes, y avisa a los nuevos firmantes de las órdenes que ya los
     * esperan. Devuelve cuántas órdenes se avisaron.
     *
     * El cambio queda en el historial de estados bajo el campo
     * `approval_chain_id`, aparte del de `status`: un registro de status
     * repetido movería las fechas del avance de la requisición.
     *
     * @throws InvalidArgumentException si la cadena no es del mismo solicitante o no puede usarse.
     */
    public function switchChain(PurchaseRequisition $requisition, PurchaseRequisitionApprovalChain $chain, User $responsible): int
    {
        if (! $this->availableChains($requisition)->contains($chain)) {
            throw new InvalidArgumentException('La cadena elegida no es del mismo solicitante o ya no puede usarse.');
        }

        $previous = $requisition->approvalChain;

        DB::transaction(function () use ($requisition, $chain, $previous, $responsible): void {
            $requisition->approval_chain_id = $chain->id;
            $requisition->save();

            $requisition->recordState(
                'approval_chain_id',
                (string) $previous?->id,
                (string) $chain->id,
                [
                    'respuesta' => sprintf(
                        'Cadena cambiada sin reiniciar. Antes: %s. Ahora: %s.',
                        $this->describeChain($previous),
                        $this->describeChain($chain),
                    ),
                ],
                $responsible,
            );
        });

        $requisition->unsetRelation('approvalChain');

        return $this->notifyWaitingOrders($requisition);
    }

    /**
     * Quién revisa, aprueba y autoriza en la cadena, para mostrarlo.
     */
    public function describeChain(?PurchaseRequisitionApprovalChain $chain): string
    {
        if (! $chain) {
            return 'sin cadena';
        }

        return sprintf(
            'Revisa %s, aprueba %s, autoriza %s',
            $chain->reviewer?->name ?? 'nadie',
            $chain->approver?->name ?? 'nadie',
            $chain->authorizer?->name ?? 'N/A',
        );
    }

    /**
     * Las órdenes que ya esperaban la firma de la cadena recibieron su aviso
     * al entrar al nivel, dirigido a quien estaba antes. Se repite para quien
     * firma ahora.
     */
    private function notifyWaitingOrders(PurchaseRequisition $requisition): int
    {
        $notified = 0;

        foreach ($requisition->orders()->get() as $order) {
            [$recipients, $subject] = match ($order->status) {
                'aprobado por gerente de compras' => [$this->resolver->approverEmails($order), 'revisar'],
                'aprobado por gerente solicitante' => [$this->resolver->authorizerEmails($order), 'revision'],
                default => [[], null],
            };

            if ($recipients === []) {
                continue;
            }

            Mail::to($recipients)->send(new Notification((new OrderService)->generateDataEmail($order->id, $subject)));
            $notified++;
        }

        return $notified;
    }

    /**
     * @template TQuery of Builder|Relation
     *
     * @param  TQuery  $orders
     * @return TQuery
     */
    private function stillInChain(Builder|Relation $orders): Builder|Relation
    {
        return $orders
            ->whereNotIn('status', self::ORDER_STATUSES_PAST_CHAIN)
            ->where('status', 'not like', 'cancelado%');
    }
}
