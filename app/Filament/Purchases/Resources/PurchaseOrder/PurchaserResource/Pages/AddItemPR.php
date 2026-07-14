<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequisitionItem;
use Filament\Actions\BulkAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AddItemPR extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithRecord;
    use InteractsWithTable;

    protected static string $resource = PurchaserResource::class;

    protected string $view = 'filament.purchases.resources.purchase-order-resource.pages.add-item-p-r';

    protected ?string $heading = 'Agregar partidas';

    protected static ?string $title = 'Partidas';

    public $rq;

    public function mount(int|string $record)
    {
        $this->record = $this->resolveRecord($record);
        $states = [
            'borrador',
            'devuelto por gerente de compras',
            'devuelto por gerente solicitante',
            'devuelto por DG nivel 1',
            'devuelto por DG nivel 2',
            'devuelto por administrador', // Permite agregar partidas cuando admin devuelve la orden
            'reabierta para edición',
        ];
        if (! in_array($this->record->status, $states)) {
            return redirect(PurchaserResource::getUrl('view', ['record' => $this->record]));
        }
    }

    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();

        return [
            // PRAssingResource::getUrl() => 'Courses',
            $resource::getUrl() => 'Ordenes',
            $resource::getUrl('view', ['record' => $this->record]) => $this->record->folio,
            $this->getBreadcrumb(),
        ];
    }

    public function table(Table $table): Table
    {
        $itemLabel = $this->record->requisition?->item_label ?? 'Producto';

        return $table
            ->relationship(fn (): HasMany => $this->record->requisition->items())
            ->columns([
                TextColumn::make('product.name')
                    ->label($itemLabel),
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
            ->recordActions([])
            ->toolbarActions([
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
                    }),
            ])
            ->checkIfRecordIsSelectableUsing(function (PurchaseRequisitionItem $record) {
                return $this->checkItemInOrder($record->product_id);
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
