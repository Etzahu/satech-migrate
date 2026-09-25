<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\UserResource\Pages\ViewUser;
use App\Mail\UserInvitation;
use App\Models\User;
use App\Services\GuideCatalog;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Invitación de bienvenida desde la ficha del usuario: qué guías se proponen,
 * cuáles se pueden adjuntar y que el correo salga con los PDF pegados.
 */
class UserInvitationTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');

        $this->admin = User::role('super_admin')->first();

        $this->assertNotNull($this->admin, 'No hay un super_admin para probar el panel.');

        $this->actingAs($this->admin);
    }

    private function catalog(): GuideCatalog
    {
        return app(GuideCatalog::class);
    }

    private function userWithRole(string $role): User
    {
        $user = User::withRole($role)
            ->where('active', 1)
            ->where('email', 'like', '%@gptservices.com')
            ->first();

        if (! $user) {
            $this->markTestSkipped("No hay un usuario activo con el rol {$role}.");
        }

        return $user;
    }

    /**
     * El catálogo solo ofrece guías cuyo PDF está realmente en disco: adjuntar
     * una que no existe dejaría el correo sin el archivo prometido.
     */
    public function test_only_offers_guides_with_a_published_pdf(): void
    {
        $catalog = $this->catalog();
        $offered = array_keys($catalog->pdfOptions());

        $this->assertNotEmpty($offered, 'No hay ninguna guía publicada en disco.');

        foreach ($offered as $slug) {
            $this->assertNotNull(
                $catalog->pdfPath($slug),
                "La guía {$slug} se ofrece pero su PDF no existe."
            );
        }

        // 'registrar-proveedor' está en el catálogo con 'pdf' => null.
        $this->assertNotContains('registrar-proveedor', $offered);
    }

    /**
     * La división por tipo sale de los roles: a un solicitante se le propone la
     * guía de requisiciones y no las de administración.
     */
    public function test_suggests_guides_that_match_the_user_roles(): void
    {
        $requester = $this->userWithRole('solicita_requisicion_compra');

        $suggested = $this->catalog()->suggestedFor($requester);

        $this->assertContains('crear-requisicion', $suggested);
        $this->assertContains('alta-productos-proyectos', $suggested);

        // Las guías sin roles aplican a todos.
        $this->assertContains('flujo-aprobacion', $suggested);

        if (! $requester->hasAnyRole(['gerente_compras', 'administrador_compras'])) {
            $this->assertNotContains('admin-usuarios', $suggested);
        }
    }

    /**
     * Un comprador recibe la guía de órdenes, que al solicitante puro no le toca.
     */
    public function test_suggests_the_orders_guide_to_a_purchaser(): void
    {
        $purchaser = $this->userWithRole('comprador');

        $this->assertContains('crear-orden-compra', $this->catalog()->suggestedFor($purchaser));
    }

    /**
     * El correo sale al usuario invitado con las guías seleccionadas adjuntas.
     */
    public function test_sends_the_invitation_with_the_selected_guides_attached(): void
    {
        Mail::fake();

        $recipient = $this->userWithRole('solicita_requisicion_compra');

        Livewire::test(ViewUser::class, ['record' => $recipient->getKey()])
            ->callAction('enviarInvitacion', [
                'guides' => ['crear-requisicion', 'flujo-aprobacion'],
                'note' => 'Cualquier duda me buscas.',
            ])
            ->assertHasNoActionErrors();

        Mail::assertSent(UserInvitation::class, function (UserInvitation $mail) use ($recipient) {
            $attachments = $mail->attachments();
            $guides = $mail->resolvedGuides();

            return $mail->hasTo($recipient->email)
                && $mail->note === 'Cualquier duda me buscas.'
                && count($guides) === 2
                && count($attachments) === 2
                && collect($guides)->pluck('slug')->all() === ['crear-requisicion', 'flujo-aprobacion'];
        });
    }

    /**
     * Sin guías seleccionadas no se manda nada: el correo perdería su razón de ser.
     */
    public function test_requires_at_least_one_guide(): void
    {
        Mail::fake();

        $recipient = $this->userWithRole('solicita_requisicion_compra');

        Livewire::test(ViewUser::class, ['record' => $recipient->getKey()])
            ->callAction('enviarInvitacion', ['guides' => [], 'note' => null])
            ->assertHasActionErrors(['guides']);

        Mail::assertNothingSent();
    }

    /**
     * Una guía sin PDF no llega a los adjuntos aunque venga en la selección.
     */
    public function test_ignores_guides_without_a_pdf(): void
    {
        $recipient = $this->userWithRole('solicita_requisicion_compra');

        $mail = new UserInvitation($recipient, ['crear-requisicion', 'registrar-proveedor']);

        $this->assertCount(1, $mail->resolvedGuides());
        $this->assertCount(1, $mail->attachments());
    }

    /**
     * La ficha del usuario carga con la acción disponible.
     */
    public function test_view_page_renders_with_the_invitation_action(): void
    {
        $recipient = $this->userWithRole('solicita_requisicion_compra');

        Livewire::test(ViewUser::class, ['record' => $recipient->getKey()])
            ->assertSuccessful()
            ->assertActionVisible('enviarInvitacion');
    }

    /**
     * A un usuario dado de baja no se le invita a entrar.
     */
    public function test_hides_the_action_for_an_inactive_user(): void
    {
        $recipient = $this->userWithRole('solicita_requisicion_compra');
        $recipient->update(['active' => 0]);

        Livewire::test(ViewUser::class, ['record' => $recipient->getKey()])
            ->assertActionHidden('enviarInvitacion');
    }
}
