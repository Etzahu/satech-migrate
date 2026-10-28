<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\HealthAlertNotifiable;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Facades\Health;
use Spatie\Health\Notifications\CheckFailedNotification;
use Tests\TestCase;

/**
 * Página de Salud (spatie/laravel-health): qué se agenda, a quién avisa cuando
 * algo falla y quién la puede ver.
 */
class HealthMonitoringTest extends TestCase
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

    public function test_el_latido_y_los_checks_corren_cada_minuto(): void
    {
        $events = collect(app(Schedule::class)->events());

        foreach (['health:schedule-check-heartbeat', 'health:check'] as $command) {
            $event = $events->first(fn (Event $event) => str_ends_with((string) $event->command, $command));

            $this->assertNotNull($event, "{$command} no está en la agenda.");
            $this->assertSame('* * * * *', $event->expression);
        }
    }

    public function test_una_falla_avisa_a_los_destinatarios_de_flow_health(): void
    {
        Notification::fake();
        config([
            'health.notifications.enabled' => true,
            'purchases.flow_alerts.recipients' => ['avisos@example.com'],
        ]);

        // Un latido que nunca se registró: el check del scheduler falla.
        Health::clearChecks()->checks([
            ScheduleCheck::new()->cacheKey('health:test:latido-inexistente'),
        ]);

        $this->artisan('health:check')->assertSuccessful();

        Notification::assertSentTo(new HealthAlertNotifiable, CheckFailedNotification::class);
        $this->assertSame(['avisos@example.com'], (new HealthAlertNotifiable)->routeNotificationForMail());
    }

    public function test_sin_fallas_no_avisa(): void
    {
        Notification::fake();
        config(['health.notifications.enabled' => true]);

        Health::clearChecks()->checks([ScheduleCheck::new()]);
        $this->artisan('health:schedule-check-heartbeat')->assertSuccessful();

        $this->artisan('health:check')->assertSuccessful();

        Notification::assertNothingSent();
    }

    public function test_super_admin_ve_la_pagina_de_salud(): void
    {
        $this->actingAs($this->panelUser('salud.admin.prueba@gptservices.com', 'super_admin'))
            ->get(route('filament.admin.pages.health-check-results'))
            ->assertOk();
    }

    public function test_el_resto_del_panel_no_ve_la_pagina_de_salud(): void
    {
        $this->actingAs($this->panelUser('salud.usuario.prueba@gptservices.com'))
            ->get(route('filament.admin.pages.health-check-results'))
            ->assertForbidden();
    }
}
