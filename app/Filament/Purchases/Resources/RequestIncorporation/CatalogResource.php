<?php

namespace App\Filament\Purchases\Resources\RequestIncorporation;

use Filament\Forms;
use Filament\Tables;
use App\Models\Brand;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CategoryFamily;
use Filament\Infolists\Infolist;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\Support\MediaStream;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Purchases\Resources\RequestIncorporation\CatalogResource\Pages;


class CatalogResource  extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $modelLabel = 'Producto/Servicio';
    protected static ?string $pluralModelLabel = 'Productos/Servicios';
    protected static ?string $navigationLabel = 'Producto/Servicio';
    protected static ?string $slug = 'altas/catalogo';
    protected static ?string $navigationGroup = 'Altas';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('solicita_requisicion_compra');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
        ->where('company_id', session()->get('company_id'))
            ->where('requester_id', auth()->user()->id);
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información general')
                    ->schema([
                        Forms\Components\Textarea::make('name')
                            ->label('Descripción del producto/servicio')
                            ->required()
                            ->maxLength(600)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('unit_id')
                            ->label('Unidad de medida')
                            ->relationship('unit', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),
                    ]),
                Forms\Components\Section::make('Documentación')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('documents')
                            ->label('Ficha técnica, etc')
                            ->hint('Puedes adjuntar más de un documento.')
                            ->hintColor('danger')
                            ->acceptedFileTypes(['application/pdf'])
                            ->collection('documents')
                            ->multiple(),
                    ])
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Información general')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Descripción del producto/servicio'),
                        Infolists\Components\TextEntry::make('unit.name')
                            ->label('Unidad de medida')
                    ]),
                Infolists\Components\Section::make('Documentación')
                    ->visible(fn($record) => $record->getMedia('documents')->count() > 0)
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('media')
                            ->state(function ($record) {
                                $record->media = $record->getMedia('documents');
                                return $record->media;
                            })
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Nombre del archivo'),
                            ]),
                        Infolists\Components\Actions::make([
                            Infolists\Components\Actions\Action::make('Descargar')
                                ->action(function ($record) {
                                    $downloads = $record->getMedia('documents');
                                    return MediaStream::create($record->code . '-documentos.zip')->addMedia($downloads);
                                }),
                        ]),
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
                    ->label('Descripción'),
                Tables\Columns\TextColumn::make('unit.name')
                    ->label('Unidad de medida')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus'),
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
            ])
        ;
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
        ];
    }
}
