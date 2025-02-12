<?php

namespace App\Filament\Purchases\Resources\RequestIncorporation;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PurchaseProvider;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Purchases\Resources\RequestIncorporation\PurchaseProviderResource\Pages;
use Hugomyb\FilamentMediaAction\Forms\Components\Actions\MediaAction;
use App\Filament\Purchases\Resources\RequestIncorporation\PurchaseProviderResource\RelationManagers;

class PurchaseProviderResource extends Resource
{
    protected static ?string $model = PurchaseProvider::class;
    protected static ?string $modelLabel = 'Proveedor';
    protected static ?string $pluralModelLabel = 'Proveedores';
    protected static ?string $navigationLabel = 'Proveedores';
    protected static ?string $slug = 'altas/proveedores';
    protected static ?string $navigationGroup = 'Altas';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('comprador');
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_request_id', auth()->user()->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Tabs::make('tabs')
                    ->schema([
                        Forms\Components\Tabs\Tab::make('Información general')
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
                        Forms\Components\Tabs\Tab::make('Cuenta bancaria')
                            ->schema([
                                Forms\Components\Select::make('bank')
                                    ->label('Banco')
                                    ->required()
                                    ->searchable()
                                    ->options([
                                        'BANAMEX',
                                        'SERFIN',
                                        'ATLÁNTICO',
                                        'CITIBANK',
                                        'UNIÓN',
                                        'CONFÍA',
                                        'BBVA BANCOMER',
                                        'INDUSTRIAL',
                                        'SANTANDER',
                                        'INTERBANCO',
                                        'BBVA SERVICIOS',
                                        'HSBC',
                                        'GE MONEY',
                                        'SURESTE',
                                        'CAPITAL',
                                        'BAJÍO',
                                        'IXE',
                                        'INBURSA',
                                        'INTERACCIONES',
                                        'MIFEL',
                                        'SCOTIABANK INVERLAT',
                                        'PRONORTE',
                                        'QUADRUM',
                                        'BANREGIO',
                                        'INVEX',
                                        'BANSI',
                                        'AFIRME',
                                        'ANÁHUAC',
                                        'PROMEX',
                                        'BANPAÍS',
                                        'BANORTE/IXE',
                                        'ORIENTE',
                                        'BANCEN',
                                        'CREMI',
                                        'INVESTA BANK',
                                        'AMERICAN EXPRESS',
                                        'SANTANDER',
                                        'BAMSA',
                                        'BOSTON',
                                        'TOKYO',
                                        'BNP',
                                        'JP MORGAN',
                                        'MONEX',
                                        'VE POR MÁS',
                                        'BANK ONE',
                                        'FUJI',
                                        'ING',
                                        'NATIONSBANK',
                                        'REPUBLIC NY',
                                        'SOCIÉTÉ',
                                        'DEUTSCHE',
                                        'Credit Suisse First Boston',
                                        'AZTECA',
                                        'AUTOFIN',
                                        'BARCLAYS',
                                        'COMPARTAMOS',
                                        'BANCO FAMSA',
                                        'BANCO MULTIVA',
                                        'BM ACTINVER',
                                        'WAL-MART',
                                        'INTERCAM BANCO',
                                        'BANCOPPEL',
                                        'ABC CAPITAL',
                                        'UBS BANK',
                                        'CONSUBANCO',
                                        'VOLKSWAGEN',
                                        'CIBANCO',
                                        'BANK NEW YORK',
                                        'BM BASE',
                                        'BICENTENARIO',
                                        'BANKAOOL',
                                        'PAGATODO',
                                        'FORJADORES',
                                        'INMOBILIARIO',
                                        'DONDÉ',
                                        'BANCREA',
                                        'CHIHUAHUA',
                                        'FINTERRA',
                                        'BANK OF CHINA',
                                        'Bancrecer, S.A.',
                                        'OBRERO',
                                    ]),
                                Forms\Components\TextInput::make('bank_account')
                                    ->label('Cuenta de banco')
                                     ->maxLength(30)
                                    ->required(),
                                Forms\Components\TextInput::make('bank_account_number')
                                    ->label('Clabe')
                                     ->maxLength(30)
                                    ->required()
                            ]),
                        Forms\Components\Tabs\Tab::make('Documentacion')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('doc_1')
                                    ->label('Hoja de datos bancarios')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->collection('bank_data_sheet')
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
                                    ->label('Constancia de situación fiscal')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->collection('cfdi')->hintActions([
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
                        Forms\Components\Tabs\Tab::make('Contactos')
                            ->visible(fn($operation) => $operation !== 'create')
                            ->schema([
                                \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(RelationManagers\ContactsRelationManager::class)->lazy(true)
                            ])
                    ])
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
                    ->color(fn(string $state): string => match ($state) {
                        'revisión' => 'warning',
                        'rechazado' => 'danger',
                        'aprobado' => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
        ;
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
