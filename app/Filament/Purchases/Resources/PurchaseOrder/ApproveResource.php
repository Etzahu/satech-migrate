<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder;

use App\Filament\Purchases\Resources\PurchaseOrder\ApproveResource\Pages;
use App\Models\PurchaseOrder;
use App\Services\PurchaseOrderChainResolver;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ApproveResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;

    protected static ?string $modelLabel = 'Orden';

    protected static ?string $pluralModelLabel = 'Orden';

    protected static ?string $navigationLabel = 'Aprobar';

    protected static ?string $slug = 'ordenes/aprobar';

    protected static string|\UnitEnum|null $navigationGroup = 'Orden';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 4;

    /**
     * Misma regla que en ReviewResource: manda la cadena, no el rol. El listado
     * filtra por `chain.authorizer_id`, así que el acceso debe leer lo mismo.
     */
    public static function canAccess(): bool
    {
        return app(PurchaseOrderChainResolver::class)->canAccessAuthorization(auth()->user());
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->approve();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::approve()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function infolist(Schema $infolist): Schema
    {
        $options[] = 'show_relation_items';

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
            ->filters([])
            ->recordActions([
                Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}/ver'),
        ];
    }
}
