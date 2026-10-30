<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource\Pages\View;
use App\Models\PurchaseOrder;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Livewire\Livewire;
use OwenIt\Auditing\Models\Audit;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;
use Tests\TestCase;

/**
 * Al aprobar DG nivel 1 la orden pasa sola a "autorizada para proveedor" y
 * ambas auditorías quedan en el mismo segundo. La más reciente debe salir
 * arriba aunque empaten en created_at.
 *
 * Corre contra la base real dentro de una transacción. Bus::fake() evita que
 * el observer de la orden exporte a las hojas de Google reales.
 */
class PurchaseOrderAuditsSortTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Bus::fake();

        Filament::setCurrentPanel('compras');
    }

    private function statusAudit(PurchaseOrder $order, string $from, string $to, string $createdAt): Audit
    {
        return Audit::forceCreate([
            'event' => 'updated',
            'auditable_type' => PurchaseOrder::class,
            'auditable_id' => $order->id,
            'old_values' => ['status' => $from],
            'new_values' => ['status' => $to],
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);
    }

    public function test_la_auditoria_mas_reciente_sale_primero_aunque_empate_en_la_hora(): void
    {
        $admin = User::forceCreate([
            'name' => 'Prueba auditorías',
            'email' => 'prueba.auditorias@gptservices.com',
            'puesto' => 'Prueba',
            'active' => true,
        ]);
        $admin->assignRole('super_admin');
        $this->actingAs($admin);

        $order = PurchaseOrder::query()->latest('id')->firstOrFail();

        // En el futuro para que queden por encima de las auditorías reales de la orden.
        $sameSecond = now()->addYear()->startOfSecond()->toDateTimeString();

        $approved = $this->statusAudit($order, 'aprobado por gerente solicitante', 'aprobado por DG nivel 1', $sameSecond);
        $authorized = $this->statusAudit($order, 'aprobado por DG nivel 1', 'autorizada para proveedor', $sameSecond);

        Livewire::test(AuditsRelationManager::class, [
            'ownerRecord' => $order,
            'pageClass' => View::class,
        ])
            ->assertCanSeeTableRecords([$authorized, $approved], inOrder: true);
    }
}
