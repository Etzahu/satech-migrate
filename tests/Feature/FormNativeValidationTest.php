<?php

namespace Tests\Feature;

use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages\CreatePurchaseOrder;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Los formularios del panel no usan la validación nativa del navegador. Con
 * ella, un valor inválido en un tab inactivo (p. ej. un decimal en "Tiempo de
 * entrega") hacía que Chrome bloqueara el envío sin mostrar nada: "An invalid
 * form control with name='' is not focusable". La validación queda del lado
 * del servidor, que ya aplica las mismas reglas y abre el tab con el error.
 */
class FormNativeValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('compras');

        $purchaser = User::role('comprador')->where('active', 1)->first();

        $this->assertNotNull($purchaser, 'No hay un comprador activo para probar el panel.');

        $this->actingAs($purchaser);
    }

    public function test_panel_form_skips_native_browser_validation(): void
    {
        $html = Livewire::test(CreatePurchaseOrder::class)->html();

        $this->assertMatchesRegularExpression('/<form\b(?=[^>]*wire:submit="create")[^>]*\bnovalidate\b/', $html);
    }

    public function test_server_still_rejects_decimal_delivery_days(): void
    {
        Livewire::test(CreatePurchaseOrder::class)
            ->fillForm(['delivery_days' => 1.5])
            ->call('create')
            ->assertHasFormErrors(['delivery_days' => 'integer']);
    }

    public function test_server_still_rejects_decimal_payment_condition(): void
    {
        $page = Livewire::test(CreatePurchaseOrder::class);

        $conditionKey = array_key_first($page->get('data.condition_payment'));

        $this->assertNotNull($conditionKey, 'El formulario ya no trae una condición de pago por defecto.');

        $page
            ->set("data.condition_payment.{$conditionKey}.value", 33.5)
            ->call('create')
            ->assertHasFormErrors(["condition_payment.{$conditionKey}.value" => 'integer']);
    }
}
