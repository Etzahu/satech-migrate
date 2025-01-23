<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProvider;

use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\PurchaseRequisition;
use Filament\Forms\Components\Tabs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use App\Filament\Purchases\Resources\PurchaseOrder\AuthorizeResource\Pages;


class AuthorizeResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;
    protected static ?string $modelLabel = 'Orden';
    protected static ?string $pluralModelLabel = 'Orden';
    protected static ?string $navigationLabel = 'Autorizar';
    protected static ?string $slug = 'ordenes/autorizar';
    protected static ?string $navigationGroup = 'Orden';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 4;

    public static function canAccess(): bool
    {
        return auth()->user()->can('view_approve_level-4_purchase::order::purchaser');
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->authorize();
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
