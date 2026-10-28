<?php

namespace Tests\Feature;

use App\Mail\PendingReviewReminder;
use App\Models\User;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
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

        $old = MailLog::create(['subject' => 'Viejo', 'body' => '<p>Viejo</p>', 'created_at' => now()->subDays(91)]);
        $recent = MailLog::create(['subject' => 'Reciente', 'body' => '<p>Reciente</p>', 'created_at' => now()->subDays(89)]);

        $prune = collect(app(Schedule::class)->events())
            ->first(fn (Event $event) => $event->description === 'Limpia la bitácora de correos');

        $this->assertNotNull($prune, 'La limpieza de la bitácora no está en la agenda.');

        $prune->run($this->app);

        $this->assertModelMissing($old);
        $this->assertModelExists($recent);
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
