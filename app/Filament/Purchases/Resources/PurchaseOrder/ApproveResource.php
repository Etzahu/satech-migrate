<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\PurchaseOrder;


use Filament\Infolists\Infolist;
use Filament\Resources\Resource;

use Illuminate\Database\Eloquent\Builder;

use App\Filament\Purchases\Resources\PurchaseOrder\ApproveResource\Pages;


class ApproveResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;
    protected static ?string $modelLabel = 'Orden';
    protected static ?string $pluralModelLabel = 'Orden';
    protected static ?string $navigationLabel = 'Aprobar';
    protected static ?string $slug = 'ordenes/aprobar';
    protected static ?string $navigationGroup = 'Orden';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 4;

    public static function canAccess(): bool
    {
        return auth()->user()->can('view_approve-level-3_purchase::order::purchaser');
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
    public static function infolist(Infolist $infolist): Infolist
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
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
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

