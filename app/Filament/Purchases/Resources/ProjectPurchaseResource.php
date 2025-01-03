<?php

namespace App\Filament\Purchases\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProjectPurchase;
use Filament\Resources\Resource;
use Filament\Forms\Components\Actions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Purchases\Resources\ProjectPurchaseResource\Pages;
use Hugomyb\FilamentMediaAction\Forms\Components\Actions\MediaAction;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;
use App\Filament\Purchases\Resources\ProjectPurchaseResource\RelationManagers;

class ProjectPurchaseResource extends Resource
{
    protected static ?string $model = ProjectPurchase::class;
    protected static ?string $modelLabel = 'Proyecto';
    protected static ?string $pluralModelLabel = 'Proyectos';
    protected static ?string $navigationLabel = 'Proyectos';
    protected static ?string $slug = 'proyectos';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 5;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('company_id', session()->get('company_id'));
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información general')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Folio')
                            ->helperText('Debe empezar con ' . (session()->get('company_id') == 1 ? 'NP' : 'DN'))
                            ->unique(table: ProjectPurchase::class, ignoreRecord: true)
                            ->rules([
                                fn(): Closure => function (string $attribute, $value, Closure $fail) {
                                    if (session()->get('company_id') == 1) {
                                        if (!str($value)->startsWith('NP-')) {
                                            $fail('El :attribute debe comenzar con NP-');
                                        }
                                    }
                                    if (session()->get('company_id') == 2) {
                                        if (!str($value)->startsWith('DN-')) {
                                            $fail('El :attribute debe comenzar con DN-');
                                        }
                                    }
                                },
                            ])
                            ->validationMessages([
                                'unique' => 'El :attribute ya esta registrado.',
                            ])
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->unique(table: ProjectPurchase::class, ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'El :attribute ya esta registrado.',
                            ])
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('status')
                            ->label('Activo')
                            ->default(true)
                            ->required(),
                    ]),
                Forms\Components\Section::make('Documentacion para aprobacion por DG')
                    // ->visible(fn($operation) => $operation == 'edit')
                    ->schema([

                        SpatieMediaLibraryFileUpload::make('doc_1')
                            ->label('Ficha de proyecto')
                            ->acceptedFileTypes(['application/pdf'])
                            ->collection('project_sheet')
                            ->hintActions([
                                MediaAction::make('ver documento')
                                    ->visible(fn($operation, $state) => $operation == 'view' && filled($state))
                                    ->media(function ($state) {
                                        $key = array_keys($state);
                                        $media = Media::where('uuid', $key[0])->first();
                                        $url = Storage::url($media->getPathRelativeToRoot());
                                        return $url;
                                    })
                                    ->autoplay()
                                    ->preload(false),
                            ]),
                        SpatieMediaLibraryFileUpload::make('doc_2')
                            ->label('Cotización de cliente')
                            ->acceptedFileTypes(['application/pdf'])
                            ->collection('customer_quote')->hintActions([
                                MediaAction::make('ver documento')
                                    ->visible(fn($operation, $state) => $operation == 'view' && filled($state))
                                    ->media(function ($state) {
                                        $key = array_keys($state);
                                        $media = Media::where('uuid', $key[0])->first();
                                        $url = Storage::url($media->getPathRelativeToRoot());
                                        return $url;
                                    })
                                    ->autoplay()
                                    ->preload(false),
                            ]),
                        SpatieMediaLibraryFileUpload::make('doc_3')
                            ->label('Pedido')
                            ->acceptedFileTypes(['application/pdf'])
                            ->collection('order')
                            ->hintActions([
                                MediaAction::make('ver documento')
                                    ->visible(fn($operation, $state) => $operation == 'view' && filled($state))
                                    ->media(function ($state) {
                                        $key = array_keys($state);
                                        $media = Media::where('uuid', $key[0])->first();
                                        $url = Storage::url($media->getPathRelativeToRoot());
                                        return $url;
                                    })
                                    ->autoplay()
                                    ->preload(false),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Folio'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')
                    ->sortable(),
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
    // public static function getRelations(): array
    // {
    //     return [
    //         RelationManagers\CategoriesRelationManager::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectPurchases::route('/'),
            'create' => Pages\CreateProjectPurchase::route('/create'),
            'view' => Pages\ViewProjectPurchase::route('/{record}'),
            'edit' => Pages\EditProjectPurchase::route('/{record}/edit'),
        ];
    }
}
