<?php

namespace Tests\Feature;

use App\Enums\ReviewLevel;
use App\Filament\Purchases\Actions\RespondInBulkAction;
use App\Filament\Purchases\Resources\PurchaseOrder\AdminResource\Pages\ListPurchaseOrders as AdminOrders;
use App\Filament\Purchases\Resources\PurchaseOrder\ApproveResource\Pages\ListPurchaseOrders as AuthorizationOrders;
use App\Filament\Purchases\Resources\PurchaseOrder\ApproveSpecialResource\Pages\ListPurchaseOrders as SpecialRouteOrders;
use App\Filament\Purchases\Resources\PurchaseOrder\AuthorizeResource\Pages\ListPurchaseOrders as AmountOrders;
use App\Filament\Purchases\Resources\PurchaseOrder\ReleaseResource\Pages\ListPurchaseOrders as ReleaseOrders;
use App\Filament\Purchases\Resources\PurchaseOrder\ReviewResource\Pages\ListPurchaseOrders as ApprovalOrders;
use App\Filament\Purchases\Resources\PurchaseRequisition\ApproverResource\Pages\ManagePRApprovals;
use App\Filament\Purchases\Resources\PurchaseRequisition\AuthorizerResource\Pages\ManagePRApprovalDGS;
use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerResource\Pages\ManagePRReviews;
use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource\Pages\ManagePRReviewWareHouses;
use App\Mail\PurchaseOrder\Notification;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Models\User;
use App\Services\PurchaseOrderChainResolver;
use App\Services\PurchaseOrderFlowService;
use Closure;
use Filament\Facades\Filament;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use RuntimeException;
use Tests\TestCase;

/**
 * Responder en lote desde la tabla de cada bandeja.
 *
 * Solo la ve quien puede responder el nivel y además es super_admin, y cada
 * registro seleccionado pasa por lo mismo que al responderlo desde su vista.
 *
 * Corre contra la base real dentro de una transacción: los registros se ponen
 * en el estado del nivel sin disparar eventos y todo se revierte al terminar.
 * Bus::fake() evita que el observer de la orden exporte a las hojas de Google
 * reales, y Mail::fake() que salgan correos.
 */
class RespondInBulkActionTest extends TestCase
{
    use DatabaseTransactions;

    private const ACTION = 'responder_seleccionadas';

    protected function setUp(): void
    {
        parent::setUp();

        Bus::fake();
        Mail::fake();

        Filament::setCurrentPanel('compras');
    }

    private function userWithRoles(string ...$roles): User
    {
        $user = User::forceCreate([
            'name' => 'Prueba respuesta en lote',
            'email' => 'prueba.lote.'.md5(implode(',', $roles)).'@gptservices.com',
            'puesto' => 'Prueba',
            'active' => true,
        ]);

        $user->assignRole($roles);

        return $user;
    }

    private function actingAsRoles(string ...$roles): User
    {
        $user = $this->userWithRoles(...$roles);

        $this->actingAs($user);

        return $user;
    }

    /**
     * Órdenes reales de una misma empresa, con comprador activo, puestas en el
     * estado indicado.
     *
     * @param  Closure(Builder): mixed|null  $scope
     * @return Collection<int, PurchaseOrder>
     */
    private function ordersIn(string $status, int $count = 2, ?Closure $scope = null): Collection
    {
        $query = PurchaseOrder::query()
            ->whereHas('purchaser', fn (Builder $purchaser) => $purchaser->where('active', 1)->whereNotNull('email'))
            ->latest('id');

        if ($scope) {
            $scope($query);
        }

        $companyId = (clone $query)->value('company_id');

        $this->assertNotNull($companyId, 'No hay órdenes con comprador activo para probar.');

        $orders = $query->where('company_id', $companyId)->take($count)->get();

        $this->assertCount($count, $orders, 'No hay suficientes órdenes de una misma empresa para probar.');

        session(['company_id' => $companyId]);

        return $orders->each(fn (PurchaseOrder $order) => $order->forceFill(['status' => $status])->saveQuietly());
    }

    /**
     * Requisiciones reales de una misma empresa, puestas en el estado
     * indicado y en la cadena indicada.
     *
     * @return Collection<int, PurchaseRequisition>
     */
    private function requisitionsIn(string $status, PurchaseRequisitionApprovalChain $chain, int $count = 2): Collection
    {
        $companyId = PurchaseRequisition::query()->latest('id')->value('company_id');

        $requisitions = PurchaseRequisition::query()
            ->where('company_id', $companyId)
            ->latest('id')
            ->take($count)
            ->get();

        $this->assertCount($count, $requisitions, 'No hay suficientes requisiciones de una misma empresa para probar.');

        session(['company_id' => $companyId]);

        return $requisitions->each(fn (PurchaseRequisition $requisition) => $requisition
            ->forceFill(['status' => $status, 'approval_chain_id' => $chain->id])
            ->saveQuietly());
    }

    private function roleFlow(): Closure
    {
        return fn (Builder $query) => app(PurchaseOrderChainResolver::class)->whereInRoleFlow($query);
    }

    // ── Quién la ve ─────────────────────────────────────────────────────────

    /**
     * Cada bandeja, con los roles que la abren y responden su nivel.
     *
     * @return array<string, array{class-string, array<int, string>}>
     */
    public static function trays(): array
    {
        return [
            'órdenes · revisa (gerente de compras)' => [AdminOrders::class, ['gerente_compras']],
            'órdenes · aprueba' => [ApprovalOrders::class, [PurchaseOrderChainResolver::APPROVER_ROLE]],
            'órdenes · autoriza' => [AuthorizationOrders::class, [PurchaseOrderChainResolver::AUTHORIZER_ROLE]],
            'órdenes · libera' => [ReleaseOrders::class, ['libera_orden_compra']],
            'órdenes · autoriza por monto' => [AmountOrders::class, ['autoriza_nivel-2-orden_compra']],
            // La bandeja la abre un rol y el botón de la vista pide otro.
            'órdenes · ruta especial' => [SpecialRouteOrders::class, ['aprueba_orden_especial', 'autoriza_nivel-1-orden_compra']],
            'requisiciones · almacén' => [ManagePRReviewWareHouses::class, ['revisa_almacen_requisicion_compra']],
            'requisiciones · revisa' => [ManagePRReviews::class, ['revisa_requisicion_compra']],
            'requisiciones · aprueba' => [ManagePRApprovals::class, ['aprueba_requisicion_compra']],
            'requisiciones · autoriza' => [ManagePRApprovalDGS::class, ['autoriza_requisicion_compra']],
        ];
    }

    /**
     * @param  class-string  $page
     * @param  array<int, string>  $roles
     */
    #[DataProvider('trays')]
    public function test_cada_bandeja_ofrece_la_accion_al_super_admin_que_responde_su_nivel(string $page, array $roles): void
    {
        $this->actingAsRoles('super_admin', ...$roles);
        session(['company_id' => PurchaseOrder::query()->latest('id')->value('company_id')]);

        Livewire::test($page)
            ->assertSuccessful()
            ->assertTableBulkActionVisible(self::ACTION);
    }

    public function test_la_ve_quien_puede_responder_el_nivel_y_es_super_admin(): void
    {
        $this->actingAsRoles('super_admin', PurchaseOrderChainResolver::AUTHORIZER_ROLE);
        $this->ordersIn('aprobado por gerente solicitante', scope: $this->roleFlow());

        Livewire::test(AuthorizationOrders::class)
            ->assertTableBulkActionVisible(self::ACTION);
    }

    public function test_no_la_ve_quien_puede_responder_el_nivel_sin_ser_super_admin(): void
    {
        $this->actingAsRoles(PurchaseOrderChainResolver::AUTHORIZER_ROLE);
        $this->ordersIn('aprobado por gerente solicitante', scope: $this->roleFlow());

        Livewire::test(AuthorizationOrders::class)
            ->assertTableBulkActionHidden(self::ACTION);
    }

    public function test_no_la_ve_un_super_admin_que_no_responde_el_nivel(): void
    {
        // super_admin tiene todos los permisos, así que entra a la bandeja,
        // pero no tiene el rol que responde las revisiones.
        $this->actingAsRoles('super_admin');
        session(['company_id' => PurchaseRequisition::query()->latest('id')->value('company_id')]);

        Livewire::test(ManagePRReviews::class)
            ->assertTableBulkActionHidden(self::ACTION);
    }

    public function test_hacen_falta_las_dos_condiciones(): void
    {
        $action = RespondInBulkAction::make()->level(ReviewLevel::OrderRelease);

        $this->assertTrue($action->isAllowedFor($this->userWithRoles('super_admin', 'libera_orden_compra')));
        $this->assertFalse($action->isAllowedFor($this->userWithRoles('libera_orden_compra')));
        $this->assertFalse($action->isAllowedFor($this->userWithRoles('super_admin')));
        $this->assertFalse($action->isAllowedFor(null));
    }

    // ── Órdenes ─────────────────────────────────────────────────────────────

    public function test_autoriza_varias_ordenes_en_lote(): void
    {
        $this->actingAsRoles('super_admin', PurchaseOrderChainResolver::AUTHORIZER_ROLE);
        $orders = $this->ordersIn('aprobado por gerente solicitante', scope: $this->roleFlow());

        Livewire::test(AuthorizationOrders::class)
            ->callTableBulkAction(self::ACTION, $orders, data: ['response' => 'aprobado por DG nivel 1'])
            ->assertHasNoTableBulkActionErrors()
            ->assertNotified('Respuesta enviada a las 2 seleccionadas');

        foreach ($orders as $order) {
            $this->assertSame('aprobado por DG nivel 1', $order->fresh()->status);
        }
    }

    public function test_devolver_o_cancelar_exige_observacion(): void
    {
        $this->actingAsRoles('super_admin', 'libera_orden_compra');
        $orders = $this->ordersIn('aprobado por DG nivel 1');

        Livewire::test(ReleaseOrders::class)
            ->callTableBulkAction(self::ACTION, $orders, data: ['response' => 'devuelto por liberación', 'observation' => ''])
            ->assertHasTableBulkActionErrors(['observation' => 'required_unless']);

        foreach ($orders as $order) {
            $this->assertSame('aprobado por DG nivel 1', $order->fresh()->status);
        }

        Mail::assertNothingSent();
    }

    public function test_devuelve_cada_orden_con_la_misma_observacion_y_su_correo(): void
    {
        $this->actingAsRoles('super_admin', 'libera_orden_compra');
        $orders = $this->ordersIn('aprobado por DG nivel 1');

        Livewire::test(ReleaseOrders::class)
            ->callTableBulkAction(self::ACTION, $orders, data: ['response' => 'devuelto por liberación', 'observation' => 'Falta la cotización.'])
            ->assertHasNoTableBulkActionErrors();

        foreach ($orders as $order) {
            $order->refresh();

            $this->assertSame('devuelto por liberación', $order->status);
            $this->assertSame('Falta la cotización.', $order->status()->history()->latest('id')->first()->getCustomProperty('respuesta'));
        }

        Mail::assertSent(Notification::class, 2);
    }

    public function test_liberar_en_lote_cierra_las_que_no_superan_el_limite(): void
    {
        $this->actingAsRoles('super_admin', 'libera_orden_compra');
        $orders = $this->ordersIn('aprobado por DG nivel 1');

        Livewire::test(ReleaseOrders::class)
            ->callTableBulkAction(self::ACTION, $orders, data: ['response' => 'liberado por dirección administrativa'])
            ->assertHasNoTableBulkActionErrors();

        $flow = new PurchaseOrderFlowService;

        foreach ($orders as $order) {
            $order->refresh();

            $this->assertSame(
                $flow->requiresAmountApproval($order) ? 'liberado por dirección administrativa' : 'autorizada para proveedor',
                $order->status,
            );
        }
    }

    public function test_la_aprobacion_por_monto_deja_traza_y_manda_la_orden_al_proveedor(): void
    {
        $this->actingAsRoles('super_admin', 'autoriza_nivel-2-orden_compra');
        $orders = $this->ordersIn('liberado por dirección administrativa');

        Livewire::test(AmountOrders::class)
            ->callTableBulkAction(self::ACTION, $orders, data: ['response' => 'aprobado por DG nivel 2'])
            ->assertHasNoTableBulkActionErrors();

        foreach ($orders as $order) {
            $order->refresh();

            $this->assertSame('autorizada para proveedor', $order->status);
            $this->assertTrue($order->status()->history()->where('to', 'aprobado por DG nivel 2')->exists());
        }
    }

    public function test_solo_se_responde_lo_que_espera_en_el_nivel(): void
    {
        // La pestaña "Todas" del gerente de compras mezcla estados.
        $this->actingAsRoles('super_admin', 'gerente_compras');
        [$awaiting, $elsewhere] = $this->ordersIn('revisión gerente de compras')->all();
        $elsewhere->forceFill(['status' => 'aprobado por DG nivel 1'])->saveQuietly();

        Livewire::test(AdminOrders::class)
            ->callTableBulkAction(self::ACTION, [$awaiting, $elsewhere], data: ['response' => 'aprobado por gerente de compras'])
            ->assertHasNoTableBulkActionErrors()
            ->assertNotified('Respuesta enviada');

        $this->assertSame('aprobado por gerente de compras', $awaiting->fresh()->status);
        $this->assertSame('aprobado por DG nivel 1', $elsewhere->fresh()->status);
    }

    public function test_una_orden_que_falla_no_detiene_a_las_demas(): void
    {
        $this->actingAsRoles('super_admin', 'gerente_compras');
        [$failing, $healthy] = $this->ordersIn('revisión gerente de compras')->all();

        // Truena después de guardar la respuesta, como cuando el correo falla.
        PurchaseOrder::updated(function (PurchaseOrder $order) use ($failing) {
            if ($order->is($failing)) {
                throw new RuntimeException('El servidor de correo no responde.');
            }
        });

        Livewire::test(AdminOrders::class)
            ->callTableBulkAction(self::ACTION, [$failing, $healthy], data: ['response' => 'devuelto por gerente de compras', 'observation' => 'Revisar precios.'])
            ->assertHasNoTableBulkActionErrors()
            ->assertNotified(FilamentNotification::make()
                ->title('Respuesta enviada a 1 de 2 seleccionadas')
                ->body("Con error: {$failing->folio}. Revisa su historial antes de volver a intentarlo.")
                ->warning()
                ->persistent());

        $this->assertSame('devuelto por gerente de compras', $healthy->fresh()->status);
    }

    // ── Requisiciones ───────────────────────────────────────────────────────

    public function test_la_gerencia_aprueba_en_lote_y_sin_autorizador_avanzan_solas(): void
    {
        $user = $this->actingAsRoles('super_admin', 'aprueba_requisicion_compra');

        $chain = PurchaseRequisitionApprovalChain::query()->whereNull('authorizer_id')->first();
        $this->assertNotNull($chain, 'No hay cadenas sin autorizador para probar.');
        $chain->forceFill(['approver_id' => $user->id])->saveQuietly();

        $requisitions = $this->requisitionsIn('aprobado por revisor', $chain);

        Livewire::test(ManagePRApprovals::class)
            ->callTableBulkAction(self::ACTION, $requisitions, data: ['response' => 'aprobado por gerencia'])
            ->assertHasNoTableBulkActionErrors();

        foreach ($requisitions as $requisition) {
            $requisition->refresh();

            $this->assertSame('aprobado por DG', $requisition->status);
            $this->assertTrue($requisition->status()->history()->where('to', 'aprobado por gerencia')->exists());
        }
    }

    public function test_el_revisor_cancela_requisiciones_en_lote(): void
    {
        $user = $this->actingAsRoles('super_admin', 'revisa_requisicion_compra');

        $chain = PurchaseRequisitionApprovalChain::query()->first();
        $chain->forceFill(['reviewer_id' => $user->id])->saveQuietly();

        $requisitions = $this->requisitionsIn('revisión', $chain);

        Livewire::test(ManagePRReviews::class)
            ->callTableBulkAction(self::ACTION, $requisitions, data: ['response' => 'cancelado por revisor', 'observation' => 'Proyecto suspendido.'])
            ->assertHasNoTableBulkActionErrors();

        foreach ($requisitions as $requisition) {
            $requisition->refresh();

            $this->assertSame('cancelado por revisor', $requisition->status);
            $this->assertSame('Proyecto suspendido.', $requisition->status()->history()->latest('id')->first()->getCustomProperty('respuesta'));
        }
    }
}
