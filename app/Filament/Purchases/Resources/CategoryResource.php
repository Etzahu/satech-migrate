<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\CategoryResource\Pages;
use App\Filament\Purchases\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $modelLabel = 'Categoría';
    protected static ?string $pluralModelLabel = 'Categorías';
    protected static ?string $navigationLabel = 'Categorías';
    protected static ?string $slug = 'categorias';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 6;


    // TODO: al crear una nueva categoria se debe vincular dependiedo si es una categoria para NP-DN,stock o servicios generales
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nombre')
                        ->unique(table: Category::class, ignoreRecord: true)
                        ->required()
                        ->maxLength(100),
                    Forms\Components\TextInput::make('code')
                        ->unique(table: Category::class, ignoreRecord: true)
                        ->label('Código')
                        ->required()
                        ->maxLength(30),
                ]),
                Forms\Components\Section::make('')
                ->visible(fn($operation)=> $operation == 'view' || $operation == 'edit')
                ->schema([
                    \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(RelationManagers\FamiliesRelationManager::class)->lazy(true)
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('Código')
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
        ;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
