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
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Un nivel pendiente que nadie activo puede firmar se marca como "Sin titular
 * activo" en el avance de la orden, en vez de quedar en blanco o como "N/A".
 *
 * Pasó con G363/26: el único titular de `autoriza_orden_compra` dejó la
 * empresa y el nivel se veía como "N/A", igual que un nivel que no existe.
 *
 * La orden se arma en memoria; los titulares de los roles se ajustan dentro de
 * una transacción que se revierte al terminar.
 */
class PurchaseOrderVacantSignerTest extends TestCase
{
    use DatabaseTransactions;

    private function order(string $status, bool $roleFlow, ?User $approver = null, ?User $authorizer = null): PurchaseOrder
    {
        $management = new Management;
        $management->purchase_order_flow = $roleFlow;

        $requester = new User;
        $requester->id = 1;
        $requester->setRelation('management', $management);

        $chain = new PurchaseRequisitionApprovalChain;
        $chain->approver_id = $approver?->id;
        $chain->authorizer_id = $authorizer?->id;
        $chain->po_flow_excluded = false;
        $chain->setRelation('requester', $requester);
        $chain->setRelation('approver', $approver);
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

    private function chainUser(bool $active): User
    {
        $user = new User;
        $user->id = 990001;
        $user->name = 'Persona de la cadena';
        $user->active = $active ? 1 : 0;

        return $user;
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

    private function holderOf(string $role, bool $active): User
    {
        $user = User::forceCreate([
            'name' => $active ? 'Titular activo' : 'Titular dado de baja',
            'email' => ($active ? 'titular.activo' : 'titular.baja').'@example.com',
            'puesto' => 'Prueba',
            'active' => $active,
        ]);

        $user->assignRole($role);

        return $user;
    }

    public function test_la_autorizacion_sin_titular_activo_se_marca_como_vacante(): void
    {
        $this->clearRole(PurchaseOrderChainResolver::AUTHORIZER_ROLE);

        $step = $this->order('aprobado por gerente solicitante', roleFlow: true)->progress['authorizer-1'];

        $this->assertTrue($step['vacant']);
        $this->assertSame(PurchaseOrder::VACANT_SIGNER, $step['name']);
    }

    public function test_un_titular_dado_de_baja_no_ocupa_el_nivel(): void
    {
        $this->clearRole(PurchaseOrderChainResolver::AUTHORIZER_ROLE);
        $this->holderOf(PurchaseOrderChainResolver::AUTHORIZER_ROLE, active: false);

        $step = $this->order('aprobado por gerente solicitante', roleFlow: true)->progress['authorizer-1'];

        $this->assertTrue($step['vacant']);
        $this->assertSame(PurchaseOrder::VACANT_SIGNER, $step['name']);
    }

    public function test_un_titular_activo_aparece_en_el_nivel_pendiente(): void
    {
        $this->clearRole(PurchaseOrderChainResolver::AUTHORIZER_ROLE);
        $this->holderOf(PurchaseOrderChainResolver::AUTHORIZER_ROLE, active: true);

        $step = $this->order('aprobado por gerente solicitante', roleFlow: true)->progress['authorizer-1'];

        $this->assertFalse($step['vacant']);
        $this->assertSame('Titular activo', $step['name']);
    }

    public function test_un_aprobador_de_cadena_dado_de_baja_deja_el_nivel_vacante(): void
    {
        $order = $this->order('aprobado por gerente de compras', roleFlow: false, approver: $this->chainUser(active: false));

        $step = $order->progress['approver'];

        $this->assertTrue($step['vacant']);
        $this->assertSame(PurchaseOrder::VACANT_SIGNER, $step['name']);
    }

    public function test_un_aprobador_de_cadena_activo_aparece_en_el_nivel_pendiente(): void
    {
        $order = $this->order('aprobado por gerente de compras', roleFlow: false, approver: $this->chainUser(active: true));

        $step = $order->progress['approver'];

        $this->assertFalse($step['vacant']);
        $this->assertSame('Persona de la cadena', $step['name']);
    }

    public function test_la_ruta_especial_marca_al_autorizador_vacante(): void
    {
        $this->clearRole('aprueba_orden_especial');

        $step = $this->order('revision por dirección general', roleFlow: false)->progressSpecial['authorizer'];

        $this->assertTrue($step['vacant']);
        $this->assertSame(PurchaseOrder::VACANT_SIGNER, $step['name']);
    }

    public function test_una_orden_cancelada_no_marca_niveles_vacantes(): void
    {
        $this->clearRole(PurchaseOrderChainResolver::AUTHORIZER_ROLE);

        $step = $this->order('cancelado por DG nivel 1', roleFlow: true)->progress['authorizer-1'];

        $this->assertFalse($step['vacant']);
        $this->assertNotSame(PurchaseOrder::VACANT_SIGNER, $step['name']);
    }

    public function test_una_orden_autorizada_no_marca_niveles_vacantes(): void
    {
        $this->clearRole(PurchaseOrderChainResolver::AUTHORIZER_ROLE);

        $step = $this->order('autorizada para proveedor', roleFlow: true)->progress['authorizer-1'];

        $this->assertFalse($step['vacant']);
    }

    public function test_el_avance_en_pantalla_pinta_el_nivel_vacante(): void
    {
        $this->clearRole(PurchaseOrderChainResolver::AUTHORIZER_ROLE);

        $html = view('filament.infolists.entries.partials.progress-approval-stepper', [
            'record' => $this->order('aprobado por gerente solicitante', roleFlow: true),
        ])->render();

        $this->assertStringContainsString('"name":"Sin titular activo"', $html);
        $this->assertStringContainsString('"vacant":true', $html);
    }
}
