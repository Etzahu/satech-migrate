<?php

namespace App\Filament\Purchases\Resources\PRAssingResource\Pages;

use Filament\Tables\Table;
use App\Services\OrderService;
use App\Models\PurchaseOrderItem;
use Filament\Resources\Pages\Page;

use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Filament\Purchases\Resources\PRAssingResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class CreateOrder extends Page implements HasForms, HasTable
{
    use InteractsWithRecord;
    use InteractsWithTable;
    use InteractsWithForms;

    public $service;
    protected static string $resource = PRAssingResource::class;
    protected static string $view = 'filament.purchases.resources.p-r-assing-resource.pages.create-order';
    protected static ?string $title = 'Crear orden de compra';
    protected ?string $heading = 'Orden de compra';
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();
        return [
            // PRAssingResource::getUrl() => 'Courses',
            $resource::getUrl() => 'Requisiciones',
            $resource::getUrl('view', ['record' => $this->record]) => $this->record->folio,
            $this->getBreadcrumb()
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn(): HasMany => $this->record->items())
            ->modifyQueryUsing(function (Builder $query) {

                if (filled($this->record->orders)) {
                    $flattened = $this->record->orders->flatMap(function ($values) {
                        return $values->items;
                    });
                    $flattened = $flattened->pluck('product_id');
                    $query->whereInNot('product_id', $flattened);
                } else {
                    return $query;
                }
            })
            ->columns([
                TextColumn::make('product.name')
                    ->label('Producto'),
                TextColumn::make('quantity_requested')
                    ->label('Cantidad solicitada')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantity_warehouse')
                    ->label('Cantidad en almacén')
                    ->numeric()
                    ->sortable(),
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
            ->filters([
                //
            ])
            ->bulkActions([
                BulkAction::make('Agregar elementos  a la orden')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        $records->each(function ($record) {
                            PurchaseOrderItem::create([
                                'product_id'=> $record->product_id,
                                'quantity'=> $record->quantity_purchase
                            ]);
                        });
                        Notification::make()
                            ->title('Se agregaron los elementos a la orden')
                            ->success()
                            ->send();
                        $this->resetTable();
                    })
            ]);
    }
}
