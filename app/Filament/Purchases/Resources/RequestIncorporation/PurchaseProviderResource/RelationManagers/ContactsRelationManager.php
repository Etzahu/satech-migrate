<?php

namespace App\Filament\Purchases\Resources\RequestIncorporation\PurchaseProviderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';
    protected static ?string $modelLabel = 'Contacto';
    protected static ?string $pluralModelLabel = 'Contacto';
    protected static ?string $navigationLabel = 'Contacto';
    protected static ?string $title = 'Contacto';
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('job')
                    ->label('Puesto')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Correo')
                    ->required()
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cell_phone')
                    ->label('Celular')
                    ->required()
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('Teléfono de la empresa')
                    ->nullable()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('job')
                    ->label('Puesto'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo'),
                Tables\Columns\TextColumn::make('cell_phone')
                    ->label('Celular'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono de la empresa'),
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
