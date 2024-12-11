<?php

namespace App\Filament\Purchases\Resources\PurchaseOrderResource\Pages;

use Filament\Tables\Table;
use App\Models\PurchaseOrderItem;
use Filament\Resources\Pages\Page;
use Filament\Forms\Contracts\HasForms;
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
use App\Filament\Purchases\Resources\PurchaseOrderResource;
use App\Models\PurchaseRequisitionItem;

class AddItemPR extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithRecord;

    protected static string $resource = PurchaseOrderResource::class;
    protected static string $view = 'filament.purchases.resources.purchase-order-resource.pages.add-item-p-r';
    protected ?string $heading = 'Agregar partidas';
    protected static ?string $title = 'Partidas';

    public $rq;
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        // $this->areItemsInOrder();
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
                    ->dateTime('d-m-Y'),
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
                                    'observation' => '',
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
        $items = $this->record->items?->pluck('product_id')->all();
        if (filled($items)) {
            return in_array($product_id, $items) ? false : true;
        } else {
            return true;
        }
    }
}
