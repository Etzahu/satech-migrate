<?php

namespace Tests\Feature;

use App\Mail\PendingReviewReminder;
use App\Models\User;
use App\Services\PendingReviewReminderService;
use Illuminate\Mail\PendingMail;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Mockery\MockInterface;
use RuntimeException;
use Tests\TestCase;

/**
 * El comando `purchases:remind-pending` manda un recordatorio por persona y
 * solo a quien tiene algo.
 *
 * A quién le toca cada pendiente lo prueba PendingReviewReminderServiceTest;
 * aquí se simula.
 */
class RemindPendingReviewsCommandTest extends TestCase
{
    private function person(string $name, string $email): User
    {
        $user = new User;
        $user->name = $name;
        $user->email = $email;

        return $user;
    }

    /**
     * @return array<string, mixed>
     */
    private function item(string $folio, string $company = 'Tech Energy Control', string $type = 'Orden', string $action = 'Aprobar', int $days = 4): array
    {
        return [
            'type' => $type,
            'folio' => $folio,
            'action' => $action,
            'requester' => 'Solicitante de prueba',
            'company' => $company,
            'days' => $days,
            'url' => "https://example.com/{$folio}",
        ];
    }

    /**
     * @param  array<int, array{user: User, items: array<int, array<string, mixed>>}>  $reminders
     * @param  array<int, array<string, mixed>>  $unattended
     */
    private function fakeReminders(array $reminders, array $unattended = []): void
    {
        $this->mock(PendingReviewReminderService::class, function (MockInterface $mock) use ($reminders, $unattended) {
            $mock->shouldReceive('reminders')->once()->andReturn(['reminders' => $reminders, 'unattended' => $unattended]);
        });
    }

    public function test_sin_pendientes_no_manda_nada(): void
    {
        Mail::fake();
        $this->fakeReminders([]);

        $this->artisan('purchases:remind-pending')
            ->expectsOutputToContain('Nadie tiene pendientes por revisar.')
            ->assertSuccessful();

        Mail::assertNothingSent();
    }

    public function test_manda_a_cada_persona_un_recordatorio_con_lo_suyo(): void
    {
        Mail::fake();
        $this->fakeReminders([
            ['user' => $this->person('Aprobador', 'aprobador@example.com'), 'items' => [$this->item('T100/26'), $this->item('T101/26')]],
            ['user' => $this->person('Revisor', 'revisor@example.com'), 'items' => [$this->item('T-GCON-2026-0001', type: 'Requisición', action: 'Revisar')]],
        ]);

        $this->artisan('purchases:remind-pending')
            ->expectsOutputToContain('Recordatorios enviados: 2.')
            ->assertSuccessful();

        Mail::assertSentCount(2);
        Mail::assertSent(PendingReviewReminder::class, fn (PendingReviewReminder $mail) => $mail->hasTo('aprobador@example.com')
            && collect($mail->items)->pluck('folio')->all() === ['T100/26', 'T101/26']);
        Mail::assertSent(PendingReviewReminder::class, fn (PendingReviewReminder $mail) => $mail->hasTo('revisor@example.com')
            && collect($mail->items)->pluck('folio')->all() === ['T-GCON-2026-0001']);
    }

    public function test_avisa_lo_que_no_tiene_a_nadie_activo_que_lo_reciba(): void
    {
        Mail::fake();
        $this->fakeReminders([], unattended: [$this->item('G349/26'), $this->item('G350/26')]);

        $this->artisan('purchases:remind-pending')
            ->expectsOutputToContain('2 pendientes no tienen a nadie activo que los reciba')
            ->assertSuccessful();

        Mail::assertNothingSent();
    }

    public function test_en_modo_de_prueba_muestra_a_quien_le_llegaria_sin_mandar_nada(): void
    {
        Mail::fake();
        $this->fakeReminders([
            ['user' => $this->person('Aprobador', 'aprobador@example.com'), 'items' => [$this->item('T100/26')]],
        ]);

        $this->artisan('purchases:remind-pending', ['--dry-run' => true])
            ->expectsOutputToContain('aprobador@example.com')
            ->expectsOutputToContain('Modo de prueba')
            ->assertSuccessful();

        Mail::assertNothingSent();
    }

    public function test_si_un_envio_falla_sigue_con_los_demas_y_termina_con_error(): void
    {
        Exceptions::fake();
        $this->fakeReminders([
            ['user' => $this->person('Con falla', 'falla@example.com'), 'items' => [$this->item('T100/26')]],
            ['user' => $this->person('Sin falla', 'ok@example.com'), 'items' => [$this->item('T101/26')]],
        ]);

        $failing = Mockery::mock(PendingMail::class);
        $failing->shouldReceive('send')->once()->andThrow(new RuntimeException('SMTP caído'));

        $working = Mockery::mock(PendingMail::class);
        $working->shouldReceive('send')->once();

        Mail::shouldReceive('to')->once()->with('falla@example.com')->andReturn($failing);
        Mail::shouldReceive('to')->once()->with('ok@example.com')->andReturn($working);

        $this->artisan('purchases:remind-pending')
            ->expectsOutputToContain('No se pudo mandar a falla@example.com: SMTP caído')
            ->expectsOutputToContain('Recordatorios enviados: 1.')
            ->assertFailed();

        Exceptions::assertReported(RuntimeException::class);
    }

    public function test_el_correo_resume_en_el_asunto_y_agrupa_los_pendientes_por_empresa(): void
    {
        $recipient = $this->person('Aprobador de prueba', 'aprobador@example.com');

        $single = new PendingReviewReminder($recipient, [$this->item('T100/26')]);
        $this->assertSame('Compras: tienes 1 documento pendiente por revisar', $single->headline());

        $mail = new PendingReviewReminder($recipient, [
            $this->item('G359/26', company: 'GPT Ingeniería Y Manufactura', action: 'Liberar', days: 12),
            $this->item('T-GCON-2026-0274', type: 'Requisición', action: 'Revisar'),
        ]);

        $this->assertSame('Compras: tienes 2 documentos pendientes por revisar', $mail->headline());

        $html = $mail->render();

        $this->assertStringContainsString('Aprobador de prueba', $html);
        $this->assertStringContainsString('GPT Ingeniería Y Manufactura', $html);
        $this->assertStringContainsString('Tech Energy Control', $html);
        $this->assertStringContainsString('https://example.com/G359/26', $html);
        $this->assertStringContainsString('T-GCON-2026-0274', $html);
        $this->assertStringContainsString('Liberar', $html);
        $this->assertStringContainsString('Solicitante de prueba', $html);
    }
}
