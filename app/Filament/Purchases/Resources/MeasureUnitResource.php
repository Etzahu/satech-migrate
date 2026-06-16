<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\MeasureUnitResource\Pages;
use App\Models\MeasureUnit;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class MeasureUnitResource extends Resource
{
    protected static ?string $model = MeasureUnit::class;

    protected static ?string $modelLabel = 'Unidad de medida';

    protected static ?string $pluralModelLabel = 'Unidades de medida';

    protected static ?string $navigationLabel = 'UM';

    protected static ?string $slug = 'um';

    protected static string|\UnitEnum|null $navigationGroup = 'Administración';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->unique(table: MeasureUnit::class, ignoreRecord: true)
                    ->maxLength(100),
                Forms\Components\TextInput::make('acronym')
                    ->label('Sigla')
                    ->required()
                    ->unique(table: MeasureUnit::class, ignoreRecord: true)
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('acronym')
                    ->label('Sigla')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Actions\EditAction::make(),
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
            'index' => Pages\ListMeasureUnits::route('/'),
            'create' => Pages\CreateMeasureUnit::route('/create'),
            'edit' => Pages\EditMeasureUnit::route('/{record}/edit'),
        ];
    }
}
