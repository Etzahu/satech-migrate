<?php

namespace App\Filament\Purchases\Resources\PurchaserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
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
    protected static ?string $title = 'Partidas';

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
                    ->currency('MXN')
                    ->locale('es_MX')
                    ->required()
                    ->minValue(0)
                    ->numeric(),
                Forms\Components\Select::make('product_id')
                    ->label('Producto/Servicio')
                    ->options(Product::all()->pluck('name', 'id'))
                    ->searchPrompt('Busca los productos o servicios por su descripción')
                    ->searchable()
                    ->noSearchResultsMessage('No se encontró el producto/servicio.')
                    ->columnSpan('full'),
                Forms\Components\Textarea::make('observation')
                    ->label('Observaciones')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product.name')
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Producto/Servicio'),
                Tables\Columns\TextColumn::make('product.unit.acronym')
                    ->label('Unidad'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Cantidad'),
                MoneyColumn::make('unit_price')
                    ->currency('MXN')
                    ->locale('es_MX')
                    ->label('Precio unitario'),
                // ->summarize(Sum::make()->money('MXN', divideBy: 100, locale: 'es_MX')),
                MoneyColumn::make('sub_total')
                    ->currency('MXN')
                    ->locale('es_MX')
                    ->label('Importe')
                    ->summarize(Sum::make()->label('Subtotal')->money('MXN', divideBy: 100, locale: 'es_MX')),
            ])

            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['sub_total'] = $data['quantity'] * $data['unit_price'];
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading(fn($record) => "Editar partida {$record->product->name}")
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['sub_total'] = $data['quantity'] * $data['unit_price'];
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
