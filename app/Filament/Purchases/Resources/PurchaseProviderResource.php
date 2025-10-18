<?php

namespace App\Filament\Purchases\Resources;

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
use App\Filament\Purchases\Resources\PurchaseProviderResource\Pages;
use App\Filament\Purchases\Resources\PurchaseProviderResource\RelationManagers;

class PurchaseProviderResource extends Resource
{
    protected static ?string $model = PurchaseProvider::class;
    protected static ?string $modelLabel = 'Proveedor';
    protected static ?string $pluralModelLabel = 'Proveedores';
    protected static ?string $navigationLabel = 'Proveedores';
    protected static ?string $slug = 'proveedores';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?int $navigationSort = 11;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('gerente_compras') || auth()->user()->hasRole('administrador_compras') || auth()->user()->hasRole('super_admin');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'revisión')->count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
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
                                    ->default('NA')
                                    ->nullable()
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
                                        'NO APLICA',
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
                                        'BANKAOOL',
                                        'BANORTE/IXE',
                                        'BANPAÍS',
                                        'BANREGIO',
                                        'BANSI',
                                        'BANK NEW YORK',
                                        'BANK OF CHINA',
                                        'BANK ONE',
                                        'BARCLAYS',
                                        'BBVA BANCOMER',
                                        'BBVA SERVICIOS',
                                        'BICENTENARIO',
                                        'BM ACTINVER',
                                        'BM BASE',
                                        'BNP',
                                        'BOSTON',
                                        'CAPITAL',
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
                                        'INTERBANCO',
                                        'INTERACCIONES',
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
                                    ])
                                    ->default('NO APLICA')
                                    ->nullable(),
                                Forms\Components\TextInput::make('bank_account')
                                    ->label('Cuenta de banco')
                                    ->default('')
                                    ->maxLength(30)
                                    ->nullable(),
                                Forms\Components\TextInput::make('bank_account_number')
                                    ->label('Clabe')
                                    ->maxLength(30)
                                    ->default('')
                                    ->nullable()
                            ]),
                        Forms\Components\Tabs\Tab::make('Documentacion')
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
                        Forms\Components\Tabs\Tab::make('Contactos')
                            ->visible(fn($operation) => $operation !== 'create')
                            ->schema([
                                \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(RelationManagers\ContactsRelationManager::class)->lazy(true)
                            ]),
                        Forms\Components\Tabs\Tab::make('Cadena de aprobación')
                            ->visible(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('gerente_compras'))
                            ->columns(1)
                            ->schema([
                                Forms\Components\Select::make('approval_chain')
                                    ->label('Tipo')
                                    ->required()
                                    ->searchable()
                                    ->options(['normal' => 'Normal', 'especial' => 'Especial'])
                                    ->helperText('Selecciona la cadena de aprobación que se utilizará para este proveedor.'),
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
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Razón social')
                    ->searchable(),
                Tables\Columns\TextColumn::make('UserRequest.name')
                    ->label('Alta de información')
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
