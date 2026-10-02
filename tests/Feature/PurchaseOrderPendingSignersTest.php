<?php

namespace Tests\Feature;

use App\Models\Management;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProvider;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use App\Services\PurchaseOrderChainResolver;
use App\Services\PurchaseOrderFlowService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Un nivel pendiente que se resuelve por rol muestra a todos los titulares
 * activos, no solo al primero.
 *
 * Cualquiera de ellos puede firmar: a todos les llega el aviso y todos ven la
 * orden en su bandeja. Antes el avance mostraba a uno solo —el primero que
 * devolvía la base— y parecía que la orden lo esperaba a él.
 *
 * La orden se arma en memoria, igual que en PurchaseOrderVacantSignerTest; los
 * titulares de los roles se ajustan dentro de una transacción que se revierte
 * al terminar.
 */
class PurchaseOrderPendingSignersTest extends TestCase
{
    use DatabaseTransactions;

    private function order(string $status, bool $roleFlow, ?User $authorizer = null): PurchaseOrder
    {
        $management = new Management;
        $management->purchase_order_flow = $roleFlow;

        $requester = new User;
        $requester->id = 1;
        $requester->setRelation('management', $management);

        $chain = new PurchaseRequisitionApprovalChain;
        $chain->authorizer_id = $authorizer?->id;
        $chain->po_flow_excluded = false;
        $chain->setRelation('requester', $requester);
        $chain->setRelation('approver', null);
        $chain->setRelation('authorizer', $authorizer);

        $requisition = new PurchaseRequisition;
        $requisition->setRelation('approvalChain', $chain);

        $order = new PurchaseOrder;
        $order->status = $status;
        // Un proveedor exento evita calcular el total de una orden que no existe.
        $order->provider_id = PurchaseOrderFlowService::PROVEEDORES_EXENTOS[0];
        $order->setRelation('provider', new PurchaseProvider);
        $order->setRelation('purchaser', null);
        $order->setRelation('requisition', $requisition);

        return $order;
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

    private function holderOf(string $role, string $name, bool $active = true): User
    {
        $user = User::forceCreate([
            'name' => $name,
            'email' => str($name)->slug('.').'@example.com',
            'puesto' => 'Prueba',
            'active' => $active,
        ]);

        $user->assignRole($role);

        return $user;
    }

    /**
     * Dos titulares activos y uno dado de baja, dados de alta en desorden.
     */
    private function holdersOf(string $role): void
    {
        $this->clearRole($role);
        $this->holderOf($role, 'Luis Prueba');
        $this->holderOf($role, 'Ana Prueba');
        $this->holderOf($role, 'Beto Baja', active: false);
    }

    public function test_el_nivel_pendiente_muestra_a_todos_los_titulares_activos(): void
    {
        $this->holdersOf(PurchaseOrderChainResolver::AUTHORIZER_ROLE);

        $step = $this->order('aprobado por gerente solicitante', roleFlow: true)->progress['authorizer-1'];

        $this->assertSame(['Ana Prueba', 'Luis Prueba'], $step['candidates']);
        $this->assertSame('Ana Prueba / Luis Prueba', $step['name']);
        $this->assertFalse($step['vacant']);
    }

    public function test_con_un_solo_titular_se_muestra_como_antes(): void
    {
        $this->clearRole(PurchaseOrderChainResolver::AUTHORIZER_ROLE);
        $this->holderOf(PurchaseOrderChainResolver::AUTHORIZER_ROLE, 'Ana Prueba');

        $step = $this->order('aprobado por gerente solicitante', roleFlow: true)->progress['authorizer-1'];

        $this->assertSame(['Ana Prueba'], $step['candidates']);
        $this->assertSame('Ana Prueba', $step['name']);
    }

    public function test_por_cadena_el_nivel_lo_firma_la_persona_de_la_cadena(): void
    {
        $this->holdersOf(PurchaseOrderChainResolver::AUTHORIZER_ROLE);

        $authorizer = new User;
        $authorizer->id = 990001;
        $authorizer->name = 'Persona de la cadena';
        $authorizer->active = 1;

        $step = $this->order('aprobado por gerente solicitante', roleFlow: false, authorizer: $authorizer)->progress['authorizer-1'];

        $this->assertSame(['Persona de la cadena'], $step['candidates']);
        $this->assertSame('Persona de la cadena', $step['name']);
    }

    public function test_los_demas_niveles_por_rol_tambien_muestran_a_todos(): void
    {
        $this->holdersOf('libera_orden_compra');

        $step = $this->order('aprobado por DG nivel 1', roleFlow: true)->progress['releaser'];

        $this->assertSame(['Ana Prueba', 'Luis Prueba'], $step['candidates']);
        $this->assertSame('Ana Prueba / Luis Prueba', $step['name']);
    }

    public function test_la_ruta_especial_muestra_a_todos_los_que_pueden_autorizar(): void
    {
        $this->holdersOf('aprueba_orden_especial');

        $step = $this->order('revision por dirección general', roleFlow: false)->progressSpecial['authorizer'];

        $this->assertSame(['Ana Prueba', 'Luis Prueba'], $step['candidates']);
        $this->assertSame('Ana Prueba / Luis Prueba', $step['name']);
    }

    public function test_un_nivel_firmado_muestra_solo_a_quien_firmo(): void
    {
        Bus::fake();

        $this->holdersOf(PurchaseOrderChainResolver::AUTHORIZER_ROLE);
        $signer = $this->holderOf(PurchaseOrderChainResolver::AUTHORIZER_ROLE, 'Firmante Prueba');

        $order = PurchaseOrder::query()->latest('id')->first();
        $order->forceFill(['status' => 'aprobado por DG nivel 1'])->saveQuietly();
        $order->recordState('status', 'aprobado por gerente solicitante', 'aprobado por DG nivel 1', [], $signer);

        $step = $order->progress['authorizer-1'];

        $this->assertSame('Firmante Prueba', $step['name']);
        $this->assertSame([], $step['candidates']);
        $this->assertNotNull($step['date']);
    }

    public function test_el_avance_en_pantalla_recibe_la_lista(): void
    {
        $this->holdersOf(PurchaseOrderChainResolver::AUTHORIZER_ROLE);

        $html = view('filament.infolists.entries.partials.progress-approval-stepper', [
            'record' => $this->order('aprobado por gerente solicitante', roleFlow: true),
        ])->render();

        $this->assertStringContainsString('"candidates":["Ana Prueba","Luis Prueba"]', $html);
    }
}
