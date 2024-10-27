<?php

namespace App\Filament\Purchases\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\PurchaseRequisition;
use Illuminate\Database\Eloquent\Builder;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use App\Filament\Purchases\Resources\PurchaseRequisitionReviewWareHouseResource\Pages;

class PurchaseRequisitionReviewWareHouseResource extends Resource
{

    protected static ?string $model = PurchaseRequisition::class;
    protected static ?string $modelLabel = 'Requisición';
    protected static ?string $pluralModelLabel = 'Requisiciones';
    protected static ?string $navigationLabel = 'Revisar por almacén';
    protected static ?string $slug = 'requisiciones-revisar-almacen';
    protected static ?string $navigationGroup = 'Requisiciones';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 2;



    public static function canAccess(): bool
    {
        return auth()->user()->can('view_review_warehouse_purchase::requisition');
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->reviewWarehouse()
            ->where('company_id', session()->get('company_id'));
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::reviewWarehouse()->count();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_delivery')
                    ->label('Fecha deseable de entrega')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePurchaseRequisitionReviewWareHouses::route('/'),
        ];
    }
}
