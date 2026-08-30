<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Rrhh\EmployeeSyncService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * Endpoints que rrhh consume para listar y sincronizar el padrón de
 * colaboradores de este proyecto.
 */
class RrhhUsersApiTest extends TestCase
{
    use DatabaseTransactions;

    private string $secret = 'test-webhook-secret';

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.rrhh.webhook_secret' => $this->secret]);
    }

    public function test_el_inventario_rechaza_una_firma_invalida(): void
    {
        $this->postSigned('/api/rrhh/users/inventory', ['requested_at' => now()->toIso8601String()], 'sha256=incorrecta')
            ->assertStatus(401);
    }

    public function test_el_inventario_rechaza_una_peticion_vieja(): void
    {
        $this->postSigned('/api/rrhh/users/inventory', ['requested_at' => now()->subHour()->toIso8601String()])
            ->assertStatus(422)
            ->assertJsonValidationErrors('requested_at');
    }

    public function test_el_inventario_manda_el_nombre_completo_y_el_vinculo(): void
    {
        User::forceCreate([
            'id' => 999201,
            'name' => 'Rosa María Mendoza Gutiérrez',
            'puesto' => 'Compras',
            'email' => 'inventario@example.com',
            'active' => true,
            'rrhh_employee_id' => 999201,
        ]);

        $response = $this->postSigned('/api/rrhh/users/inventory', ['requested_at' => now()->toIso8601String()])
            ->assertOk()
            ->assertJsonStructure(['project', 'generated_at', 'counts' => ['total', 'active'], 'users']);

        $usuario = collect($response->json('users'))->firstWhere('id', 999201);

        $this->assertNotNull($usuario);
        // El nombre vive en una sola columna: viaja entero en first_name.
        $this->assertSame('Rosa María Mendoza Gutiérrez', $usuario['first_name']);
        $this->assertNull($usuario['last_name']);
        $this->assertSame('Compras', $usuario['puesto']);
        $this->assertTrue($usuario['active']);
        $this->assertSame(999201, $usuario['rrhh_employee_id']);
    }

    public function test_la_sincronizacion_crea_actualiza_y_desactiva(): void
    {
        User::forceCreate([
            'id' => 999202,
            'name' => 'Juan Pérez',
            'puesto' => 'Antiguo',
            'email' => 'sync.existente@example.com',
            'active' => true,
        ]);

        User::forceCreate([
            'id' => 999203,
            'name' => 'Ya No Está Aquí',
            'puesto' => 'Algo',
            'email' => 'sync.baja@example.com',
            'active' => true,
        ]);

        $response = $this->postSigned('/api/rrhh/users/sync', [
            'requested_at' => now()->toIso8601String(),
            'employees' => [
                // Nombre distinto al de la fila existente: si coincidiera, el
                // matcher lo tomaría por la misma persona (y con razón).
                $this->employeeData(999204, 'sync.nuevo@example.com', nombre: 'Zeta Sintetica Nueva'),
                $this->employeeData(999202, 'sync.existente@example.com'),
            ],
            'deactivate' => [999203],
        ])->assertOk();

        $this->assertSame(3, $response->json('processed'));
        $this->assertSame(1, $response->json('summary.'.EmployeeSyncService::CREADO));
        $this->assertSame(1, $response->json('summary.'.EmployeeSyncService::ACTUALIZADO));
        $this->assertSame(1, $response->json('summary.'.EmployeeSyncService::DESACTIVADO));

        // El alta se reporta con el id de rrhh, no con el lastInsertId de MySQL.
        $this->assertSame(999204, $response->json('results.0.local_id'));
        $this->assertTrue($response->json('results.0.id_alineado'));
        $this->assertSame(0, $response->json('summary.id_divergente'));

        $this->assertDatabaseHas('users', [
            'id' => 999204,
            'name' => 'Zeta Sintetica Nueva',
            'puesto' => 'Soldador',
            'email' => 'sync.nuevo@example.com',
            'active' => 1,
            'rrhh_employee_id' => 999204,
        ]);
        $this->assertDatabaseHas('users', ['id' => 999203, 'active' => 0]);
    }

    public function test_la_sincronizacion_reporta_el_conflicto_sin_tocar_a_nadie(): void
    {
        User::forceCreate([
            'id' => 999205,
            'name' => 'Zeta Sintetica Ocupada',
            'puesto' => 'Compras',
            'email' => 'msalazar@example.com',
            'active' => true,
        ]);

        $response = $this->postSigned('/api/rrhh/users/sync', [
            'requested_at' => now()->toIso8601String(),
            'employees' => [$this->employeeData(999205, 'otro@example.com')],
        ])->assertOk();

        $this->assertSame(1, $response->json('summary.'.EmployeeSyncService::CONFLICTO));
        $this->assertStringContainsString('otra persona', $response->json('results.0.motivo'));
        // Un conflicto no se cuenta como divergencia de id: no se aplicó nada.
        $this->assertSame(0, $response->json('summary.id_divergente'));

        $this->assertDatabaseHas('users', [
            'id' => 999205,
            'name' => 'Zeta Sintetica Ocupada',
            'email' => 'msalazar@example.com',
        ]);
    }

    public function test_la_sincronizacion_vincula_por_nombre_y_reporta_el_id_divergente(): void
    {
        User::forceCreate([
            'id' => 999206,
            'name' => 'Zeta Sintetica Divergente',
            'puesto' => 'Algo',
            'email' => 'sramos@example.com',
            'active' => true,
        ]);

        $employee = $this->employeeData(999207, 'sramos@example.com', nombre: 'Zeta Sintetica Divergente');

        $response = $this->postSigned('/api/rrhh/users/sync', [
            'requested_at' => now()->toIso8601String(),
            'employees' => [$employee],
        ])->assertOk();

        $this->assertSame(1, $response->json('summary.id_divergente'));
        $this->assertSame(999206, $response->json('results.0.local_id'));
        $this->assertFalse($response->json('results.0.id_alineado'));

        $this->assertDatabaseHas('users', ['id' => 999206, 'rrhh_employee_id' => 999207]);
        $this->assertDatabaseMissing('users', ['id' => 999207]);
    }

    public function test_el_modo_de_prueba_no_escribe_nada(): void
    {
        $response = $this->postSigned('/api/rrhh/users/sync', [
            'requested_at' => now()->toIso8601String(),
            'dry_run' => true,
            'employees' => [$this->employeeData(999208, 'ensayo@example.com')],
        ])->assertOk();

        $this->assertTrue($response->json('dry_run'));
        $this->assertSame(1, $response->json('summary.'.EmployeeSyncService::CREADO));

        // El resultado dice qué pasaría, pero la base queda intacta.
        $this->assertDatabaseMissing('users', ['id' => 999208]);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function postSigned(string $uri, array $payload, ?string $signature = null): TestResponse
    {
        $body = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return $this->call('POST', $uri, [], [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_X_WEBHOOK_SIGNATURE' => $signature ?? 'sha256='.hash_hmac('sha256', $body, $this->secret),
        ], $body);
    }

    /**
     * @return array<string, mixed>
     */
    private function employeeData(int $id, string $email, bool $active = true, string $nombre = 'Juan Pérez', bool $correoCompartido = false): array
    {
        [$primero, $resto] = array_pad(explode(' ', $nombre, 2), 2, '');

        return [
            'employee_id' => $id,
            'uuid' => 'uuid-'.$id,
            'first_name' => $primero,
            'last_name' => $resto,
            'full_name' => $nombre,
            'email' => $email,
            'email_compartido' => $correoCompartido,
            'phone' => '5551234567',
            'admission' => '2024-01-15',
            'active' => $active,
            'business_name_id' => 2,
            'job_id' => 73,
            'boss_id' => null,
            'job' => ['id' => 73, 'name' => 'Soldador'],
            'business_name' => ['id' => 2, 'name' => 'Satech'],
            'profile_image' => null,
            'updated_at' => now()->toIso8601String(),
        ];
    }
}
