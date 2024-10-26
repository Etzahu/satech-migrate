<?php

namespace App\Filament\Purchases\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CategoryFamily;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Purchases\Resources\ProductResource\Pages;
use App\Filament\Purchases\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $modelLabel = 'Producto';
    protected static ?string $pluralModelLabel = 'Productos';
    protected static ?string $navigationLabel = 'Productos';
    protected static ?string $slug = 'productos';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 4;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Categoría')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('category_family_id', null);
                            })
                            ->required(),
                        Forms\Components\Select::make('category_family_id')
                            ->label('Familia')
                            ->options(
                                function (Get $get) {
                                    $options = [];
                                    $data =  CategoryFamily::query()
                                        ->where('category_id', $get('category_id'))
                                        ->select('id', 'name', 'type', 'code')
                                        ->get();
                                    if (filled($data)) {
                                        foreach ($data as $value) {
                                            $type = strtoupper($value->type);
                                            $options[$type][$value->id] = $value->name . ' (' . $value->code . ')';
                                        }
                                        logger($options);
                                    }
                                    return $options;
                                }
                            )
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
                    ]),
                Forms\Components\Section::make('')
                    ->schema([
                        Forms\Components\Textarea::make('name')
                            ->label('Nombre del producto')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('unit_id')
                            ->label('Unidad de medida')
                            ->relationship('unit', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Código')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit.name')
                    ->label('Unidad de medida')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoría')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
