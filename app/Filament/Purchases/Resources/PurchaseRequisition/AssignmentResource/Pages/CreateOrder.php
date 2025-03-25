<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource\Pages;

use Filament\Forms\Form;
use App\Models\PurchaseOrder;
use App\Services\OrderService;
use Filament\Resources\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource;

class CreateOrder extends Page implements HasForms
{
    use InteractsWithRecord;
    use InteractsWithForms;

    public $service;
    public ?array $data = [];
    protected static string $resource = AssignmentResource::class;
    protected static string $view = 'filament.purchases.resources.p-r-assing-resource.pages.create-order';
    protected static ?string $title = 'Crear orden de compra';
    protected ?string $heading = 'Orden de compra';
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->data['currency'] = 'MXN';
        $this->data['type_payment'] = '';
        $this->data['form_payment'] = '';
        $this->data['condition_payment'] = '';
        $this->data['quote_folio'] = '';
        $this->data['use_cfdi'] = '';
        $this->data['shipping_method'] = '';
        $this->data['tax_iva'] = 0;
        $this->data['provider_id'] = '';
        $this->data['retention_iva'] = 0;
        $this->data['retention_isr'] = 0;
        $this->data['retention_another'] = 0;
        $this->data['discount'] = 0;
        $this->data['initial_delivery_date'] = '';
        $this->data['final_delivery_date'] = '';
        $this->data['observations'] = 'Sin observaciones';

        $this->data['folio'] = 'N/A';
        $this->data['purchaser_user_id'] = auth()->user()->id;
        $this->data['company_id'] = session()->get('company_id');
        $this->data['requisition_id'] = $this->record->id;

        $this->data['doc_1'] = null;
        $this->data['doc_2'] = null;
        $this->data['doc_3'] = null;
    }
    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();
        return [
            $resource::getUrl() => 'Requisiciones',
            $resource::getUrl('view', ['record' => $this->record]) => $this->record->folio,
            $this->getBreadcrumb()
        ];
    }
    public function form(Form $form): Form
    {
        $form->statePath('data');
        $options['rq'] = true;
        return PurchaserResource::form($form, $options);
    }
    public function create(): void
    {
        // TODO:falta la logica para guardar las imagenes
        $this->form->getState();
        $order = PurchaseOrder::create($this->data);
        $order->save();
        Notification::make()
            ->title('Orden de compra creada')
            ->success()
            ->send();
        redirect(AssignmentResource::getUrl('view', ['record' => $this->record->id]));
    }
}
