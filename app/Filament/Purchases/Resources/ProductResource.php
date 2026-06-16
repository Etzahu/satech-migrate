<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\ProductResource\Pages;
use App\Models\Brand;
use App\Models\CategoryFamily;
use App\Models\Product;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $modelLabel = 'Catálogo';

    protected static ?string $pluralModelLabel = 'Catálogo';

    protected static ?string $navigationLabel = 'Catálogo';

    protected static ?string $slug = 'catálogo';

    protected static string|\UnitEnum|null $navigationGroup = 'Administración';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 4;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('gerente_compras') || auth()->user()->hasRole('super_admin') ||
            auth()->user()->hasRole('administrador_compras');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pendiente')
            ->where('company_id', session()->get('company_id'))->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make('')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Código')
                            ->visible(fn (string $operation) => $operation == 'edit')
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
                        Forms\Components\Select::make('type_purchase')
                            ->label('Tipo de compra')
                            ->options([
                                'servicio' => 'Servicio',
                                'proveeduria' => 'Proveeduría',
                            ])
                            ->required(),
                        Forms\Components\Select::make('category_family_id')
                            ->label('Familia')
                            ->options(
                                function (Get $get) {
                                    $options = [];
                                    $data = CategoryFamily::query()
                                        ->where('category_id', $get('category_id'))
                                        ->select('id', 'name', 'type', 'code')
                                        ->get();
                                    if (filled($data)) {
                                        foreach ($data as $value) {
                                            $type = strtoupper($value->type);
                                            $options[$type][$value->id] = $value->name.' ('.$value->code.')';
                                        }
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
                            ->options(Brand::orderBy('name', 'asc')->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ]),
                Schemas\Components\Section::make('')
                    ->visible(fn ($operation) => $operation == 'view' || $operation == 'create')
                    ->schema([
                        Forms\Components\Checkbox::make('automatic_code')
                            ->label('Generar código de forma automática'),
                    ]),
                Schemas\Components\Section::make('')
                    ->schema([
                        Textarea::make('name')
                            ->label('Nombre del producto/servicio')
                            ->required()
                            ->maxLength(600)
                            ->rows(8)
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
                    ->label('Nombre')
                    ->words(5)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus'),
                Tables\Columns\TextColumn::make('type_purchase')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'servicio' => 'info',
                        'proveeduria' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'servicio' => 'Servicio',
                        'proveeduria' => 'Producto',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('unit.name')
                    ->label('Unidad de medida'),
                Tables\Columns\TextColumn::make('requester.name')
                    ->label('Solicitante')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualización')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // Actions\ViewAction::make(),
                Actions\EditAction::make()
                    ->visible(fn ($record) => $record->status == 'aprobado' || $record->status == 'pendiente'),
            ])
            ->toolbarActions([
                Actions\BulkAction::make('aceptar')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        try {
                            $records->each(function ($item) {
                                $item->status()->transitionTo('aprobado');
                            });
                            Notification::make()
                                ->title('Respuesta enviada')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            logger()->error($e->getMessages());
                            Notification::make()
                                ->title('Ocurrió un error.')
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->checkIfRecordIsSelectableUsing(
                fn (Model $record): bool => $record->status == 'pendiente',
            );
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
