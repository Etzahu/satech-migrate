<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder;


use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\PurchaseOrder;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource\Pages;

class HistoryResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;
    protected static ?string $modelLabel = 'Orden';
    protected static ?string $pluralModelLabel = 'Historial de órdenes';
    protected static ?string $navigationLabel = 'Historial';
    protected static ?string $slug = 'orden-historial';
    protected static ?string $navigationGroup = 'Orden';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 12;

    public static function canAccess(): bool
    {
        return
            auth()->user()->hasRole('comprador') ||
            auth()->user()->hasRole('gerente_solicitante_orden_compra') ||
            auth()->user()->hasRole('autoriza_nivel-1-orden_compra') ||
            auth()->user()->hasRole('autoriza_nivel-2-orden_compra') ||
            auth()->user()->hasRole('gerente_compras') ||
            auth()->user()->hasRole('super_admin') ||
            auth()->user()->hasRole('administrador_compras');
    }
    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        $options = [];
        return PurchaserResource::infolist($infolist, $options);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provider.company_name')
                    ->label('Proveedor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('requisition.folio')
                    ->label('Requisición')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualización')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Creados desde'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Creados hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('Ver pdf')
                        ->icon('heroicon-m-document')
                        ->url(fn($record) => (string)route('order.pdf', ['id' => $record->id]))
                        ->openUrlInNewTab(),
                ]),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePR::route('/'),
            'view' => Pages\View::route('/{record}'),
        ];
    }
}
