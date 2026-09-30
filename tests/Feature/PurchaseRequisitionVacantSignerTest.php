<?php

namespace Tests\Feature;

use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * En el avance de la requisición, un nivel pendiente cuya persona de la cadena
 * ya no está activa se marca como "Sin titular activo", igual que en la orden.
 * El "N/A" del autorizador se queda: ahí significa que el nivel no existe.
 *
 * La requisición se arma en memoria; el rol de almacén se ajusta dentro de una
 * transacción que se revierte al terminar.
 */
class PurchaseRequisitionVacantSignerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // El avance se arma según la compañía de la sesión.
        session(['company_id' => 1]);
    }

    private function user(int $id, string $name, bool $active = true): User
    {
        $user = new User;
        $user->id = $id;
        $user->name = $name;
        $user->active = $active ? 1 : 0;

        return $user;
    }

    private function requisition(string $status, ?User $reviewer = null, ?User $authorizer = null): PurchaseRequisition
    {
        $reviewer ??= $this->user(2, 'Revisor');

        $chain = new PurchaseRequisitionApprovalChain;
        $chain->requester_id = 1;
        $chain->reviewer_id = $reviewer->id;
        $chain->approver_id = 3;
        $chain->authorizer_id = $authorizer?->id;
        $chain->setRelation('requester', $this->user(1, 'Solicitante'));
        $chain->setRelation('reviewer', $reviewer);
        $chain->setRelation('approver', $this->user(3, 'Aprobador'));
        $chain->setRelation('authorizer', $authorizer);

        $requisition = new PurchaseRequisition;
        $requisition->status = $status;
        $requisition->setRelation('approvalChain', $chain);
        $requisition->setRelation('purchaser', null);

        return $requisition;
    }

    public function test_un_revisor_dado_de_baja_deja_su_nivel_vacante(): void
    {
        $step = $this->requisition('revisión', reviewer: $this->user(2, 'Revisor que se fue', active: false))->progress['reviewer'];

        $this->assertTrue($step['vacant']);
        $this->assertSame(PurchaseOrder::VACANT_SIGNER, $step['name']);
    }

    public function test_un_revisor_activo_aparece_en_su_nivel(): void
    {
        $step = $this->requisition('revisión')->progress['reviewer'];

        $this->assertArrayNotHasKey('vacant', $step);
        $this->assertSame('Revisor', $step['name']);
    }

    public function test_un_autorizador_dado_de_baja_deja_su_nivel_vacante(): void
    {
        $step = $this->requisition('aprobado por gerencia', authorizer: $this->user(4, 'Autorizador que se fue', active: false))->progress['authorizer'];

        $this->assertTrue($step['vacant']);
        $this->assertSame(PurchaseOrder::VACANT_SIGNER, $step['name']);
    }

    public function test_sin_autorizador_en_la_cadena_el_nivel_sigue_como_no_aplica(): void
    {
        $step = $this->requisition('aprobado por gerencia', authorizer: null)->progress['authorizer'];

        $this->assertArrayNotHasKey('vacant', $step);
        $this->assertSame('N/A', $step['name']);
    }

    public function test_almacen_sin_titular_activo_queda_vacante(): void
    {
        $roleId = Role::where('name', 'revisa_almacen_requisicion_compra')->value('id');

        $this->assertNotNull($roleId, 'No existe el rol de almacén en la base.');

        DB::table(config('permission.table_names.model_has_roles'))->where('role_id', $roleId)->delete();

        $step = $this->requisition('revisión por almacén')->progress['warehouse'];

        $this->assertTrue($step['vacant']);
        $this->assertSame(PurchaseOrder::VACANT_SIGNER, $step['name']);
    }

    public function test_una_requisicion_cancelada_no_marca_niveles_vacantes(): void
    {
        $step = $this->requisition('cancelado por revisor', reviewer: $this->user(2, 'Revisor que se fue', active: false))->progress['reviewer'];

        $this->assertArrayNotHasKey('vacant', $step);
        $this->assertSame('Revisor que se fue', $step['name']);
    }
}
