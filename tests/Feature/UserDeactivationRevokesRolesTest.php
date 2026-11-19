<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\UserResource\Pages\EditUser;
use App\Models\Management;
use App\Models\User;
use App\Services\Rrhh\EmployeeSyncService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Al dar de baja a un usuario se le retiran todos sus roles, llegue la baja
 * por la pantalla de usuarios o por la sincronización con RRHH.
 */
class UserDeactivationRevokesRolesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array<int, string>
     */
    private const ROLES = ['solicita_requisicion_compra', 'aprueba_requisicion_compra'];

    private function activeUserWithRoles(): User
    {
        $user = User::forceCreate([
            'id' => 999101,
            'name' => 'Prueba Baja Roles',
            'email' => 'prueba.baja.roles@gptservices.com',
            'puesto' => 'Prueba',
            'active' => true,
            'management_id' => Management::query()->value('id'),
        ]);

        $user->assignRole(self::ROLES);

        return $user;
    }

    public function test_al_darlo_de_baja_pierde_todos_sus_roles(): void
    {
        $user = $this->activeUserWithRoles();

        $user->update(['active' => false]);

        $this->assertSame([], $user->fresh()->getRoleNames()->all());
    }

    public function test_cambiar_otro_dato_no_toca_sus_roles(): void
    {
        $user = $this->activeUserWithRoles();

        $user->update(['puesto' => 'Otro puesto']);

        $this->assertEqualsCanonicalizing(self::ROLES, $user->fresh()->getRoleNames()->all());
    }

    public function test_reactivarlo_no_le_devuelve_los_roles(): void
    {
        $user = $this->activeUserWithRoles();

        $user->update(['active' => false]);
        $user->update(['active' => true]);

        $this->assertSame([], $user->fresh()->getRoleNames()->all());
    }

    public function test_la_baja_que_manda_rrhh_tambien_retira_los_roles(): void
    {
        $user = $this->activeUserWithRoles();

        app(EmployeeSyncService::class)->syncBatch([], [$user->id]);

        $user = $user->fresh();
        $this->assertFalse((bool) $user->active);
        $this->assertSame([], $user->getRoleNames()->all());
    }

    /**
     * La casilla de roles del formulario se guarda después del usuario; sin
     * el retiro en afterSave() se los volvía a poner.
     */
    public function test_la_baja_desde_la_pantalla_de_usuarios_no_le_deja_roles(): void
    {
        $user = $this->activeUserWithRoles();

        Filament::setCurrentPanel('compras');
        $this->actingAs(User::withRole('super_admin')->where('active', 1)->firstOrFail());

        Livewire::test(EditUser::class, ['record' => $user->getRouteKey()])
            ->fillForm(['active' => false])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified('Se le retiraron sus roles');

        $user = $user->fresh();
        $this->assertFalse((bool) $user->active);
        $this->assertSame([], $user->getRoleNames()->all());
    }

    public function test_a_un_usuario_inactivo_no_se_le_pueden_marcar_roles(): void
    {
        $user = $this->activeUserWithRoles();
        $user->update(['active' => false]);

        Filament::setCurrentPanel('compras');
        $this->actingAs(User::withRole('super_admin')->where('active', 1)->firstOrFail());

        Livewire::test(EditUser::class, ['record' => $user->getRouteKey()])
            ->fillForm(['roles' => Role::whereIn('name', self::ROLES)->pluck('id')->all()])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified('Se le retiraron sus roles');

        $this->assertSame([], $user->fresh()->getRoleNames()->all());
    }
}
