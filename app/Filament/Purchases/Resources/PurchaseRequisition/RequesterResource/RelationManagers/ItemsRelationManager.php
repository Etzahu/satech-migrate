<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\RelationManagers;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

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
                Forms\Components\TextInput::make('quantity_requested')
                    ->label('Cantidad solicitada')
                    ->numeric()
                    ->required()
                    ->minValue(1),
                Forms\Components\Select::make('product_id')
                    ->label('Producto')
                    ->options(Product::whereNotIn('id', $this->ownerRecord->items->pluck('product_id'))->pluck('name', 'id'))
                    ->searchable()
                    ->live()
                    ->required(),
                Forms\Components\Textarea::make('observation')
                    ->label('Observación')
                    ->maxLength(600),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Producto'),
                Tables\Columns\TextColumn::make('quantity_requested')
                    ->label('Cantidad solicitada')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_warehouse')
                    ->label('Cantidad en almacén')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_purchase')
                    ->label('Cantidad a comprar')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('observation')
                    ->label('Observación'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['quantity_purchase'] = $data['quantity_requested'];
                        return $data;
                    })
                    ->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
