<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\UserResource\Pages\CreateUser;
use App\Filament\Purchases\Resources\UserResource\Pages\EditUser;
use App\Models\Management;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * El alta de usuarios no admite repetidos: ni el ID del colaborador, ni el
 * nombre, ni la combinación de ambos.
 */
class UserUniquenessValidationTest extends TestCase
{
    use DatabaseTransactions;

    private User $existing;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');

        $admin = User::role('super_admin')->first();

        $this->assertNotNull($admin, 'No hay un super_admin para probar el panel.');

        $this->actingAs($admin);

        // Un usuario que el formulario pueda guardar tal cual: hay registros
        // antiguos sin gerencia o con celular en formatos que hoy no pasan.
        $this->existing = User::where('email', 'like', '%@gptservices.com')
            ->whereNotNull('management_id')
            ->whereNotNull('puesto')
            ->whereNull('phone')
            ->firstOrFail();
    }

    /**
     * @return array<string, mixed>
     */
    private function newUserData(array $overrides = []): array
    {
        return array_merge([
            'id' => User::max('id') + 1000,
            'name' => 'Colaborador De Prueba '.(User::max('id') + 1000),
            'email' => 'prueba.'.(User::max('id') + 1000).'@gptservices.com',
            'management_id' => Management::value('id'),
            'puesto' => 'Puesto de prueba',
            'active' => true,
        ], $overrides);
    }

    public function test_rejects_a_repeated_name(): void
    {
        Livewire::test(CreateUser::class)
            ->fillForm($this->newUserData(['name' => $this->existing->name]))
            ->call('create')
            ->assertHasFormErrors(['name']);
    }

    public function test_rejects_a_repeated_collaborator_id(): void
    {
        Livewire::test(CreateUser::class)
            ->fillForm($this->newUserData(['id' => $this->existing->id]))
            ->call('create')
            ->assertHasFormErrors(['id']);
    }

    public function test_rejects_a_repeated_id_and_name_together(): void
    {
        Livewire::test(CreateUser::class)
            ->fillForm($this->newUserData([
                'id' => $this->existing->id,
                'name' => $this->existing->name,
            ]))
            ->call('create')
            ->assertHasFormErrors(['id', 'name'])
            // El aviso distingue este caso del simple homónimo.
            ->assertSee('Ya existe un usuario con este mismo ID de colaborador y nombre.');
    }

    public function test_accepts_an_id_and_name_that_are_free(): void
    {
        Livewire::test(CreateUser::class)
            ->fillForm($this->newUserData())
            ->call('create')
            ->assertHasNoFormErrors();
    }

    public function test_editing_a_user_without_touching_the_name_is_allowed(): void
    {
        Livewire::test(EditUser::class, ['record' => $this->existing->getKey()])
            ->call('save')
            ->assertHasNoFormErrors();
    }

    public function test_editing_cannot_steal_another_users_name(): void
    {
        $other = User::whereKeyNot($this->existing->getKey())
            ->where('email', 'like', '%@gptservices.com')
            ->firstOrFail();

        Livewire::test(EditUser::class, ['record' => $this->existing->getKey()])
            ->fillForm(['name' => $other->name])
            ->call('save')
            ->assertHasFormErrors(['name']);
    }
}
