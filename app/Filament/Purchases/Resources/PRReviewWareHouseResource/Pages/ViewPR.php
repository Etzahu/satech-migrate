<?php

namespace App\Filament\Purchases\Resources\PRReviewWareHouseResource\Pages;


use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Services\PRMediaService;
use Filament\Infolists\Infolist;
use App\Models\PurchaseRequisitionItem;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Actions\Action as ActionTable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Filament\Purchases\Resources\PRReviewWareHouseResource;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;


class ViewPR extends ViewRecord  implements HasTable
{
    use InteractsWithTable;
    use InteractsWithInfolists;
    use InteractsWithRecord;

    protected static string $resource = PRReviewWareHouseResource::class;
    protected static string $view = 'filament.purchases.resources.pr-review-warehouse-resource.pages.view';
    protected function getHeaderActions(): array
    {
        return [
            Action::make('Enviar revisión')
                ->visible(fn() => $this->record->status()->canBe('revisión'))
                ->color('success')
                ->form([
                    Textarea::make('observation')
                        ->label('Observación'),
                ])
                ->requiresConfirmation()
                ->action(function (array $data) {
                    $this->record->status()->transitionTo('revisión', ['respuesta' => $data['observation']]);
                    Notification::make()
                        ->title('Respuesta enviada')
                        ->success()
                        ->send();
                    return redirect()->route('filament.compras.resources.requisiciones.revisar.almacen.index');
                }),
            Action::make('Ver pdf')
                ->color('danger')
                ->icon('heroicon-m-document')
                // ->url(fn(): string => route('compras.requisiciones.pdf', ['id' => $this->record->id]))
                // ->url(fn(): string => route('filament.compras.resources.mis-requisiciones.pdf', ['record' => $this->record->id]))
                ->openUrlInNewTab()
        ];
    }
    public function infolist(Infolist $infolist): Infolist
    {
        $service = new PRMediaService();
        return $service->generateInfolist($infolist, $this->record);
    }
    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn(): HasMany => $this->record->items())
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Producto'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Cantidad')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                ActionTable::make('Ver')
                    ->color('gray')
                    ->icon('heroicon-m-eye')
                    ->modalHeading('Ver partida')
                    ->modalSubmitAction(false)
                    ->fillForm(fn(PurchaseRequisitionItem $record): array => [
                        'product' => $record->product->name,
                        'um' => $record->product->unit->name,
                        'quantity' => $record->quantity,
                        'observation' => $record->observation,
                    ])
                    ->form([
                        TextInput::make('product')
                            ->label('Producto'),
                        TextInput::make('quantity')
                            ->label('Cantidad'),
                        TextInput::make('um')
                            ->label('Unidad de medida'),
                        TextArea::make('observation')
                            ->label('Observaciones')
                    ])
                    ->disabledForm(),
                ActionTable::make('Editar cantidad')
                    ->action(function (array $data, PurchaseRequisitionItem $record): void {
                        dd($record);
                    }),

            ]);
    }
}
