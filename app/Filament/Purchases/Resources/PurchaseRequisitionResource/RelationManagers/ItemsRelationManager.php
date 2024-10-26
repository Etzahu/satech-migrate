<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisitionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    protected static ?string $modelLabel = 'Partida';
    protected static ?string $pluralModelLabel = 'partidas';
    protected static ?string $navigationLabel = 'partidas';
    protected static ?string $slug = 'partidas';
    protected static ?string $title = 'Partida';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('quantity')
                    ->label('Cantidad')
                    ->integer()
                    ->minValue(1)
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('observation')
                    ->label('Observación')
                    ->nullable()
                    ->maxLength(600)
                    ->columnSpanFull(),
                // Forms\Components\Select::make('requisition_id')
                //     ->relationship('requisition', 'id')
                //     ->required(),
                Forms\Components\Select::make('product_id')
                    ->label('Producto')
                    ->searchable()
                    ->relationship('product', 'name')
                    ->required(),
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
                    ->label('Producto'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible($this->getOwnerRecord()->status == 'borrador'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->visible($this->getOwnerRecord()->status == 'borrador'),
                Tables\Actions\DeleteAction::make()->visible($this->getOwnerRecord()->status == 'borrador'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
