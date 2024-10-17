<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\ProjectUsageResource\Pages;
use App\Filament\Purchases\Resources\ProjectUsageResource\RelationManagers;
use App\Models\ProjectUsage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectUsageResource extends Resource
{
    protected static ?string $model = ProjectUsage::class;

    protected static ?string $modelLabel = 'Necesidad de proyecto';
    protected static ?string $pluralModelLabel = 'Necesidad de proyectos';
    protected static ?string $navigationLabel = 'Necesidad de proyectos';
    protected static ?string $slug = 'proyectos-necesidad';
    // protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationIcon = 'heroicon-o-minus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
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
            'index' => Pages\ListProjectUsages::route('/'),
            'create' => Pages\CreateProjectUsage::route('/create'),
            'edit' => Pages\EditProjectUsage::route('/{record}/edit'),
        ];
    }
}
