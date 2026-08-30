<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Antigüedad de las órdenes de compra detenidas.
 *
 * Responde dos preguntas distintas que conviene no mezclar:
 *
 *  - **¿Alguien está tardando en decidir?** La orden está esperando la firma de
 *    un nivel del flujo.
 *  - **¿La orden está en cancha del comprador?** Está en borrador o le
 *    devolvieron con observaciones. Nadie está atorado: falta que la trabajen.
 *
 * Mide desde la **última transición** (`state_histories`), no desde
 * `updated_at`, que se mueve con cualquier edición y haría ver como reciente
 * una orden que lleva meses sin avanzar.
 */
class StalledOrderService
{
    /**
     * Días a partir de los cuales un estado se considera detenido.
     *
     * Los estados de decisión son estrictos —quien firma tiene la orden en su
     * bandeja— y los del comprador, laxos: cotizar y corregir toma días.
     */
    public const UMBRALES = [
        // Esperando una decisión
        'revisión gerente de compras' => 3,
        'aprobado por gerente de compras' => 3,
        'aprobado por gerente solicitante' => 3,
        'aprobado por DG nivel 1' => 3,
        'liberado por dirección administrativa' => 3,
        'revision por dirección general' => 3,

        // En cancha del comprador
        'borrador' => 15,
        'reabierta para edición' => 10,
        'devuelto por gerente de compras' => 10,
        'devuelto por gerente solicitante' => 10,
        'devuelto por DG nivel 1' => 10,
        'devuelto por DG nivel 2' => 10,
        'devuelto por liberación' => 10,
        'devuelto por dirección general' => 10,
        'devuelto por administrador' => 10,
        'requisición reasignada' => 10,
        'cadena reasignada' => 10,
    ];

    /**
     * Estados en los que la pelota la tiene el comprador, no un aprobador.
     */
    public const EN_CANCHA_DEL_COMPRADOR = [
        'borrador',
        'reabierta para edición',
        'devuelto por gerente de compras',
        'devuelto por gerente solicitante',
        'devuelto por DG nivel 1',
        'devuelto por DG nivel 2',
        'devuelto por liberación',
        'devuelto por dirección general',
        'devuelto por administrador',
        'requisición reasignada',
        'cadena reasignada',
    ];

    /**
     * Órdenes detenidas más allá del umbral de su estado, de la más antigua a
     * la más reciente.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public function stalled(?int $companyId = null): Collection
    {
        return PurchaseOrder::query()
            ->whereIn('status', array_keys(self::UMBRALES))
            ->when($companyId, fn ($query) => $query->where('company_id', $companyId))
            ->with(['purchaser', 'requisition.approvalChain.requester.management'])
            ->get()
            ->map(fn (PurchaseOrder $order) => $this->describe($order))
            ->filter(fn (array $fila) => $fila['dias'] >= self::UMBRALES[$fila['estado']])
            ->sortByDesc('dias')
            ->values();
    }

    /**
     * @return array<string, mixed>
     */
    public function describe(PurchaseOrder $order): array
    {
        $responsables = $this->responsablesDe($order);

        return [
            'orden' => $order,
            'folio' => $order->folio,
            'estado' => $order->status,
            'dias' => $this->diasDetenida($order),
            'umbral' => self::UMBRALES[$order->status] ?? null,
            'esperando_decision' => ! in_array($order->status, self::EN_CANCHA_DEL_COMPRADOR, true),
            'gerencia' => $order->requisition?->approvalChain?->requester?->management?->acronym,
            'responsables' => $responsables->pluck('name')->all(),
            'problema' => $this->problemaDe($order, $responsables),
        ];
    }

    /**
     * Días desde la última transición de estado.
     *
     * Sin histórico —órdenes anteriores a que se registrara— cae en la fecha de
     * creación, que es lo más cercano que hay.
     */
    public function diasDetenida(PurchaseOrder $order): int
    {
        $ultima = $order->status()->history()
            ->where('field', 'status')
            ->orderByDesc('created_at')
            ->value('created_at');

        return (int) ($ultima ?? $order->created_at)?->diffInDays(now());
    }

    /**
     * Quién tiene que mover esta orden ahora mismo.
     *
     * @return Collection<int, User>
     */
    public function responsablesDe(PurchaseOrder $order): Collection
    {
        if (in_array($order->status, self::EN_CANCHA_DEL_COMPRADOR, true)) {
            return collect(array_filter([$order->purchaser]));
        }

        $resolver = app(PurchaseOrderChainResolver::class);

        return match ($order->status) {
            'revisión gerente de compras' => User::withRole('gerente_compras')->get(),
            'aprobado por gerente de compras' => $this->porCorreo($resolver->approverEmails($order)),
            'aprobado por gerente solicitante' => $this->porCorreo($resolver->authorizerEmails($order)),
            'aprobado por DG nivel 1' => User::withRole('libera_orden_compra')->get(),
            'liberado por dirección administrativa' => (new PurchaseOrderFlowService)->requiresAmountApproval($order)
                ? User::withRole('autoriza_nivel-2-orden_compra')->get()
                : collect(),
            'revision por dirección general' => User::withRole('aprueba_orden_especial')->get(),
            default => collect(),
        };
    }

    /**
     * Por qué la orden no puede avanzar aunque alguien la mire, o null si el
     * único problema es el tiempo.
     *
     * @param  Collection<int, User>  $responsables
     */
    private function problemaDe(PurchaseOrder $order, Collection $responsables): ?string
    {
        if (in_array($order->status, self::EN_CANCHA_DEL_COMPRADOR, true)) {
            return $order->purchaser ? null : 'La orden no tiene comprador asignado.';
        }

        if ($responsables->isEmpty()) {
            return 'Nadie puede responder este nivel: el rol está vacío o la cadena no nombra a nadie.';
        }

        $inactivos = $responsables->where('active', 0);

        if ($inactivos->count() === $responsables->count()) {
            return 'Quien debe responder está dado de baja: '.$inactivos->pluck('name')->implode(', ').'.';
        }

        return null;
    }

    /**
     * @param  array<int, string>  $emails
     * @return Collection<int, User>
     */
    private function porCorreo(array $emails): Collection
    {
        return $emails === [] ? collect() : User::whereIn('email', $emails)->get();
    }
}
