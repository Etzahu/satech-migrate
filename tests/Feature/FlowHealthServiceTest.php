<?php

namespace Tests\Feature;

use App\Models\Management;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use App\Services\FlowHealthService;
use App\Services\PurchaseOrderChainResolver;
use App\Services\PurchaseOrderFlowService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Qué detecta la revisión diaria del flujo y qué deja fuera.
 *
 * Los pendientes se arman en memoria y se le pasan a build(); los titulares
 * de los roles se ajustan dentro de una transacción que se revierte al
 * terminar. Cada prueba parte de que todos los roles del flujo tienen a
 * alguien activo, para que lo que haya en la base no se cuele en el reporte.
 */
class FlowHealthServiceTest extends TestCase
{
    use DatabaseTransactions;

    private FlowHealthService $service;

    protected function setUp(): void
    {
        parent::setUp();

        config(['purchases.flow_alerts.idle_days' => 30]);

        $this->service = app(FlowHealthService::class);

        $this->staffAllFlowRoles();
    }

    private function staffAllFlowRoles(): void
    {
        $user = User::forceCreate([
            'name' => 'Titular de todos los roles',
            'email' => 'titular.flujo@example.com',
            'puesto' => 'Prueba',
            'active' => true,
        ]);

        $user->assignRole(array_keys(FlowHealthService::FLOW_ROLES));
    }

    /**
     * Deja el rol sin titulares; la transacción lo revierte al terminar.
     */
    private function clearRole(string $role): void
    {
        $roleId = Role::where('name', $role)->value('id');

        $this->assertNotNull($roleId, "No existe el rol {$role} en la base.");

        DB::table(config('permission.table_names.model_has_roles'))->where('role_id', $roleId)->delete();
    }

    private function person(bool $active): User
    {
        $user = new User;
        $user->id = 990001;
        $user->name = 'Persona que se fue';
        $user->active = $active ? 1 : 0;

        return $user;
    }

    private function order(string $status, bool $roleFlow = false, ?User $approver = null, ?User $purchaser = null, int $daysAgo = 0): PurchaseOrder
    {
        $management = new Management;
        $management->purchase_order_flow = $roleFlow;

        $requester = new User;
        $requester->id = 1;
        $requester->setRelation('management', $management);

        $chain = new PurchaseRequisitionApprovalChain;
        $chain->approver_id = $approver?->id;
        $chain->po_flow_excluded = false;
        $chain->setRelation('requester', $requester);
        $chain->setRelation('approver', $approver);
        $chain->setRelation('authorizer', null);

        $requisition = new PurchaseRequisition;
        $requisition->setRelation('approvalChain', $chain);

        $order = new PurchaseOrder;
        $order->id = 990001;
        $order->folio = 'PRUEBA/26';
        $order->status = $status;
        $order->provider_id = PurchaseOrderFlowService::PROVEEDORES_EXENTOS[0];
        $order->created_at = Carbon::now()->subDays($daysAgo);
        $order->setRelation('purchaser', $purchaser);
        $order->setRelation('requisition', $requisition);

        return $order;
    }

    private function requisition(string $status, ?User $reviewer = null, ?User $purchaser = null, ?int $authorizerId = null, int $orders = 0, int $daysAgo = 0): PurchaseRequisition
    {
        $chain = new PurchaseRequisitionApprovalChain;
        $chain->reviewer_id = $reviewer?->id;
        $chain->authorizer_id = $authorizerId;
        $chain->setRelation('reviewer', $reviewer);
        $chain->setRelation('authorizer', null);

        $requisition = new PurchaseRequisition;
        $requisition->id = 990001;
        $requisition->folio = 'T-PRUEBA-2026-0001';
        $requisition->status = $status;
        $requisition->orders_count = $orders;
        $requisition->created_at = Carbon::now()->subDays($daysAgo);
        $requisition->setRelation('approvalChain', $chain);
        $requisition->setRelation('purchaser', $purchaser);

        return $requisition;
    }

    public function test_con_todos_los_roles_ocupados_y_nada_detenido_el_reporte_queda_vacio(): void
    {
        $report = $this->service->build(collect(), collect());

        $this->assertSame([], $report['vacant_roles']);
        $this->assertSame([], $report['inactive']);
    }

    public function test_un_rol_sin_titular_activo_se_reporta_aunque_nada_lo_espere(): void
    {
        $this->clearRole('libera_orden_compra');

        $report = $this->service->build(collect(), collect());

        $this->assertCount(1, $report['vacant_roles']);
        $this->assertSame('libera_orden_compra', $report['vacant_roles'][0]['role']);
        $this->assertSame([], $report['vacant_roles'][0]['items']);
    }

    public function test_un_titular_dado_de_baja_no_cuenta_como_titular(): void
    {
        $this->clearRole('libera_orden_compra');

        User::forceCreate([
            'name' => 'Titular dado de baja',
            'email' => 'titular.baja@example.com',
            'puesto' => 'Prueba',
            'active' => false,
        ])->assignRole('libera_orden_compra');

        $roles = collect($this->service->build(collect(), collect())['vacant_roles'])->pluck('role');

        $this->assertContains('libera_orden_compra', $roles);
    }

    public function test_la_orden_que_espera_un_rol_vacante_se_lista_en_el_rol_sin_importar_la_antiguedad(): void
    {
        $this->clearRole(PurchaseOrderChainResolver::AUTHORIZER_ROLE);

        $order = $this->order('aprobado por gerente solicitante', roleFlow: true, daysAgo: 100);

        $report = $this->service->build(collect([$order]), collect());

        $this->assertSame(PurchaseOrderChainResolver::AUTHORIZER_ROLE, $report['vacant_roles'][0]['role']);
        $this->assertSame('PRUEBA/26', $report['vacant_roles'][0]['items'][0]['folio']);
        $this->assertGreaterThanOrEqual(100, $report['vacant_roles'][0]['items'][0]['days']);
        $this->assertSame([], $report['inactive']);
    }

    public function test_los_roles_del_flujo_por_rol_no_se_avisan_si_ninguna_gerencia_lo_usa(): void
    {
        $this->clearRole(PurchaseOrderChainResolver::AUTHORIZER_ROLE);

        Management::query()->update(['purchase_order_flow' => 0]);

        $this->assertSame([], $this->service->build(collect(), collect())['vacant_roles']);
    }

    public function test_la_orden_que_espera_a_una_cuenta_inactiva_de_la_cadena_se_reporta(): void
    {
        $order = $this->order('aprobado por gerente de compras', approver: $this->person(active: false));

        $report = $this->service->build(collect([$order]), collect());

        $this->assertSame('Persona que se fue', $report['inactive'][0]['name']);
        $this->assertSame(990001, $report['inactive'][0]['user_id']);
        $this->assertSame('Aprueba', $report['inactive'][0]['items'][0]['level']);
    }

    public function test_un_responsable_activo_no_se_reporta(): void
    {
        $order = $this->order('aprobado por gerente de compras', approver: $this->person(active: true));

        $this->assertSame([], $this->service->build(collect([$order]), collect())['inactive']);
    }

    public function test_lo_que_lleva_mas_de_los_dias_de_abandono_ya_no_se_avisa(): void
    {
        $order = $this->order('aprobado por gerente de compras', approver: $this->person(active: false), daysAgo: 40);

        $this->assertSame([], $this->service->build(collect([$order]), collect())['inactive']);
    }

    public function test_la_cadena_que_no_nombra_a_nadie_se_reporta_sin_cuenta(): void
    {
        $order = $this->order('aprobado por gerente de compras', approver: null);

        $report = $this->service->build(collect([$order]), collect());

        $this->assertSame('Sin responsable asignado', $report['inactive'][0]['name']);
        $this->assertNull($report['inactive'][0]['user_id']);
    }

    public function test_la_orden_de_un_comprador_inactivo_se_reporta(): void
    {
        $order = $this->order('borrador', purchaser: $this->person(active: false));

        $report = $this->service->build(collect([$order]), collect());

        $this->assertSame('Comprador', $report['inactive'][0]['items'][0]['level']);
    }

    public function test_la_requisicion_que_espera_a_un_revisor_inactivo_se_reporta(): void
    {
        $requisition = $this->requisition('revisión', reviewer: $this->person(active: false));

        $report = $this->service->build(collect(), collect([$requisition]));

        $this->assertSame('Requisición', $report['inactive'][0]['items'][0]['type']);
        $this->assertSame('Revisa', $report['inactive'][0]['items'][0]['level']);
    }

    public function test_la_requisicion_asignada_a_un_comprador_inactivo_solo_se_reporta_sin_ordenes(): void
    {
        $sinOrdenes = $this->requisition('comprador asignado', purchaser: $this->person(active: false));
        $conOrdenes = $this->requisition('comprador asignado', purchaser: $this->person(active: false), orders: 1);

        $this->assertCount(1, $this->service->build(collect(), collect([$sinOrdenes]))['inactive']);
        $this->assertSame([], $this->service->build(collect(), collect([$conOrdenes]))['inactive']);
    }

    public function test_la_requisicion_sin_autorizador_en_la_cadena_no_espera_a_nadie(): void
    {
        $requisition = $this->requisition('aprobado por gerencia', authorizerId: null);

        $report = $this->service->build(collect(), collect([$requisition]));

        $this->assertSame([], $report['inactive']);
    }
}
