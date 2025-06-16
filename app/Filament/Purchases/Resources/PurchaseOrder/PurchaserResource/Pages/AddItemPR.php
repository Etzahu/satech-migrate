<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;

use Filament\Tables\Table;
use App\Models\PurchaseOrderItem;
use Filament\Resources\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use App\Models\PurchaseRequisitionItem;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource;


class AddItemPR extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithRecord;

    protected static string $resource = PurchaserResource::class;
    protected static string $view = 'filament.purchases.resources.purchase-order-resource.pages.add-item-p-r';
    protected ?string $heading = 'Agregar partidas';
    protected static ?string $title = 'Partidas';

    public $rq;
    public function mount(int | string $record)
    {
        $this->record = $this->resolveRecord($record);
        $states = [
            'borrador',
            'devuelto por gerente de compras',
            'devuelto por gerente solicitante',
            'devuelto por DG nivel 1',
            'devuelto por DG nivel 2',
            'reabierta para edición'
        ];
        if (!in_array($this->record->status, $states)) {
            return redirect(PurchaserResource::getUrl('view',['record' => $this->record]));
        }
    }

    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();
        return [
            // PRAssingResource::getUrl() => 'Courses',
            $resource::getUrl() => 'Ordenes',
            $resource::getUrl('view', ['record' => $this->record]) => $this->record->folio,
            $this->getBreadcrumb()
        ];
    }
    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn(): HasMany => $this->record->requisition->items())
            ->columns([
                TextColumn::make('product.name')
                    ->label('Producto'),
                TextColumn::make('quantity_purchase')
                    ->label('Cantidad a comprar')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('observation')
                    ->label('Observación'),
                TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')->sinceTooltip(),
            ])
            ->actions([])
            ->bulkActions([
                BulkAction::make('Agregar partidas seleccionadas a la orden')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        try {
                            $records->each(function ($item, $key) {
                                PurchaseOrderItem::create([
                                    'quantity' => $item->quantity_purchase,
                                    'unit_price' => 0,
                                    'observation' => '.',
                                    'purchase_order_id' => $this->record->id,
                                    'product_id' => $item->product_id,
                                ]);
                            });
                            Notification::make()
                                ->title('Partidas agregadas')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            logger()->error($e->getMessage());
                            Notification::make()
                                ->title('Ocurrió un error')
                                ->danger()
                                ->send();
                        }
                    })
            ])
            ->checkIfRecordIsSelectableUsing(function (PurchaseRequisitionItem $record) {
                return  $this->checkItemInOrder($record->product_id);
            });
    }
    public function checkItemInOrder($product_id)
    {
        // Obtengo todas las ordenes relacionadas
        $orders = $this->record->requisition->orders;
        $itemsWithOrder = [];
        foreach ($orders as $order) {
            $items = $order->items?->pluck('product_id')->all();
            // $itemsWithOrder[] = $items;
            $itemsWithOrder = array_merge($itemsWithOrder, $items);
        }
        if (filled($itemsWithOrder)) {
            return in_array($product_id, $itemsWithOrder) ? false : true;
        } else {
            return true;
        }
    }
}
