<?php

namespace App\Filament\Purchases\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FamiliesRelationManager extends RelationManager
{
    protected static string $relationship = 'families';
    protected static ?string $modelLabel = 'Familia';
    protected static ?string $pluralModelLabel = 'Familias';
    protected static ?string $navigationLabel = 'Familias';
    protected static ?string $title = 'Familias';
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('code')
                    ->label('Código')
                    ->required()
                    ->maxLength(30),
                Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->options([
                        'DN-NP' => 'DN-NP',
                        'Stock' => 'Stock',
                        'Servicios generales' => 'Servicios generales',
                    ])
                    ->required()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('code')
                    ->label('Código'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
        ;
    }
}
