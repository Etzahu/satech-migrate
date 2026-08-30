<?php

namespace Tests\Unit;

use App\Models\Management;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use App\Services\PurchaseOrderChainResolver;
use Tests\TestCase;

/**
 * Qué flujo aplica a cada orden y quién responde sus niveles 2 y 3.
 *
 * El correo de Operaciones pide que en los cinco departamentos operativos las
 * órdenes las apruebe Alan Anaya y las autorice Sergio Ordaz, mientras la
 * requisición sigue pasando por el gerente de área. Como la misma cadena sirve
 * a los dos documentos, el nivel de la orden se resuelve por rol y el alcance
 * se marca en la gerencia, con una excepción por cadena.
 *
 * Esta clase decide quién ve, quién accede y quién tiene botón: si se equivoca,
 * o se atoran 1,012 órdenes o las aprueba quien no debe.
 *
 * Arma el grafo en memoria y no persiste nada, igual que
 * PurchaseOrderChainRolesTest.
 */
class PurchaseOrderChainResolverTest extends TestCase
{
    private PurchaseOrderChainResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resolver = new PurchaseOrderChainResolver;
    }

    /**
     * @param  array<string, int|null>  $puestos  rol de la cadena => id de usuario
     */
    private function order(array $puestos, bool $gerenciaEnFlujo, bool $cadenaExcluida = false): PurchaseOrder
    {
        $management = new Management;
        $management->purchase_order_flow = $gerenciaEnFlujo;

        $requester = new User;
        $requester->id = $puestos['requester'] ?? 1;
        $requester->setRelation('management', $management);

        $chain = new PurchaseRequisitionApprovalChain;
        foreach (PurchaseRequisitionApprovalChain::ROLES as $role) {
            $chain->{$role.'_id'} = $puestos[$role] ?? null;
        }
        $chain->po_flow_excluded = $cadenaExcluida;
        $chain->setRelation('requester', $requester);

        $requisition = new PurchaseRequisition;
        $requisition->setRelation('approvalChain', $chain);

        $order = new PurchaseOrder;
        $order->setRelation('requisition', $requisition);

        return $order;
    }

    /**
     * Un usuario que solo existe por su id, sin roles: hasRole() responde false
     * sin tocar la base porque la relación se inyecta vacía.
     */
    private function user(int $id, array $roles = []): User
    {
        $user = new User;
        $user->id = $id;
        $user->setRelation('roles', collect($roles)->map(function (string $name) {
            $role = new \Spatie\Permission\Models\Role;
            $role->name = $name;
            $role->guard_name = 'web';

            return $role;
        }));

        return $user;
    }

    public function test_la_gerencia_marcada_activa_el_flujo_por_rol(): void
    {
        $order = $this->order(['approver' => 20, 'authorizer' => 30], gerenciaEnFlujo: true);

        $this->assertTrue($this->resolver->usesRoleFlow($order));
    }

    public function test_una_gerencia_sin_marcar_sigue_resolviendo_por_cadena(): void
    {
        $order = $this->order(['approver' => 20, 'authorizer' => 30], gerenciaEnFlujo: false);

        $this->assertFalse($this->resolver->usesRoleFlow($order));
    }

    public function test_la_excepcion_por_cadena_gana_sobre_la_gerencia(): void
    {
        // El caso de las cadenas que rutean a Contratos y el de la cadena
        // propia de Alan: la gerencia usa el flujo nuevo, esa cadena no.
        $order = $this->order(['approver' => 20, 'authorizer' => 30], gerenciaEnFlujo: true, cadenaExcluida: true);

        $this->assertFalse($this->resolver->usesRoleFlow($order));
    }

    public function test_bajo_el_flujo_por_rol_responde_quien_tiene_el_rol(): void
    {
        $order = $this->order(['approver' => 20, 'authorizer' => 30], gerenciaEnFlujo: true);

        $alan = $this->user(341, [PurchaseOrderChainResolver::APPROVER_ROLE]);
        $sergio = $this->user(168, [PurchaseOrderChainResolver::AUTHORIZER_ROLE]);

        $this->assertTrue($this->resolver->isApprover($order, $alan));
        $this->assertTrue($this->resolver->isAuthorizer($order, $sergio));
    }

    public function test_bajo_el_flujo_por_rol_el_de_la_cadena_deja_de_responder(): void
    {
        // Kevin Pérez sigue aprobando la requisición, pero ya no la orden.
        $order = $this->order(['approver' => 227, 'authorizer' => 168], gerenciaEnFlujo: true);
        $kevin = $this->user(227);

        $this->assertFalse($this->resolver->isApprover($order, $kevin));
    }

    public function test_fuera_del_flujo_responde_la_cadena_y_no_el_rol(): void
    {
        $order = $this->order(['approver' => 227, 'authorizer' => 168], gerenciaEnFlujo: false);

        $kevin = $this->user(227);
        $alan = $this->user(341, [PurchaseOrderChainResolver::APPROVER_ROLE]);

        $this->assertTrue($this->resolver->isApprover($order, $kevin));
        $this->assertFalse($this->resolver->isApprover($order, $alan));
    }

    public function test_una_orden_sin_cadena_no_entra_al_flujo_por_rol(): void
    {
        $order = new PurchaseOrder;
        $order->setRelation('requisition', null);

        $this->assertFalse($this->resolver->usesRoleFlow($order));
        $this->assertFalse($this->resolver->isApprover($order, $this->user(341, [PurchaseOrderChainResolver::APPROVER_ROLE])));
    }

    public function test_un_solicitante_sin_gerencia_no_entra_al_flujo_por_rol(): void
    {
        // Siete cadenas vivas tienen al solicitante sin gerencia asignada.
        $chain = new PurchaseRequisitionApprovalChain;
        $chain->approver_id = 20;
        $chain->po_flow_excluded = false;

        $requester = new User;
        $requester->id = 1;
        $requester->setRelation('management', null);
        $chain->setRelation('requester', $requester);

        $requisition = new PurchaseRequisition;
        $requisition->setRelation('approvalChain', $chain);

        $order = new PurchaseOrder;
        $order->setRelation('requisition', $requisition);

        $this->assertFalse($this->resolver->usesRoleFlow($order));
    }

    public function test_sin_usuario_nadie_responde(): void
    {
        $order = $this->order(['approver' => 20, 'authorizer' => 30], gerenciaEnFlujo: true);

        $this->assertFalse($this->resolver->isApprover($order, null));
        $this->assertFalse($this->resolver->isAuthorizer($order, null));
        $this->assertFalse($this->resolver->participates($order, null));
    }

    public function test_participates_cubre_los_dos_niveles(): void
    {
        // Lo usa la policy: bajo el flujo por rol ni Alan ni Sergio aparecen en
        // la cadena, así que participatesInChain() no basta para abrir la orden.
        $order = $this->order(['approver' => 20, 'authorizer' => 30], gerenciaEnFlujo: true);

        $alan = $this->user(341, [PurchaseOrderChainResolver::APPROVER_ROLE]);
        $sergio = $this->user(168, [PurchaseOrderChainResolver::AUTHORIZER_ROLE]);
        $ajeno = $this->user(999);

        $this->assertTrue($this->resolver->participates($order, $alan));
        $this->assertTrue($this->resolver->participates($order, $sergio));
        $this->assertFalse($this->resolver->participates($order, $ajeno));
    }
}
