<?php

namespace Tests\Unit;

use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use Tests\TestCase;

/**
 * chainRolesFor() debe devolver TODOS los roles que el usuario ocupa en la
 * cadena, no el primero.
 *
 * La versión anterior recorría PurchaseRequisitionApprovalChain::ROLES y hacía
 * `return $role` en la primera coincidencia. Como una misma persona ocupa dos
 * casillas con frecuencia —el solicitante suele ser también el revisor o el
 * aprobador, y en cuatro cadenas Alan Anaya aprueba y autoriza—, los niveles
 * posteriores quedaban invisibles: la orden aparecía en el listado del
 * responsable pero sin botón para responder. Afectaba a 922 órdenes vivas.
 *
 * Arma el grafo en memoria y no persiste nada: no toca la base de datos, pero
 * arranca la app porque los modelos usan facades (Shield, la maquina de estados).
 */
class PurchaseOrderChainRolesTest extends TestCase
{
    /**
     * @param  array<string, int>  $puestos  rol de la cadena => id de usuario
     */
    private function orderWithChain(array $puestos): PurchaseOrder
    {
        $chain = new PurchaseRequisitionApprovalChain;
        foreach (PurchaseRequisitionApprovalChain::ROLES as $role) {
            $chain->{$role.'_id'} = $puestos[$role] ?? null;
        }

        $requisition = new PurchaseRequisition;
        $requisition->setRelation('approvalChain', $chain);

        $order = new PurchaseOrder;
        $order->setRelation('requisition', $requisition);

        return $order;
    }

    private function user(int $id): User
    {
        $user = new User;
        $user->id = $id;

        return $user;
    }

    public function test_devuelve_los_dos_roles_cuando_aprueba_y_autoriza(): void
    {
        // Caso real de las cadenas 90, 104, 113 y 115: Alan Anaya en ambos niveles.
        $order = $this->orderWithChain([
            'requester' => 10, 'reviewer' => 10, 'approver' => 341, 'authorizer' => 341,
        ]);
        $alan = $this->user(341);

        $this->assertSame(['approver', 'authorizer'], $order->chainRolesFor($alan));
        $this->assertTrue($order->isChainApprover($alan), 'debe poder aprobar');
        $this->assertTrue($order->isChainAuthorizer($alan), 'debe poder autorizar');
    }

    public function test_el_solicitante_que_ademas_aprueba_conserva_su_nivel(): void
    {
        // Caso real de las cadenas 102 y 151.
        $order = $this->orderWithChain([
            'requester' => 22, 'reviewer' => 270, 'approver' => 22, 'authorizer' => 341,
        ]);
        $ivan = $this->user(22);

        $this->assertSame(['requester', 'approver'], $order->chainRolesFor($ivan));
        $this->assertTrue($order->isChainApprover($ivan));
        $this->assertFalse($order->isChainAuthorizer($ivan));
    }

    public function test_el_revisor_que_ademas_aprueba_conserva_su_nivel(): void
    {
        // Caso real de la cadena 117.
        $order = $this->orderWithChain([
            'requester' => 338, 'reviewer' => 333, 'approver' => 333, 'authorizer' => 341,
        ]);

        $this->assertTrue($order->isChainApprover($this->user(333)));
    }

    public function test_cada_nivel_por_separado_sigue_funcionando(): void
    {
        $order = $this->orderWithChain([
            'requester' => 1, 'reviewer' => 2, 'approver' => 3, 'authorizer' => 4,
        ]);

        $this->assertSame(['approver'], $order->chainRolesFor($this->user(3)));
        $this->assertSame(['authorizer'], $order->chainRolesFor($this->user(4)));
        $this->assertTrue($order->isChainApprover($this->user(3)));
        $this->assertFalse($order->isChainApprover($this->user(4)));
        $this->assertTrue($order->isChainAuthorizer($this->user(4)));
        $this->assertFalse($order->isChainAuthorizer($this->user(3)));
    }

    public function test_quien_no_participa_no_obtiene_ningun_rol(): void
    {
        $order = $this->orderWithChain([
            'requester' => 1, 'reviewer' => 2, 'approver' => 3, 'authorizer' => 4,
        ]);
        $ajeno = $this->user(999);

        $this->assertSame([], $order->chainRolesFor($ajeno));
        $this->assertFalse($order->participatesInChain($ajeno));
        $this->assertFalse($order->isChainApprover($ajeno));
        $this->assertFalse($order->isChainAuthorizer($ajeno));
    }

    public function test_un_autorizador_nulo_no_casa_con_nadie(): void
    {
        // La Fase D vuelve authorizer_id nullable para el "N/A" que pide el correo
        // en Soldadura y Servicios Técnicos: un NULL no debe casar con ningún id.
        $order = $this->orderWithChain([
            'requester' => 1, 'reviewer' => 2, 'approver' => 3, 'authorizer' => null,
        ]);

        $this->assertSame(['approver'], $order->chainRolesFor($this->user(3)));
        $this->assertFalse($order->isChainAuthorizer($this->user(3)));
    }

    public function test_sin_cadena_no_hay_roles(): void
    {
        $order = new PurchaseOrder;
        $order->setRelation('requisition', null);

        $this->assertSame([], $order->chainRolesFor($this->user(1)));
        $this->assertFalse($order->participatesInChain($this->user(1)));
    }
}
