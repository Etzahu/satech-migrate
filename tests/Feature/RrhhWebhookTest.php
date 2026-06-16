<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class RrhhWebhookTest extends TestCase
{
    use DatabaseTransactions;

    private string $secret = 'test-webhook-secret';

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.rrhh.webhook_secret' => $this->secret]);
    }

    public function test_rechaza_peticion_con_firma_invalida(): void
    {
        $body = json_encode([
            'event' => 'employee.updated',
            'data' => ['employee_id' => 999001],
        ]);

        $this->postWebhook($body, 'sha256=incorrecta')->assertStatus(401);
    }

    public function test_crea_colaborador_en_employee_created(): void
    {
        $data = $this->employeeData(999001, 'created.test@example.com');
        $body = json_encode(['event' => 'employee.created', 'data' => $data]);

        $this->postWebhook($body, $this->sign($body))
            ->assertOk()
            ->assertJson(['status' => 'ok']);

        $this->assertDatabaseHas('users', [
            'id' => 999001,
            'name' => 'Juan Pérez',
            'puesto' => 'Soldador',
            'email' => 'created.test@example.com',
            'phone' => '5551234567',
            'active' => 1,
        ]);
    }

    public function test_actualiza_colaborador_existente_por_id(): void
    {
        User::forceCreate([
            'id' => 999002,
            'name' => 'Viejo Nombre',
            'puesto' => 'Antiguo',
            'email' => 'old@example.com',
            'active' => true,
        ]);

        $data = $this->employeeData(999002, 'updated@example.com', active: false);
        $body = json_encode(['event' => 'employee.updated', 'data' => $data]);

        $this->postWebhook($body, $this->sign($body))->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => 999002,
            'name' => 'Juan Pérez',
            'email' => 'updated@example.com',
            'active' => 0,
        ]);
    }

    public function test_usa_email_como_verificacion_secundaria_cuando_el_id_no_coincide(): void
    {
        User::forceCreate([
            'id' => 999003,
            'name' => 'Existente Email',
            'puesto' => 'Algo',
            'email' => 'match-email@example.com',
            'active' => true,
        ]);

        $data = $this->employeeData(999999, 'match-email@example.com');
        $body = json_encode(['event' => 'employee.updated', 'data' => $data]);

        $this->postWebhook($body, $this->sign($body))->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => 999003,
            'name' => 'Juan Pérez',
            'email' => 'match-email@example.com',
        ]);
        $this->assertDatabaseMissing('users', ['id' => 999999]);
    }

    public function test_desactiva_colaborador_en_employee_deleted(): void
    {
        User::forceCreate([
            'id' => 999004,
            'name' => 'A Borrar',
            'puesto' => 'Algo',
            'email' => 'delete@example.com',
            'active' => true,
        ]);

        $body = json_encode([
            'event' => 'employee.deleted',
            'data' => ['employee_id' => 999004, 'email' => 'delete@example.com'],
        ]);

        $this->postWebhook($body, $this->sign($body))->assertOk();

        $this->assertDatabaseHas('users', ['id' => 999004, 'active' => 0]);
    }

    private function sign(string $body): string
    {
        return 'sha256='.hash_hmac('sha256', $body, $this->secret);
    }

    private function postWebhook(string $body, string $signature): TestResponse
    {
        return $this->call('POST', '/api/webhooks/rrhh', [], [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_X_WEBHOOK_SIGNATURE' => $signature,
        ], $body);
    }

    /**
     * @return array<string, mixed>
     */
    private function employeeData(int $id, string $email, bool $active = true): array
    {
        return [
            'employee_id' => $id,
            'uuid' => 'uuid-'.$id,
            'first_name' => 'Juan',
            'last_name' => 'Pérez',
            'full_name' => 'Juan Pérez',
            'email' => $email,
            'phone' => '5551234567',
            'admission' => '2024-01-15',
            'active' => $active,
            'business_name_id' => 2,
            'job_id' => 73,
            'boss_id' => null,
            'job' => ['id' => 73, 'name' => 'Soldador'],
            'business_name' => ['id' => 2, 'name' => 'Satech'],
            'profile_image' => 'https://example.com/foto.png',
        ];
    }
}
