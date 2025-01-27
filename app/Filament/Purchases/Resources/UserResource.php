<?php

namespace App\Filament\Purchases\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Purchases\Resources\UserResource\Pages;
use App\Filament\Purchases\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'Usuario';
    protected static ?string $pluralModelLabel = 'Usuarios';
    protected static ?string $navigationLabel = 'Usuarios';
    protected static ?string $slug = 'usuarios';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->label('Correo')
                                    ->required()
                                    ->email('gptservices')
                                    ->endsWith(['@gptservices.com'])
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone')
                                    ->label('Celular')
                                    ->tel()
                                    ->maxLength(20),
                                Forms\Components\Select::make('management_id')
                                    ->label('Gerencia')
                                    ->relationship('management', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\TextInput::make('puesto')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\Toggle::make('active')
                                    ->default(1)
                                    ->required(),

                            ]),
                        Forms\Components\Tabs\Tab::make('Roles')
                            ->schema([
                                // Forms\Components\Select::make('roles')
                                //     ->relationship('roles', 'name')
                                //     ->multiple()
                                //     ->preload()
                                //     ->searchable(),
                                Forms\Components\CheckboxList::make('roles')
                                    ->relationship('roles', 'name')
                                    ->searchable(),
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('management.name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
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
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
        ;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
