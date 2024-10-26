<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\ManagementResource\Pages;
use App\Filament\Purchases\Resources\ManagementResource\RelationManagers;
use App\Models\Management;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManagementResource extends Resource
{
    protected static ?string $model = Management::class;
    protected static ?string $modelLabel = 'Gerencia';
    protected static ?string $pluralModelLabel = 'Gerencias';
    protected static ?string $navigationLabel = 'Gerencias';
    protected static ?string $slug = 'gerencias';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 2;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->validationMessages([
                        'unique' => 'El :attribute ya esta registrado.',
                    ])
                    ->required()
                    ->unique(table: Management::class, ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('acronym')
                    ->label('Codigo')
                    ->validationMessages([
                        'unique' => 'El :attribute ya esta registrado.',
                    ])
                    ->required()
                    ->unique(table: Management::class, ignoreRecord: true)
                    ->maxLength(10),
                Forms\Components\Select::make('responsible_id')
                    ->label('Responsable')
                    ->relationship('responsible', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Gerencia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('responsible.name')
                    ->label('Responsable')
                    ->sortable(),
                Tables\Columns\TextColumn::make('acronym')
                    ->label('Código')
                    ->sortable(),
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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListManagement::route('/'),
            'create' => Pages\CreateManagement::route('/create'),
            'edit' => Pages\EditManagement::route('/{record}/edit'),
        ];
    }
}
