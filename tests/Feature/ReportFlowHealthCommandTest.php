<?php

namespace Tests\Feature;

use App\Mail\FlowHealthReport;
use App\Models\User;
use App\Services\FlowHealthService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * El comando `purchases:flow-health` solo manda correo cuando hay algo que
 * corregir, y a quién se lo manda.
 *
 * El contenido del reporte lo prueba FlowHealthServiceTest; aquí se simula.
 */
class ReportFlowHealthCommandTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return array{vacant_roles: array<int, array<string, mixed>>, inactive: array<int, array<string, mixed>>}
     */
    private function reportWithProblems(): array
    {
        return [
            'vacant_roles' => [[
                'role' => 'autoriza_orden_compra',
                'label' => 'Autoriza órdenes de los departamentos operativos',
                'url' => 'https://example.com/roles/1',
                'items' => [['type' => 'Orden', 'folio' => 'G349/26', 'level' => 'Autoriza', 'days' => 11, 'url' => 'https://example.com/ordenes/1']],
            ]],
            'inactive' => [[
                'name' => 'Persona que se fue',
                'user_id' => 990001,
                'items' => [['type' => 'Requisición', 'folio' => 'T-GCON-2026-0273', 'level' => 'Autoriza', 'days' => 0, 'url' => 'https://example.com/requisiciones/1']],
            ]],
        ];
    }

    /**
     * @param  array{vacant_roles: array<int, array<string, mixed>>, inactive: array<int, array<string, mixed>>}  $report
     */
    private function fakeReport(array $report): void
    {
        $this->mock(FlowHealthService::class, function (MockInterface $mock) use ($report) {
            $mock->shouldReceive('report')->once()->andReturn($report);
        });
    }

    public function test_sin_problemas_no_manda_correo(): void
    {
        Mail::fake();
        $this->fakeReport(['vacant_roles' => [], 'inactive' => []]);

        $this->artisan('purchases:flow-health')->assertSuccessful();

        Mail::assertNothingSent();
    }

    public function test_con_problemas_avisa_a_los_correos_configurados(): void
    {
        Mail::fake();
        config(['purchases.flow_alerts.recipients' => ['avisos@example.com']]);
        $this->fakeReport($this->reportWithProblems());

        $this->artisan('purchases:flow-health')->assertSuccessful();

        Mail::assertSent(FlowHealthReport::class, fn (FlowHealthReport $mail) => $mail->hasTo('avisos@example.com'));
    }

    public function test_sin_correos_configurados_avisa_a_los_super_admin_activos(): void
    {
        Mail::fake();
        config(['purchases.flow_alerts.recipients' => []]);
        $this->fakeReport($this->reportWithProblems());

        User::forceCreate([
            'name' => 'Administrador de prueba',
            'email' => 'admin.flujo@example.com',
            'puesto' => 'Prueba',
            'active' => true,
        ])->assignRole('super_admin');

        User::forceCreate([
            'name' => 'Administrador dado de baja',
            'email' => 'admin.baja@example.com',
            'puesto' => 'Prueba',
            'active' => false,
        ])->assignRole('super_admin');

        $this->artisan('purchases:flow-health')->assertSuccessful();

        Mail::assertSent(FlowHealthReport::class, fn (FlowHealthReport $mail) => $mail->hasTo('admin.flujo@example.com')
            && ! $mail->hasTo('admin.baja@example.com'));
    }

    public function test_en_modo_de_prueba_no_manda_nada(): void
    {
        Mail::fake();
        config(['purchases.flow_alerts.recipients' => ['avisos@example.com']]);
        $this->fakeReport($this->reportWithProblems());

        $this->artisan('purchases:flow-health', ['--dry-run' => true])->assertSuccessful();

        Mail::assertNothingSent();
    }

    public function test_el_correo_resume_el_problema_en_el_asunto_y_lista_lo_pendiente(): void
    {
        $mail = new FlowHealthReport($this->reportWithProblems());

        $this->assertSame(
            'Flujo de compras: 1 rol sin titular activo · 1 pendiente que espera a una cuenta inactiva',
            $mail->headline()
        );

        $html = $mail->render();

        $this->assertStringContainsString('Autoriza órdenes de los departamentos operativos', $html);
        $this->assertStringContainsString('G349/26', $html);
        $this->assertStringContainsString('Persona que se fue', $html);
        $this->assertStringContainsString('cuenta inactiva', $html);
        $this->assertStringContainsString('T-GCON-2026-0273', $html);
    }
}
