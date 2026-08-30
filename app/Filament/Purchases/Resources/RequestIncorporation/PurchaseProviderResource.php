<?php

namespace App\Filament\Purchases\Resources\RequestIncorporation;

use App\Filament\Purchases\Resources\RequestIncorporation\PurchaseProviderResource\Pages;
use App\Filament\Purchases\Resources\RequestIncorporation\PurchaseProviderResource\RelationManagers;
use App\Models\PurchaseProvider;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Njxqlus\Filament\Components\Forms\RelationManager;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PurchaseProviderResource extends Resource
{
    protected static ?string $model = PurchaseProvider::class;

    protected static ?string $modelLabel = 'Proveedor';

    protected static ?string $pluralModelLabel = 'Proveedores';

    protected static ?string $navigationLabel = 'Proveedores';

    protected static ?string $slug = 'altas/proveedores';

    protected static string|\UnitEnum|null $navigationGroup = 'Altas';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('comprador');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->columns(1)
            ->schema([
                Schemas\Components\Tabs::make('tabs')
                    ->schema([
                        Schemas\Components\Tabs\Tab::make('Información general')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('rfc')
                                    ->label('RFC')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(30),
                                Forms\Components\TextInput::make('company_name')
                                    ->label('Razón social')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('street')
                                    ->label('Calle')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('number')
                                    ->label('Número #')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('neighborhood')
                                    ->label('Colonia')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('municipality')
                                    ->label('Municipio')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('state')
                                    ->label('Estado')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('country')
                                    ->label('País')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('cp')
                                    ->label('Código postal')
                                    ->required()
                                    ->maxLength(10),
                                Forms\Components\TextInput::make('web_company')
                                    ->label('Sitio web  de la empresa')
                                    ->nullable()
                                    ->maxLength(255),
                            ]),
                        Schemas\Components\Tabs\Tab::make('Cuenta bancaria')
                            ->schema([
                                Forms\Components\Select::make('bank')
                                    ->label('Banco')
                                    ->required()
                                    ->searchable()
                                    ->options([
                                        'ABC CAPITAL',
                                        'AFIRME',
                                        'AMERICAN EXPRESS',
                                        'ANÁHUAC',
                                        'ATLÁNTICO',
                                        'AUTOFIN',
                                        'AZTECA',
                                        'BAJÍO',
                                        'BAMSA',
                                        'BANAMEX',
                                        'BANCEN',
                                        'BANCO FAMSA',
                                        'BANCO MULTIVA',
                                        'BANCOPPEL',
                                        'BANCREA',
                                        'Bancrecer, S.A.',
                                        'BANK NEW YORK',
                                        'BANK OF CHINA',
                                        'BANK ONE',
                                        'BANKAOOL',
                                        'BANORTE/IXE',
                                        'BANPAÍS',
                                        'BANREGIO',
                                        'BANSI',
                                        'BARCLAYS',
                                        'BBVA BANCOMER',
                                        'BBVA SERVICIOS',
                                        'BICENTENARIO',
                                        'BM ACTINVER',
                                        'BM BASE',
                                        'BNP',
                                        'BOSTON',
                                        'CAPITAL',
                                        'CHASE BANK',
                                        'CHIHUAHUA',
                                        'CIBANCO',
                                        'CITIBANK',
                                        'COMPARTAMOS',
                                        'CONFÍA',
                                        'CONSUBANCO',
                                        'Credit Suisse First Boston',
                                        'CREMI',
                                        'DEUTSCHE',
                                        'DONDÉ',
                                        'FINTERRA',
                                        'FORJADORES',
                                        'FUJI',
                                        'GE MONEY',
                                        'HSBC',
                                        'INBURSA',
                                        'INDUSTRIAL',
                                        'ING',
                                        'INMOBILIARIO',
                                        'INTERACCIONES',
                                        'INTERBANCO',
                                        'INTERCAM BANCO',
                                        'INVESTA BANK',
                                        'INVEX',
                                        'IXE',
                                        'JP MORGAN',
                                        'MIFEL',
                                        'MONEX',
                                        'NATIONSBANK',
                                        'OBRERO',
                                        'ORIENTE',
                                        'PAGATODO',
                                        'PROMEX',
                                        'PRONORTE',
                                        'QUADRUM',
                                        'REPUBLIC NY',
                                        'SANTANDER',
                                        'SCOTIABANK INVERLAT',
                                        'SERFIN',
                                        'SOCIÉTÉ',
                                        'SURESTE',
                                        'TOKYO',
                                        'UBS BANK',
                                        'UNIÓN',
                                        'VE POR MÁS',
                                        'VOLKSWAGEN',
                                        'WAL-MART',
                                    ]),
                                Forms\Components\TextInput::make('bank_account')
                                    ->label('Cuenta de banco')
                                    ->maxLength(30)
                                    ->required(),
                                Forms\Components\TextInput::make('bank_account_number')
                                    ->label('Clabe')
                                    ->maxLength(30)
                                    ->required(),
                            ]),
                        Schemas\Components\Tabs\Tab::make('Documentacion')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('doc_1')
                                    ->label('Hoja de datos bancarios')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->collection('bank_data_sheet')
                                    ->hintActions([
                                        // MediaAction::make('ver documento')
                                        //     ->visible(fn($operation, $state) => $operation == 'view' && filled($state))
                                        //     ->media(function ($state) {
                                        //         $key = array_keys($state);
                                        //         $media = Media::where('uuid', $key[0])->first();
                                        //         $url = Storage::url($media->getPathRelativeToRoot());
                                        //         return $url;
                                        //     })
                                        //     ->autoplay()
                                        //     ->preload(false),
                                    ]),
                                SpatieMediaLibraryFileUpload::make('doc_2')
                                    ->label('Constancia de situación fiscal')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->collection('cfdi')->hintActions([
                                        // MediaAction::make('ver documento')
                                        //     ->visible(fn($operation, $state) => $operation == 'view' && filled($state))
                                        //     ->media(function ($state) {
                                        //         $key = array_keys($state);
                                        //         $media = Media::where('uuid', $key[0])->first();
                                        //         $url = Storage::url($media->getPathRelativeToRoot());
                                        //         return $url;
                                        //     })
                                        //     ->autoplay()
                                        //     ->preload(false),
                                    ]),
                            ]),
                        Schemas\Components\Tabs\Tab::make('Contactos')
                            ->visible(fn ($operation) => $operation !== 'create')
                            ->schema([
                                RelationManager::make()->manager(RelationManagers\ContactsRelationManager::class)->lazy(true),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rfc')
                    ->label('RFC')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Razón social')
                    ->searchable(),
                Tables\Columns\TextColumn::make('userRequest.name')
                    ->label('Alta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'revisión' => 'warning',
                        'rechazado' => 'danger',
                        'aprobado' => 'success',
                        'borrador' => 'info',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualización')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseProviders::route('/'),
            'create' => Pages\CreatePurchaseProvider::route('/create'),
            'view' => Pages\ViewPurchaseProvider::route('/{record}'),
            'edit' => Pages\EditPurchaseProvider::route('/{record}/edit'),
        ];
    }
}
