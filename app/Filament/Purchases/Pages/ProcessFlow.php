<?php

namespace App\Filament\Purchases\Pages;

use Filament\Pages\Page;

class ProcessFlow extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map';

    protected string $view = 'filament.purchases.pages.process-flow';

    protected static ?string $navigationLabel = 'Flujo del proceso';

    protected static ?string $title = 'Flujo del proceso';

    protected static ?int $navigationSort = 3;

    /**
     * Diagrama de flujo de la requisición de compra.
     *
     * Los nodos y transiciones reflejan PurchaseRequisitionStateMachine.
     * `col`/`row` definen la posición en la cuadrícula del diagrama:
     * fila 0 = cancelaciones y casos especiales, fila 1 = camino principal,
     * fila 2 = devoluciones.
     *
     * @return array{id: string, title: string, reentryLabel: string, nodes: array, edges: array}
     */
    public function getRequisitionFlow(): array
    {
        return [
            'id' => 'requisition',
            'title' => 'Requisición de compra',
            'reentryLabel' => 'El solicitante corrige y reenvía al flujo',
            'nodes' => [
                [
                    'id' => 'borrador', 'label' => 'Borrador', 'icon' => '📝', 'type' => 'start',
                    'col' => 0, 'row' => 1, 'progress' => 0,
                    'actor' => 'Solicitante',
                    'description' => 'El solicitante captura la requisición: partidas, proyecto, prioridad, fecha y dirección de entrega, y adjunta archivos de soporte. Al enviarla inicia el flujo de aprobación.',
                    'notify' => null,
                ],
                [
                    'id' => 'rev_almacen', 'label' => 'Revisión por almacén', 'icon' => '📦', 'type' => 'review',
                    'col' => 1, 'row' => 1, 'progress' => 20,
                    'actor' => 'Almacén',
                    'description' => 'Almacén verifica la existencia de las partidas solicitadas: puede surtir desde inventario, ajustar cantidades o devolver la requisición. Las requisiciones de servicio omiten este paso y pasan directo a revisión.',
                    'notify' => 'Correo al equipo de almacén',
                ],
                [
                    'id' => 'revision', 'label' => 'Revisión', 'icon' => '🔍', 'type' => 'review',
                    'col' => 2, 'row' => 1, 'progress' => 40,
                    'actor' => 'Revisor de la cadena',
                    'description' => 'El revisor valida que la requisición sea correcta y esté completa. Si almacén modificó alguna partida, el solicitante recibe un aviso con los cambios. El revisor puede aprobar, devolver o cancelar.',
                    'notify' => 'Correo al revisor; aviso al solicitante si almacén editó partidas',
                ],
                [
                    'id' => 'apr_revisor', 'label' => 'Aprobado por revisor', 'icon' => '✔️', 'type' => 'approval',
                    'col' => 3, 'row' => 1, 'progress' => 60,
                    'actor' => 'Gerente solicitante (aprobador)',
                    'description' => 'El revisor aprobó la requisición. Queda en espera del gerente del área solicitante, quien puede aprobar, devolver o cancelar.',
                    'notify' => 'Correo al gerente aprobador',
                ],
                [
                    'id' => 'apr_gerencia', 'label' => 'Aprobado por gerencia', 'icon' => '✔️', 'type' => 'approval',
                    'col' => 4, 'row' => 1, 'progress' => 80,
                    'actor' => 'Dirección General (autorizador)',
                    'description' => 'El gerente aprobó la requisición. Queda en espera de la autorización final de Dirección General, que puede autorizar, devolver o cancelar.',
                    'notify' => 'Correo al autorizador de Dirección General',
                ],
                [
                    'id' => 'apr_dg', 'label' => 'Aprobado por DG', 'icon' => '🏛️', 'type' => 'approval',
                    'col' => 5, 'row' => 1, 'progress' => 90,
                    'actor' => 'Gerente de compras',
                    'description' => 'Dirección General autorizó la requisición. El gerente de compras asigna al comprador responsable de colocar las órdenes de compra, o puede devolverla.',
                    'notify' => 'Correo al solicitante con copia a los involucrados',
                ],
                [
                    'id' => 'comprador', 'label' => 'Comprador asignado', 'icon' => '🛒', 'type' => 'purchase',
                    'col' => 6, 'row' => 1, 'progress' => 95,
                    'actor' => 'Comprador',
                    'description' => 'El comprador genera las órdenes de compra necesarias para surtir las partidas de la requisición. Si detecta un problema puede devolverla al solicitante.',
                    'notify' => 'Correo al comprador asignado con copia al gerente de compras',
                ],
                [
                    'id' => 'cerrada', 'label' => 'Cerrada', 'icon' => '🏁', 'type' => 'final',
                    'col' => 7, 'row' => 1, 'progress' => 100,
                    'actor' => 'Sistema / Gerente de compras',
                    'description' => 'Proceso concluido: todas las partidas fueron atendidas con órdenes de compra autorizadas o surtidas por almacén. Estado final.',
                    'notify' => 'Correo al solicitante con copia al gerente de compras',
                ],
                // ── Cancelaciones (estados finales) ─────────────────────────
                [
                    'id' => 'can_revisor', 'label' => 'Cancelado por revisor', 'icon' => '⛔', 'type' => 'cancel',
                    'col' => 2, 'row' => 0,
                    'actor' => 'Revisor de la cadena',
                    'description' => 'El revisor canceló definitivamente la requisición. Es un estado final: no puede reactivarse.',
                    'notify' => 'Correo al solicitante',
                ],
                [
                    'id' => 'can_gerencia', 'label' => 'Cancelado por gerencia', 'icon' => '⛔', 'type' => 'cancel',
                    'col' => 3, 'row' => 0,
                    'actor' => 'Gerente solicitante',
                    'description' => 'El gerente canceló definitivamente la requisición. Es un estado final: no puede reactivarse.',
                    'notify' => 'Correo al solicitante',
                ],
                [
                    'id' => 'can_dg', 'label' => 'Cancelado por DG', 'icon' => '⛔', 'type' => 'cancel',
                    'col' => 4, 'row' => 0,
                    'actor' => 'Dirección General',
                    'description' => 'Dirección General canceló definitivamente la requisición. Es un estado final: no puede reactivarse.',
                    'notify' => 'Correo al solicitante',
                ],
                // ── Devoluciones (regresan al solicitante) ──────────────────
                [
                    'id' => 'dev_almacen', 'label' => 'Devuelto por almacén', 'icon' => '↩️', 'type' => 'return',
                    'col' => 1, 'row' => 2,
                    'actor' => 'Solicitante (corrige)',
                    'description' => 'Almacén devolvió la requisición con observaciones. El solicitante la corrige y la reenvía al flujo.',
                    'notify' => 'Correo al solicitante',
                ],
                [
                    'id' => 'dev_revisor', 'label' => 'Devuelto por revisor', 'icon' => '↩️', 'type' => 'return',
                    'col' => 2, 'row' => 2,
                    'actor' => 'Solicitante (corrige)',
                    'description' => 'El revisor devolvió la requisición con observaciones. El solicitante la corrige y la reenvía al flujo.',
                    'notify' => 'Correo al solicitante',
                ],
                [
                    'id' => 'dev_gerencia', 'label' => 'Devuelto por gerencia', 'icon' => '↩️', 'type' => 'return',
                    'col' => 3, 'row' => 2,
                    'actor' => 'Solicitante (corrige)',
                    'description' => 'El gerente devolvió la requisición con observaciones. El solicitante la corrige y la reenvía al flujo.',
                    'notify' => 'Correo al solicitante',
                ],
                [
                    'id' => 'dev_dg', 'label' => 'Devuelto por DG', 'icon' => '↩️', 'type' => 'return',
                    'col' => 4, 'row' => 2,
                    'actor' => 'Solicitante (corrige)',
                    'description' => 'Dirección General devolvió la requisición con observaciones. El solicitante la corrige y la reenvía al flujo.',
                    'notify' => 'Correo al solicitante',
                ],
                [
                    'id' => 'dev_gcompras', 'label' => 'Devuelto por gte. de compras', 'icon' => '↩️', 'type' => 'return',
                    'col' => 5, 'row' => 2,
                    'actor' => 'Solicitante (corrige)',
                    'description' => 'El gerente de compras devolvió la requisición; además se libera el comprador asignado. El solicitante la corrige y la reenvía al flujo.',
                    'notify' => 'Correo al solicitante',
                ],
                [
                    'id' => 'dev_comprador', 'label' => 'Devuelto por comprador', 'icon' => '↩️', 'type' => 'return',
                    'col' => 6, 'row' => 2,
                    'actor' => 'Solicitante (corrige)',
                    'description' => 'El comprador devolvió la requisición; se libera su asignación. El solicitante la corrige y la reenvía al flujo.',
                    'notify' => 'Correo al solicitante',
                ],
                // ── Casos especiales ─────────────────────────────────────────
                [
                    'id' => 'cadena_reasignada', 'label' => 'Cadena reasignada', 'icon' => '🔄', 'type' => 'special',
                    'col' => 0, 'row' => 0,
                    'actor' => 'Administrador',
                    'description' => 'Puede ocurrir desde cualquier estado: un administrador cambia la cadena de aprobación (por ejemplo, por un usuario inactivo) y la requisición vuelve a iniciar el flujo de revisión.',
                    'notify' => 'Correo al solicitante con el detalle del cambio',
                ],
                [
                    'id' => 'comprador_reasignado', 'label' => 'Comprador reasignado', 'icon' => '🔁', 'type' => 'special',
                    'col' => 6, 'row' => 0, 'progress' => 95,
                    'actor' => 'Gerente de compras',
                    'description' => 'Puede ocurrir en cualquier momento: el gerente de compras asigna la requisición a un comprador distinto, quien continúa generando las órdenes de compra.',
                    'notify' => 'Correo al nuevo comprador con copia al gerente de compras',
                ],
            ],
            'edges' => [
                // Camino principal
                ['from' => 'borrador', 'to' => 'rev_almacen', 'label' => 'Envía · proveeduría', 'type' => 'forward', 'main' => true],
                ['from' => 'borrador', 'to' => 'revision', 'label' => 'Envía · servicio', 'type' => 'forward', 'arc' => -80],
                ['from' => 'borrador', 'to' => 'apr_revisor', 'label' => 'Solicitante es el revisor', 'type' => 'alt', 'arc' => -165],
                ['from' => 'rev_almacen', 'to' => 'revision', 'label' => 'Valida', 'type' => 'forward', 'main' => true],
                ['from' => 'revision', 'to' => 'apr_revisor', 'label' => 'Aprueba', 'type' => 'forward', 'main' => true],
                ['from' => 'apr_revisor', 'to' => 'apr_gerencia', 'label' => 'Aprueba', 'type' => 'forward', 'main' => true],
                ['from' => 'apr_gerencia', 'to' => 'apr_dg', 'label' => 'Autoriza', 'type' => 'forward', 'main' => true],
                ['from' => 'apr_dg', 'to' => 'comprador', 'label' => 'Asigna', 'type' => 'forward', 'main' => true],
                ['from' => 'comprador', 'to' => 'cerrada', 'label' => 'Concluye', 'type' => 'forward', 'main' => true],
                // Cancelaciones
                ['from' => 'revision', 'to' => 'can_revisor', 'label' => 'Cancela', 'type' => 'cancel'],
                ['from' => 'apr_revisor', 'to' => 'can_gerencia', 'label' => 'Cancela', 'type' => 'cancel'],
                ['from' => 'apr_gerencia', 'to' => 'can_dg', 'label' => 'Cancela', 'type' => 'cancel'],
                // Devoluciones
                ['from' => 'rev_almacen', 'to' => 'dev_almacen', 'label' => 'Devuelve', 'type' => 'return'],
                ['from' => 'revision', 'to' => 'dev_revisor', 'label' => 'Devuelve', 'type' => 'return'],
                ['from' => 'apr_revisor', 'to' => 'dev_gerencia', 'label' => 'Devuelve', 'type' => 'return'],
                ['from' => 'apr_gerencia', 'to' => 'dev_dg', 'label' => 'Devuelve', 'type' => 'return'],
                ['from' => 'apr_dg', 'to' => 'dev_gcompras', 'label' => 'Devuelve', 'type' => 'return'],
                ['from' => 'comprador', 'to' => 'dev_comprador', 'label' => 'Devuelve', 'type' => 'return'],
                // Reingreso al flujo
                ['from' => 'dev_almacen', 'to' => 'rev_almacen', 'label' => 'Corrige y reenvía', 'type' => 'loop'],
                ['from' => 'dev_revisor', 'to' => 'rev_almacen', 'type' => 'bus'],
                ['from' => 'dev_gerencia', 'to' => 'rev_almacen', 'type' => 'bus'],
                ['from' => 'dev_dg', 'to' => 'rev_almacen', 'type' => 'bus'],
                ['from' => 'dev_gcompras', 'to' => 'rev_almacen', 'type' => 'bus'],
                ['from' => 'dev_comprador', 'to' => 'rev_almacen', 'type' => 'bus'],
                // Casos especiales
                ['from' => 'cadena_reasignada', 'to' => 'rev_almacen', 'label' => 'Reinicia el flujo', 'type' => 'special'],
                ['from' => 'comprador_reasignado', 'to' => 'comprador', 'label' => 'Continúa', 'type' => 'special'],
            ],
        ];
    }

    /**
     * Diagrama de flujo de la orden de compra.
     *
     * Los nodos y transiciones reflejan PurchaseOrderStateMachine:
     * flujo normal de 4 niveles de aprobación con bifurcación por monto
     * y flujo especial directo a Dirección General para proveedores de
     * lista especial.
     *
     * @return array{id: string, title: string, reentryLabel: string, nodes: array, edges: array}
     */
    public function getOrderFlow(): array
    {
        return [
            'id' => 'order',
            'title' => 'Orden de compra',
            'reentryLabel' => 'El comprador corrige y reenvía al flujo',
            'nodes' => [
                [
                    'id' => 'borrador', 'label' => 'Borrador', 'icon' => '📝', 'type' => 'start',
                    'col' => 0, 'row' => 1,
                    'actor' => 'Comprador',
                    'description' => 'El comprador crea la orden a partir de una requisición aprobada que le fue asignada: selecciona proveedor y contacto, captura partidas, cotización, moneda y condiciones de pago. El folio se genera automáticamente.',
                    'notify' => null,
                ],
                [
                    'id' => 'rev_gcompras', 'label' => 'Revisión gte. de compras', 'icon' => '🔍', 'type' => 'review',
                    'col' => 1, 'row' => 1,
                    'actor' => 'Gerente de compras',
                    'description' => 'El gerente de compras revisa la orden: proveedor, precios, condiciones y documentación. Puede aprobar, devolver o cancelar.',
                    'notify' => 'Correo a los gerentes de compras',
                ],
                [
                    'id' => 'apr_gcompras', 'label' => 'Aprobado por gte. de compras', 'icon' => '✔️', 'type' => 'approval',
                    'col' => 2, 'row' => 1,
                    'actor' => 'Gerente solicitante',
                    'description' => 'El gerente de compras aprobó. La orden espera la aprobación del gerente del área solicitante, según la cadena de aprobación de la requisición.',
                    'notify' => 'Correo al gerente solicitante',
                ],
                [
                    'id' => 'apr_gsolicitante', 'label' => 'Aprobado por gte. solicitante', 'icon' => '✔️', 'type' => 'approval',
                    'col' => 3, 'row' => 1,
                    'actor' => 'Dirección General (nivel 1)',
                    'description' => 'El gerente solicitante aprobó. La orden espera la autorización de Dirección General nivel 1.',
                    'notify' => 'Correo al autorizador de Dirección General',
                ],
                [
                    'id' => 'apr_dg1', 'label' => 'Aprobado por DG nivel 1', 'icon' => '🏛️', 'type' => 'approval',
                    'col' => 4, 'row' => 1,
                    'actor' => 'Dirección General (nivel 2) / Sistema',
                    'description' => 'DG nivel 1 autorizó. Si el total supera $300,000 MXN o $15,000 USD, la orden requiere una segunda autorización (DG nivel 2); de lo contrario queda autorizada para el proveedor. Algunos proveedores específicos están exentos del nivel 2.',
                    'notify' => 'Correo a DG nivel 2 solo si el monto supera el límite',
                ],
                [
                    'id' => 'apr_dg2', 'label' => 'Aprobado por DG nivel 2', 'icon' => '🏛️', 'type' => 'approval',
                    'col' => 5, 'row' => 1,
                    'actor' => 'Dirección General CA',
                    'description' => 'Segunda autorización de Dirección General, requerida solo para montos que superan el límite establecido.',
                    'notify' => null,
                ],
                [
                    'id' => 'autorizada', 'label' => 'Autorizada para proveedor', 'icon' => '🏁', 'type' => 'final',
                    'col' => 6, 'row' => 1,
                    'actor' => 'Comprador',
                    'description' => 'La orden queda autorizada y puede enviarse al proveedor. Se calcula la fecha final de entrega según los días capturados y se genera la evaluación del proveedor.',
                    'notify' => 'Correo al comprador con copia a los involucrados',
                ],
                [
                    'id' => 'reabierta', 'label' => 'Reabierta para edición', 'icon' => '🔓', 'type' => 'special',
                    'col' => 7, 'row' => 0,
                    'actor' => 'Comprador',
                    'description' => 'Una orden ya autorizada se reabre para corregirla: se cancelan las evaluaciones de proveedor pendientes y la orden vuelve a iniciar el flujo de aprobación.',
                    'notify' => 'Correo al comprador, solicitante, autorizador, DG y gerente de compras',
                ],
                // ── Flujo especial: proveedor de lista especial ─────────────
                [
                    'id' => 'rev_dg_especial', 'label' => 'Revisión por Dirección General', 'icon' => '⭐', 'type' => 'review',
                    'col' => 2, 'row' => 0,
                    'actor' => 'Dirección General',
                    'description' => 'Flujo especial: cuando el proveedor pertenece a la lista especial definida por el gerente de compras, la orden pasa directamente a revisión de Dirección General, sin el resto de aprobaciones intermedias.',
                    'notify' => 'Correo a Dirección General',
                ],
                [
                    'id' => 'dev_dg_especial', 'label' => 'Devuelto por Dirección General', 'icon' => '↩️', 'type' => 'return',
                    'col' => 1, 'row' => 0,
                    'actor' => 'Comprador (corrige)',
                    'description' => 'Dirección General devolvió la orden del flujo especial. El comprador la corrige y la reenvía a revisión de DG.',
                    'notify' => 'Correo al comprador',
                ],
                [
                    'id' => 'can_dg_especial', 'label' => 'Cancelado por Dirección General', 'icon' => '⛔', 'type' => 'cancel',
                    'col' => 2, 'row' => -1,
                    'actor' => 'Dirección General',
                    'description' => 'Dirección General canceló definitivamente la orden del flujo especial. Estado final.',
                    'notify' => 'Correo al comprador',
                ],
                // ── Devoluciones (flujo normal) ──────────────────────────────
                [
                    'id' => 'dev_gcompras', 'label' => 'Devuelto por gte. de compras', 'icon' => '↩️', 'type' => 'return',
                    'col' => 1, 'row' => 2,
                    'actor' => 'Comprador (corrige)',
                    'description' => 'El gerente de compras devolvió la orden con observaciones. El comprador la corrige y la reenvía al flujo.',
                    'notify' => 'Correo al comprador',
                ],
                [
                    'id' => 'dev_gsolicitante', 'label' => 'Devuelto por gte. solicitante', 'icon' => '↩️', 'type' => 'return',
                    'col' => 2, 'row' => 2,
                    'actor' => 'Comprador (corrige)',
                    'description' => 'El gerente solicitante devolvió la orden con observaciones. El comprador la corrige y la reenvía al flujo.',
                    'notify' => 'Correo al comprador',
                ],
                [
                    'id' => 'dev_dg1', 'label' => 'Devuelto por DG nivel 1', 'icon' => '↩️', 'type' => 'return',
                    'col' => 3, 'row' => 2,
                    'actor' => 'Comprador (corrige)',
                    'description' => 'Dirección General nivel 1 devolvió la orden con observaciones. El comprador la corrige y la reenvía al flujo.',
                    'notify' => 'Correo al comprador',
                ],
                [
                    'id' => 'dev_dg2', 'label' => 'Devuelto por DG nivel 2', 'icon' => '↩️', 'type' => 'return',
                    'col' => 4, 'row' => 2,
                    'actor' => 'Comprador (corrige)',
                    'description' => 'Dirección General nivel 2 devolvió la orden con observaciones. El comprador la corrige y la reenvía al flujo.',
                    'notify' => 'Correo al comprador',
                ],
                // ── Cancelaciones (estados finales) ──────────────────────────
                [
                    'id' => 'can_gcompras', 'label' => 'Cancelado por gte. de compras', 'icon' => '⛔', 'type' => 'cancel',
                    'col' => 1.5, 'row' => 3,
                    'actor' => 'Gerente de compras',
                    'description' => 'El gerente de compras canceló definitivamente la orden. Estado final.',
                    'notify' => 'Correo al comprador',
                ],
                [
                    'id' => 'can_gsolicitante', 'label' => 'Cancelado por gte. solicitante', 'icon' => '⛔', 'type' => 'cancel',
                    'col' => 2.5, 'row' => 3,
                    'actor' => 'Gerente solicitante',
                    'description' => 'El gerente solicitante canceló definitivamente la orden. Estado final.',
                    'notify' => 'Correo al comprador',
                ],
                [
                    'id' => 'can_dg1', 'label' => 'Cancelado por DG nivel 1', 'icon' => '⛔', 'type' => 'cancel',
                    'col' => 3.5, 'row' => 3,
                    'actor' => 'Dirección General (nivel 1)',
                    'description' => 'Dirección General nivel 1 canceló definitivamente la orden. Estado final.',
                    'notify' => 'Correo al comprador',
                ],
                [
                    'id' => 'can_dg2', 'label' => 'Cancelado por DG nivel 2', 'icon' => '⛔', 'type' => 'cancel',
                    'col' => 4.5, 'row' => 3,
                    'actor' => 'Dirección General (nivel 2)',
                    'description' => 'Dirección General nivel 2 canceló definitivamente la orden. Estado final.',
                    'notify' => 'Correo al comprador',
                ],
                // ── Casos especiales (desde cualquier estado) ────────────────
                [
                    'id' => 'cadena_reasignada', 'label' => 'Cadena reasignada', 'icon' => '🔄', 'type' => 'special',
                    'col' => 5, 'row' => 2,
                    'actor' => 'Administrador',
                    'description' => 'Puede ocurrir desde cualquier estado: cambió la cadena de aprobación de la requisición y la orden vuelve al inicio del flujo de aprobación.',
                    'notify' => 'Correo al comprador, gerente de compras y nuevos aprobadores',
                ],
                [
                    'id' => 'dev_admin', 'label' => 'Devuelto por administrador', 'icon' => '↩️', 'type' => 'return',
                    'col' => 6, 'row' => 2,
                    'actor' => 'Comprador (corrige)',
                    'description' => 'Puede ocurrir desde cualquier estado: un administrador devolvió la orden y esta vuelve a revisión del gerente de compras.',
                    'notify' => 'Correo al comprador',
                ],
                [
                    'id' => 'req_reasignada', 'label' => 'Requisición reasignada', 'icon' => '🔄', 'type' => 'special',
                    'col' => 7, 'row' => 2,
                    'actor' => 'Administrador',
                    'description' => 'Puede ocurrir desde cualquier estado: la orden se vincula a otra requisición (con otra cadena de aprobación) y el flujo de aprobación reinicia.',
                    'notify' => 'Correo al comprador con copia al gerente de compras',
                ],
            ],
            'edges' => [
                // Camino principal
                ['from' => 'borrador', 'to' => 'rev_gcompras', 'label' => 'Envía', 'type' => 'forward', 'main' => true],
                ['from' => 'rev_gcompras', 'to' => 'apr_gcompras', 'label' => 'Aprueba', 'type' => 'forward', 'main' => true],
                ['from' => 'apr_gcompras', 'to' => 'apr_gsolicitante', 'label' => 'Aprueba', 'type' => 'forward', 'main' => true],
                ['from' => 'apr_gsolicitante', 'to' => 'apr_dg1', 'label' => 'Autoriza', 'type' => 'forward', 'main' => true],
                ['from' => 'apr_dg1', 'to' => 'apr_dg2', 'label' => 'Supera límite', 'type' => 'forward', 'main' => true],
                ['from' => 'apr_dg2', 'to' => 'autorizada', 'label' => 'Autoriza', 'type' => 'forward', 'main' => true],
                ['from' => 'apr_dg1', 'to' => 'autorizada', 'label' => 'En límite', 'type' => 'forward', 'arc' => -95],
                ['from' => 'autorizada', 'to' => 'reabierta', 'label' => 'Se reabre', 'type' => 'special'],
                // Flujo especial: proveedor de lista especial
                ['from' => 'borrador', 'to' => 'rev_dg_especial', 'label' => 'Proveedor de lista especial', 'type' => 'special', 'exit' => 'top', 'enter' => 'left', 'via' => [[0.85, 0.47]]],
                ['from' => 'rev_dg_especial', 'to' => 'autorizada', 'label' => 'DG autoriza', 'type' => 'overpass'],
                ['from' => 'rev_dg_especial', 'to' => 'dev_dg_especial', 'label' => 'Devuelve', 'type' => 'return'],
                ['from' => 'dev_dg_especial', 'to' => 'rev_dg_especial', 'label' => 'Corrige y reenvía', 'type' => 'loop', 'labelDy' => 14],
                ['from' => 'rev_dg_especial', 'to' => 'can_dg_especial', 'label' => 'Cancela', 'type' => 'cancel'],
                // Devoluciones (flujo normal)
                ['from' => 'rev_gcompras', 'to' => 'dev_gcompras', 'label' => 'Devuelve', 'type' => 'return'],
                ['from' => 'apr_gcompras', 'to' => 'dev_gsolicitante', 'label' => 'Devuelve', 'type' => 'return'],
                ['from' => 'apr_gsolicitante', 'to' => 'dev_dg1', 'label' => 'Devuelve', 'type' => 'return'],
                ['from' => 'apr_dg1', 'to' => 'dev_dg2', 'label' => 'Devuelve', 'type' => 'return'],
                // Cancelaciones (flujo normal, enrutadas por el pasillo entre columnas)
                ['from' => 'rev_gcompras', 'to' => 'can_gcompras', 'label' => 'Cancela', 'type' => 'cancelGap'],
                ['from' => 'apr_gcompras', 'to' => 'can_gsolicitante', 'label' => 'Cancela', 'type' => 'cancelGap'],
                ['from' => 'apr_gsolicitante', 'to' => 'can_dg1', 'label' => 'Cancela', 'type' => 'cancelGap'],
                ['from' => 'apr_dg1', 'to' => 'can_dg2', 'label' => 'Cancela', 'type' => 'cancelGap'],
                // Reingreso al flujo
                ['from' => 'dev_gcompras', 'to' => 'rev_gcompras', 'label' => 'Corrige y reenvía', 'type' => 'loop'],
                ['from' => 'dev_gsolicitante', 'to' => 'rev_gcompras', 'type' => 'bus'],
                ['from' => 'dev_dg1', 'to' => 'rev_gcompras', 'type' => 'bus'],
                ['from' => 'dev_dg2', 'to' => 'rev_gcompras', 'type' => 'bus'],
                ['from' => 'cadena_reasignada', 'to' => 'rev_gcompras', 'type' => 'bus'],
                ['from' => 'dev_admin', 'to' => 'rev_gcompras', 'type' => 'bus'],
                ['from' => 'req_reasignada', 'to' => 'rev_gcompras', 'type' => 'bus'],
                ['from' => 'reabierta', 'to' => 'rev_gcompras', 'type' => 'bus', 'busDx' => 120],
            ],
        ];
    }
}
