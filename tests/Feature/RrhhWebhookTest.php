<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Rrhh\EmployeeSyncService;
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

    /**
     * El nombre de la fila es el de la misma persona: es lo que autoriza a
     * escribirle. Si el id estuviera ocupado por alguien más, el evento no se
     * aplica (ver `test_no_sobreescribe_a_otra_persona_que_ocupa_el_mismo_id`).
     */
    public function test_actualiza_colaborador_existente_por_id(): void
    {
        User::forceCreate([
            'id' => 999002,
            'name' => 'Juan Pérez',
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
            'puesto' => 'Soldador',
            'email' => 'updated@example.com',
            'active' => 0,
        ]);
    }

    /**
     * Antes el correo bastaba como verificación secundaria. Ya no: en rrhh hay
     * buzones compartidos por varias personas (`vigilanciagpt@`,
     * `cmartinez@`), y engancharse por correo escribía los datos de alguien
     * sobre la fila de otro. Un correo compartido ya no vincula a nadie.
     */
    public function test_un_correo_compartido_no_vincula_a_otra_persona(): void
    {
        User::forceCreate([
            'id' => 999003,
            'name' => 'Zeta Sintetica Buzon',
            'puesto' => 'Algo',
            'email' => 'buzon-compartido@example.com',
            'active' => true,
        ]);

        // Llega otra persona con el mismo buzón: no debe tocar la fila de
        // Marcos, y como su id está libre se da de alta aparte.
        $data = $this->employeeData(999999, 'buzon-compartido@example.com', correoCompartido: true);
        $body = json_encode(['event' => 'employee.updated', 'data' => $data]);

        $this->postWebhook($body, $this->sign($body))->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => 999003,
            'name' => 'Zeta Sintetica Buzon',
        ]);
        $this->assertDatabaseHas('users', ['id' => 999999, 'name' => 'Juan Pérez']);
    }

    /**
     * El caso que obligó a cambiar el cruce: el id que rrhh manda existe aquí,
     * pero es de otra persona. Escribirle encima la renombraría y dejaría sus
     * requisiciones firmadas por quien no fue.
     */
    public function test_no_sobreescribe_a_otra_persona_que_ocupa_el_mismo_id(): void
    {
        User::forceCreate([
            'id' => 999005,
            'name' => 'Zeta Sintetica Ocupada',
            'puesto' => 'Compras',
            'email' => 'msalazar@example.com',
            'active' => true,
        ]);

        $data = $this->employeeData(999005, 'otro@example.com');
        $body = json_encode(['event' => 'employee.updated', 'data' => $data]);

        $this->postWebhook($body, $this->sign($body))
            ->assertOk()
            ->assertJson(['result' => EmployeeSyncService::CONFLICTO]);

        $this->assertDatabaseHas('users', [
            'id' => 999005,
            'name' => 'Zeta Sintetica Ocupada',
            'email' => 'msalazar@example.com',
        ]);
    }

    /**
     * rrhh guarda el nombre completo y aquí quedó el corto: sigue siendo la
     * misma persona y su fila se actualiza.
     */
    public function test_reconoce_a_la_misma_persona_con_el_nombre_corto(): void
    {
        User::forceCreate([
            'id' => 999006,
            'name' => 'Zeta Sintetica Corta',
            'puesto' => 'Algo',
            'email' => 'dreyes@example.com',
            'active' => true,
        ]);

        $data = $this->employeeData(999006, 'dreyes@example.com');
        $data['first_name'] = 'Zeta Marisol';
        $data['last_name'] = 'Sintetica Corta';
        $data['full_name'] = 'Zeta Marisol Sintetica Corta';
        $body = json_encode(['event' => 'employee.updated', 'data' => $data]);

        $this->postWebhook($body, $this->sign($body))->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => 999006,
            'name' => 'Zeta Marisol Sintetica Corta',
            'rrhh_employee_id' => 999006,
        ]);
    }

    /**
     * Quien vive aquí con otro id se reconoce por nombre y se le sella el
     * vínculo, sin duplicarlo ni renumerarlo.
     */
    public function test_vincula_por_nombre_a_quien_vive_con_otro_id(): void
    {
        User::forceCreate([
            'id' => 999007,
            'name' => 'Juan Pérez',
            'puesto' => 'Algo',
            'email' => 'jperez@example.com',
            'active' => true,
        ]);

        $data = $this->employeeData(999008, 'jperez@example.com');
        $body = json_encode(['event' => 'employee.updated', 'data' => $data]);

        $this->postWebhook($body, $this->sign($body))->assertOk();

        $this->assertDatabaseHas('users', ['id' => 999007, 'rrhh_employee_id' => 999008]);
        $this->assertDatabaseMissing('users', ['id' => 999008]);
    }

    /**
     * Al colaborador se le corrigió el nombre completo en rrhh: el nombre ya
     * no confirma nada, pero su correo —que identifica a una sola persona— sí.
     * Sin esto, corregir un nombre en rrhh dejaría la fila congelada.
     */
    public function test_el_correo_confirma_la_identidad_cuando_el_nombre_cambio(): void
    {
        User::forceCreate([
            'id' => 999009,
            'name' => 'Nombre Mal Capturado',
            'puesto' => 'Algo',
            'email' => 'unico@example.com',
            'active' => true,
        ]);

        $data = $this->employeeData(999009, 'unico@example.com');
        $body = json_encode(['event' => 'employee.updated', 'data' => $data]);

        $this->postWebhook($body, $this->sign($body))->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => 999009,
            'name' => 'Juan Pérez',
            'rrhh_employee_id' => 999009,
        ]);
    }

    /**
     * Vive aquí con otro id y con el nombre escrito de otra forma. El correo
     * es lo único que queda para reconocerlo, y alcanza porque identifica a
     * una sola persona en rrhh y a una sola fila aquí.
     */
    public function test_vincula_por_correo_a_quien_tiene_el_nombre_distinto(): void
    {
        User::forceCreate([
            'id' => 999010,
            'name' => 'Otra Forma De Escribirlo',
            'puesto' => 'Algo',
            'email' => 'porcorreo@example.com',
            'active' => true,
        ]);

        $data = $this->employeeData(999011, 'porcorreo@example.com');
        $body = json_encode(['event' => 'employee.updated', 'data' => $data]);

        $this->postWebhook($body, $this->sign($body))->assertOk();

        $this->assertDatabaseHas('users', ['id' => 999010, 'rrhh_employee_id' => 999011]);
        $this->assertDatabaseMissing('users', ['id' => 999011]);
    }

    /**
     * Dos filas con el mismo nombre: sin correo no hay forma de elegir, con
     * correo sí.
     */
    public function test_el_correo_desempata_entre_dos_filas_con_el_mismo_nombre(): void
    {
        User::forceCreate([
            'id' => 999012,
            'name' => 'Zeta Sintetica Repetida',
            'puesto' => 'Algo',
            'email' => 'repetida.uno@example.com',
            'active' => true,
        ]);

        User::forceCreate([
            'id' => 999013,
            'name' => 'Zeta Sintetica Repetida',
            'puesto' => 'Algo',
            'email' => 'repetida.dos@example.com',
            'active' => true,
        ]);

        $data = $this->employeeData(999014, 'repetida.dos@example.com');
        $data['first_name'] = 'Zeta';
        $data['last_name'] = 'Sintetica Repetida';
        $data['full_name'] = 'Zeta Sintetica Repetida';
        $body = json_encode(['event' => 'employee.updated', 'data' => $data]);

        $this->postWebhook($body, $this->sign($body))->assertOk();

        $this->assertDatabaseHas('users', ['id' => 999013, 'rrhh_employee_id' => 999014]);
        $this->assertDatabaseHas('users', ['id' => 999012, 'rrhh_employee_id' => null]);
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
    private function employeeData(int $id, string $email, bool $active = true, bool $correoCompartido = false): array
    {
        return [
            'employee_id' => $id,
            'uuid' => 'uuid-'.$id,
            'first_name' => 'Juan',
            'last_name' => 'Pérez',
            'full_name' => 'Juan Pérez',
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
            'profile_image' => 'https://example.com/foto.png',
        ];
    }
}
