<?php

namespace Tests\Feature;

use App\Filament\Admin\Resources\MailLogResource\Pages\ListMailLogs;
use App\Mail\PendingReviewReminder;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tapp\FilamentMailLog\Models\MailLog;
use Tests\TestCase;

/**
 * Bitácora de correos (tapp/filament-maillog): registra cada correo que sale,
 * se limpia sola y solo la ve super_admin.
 */
class MailLogTest extends TestCase
{
    use DatabaseTransactions;

    private function panelUser(string $email, ?string $role = null): User
    {
        $user = User::forceCreate([
            'name' => 'Usuario de prueba',
            'email' => $email,
            'puesto' => 'Prueba',
            'active' => true,
        ]);

        if ($role !== null) {
            $user->assignRole($role);
        }

        return $user;
    }

    /**
     * Un registro como los que deja un envío real: la tabla del panel decodifica
     * `from` y `headers`, que nunca vienen vacíos.
     */
    private function logEntry(string $subject, CarbonInterface $sentAt): MailLog
    {
        return MailLog::create([
            'from' => 'Compras <compras@example.com>',
            'to' => 'destino@example.com',
            'subject' => $subject,
            'body' => "<p>{$subject}</p>",
            'headers' => "Subject: {$subject}",
            'created_at' => $sentAt,
        ]);
    }

    public function test_el_recordatorio_de_pendientes_queda_en_la_bitacora(): void
    {
        $recipient = new User;
        $recipient->name = 'Aprobador de prueba';
        $recipient->email = 'aprobador.bitacora@example.com';

        Mail::to($recipient->email)->send(new PendingReviewReminder($recipient, [[
            'type' => 'Orden',
            'folio' => 'T999/26',
            'action' => 'Aprobar',
            'requester' => 'Solicitante de prueba',
            'company' => 'Tech Energy Control',
            'days' => 3,
            'url' => 'https://example.com/T999/26',
        ]]));

        $log = MailLog::query()->where('to', 'like', '%aprobador.bitacora@example.com%')->latest('id')->first();

        $this->assertNotNull($log);
        $this->assertSame('Compras: tienes 1 documento pendiente por revisar', $log->subject);
        $this->assertStringContainsString('T999/26', $log->body);
    }

    public function test_un_correo_de_texto_plano_tambien_se_manda_y_se_registra(): void
    {
        Mail::raw('Solo texto', fn (Message $message) => $message
            ->to('texto.bitacora@example.com')
            ->subject('Correo de texto de prueba'));

        $this->assertDatabaseHas('mail_logs', [
            'subject' => 'Correo de texto de prueba',
            'body' => null,
        ]);
    }

    public function test_la_limpieza_borra_solo_lo_que_pasa_de_los_dias_configurados(): void
    {
        config(['filament-maillog.keep_for_days' => 90]);

        $old = $this->logEntry('Viejo', now()->subDays(91));
        $recent = $this->logEntry('Reciente', now()->subDays(89));

        $prune = collect(app(Schedule::class)->events())
            ->first(fn (Event $event) => $event->description === 'Limpia la bitácora de correos');

        $this->assertNotNull($prune, 'La limpieza de la bitácora no está en la agenda.');

        $prune->run($this->app);

        $this->assertModelMissing($old);
        $this->assertModelExists($recent);
    }

    public function test_el_boton_limpiar_borra_lo_que_pasa_de_los_dias_indicados(): void
    {
        $this->actingAs($this->panelUser('bitacora.limpia.prueba@gptservices.com', 'super_admin'));

        $old = $this->logEntry('Viejo', now()->subDays(31));
        $recent = $this->logEntry('Reciente', now()->subDays(29));

        Livewire::test(ListMailLogs::class)
            ->assertActionVisible('prune')
            ->callAction('prune', data: ['days' => 30])
            ->assertHasNoActionErrors()
            ->assertNotified();

        $this->assertModelMissing($old);
        $this->assertModelExists($recent);
    }

    public function test_el_boton_limpiar_pide_al_menos_un_dia(): void
    {
        $this->actingAs($this->panelUser('bitacora.limpia.cero@gptservices.com', 'super_admin'));

        $today = $this->logEntry('De hoy', now());

        Livewire::test(ListMailLogs::class)
            ->callAction('prune', data: ['days' => 0])
            ->assertHasActionErrors(['days' => 'min']);

        $this->assertModelExists($today);
    }

    public function test_solo_super_admin_puede_limpiar(): void
    {
        $this->assertTrue($this->panelUser('bitacora.puede.prueba@gptservices.com', 'super_admin')->can('deleteAny', MailLog::class));
        $this->assertFalse($this->panelUser('bitacora.nopuede.prueba@gptservices.com')->can('deleteAny', MailLog::class));
    }

    public function test_super_admin_ve_la_bitacora(): void
    {
        $this->actingAs($this->panelUser('bitacora.admin.prueba@gptservices.com', 'super_admin'))
            ->get(route('filament.admin.resources.mail-logs.index'))
            ->assertOk();
    }

    public function test_el_resto_del_panel_no_ve_la_bitacora(): void
    {
        $this->actingAs($this->panelUser('bitacora.usuario.prueba@gptservices.com'))
            ->get(route('filament.admin.resources.mail-logs.index'))
            ->assertForbidden();
    }
}
