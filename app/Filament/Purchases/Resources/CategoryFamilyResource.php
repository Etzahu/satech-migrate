<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\CategoryFamilyResource\Pages;
use App\Filament\Purchases\Resources\CategoryFamilyResource\RelationManagers;
use App\Models\CategoryFamily;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryFamilyResource extends Resource
{
    protected static ?string $model = CategoryFamily::class;
    protected static ?string $modelLabel = 'Familia';
    protected static ?string $pluralModelLabel = 'Familias';
    protected static ?string $navigationLabel = 'Familias';
    protected static ?string $slug = 'familias';
    protected static bool $shouldRegisterNavigation = false;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(30),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
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
            'index' => Pages\ListCategoryFamilies::route('/'),
            'create' => Pages\CreateCategoryFamily::route('/create'),
            'edit' => Pages\EditCategoryFamily::route('/{record}/edit'),
        ];
    }
}
