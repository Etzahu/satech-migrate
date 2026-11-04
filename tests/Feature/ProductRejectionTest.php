<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\ProductResource;
use App\Filament\Purchases\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Purchases\Resources\RequestIncorporation\CatalogResource\Pages\ListProducts as RequesterListProducts;
use App\Mail\CatalogNotification;
use App\Models\CategoryFamily;
use App\Models\Company;
use App\Models\MeasureUnit;
use App\Models\Product;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Compras puede rechazar una solicitud de alta con una observación, sin tener
 * que clasificarla, y el solicitante ve el motivo en su lista y en el correo.
 */
class ProductRejectionTest extends TestCase
{
    use DatabaseTransactions;

    private const RESPONSE_ACTION = 'Capturar respuesta';

    private const REASON = 'Ya existe en el catálogo como guantes de nitrilo talla M.';

    private User $purchasingManager;

    private User $requester;

    private Product $request;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Filament::setCurrentPanel('compras');

        $purchasingManager = User::withRole('gerente_compras')->where('active', 1)->first();
        $requester = User::role('solicita_requisicion_compra')
            ->where('active', 1)
            ->where('id', '!=', $purchasingManager?->id)
            ->first();

        $this->assertNotNull($purchasingManager, 'No hay un gerente de compras activo para probar la respuesta.');
        $this->assertNotNull($requester, 'No hay un solicitante activo para probar la respuesta.');

        $this->purchasingManager = $purchasingManager;
        $this->requester = $requester;

        session([
            'company_id' => Company::query()->value('id'),
            'company_name' => 'test',
            'company_acronym' => 'T',
        ]);

        $this->request = Product::create([
            'name' => 'solicitud de prueba '.uniqid(),
            'code' => 'Sin código asignado',
            'type_purchase' => 'proveeduria',
            'company_id' => session('company_id'),
            'unit_id' => MeasureUnit::query()->value('id'),
            'requester_id' => $requester->id,
        ]);

        $this->assertSame('pendiente', $this->request->status);

        $this->actingAs($purchasingManager);
    }

    public function test_rejecting_needs_only_an_observation_not_the_classification(): void
    {
        Livewire::test(EditProduct::class, ['record' => $this->request->getRouteKey()])
            ->callAction($this->responseAction(), ['response' => 'rechazado', 'observation' => self::REASON])
            ->assertHasNoFormErrors()
            ->assertRedirect(ProductResource::getUrl('index'));

        $this->request->refresh();

        $this->assertSame('rechazado', $this->request->status);
        $this->assertSame(self::REASON, $this->request->rejectionReason());
        $this->assertNull($this->request->category_id, 'Rechazar guardó la clasificación del formulario.');
        $this->assertSame('Sin código asignado', $this->request->code);

        Mail::assertSent(CatalogNotification::class, fn (CatalogNotification $mail): bool => $mail->hasTo($this->requester->email)
            && str_contains($mail->render(), self::REASON));
    }

    public function test_rejecting_without_an_observation_is_not_allowed(): void
    {
        Livewire::test(EditProduct::class, ['record' => $this->request->getRouteKey()])
            ->callAction($this->responseAction(), ['response' => 'rechazado', 'observation' => null])
            ->assertHasActionErrors(['observation' => 'required_unless']);

        $this->assertSame('pendiente', $this->request->refresh()->status);
        Mail::assertNothingSent();
    }

    public function test_approving_still_requires_the_classification(): void
    {
        Livewire::test(EditProduct::class, ['record' => $this->request->getRouteKey()])
            ->callAction($this->responseAction(), ['response' => 'aprobado'])
            ->assertHasErrors(['data.category_id' => 'required', 'data.category_family_id' => 'required']);

        $this->assertSame('pendiente', $this->request->refresh()->status);
    }

    public function test_approving_saves_the_classification_without_an_observation(): void
    {
        $family = CategoryFamily::query()->whereNotNull('category_id')->firstOrFail();

        Livewire::test(EditProduct::class, ['record' => $this->request->getRouteKey()])
            ->fillForm([
                'code' => 'TEST-001',
                'category_id' => $family->category_id,
                'category_family_id' => $family->id,
            ])
            ->callAction($this->responseAction(), ['response' => 'aprobado'])
            ->assertHasNoFormErrors()
            ->assertHasNoActionErrors();

        $this->request->refresh();

        $this->assertSame('aprobado', $this->request->status);
        $this->assertSame('TEST-001', $this->request->code);
        $this->assertSame($family->id, (int) $this->request->category_family_id);
        $this->assertSame($this->purchasingManager->id, (int) $this->request->registered_user_id);
        $this->assertNull($this->request->rejectionReason());
    }

    public function test_after_approving_the_response_button_gives_way_to_save_without_reloading(): void
    {
        $family = CategoryFamily::query()->whereNotNull('category_id')->firstOrFail();

        Livewire::test(EditProduct::class, ['record' => $this->request->getRouteKey()])
            ->assertActionVisible($this->responseAction())
            ->fillForm([
                'code' => 'TEST-001',
                'category_id' => $family->category_id,
                'category_family_id' => $family->id,
            ])
            ->callAction($this->responseAction(), ['response' => 'aprobado'])
            ->assertHasNoFormErrors()
            ->assertDontSee(self::RESPONSE_ACTION)
            ->assertActionVisible($this->saveAction());
    }

    public function test_requester_sees_the_status_and_the_reason(): void
    {
        $this->request->status()->transitionTo('rechazado', ['respuesta' => self::REASON]);

        $this->actingAs($this->requester);

        Livewire::test(RequesterListProducts::class)
            ->assertCanSeeTableRecords([$this->request])
            ->assertSee('Rechazado')
            ->assertSee(self::REASON)
            ->mountAction(TestAction::make('view')->table($this->request))
            ->assertMountedActionModalSee(['Motivo del rechazo', self::REASON]);
    }

    /**
     * "Capturar respuesta" vive debajo del formulario (getFormActions), no en
     * el encabezado de la página.
     */
    private function responseAction(): TestAction
    {
        return TestAction::make(self::RESPONSE_ACTION)->schemaComponent('form-actions', schema: 'content');
    }

    private function saveAction(): TestAction
    {
        return TestAction::make('save')->schemaComponent('form-actions', schema: 'content');
    }
}
