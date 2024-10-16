<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\MeasureUnitResource\Pages;
use App\Filament\Purchases\Resources\MeasureUnitResource\RelationManagers;
use App\Models\MeasureUnit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MeasureUnitResource extends Resource
{
    protected static ?string $model = MeasureUnit::class;
    protected static ?string $modelLabel = 'Unidad de medida';
    protected static ?string $pluralModelLabel = 'Unidades de medida';
    protected static ?string $navigationLabel = 'UM';
    protected static ?string $slug = 'um';
    protected static ?string $navigationGroup = 'Bienes y servicios';
    protected static ?string $navigationIcon = 'heroicon-o-minus';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
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
            'index' => Pages\ListMeasureUnits::route('/'),
            'create' => Pages\CreateMeasureUnit::route('/create'),
            'edit' => Pages\EditMeasureUnit::route('/{record}/edit'),
        ];
    }
}
