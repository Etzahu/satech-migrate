<?php

namespace App\Filament\Purchases\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Brand;
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
    protected static ?string $modelLabel = 'Catálogo';
    protected static ?string $pluralModelLabel = 'Catálogo';
    protected static ?string $navigationLabel = 'Catálogo';
    protected static ?string $slug = 'catálogo';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 4;


    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('gerente_compras') || auth()->user()->hasRole('super_admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Código')
                            ->visible(fn(string $operation) => $operation == 'edit')
                            ->required(),
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
                        Forms\Components\Select::make('brand_id')
                            ->label('Márca')
                            ->options(Brand::all()->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ]),
                Forms\Components\Section::make('')
                    ->visible(fn($operation) => $operation == 'view' || $operation == 'create')
                    ->schema([
                        Forms\Components\Checkbox::make('automatic_code')
                            ->label('Generar código de forma automática')
                    ]),
                Forms\Components\Section::make('')
                    ->schema([
                        Forms\Components\Textarea::make('name')
                            ->label('Nombre del producto/servicio')
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus'),
                Tables\Columns\TextColumn::make('unit.name')
                    ->label('Unidad de medida')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoría')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualización')
                    ->dateTime('d-m-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn($record) => $record->status == 'aprobado' || $record->status == 'pendiente'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
