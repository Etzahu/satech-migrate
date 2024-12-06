<?php

namespace App\Filament\Purchases\Resources\PurchaseOrderResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    protected static ?string $modelLabel = 'Partida';
    protected static ?string $pluralModelLabel = 'Partidas';
    protected static ?string $navigationLabel = 'Partidas';
    protected static ?string $title = 'Partida';

    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\TextInput::make('quantity')
                    ->label('Cantidad')
                    ->required()
                    ->minValue(0)
                    ->integer(),
                MoneyInput::make('unit_price')
                    ->label('Precio unitario')
                    ->required()
                    ->minValue(0)
                    ->numeric(),
                Forms\Components\Select::make('product_id')
                    ->label('Producto/Servicio')
                    ->options(Product::all()->pluck('name', 'id'))
                    ->searchPrompt('Busca los productos o servicios por su descripción')
                    ->searchable()
                    ->columnSpan('full'),
                Forms\Components\Textarea::make('observation')
                    ->label('Observaciones')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('quantity')
            ->columns([
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Cantidad'),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Producto/Servicio'),
                MoneyColumn::make('unit_price')
                    ->label('Precio unitario'),
            ])

            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
