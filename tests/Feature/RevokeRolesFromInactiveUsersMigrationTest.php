<?php

namespace Tests\Feature;

use App\Models\Management;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

/**
 * La limpieza única que retira los roles a quienes ya estaban dados de baja
 * antes de que existiera UserObserver.
 */
class RevokeRolesFromInactiveUsersMigrationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array<int, string>
     */
    private const ROLES = ['solicita_requisicion_compra', 'revisa_requisicion_compra'];

    /**
     * La limpieza alcanza a los inactivos reales de la base —se revierte con la
     * transacción—; sin el espía dejaría en el log constancias falsas de ellos.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Log::spy();
    }

    private function migration(): Migration
    {
        return require database_path('migrations/2026_11_18_111619_revoke_roles_from_inactive_users.php');
    }

    /**
     * Se crea ya con el estado final: el observer solo actúa al actualizar, así
     * que el inactivo conserva sus roles como los que se dieron de baja antes.
     */
    private function userWithRoles(int $id, bool $active): User
    {
        $user = User::forceCreate([
            'id' => $id,
            'name' => "Prueba Limpieza {$id}",
            'email' => "prueba.limpieza.{$id}@gptservices.com",
            'puesto' => 'Prueba',
            'active' => $active,
            'management_id' => Management::query()->value('id'),
        ]);

        $user->assignRole(self::ROLES);

        return $user;
    }

    public function test_retira_los_roles_a_los_que_ya_estaban_inactivos(): void
    {
        $inactive = $this->userWithRoles(999201, active: false);

        $this->migration()->up();

        $this->assertSame([], $inactive->fresh()->getRoleNames()->all());
        $this->assertFalse(User::where('active', 0)->whereHas('roles')->exists());

        Log::shouldHaveReceived('info')
            ->with('Roles retirados al dar de baja al usuario', Mockery::on(
                fn (array $context): bool => $context['user_id'] === $inactive->id && $context['roles'] === self::ROLES,
            ));
    }

    public function test_no_toca_a_los_activos(): void
    {
        $active = $this->userWithRoles(999202, active: true);

        $this->migration()->up();

        $this->assertEqualsCanonicalizing(self::ROLES, $active->fresh()->getRoleNames()->all());
    }

    public function test_se_puede_correr_dos_veces(): void
    {
        $inactive = $this->userWithRoles(999203, active: false);
        $active = $this->userWithRoles(999204, active: true);

        $this->migration()->up();
        $this->migration()->up();

        $this->assertSame([], $inactive->fresh()->getRoleNames()->all());
        $this->assertEqualsCanonicalizing(self::ROLES, $active->fresh()->getRoleNames()->all());
    }
}
