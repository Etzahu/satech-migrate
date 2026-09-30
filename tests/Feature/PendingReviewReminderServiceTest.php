<?php

namespace Tests\Feature;

use App\Models\Management;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use App\Services\PendingReviewReminderService;
use App\Services\PurchaseOrderFlowService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * A quién le llega el recordatorio de pendientes y con qué.
 *
 * Los pendientes se arman en memoria y se le pasan a build(). Las personas de
 * la cadena también viven en memoria; los titulares de un rol se crean dentro
 * de una transacción que se revierte al terminar, después de vaciar el rol
 * para que los titulares reales no se cuelen en la prueba.
 */
class PendingReviewReminderServiceTest extends TestCase
{
    use DatabaseTransactions;

    private PendingReviewReminderService $service;

    protected function setUp(): void
    {
        parent::setUp();

        config(['purchases.reminders.min_days' => 1]);

        $this->service = app(PendingReviewReminderService::class);
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

    private function roleHolder(string $role, string $email, bool $active = true): User
    {
        $user = User::forceCreate([
            'name' => "Titular {$email}",
            'email' => $email,
            'puesto' => 'Prueba',
            'active' => $active,
        ]);

        $user->assignRole($role);

        return $user;
    }

    private function person(int $id, string $name, ?string $email = 'persona.cadena@example.com', bool $active = true): User
    {
        $user = new User;
        $user->id = $id;
        $user->name = $name;
        $user->email = $email;
        $user->active = $active ? 1 : 0;

        return $user;
    }

    private function order(string $status, ?User $approver = null, ?User $purchaser = null, int $daysAgo = 5, int $id = 990001): PurchaseOrder
    {
        $management = new Management;
        $management->purchase_order_flow = false;

        $requester = new User;
        $requester->id = 1;
        $requester->name = 'Solicitante de prueba';
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
        $order->id = $id;
        $order->folio = "PRUEBA-{$id}/26";
        $order->status = $status;
        $order->provider_id = PurchaseOrderFlowService::PROVEEDORES_EXENTOS[0];
        $order->created_at = Carbon::now()->subDays($daysAgo);
        $order->setRelation('purchaser', $purchaser);
        $order->setRelation('requisition', $requisition);

        return $order;
    }

    private function requisition(string $status, ?User $reviewer = null, ?User $purchaser = null, int $daysAgo = 5, int $id = 990001): PurchaseRequisition
    {
        $chain = new PurchaseRequisitionApprovalChain;
        $chain->reviewer_id = $reviewer?->id;
        $chain->authorizer_id = null;
        $chain->setRelation('requester', null);
        $chain->setRelation('reviewer', $reviewer);
        $chain->setRelation('authorizer', null);

        $requisition = new PurchaseRequisition;
        $requisition->id = $id;
        $requisition->folio = "T-PRUEBA-2026-{$id}";
        $requisition->status = $status;
        $requisition->orders_count = 0;
        $requisition->created_at = Carbon::now()->subDays($daysAgo);
        $requisition->setRelation('approvalChain', $chain);
        $requisition->setRelation('purchaser', $purchaser);

        return $requisition;
    }

    public function test_sin_pendientes_no_hay_recordatorios(): void
    {
        $result = $this->service->build(collect(), collect());

        $this->assertSame([], $result['reminders']);
        $this->assertSame([], $result['unattended']);
    }

    public function test_la_persona_de_la_cadena_recibe_lo_que_espera_su_aprobacion(): void
    {
        $approver = $this->person(990011, 'Aprobador de prueba', 'aprobador@example.com');

        $result = $this->service->build(collect([$this->order('aprobado por gerente de compras', approver: $approver)]), collect());

        $this->assertCount(1, $result['reminders']);
        $this->assertSame($approver, $result['reminders'][0]['user']);

        $item = $result['reminders'][0]['items'][0];

        $this->assertSame('Orden', $item['type']);
        $this->assertSame('PRUEBA-990001/26', $item['folio']);
        $this->assertSame('Aprobar', $item['action']);
        $this->assertSame('Solicitante de prueba', $item['requester']);
        $this->assertGreaterThanOrEqual(5, $item['days']);
        $this->assertStringEndsWith('/compras/ordenes/revisar/990001/ver', $item['url']);
    }

    public function test_cada_titular_activo_del_rol_recibe_su_recordatorio(): void
    {
        $this->clearRole('libera_orden_compra');

        $this->roleHolder('libera_orden_compra', 'libera.uno@example.com');
        $this->roleHolder('libera_orden_compra', 'libera.dos@example.com');
        $this->roleHolder('libera_orden_compra', 'libera.baja@example.com', active: false);

        $result = $this->service->build(collect([$this->order('aprobado por DG nivel 1')]), collect());

        $emails = collect($result['reminders'])->pluck('user.email')->sort()->values()->all();

        $this->assertSame(['libera.dos@example.com', 'libera.uno@example.com'], $emails);
        $this->assertSame('Liberar', $result['reminders'][0]['items'][0]['action']);
        $this->assertSame([], $result['unattended']);
    }

    public function test_una_persona_recibe_un_solo_recordatorio_con_todo_lo_suyo_del_mas_antiguo_al_mas_reciente(): void
    {
        $person = $this->person(990011, 'Revisa y aprueba', 'revisa.aprueba@example.com');

        $result = $this->service->build(
            collect([
                $this->order('aprobado por gerente de compras', approver: $person, daysAgo: 3, id: 990001),
                $this->order('aprobado por gerente de compras', approver: $person, daysAgo: 20, id: 990002),
            ]),
            collect([$this->requisition('revisión', reviewer: $person, daysAgo: 8)]),
        );

        $this->assertCount(1, $result['reminders']);
        $this->assertSame(
            ['PRUEBA-990002/26', 'T-PRUEBA-2026-990001', 'PRUEBA-990001/26'],
            collect($result['reminders'][0]['items'])->pluck('folio')->all()
        );
        $this->assertSame('Revisar', $result['reminders'][0]['items'][1]['action']);
        $this->assertStringEndsWith('/compras/requisiciones-revisar/990001', $result['reminders'][0]['items'][1]['url']);
    }

    public function test_lo_que_acaba_de_llegar_al_nivel_no_se_recuerda(): void
    {
        $approver = $this->person(990011, 'Aprobador de prueba');
        $order = $this->order('aprobado por gerente de compras', approver: $approver, daysAgo: 0);

        $result = $this->service->build(collect([$order]), collect());

        $this->assertSame([], $result['reminders']);
        $this->assertSame([], $result['unattended']);
    }

    public function test_con_cero_dias_minimos_se_recuerda_tambien_lo_de_hoy(): void
    {
        config(['purchases.reminders.min_days' => 0]);

        $approver = $this->person(990011, 'Aprobador de prueba');
        $order = $this->order('aprobado por gerente de compras', approver: $approver, daysAgo: 0);

        $this->assertCount(1, $this->service->build(collect([$order]), collect())['reminders']);
    }

    public function test_lo_que_esta_en_cancha_del_comprador_no_se_recuerda(): void
    {
        $purchaser = $this->person(990011, 'Comprador de prueba');

        $result = $this->service->build(
            collect([
                $this->order('borrador', purchaser: $purchaser),
                $this->order('devuelto por gerente de compras', purchaser: $purchaser, id: 990002),
            ]),
            collect([$this->requisition('comprador asignado', purchaser: $purchaser)]),
        );

        $this->assertSame([], $result['reminders']);
        $this->assertSame([], $result['unattended']);
    }

    public function test_lo_que_espera_a_una_cuenta_inactiva_queda_sin_atender(): void
    {
        $approver = $this->person(990011, 'Persona que se fue', active: false);

        $result = $this->service->build(collect([$this->order('aprobado por gerente de compras', approver: $approver)]), collect());

        $this->assertSame([], $result['reminders']);
        $this->assertSame(['PRUEBA-990001/26'], collect($result['unattended'])->pluck('folio')->all());
    }

    public function test_lo_que_espera_a_un_rol_sin_titular_activo_queda_sin_atender(): void
    {
        $this->clearRole('libera_orden_compra');
        $this->roleHolder('libera_orden_compra', 'libera.baja@example.com', active: false);

        $result = $this->service->build(collect([$this->order('aprobado por DG nivel 1')]), collect());

        $this->assertSame([], $result['reminders']);
        $this->assertCount(1, $result['unattended']);
    }

    public function test_quien_no_tiene_correo_no_recibe_recordatorio(): void
    {
        $approver = $this->person(990011, 'Aprobador sin correo', email: null);

        $result = $this->service->build(collect([$this->order('aprobado por gerente de compras', approver: $approver)]), collect());

        $this->assertSame([], $result['reminders']);
        $this->assertCount(1, $result['unattended']);
    }

    public function test_la_requisicion_sin_autorizador_en_la_cadena_no_espera_a_nadie(): void
    {
        $result = $this->service->build(collect(), collect([$this->requisition('aprobado por gerencia')]));

        $this->assertSame([], $result['reminders']);
        $this->assertSame([], $result['unattended']);
    }

    public function test_cada_nivel_lleva_a_una_bandeja_que_existe(): void
    {
        $levels = [...PendingReviewReminderService::ORDER_LEVELS, ...PendingReviewReminderService::REQUISITION_LEVELS];

        foreach ($levels as $status => $level) {
            $this->assertTrue(Route::has($level['route']), "La bandeja de «{$status}» no existe: {$level['route']}");
        }
    }
}
