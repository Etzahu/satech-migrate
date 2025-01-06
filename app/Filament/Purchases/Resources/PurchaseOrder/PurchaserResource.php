<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProvider;
use Filament\Resources\Resource;
use App\Models\PurchaseRequisition;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Hugomyb\FilamentMediaAction\Forms\Components\Actions\MediaAction;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;
use App\Filament\Purchases\Resources\PurchaseResource\PurchaserResource\RelationManagers;

class PurchaserResource extends Resource  implements HasShieldPermissions
{
    protected static ?string $model = PurchaseOrder::class;
    protected static ?string $modelLabel = 'Orden';
    protected static ?string $pluralModelLabel = 'Orden';
    protected static ?string $navigationLabel = 'Mis ordenes';
    protected static ?string $slug = 'ordenes';
    protected static ?string $navigationGroup = 'Orden';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('comprador');
    }
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'view_approve-level-1', //Revisar gerente de compras
            'view_approve_level-2', //Revisar gerente relacionado a la requisicion
            'view_approve-level-3', //Revisar por direccion (Denisse)
            'view_approve_level-4', //Si el total de la orden es mayor a X de valor revisa Carlos
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->myRequisitions();
    }
    public static function form(Form $form, array $options = []): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Orden')
                        ->schema([
                            Forms\Components\Tabs::make('Tabs')
                                ->tabs([
                                    Tabs\Tab::make('Datos generales')
                                        ->columns(2)
                                        ->schema([
                                            Forms\Components\Select::make('currency')
                                                ->label('Moneda')
                                                ->required()
                                                ->options([
                                                    'MXN' => 'MXN',
                                                    'USD' => 'USD',
                                                ])
                                                ->default('MXN'),
                                            Forms\Components\Select::make('type_payment')
                                                ->label('Tipo de pago')
                                                ->options([
                                                    'PPD - Pago en parcialidades o diferido' => 'PPD - Pago en parcialidades o diferido',
                                                    'PUE - Pago en una sola exhibición' => 'PUE - Pago en una sola exhibición',
                                                ])
                                                ->required(),
                                            Forms\Components\Select::make('form_payment')
                                                ->label('Forma de pago')
                                                ->options([
                                                    'efectivo' => 'Efectivo',
                                                    'transferencia' => 'Transferencia'
                                                ])
                                                ->required(),
                                            Forms\Components\Select::make('term_payment')
                                                ->label('Término de pago')
                                                ->options([
                                                    'contado' => 'Contado',
                                                    '15 días' => '15 días',
                                                    '30 días' => '30 días',
                                                    '45 días' => '45 días',
                                                    '60 días' => '60 días',
                                                ])
                                                ->required(),
                                            Forms\Components\TextInput::make('condition_payment')
                                                ->label('Condiciones de pago')
                                                ->required()
                                                ->columnSpan('full')
                                                ->maxLength(100),
                                            Forms\Components\TextInput::make('quote_folio')
                                                ->label('Folio de cotización')
                                                ->required()
                                                ->maxLength(100),
                                            Forms\Components\Select::make('use_cfdi')
                                                ->label('Uso de CFDI')
                                                ->options([
                                                    'G01-Adquisición de mercancías' => 'G01 - Adquisición de mercancías',
                                                    'G02-Devoluciones y descuentos sobre compras' => 'G02 - Devoluciones y descuentos sobre compras',
                                                    'G03-Gastos en general' => 'G03 - Gastos en general',
                                                    '101-Construcciones' => '101 - Construcciones',
                                                    '102-Mobiliario y equipo de oficina por inversiones' => '102 - Mobiliario y equipo de oficina por inversiones',
                                                    '103-Equipo de transporte' => '103 - Equipo de transporte',
                                                    '104-Equipo de cómputo y accesorios' => '104 - Equipo de cómputo y accesorios',
                                                    '105-Dados, troqueles, moldes, matrices y herramental' => '105 - Dados, troqueles, moldes, matrices y herramental',
                                                    '106-Comunicaciones telefónicas' => '106 - Comunicaciones telefónicas',
                                                    '107-Comunicaciones satelitales' => '107 - Comunicaciones satelitales',
                                                    '108-Otra maquinaria y equipo' => '108 - Otra maquinaria y equipo',
                                                ])
                                                ->required(),
                                            Forms\Components\Textarea::make('shipping_method')
                                                ->label('Método de envío')
                                                ->required(),
                                            Forms\Components\Select::make('tax_iva')
                                                ->label('IVA')
                                                ->options([
                                                    '0' => '0%',
                                                    '8' => '8%',
                                                    '16' => '16%',
                                                ])
                                                ->required(),
                                            Forms\Components\Select::make('requisition_id')
                                                ->label('Requisición')
                                                ->hidden($options['rq'] ?? false)
                                                ->searchable()
                                                ->preload()
                                                ->options(PurchaseRequisition::myAssing()->pluck('folio', 'id'))
                                                ->required()
                                                ->columnSpan('full'),
                                            Forms\Components\Select::make('provider_id')
                                                ->label('Proveedor')
                                                ->searchable()
                                                ->preload()
                                                ->options(PurchaseProvider::where('status', 'aprobado')->pluck('company_name', 'id'))
                                                ->required()
                                                ->columnSpan('full'),
                                        ]),
                                    Forms\Components\Tabs\Tab::make('Partidas')->schema([
                                        \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(RelationManagers\ItemsRelationManager::class)->lazy(true)
                                    ])
                                        ->visible(isset($options['show_relation_items'])),
                                    Tabs\Tab::make('Soporte')
                                        ->schema([
                                            SpatieMediaLibraryFileUpload::make('doc_1')
                                                ->label('Justificación')
                                                ->required()
                                                ->acceptedFileTypes(['application/pdf'])
                                                ->collection('justification')
                                                ->hintActions([
                                                    MediaAction::make('ver documento')
                                                        // ->visible(fn($operation, $state) =>dd($operation, $state))
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
                                                ->label('Tabla comparativa')
                                                ->required()
                                                ->acceptedFileTypes(['application/pdf'])
                                                ->collection('comparative_table')->hintActions([
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
                                                ->label('Certificaciones')
                                                ->required()
                                                ->acceptedFileTypes(['application/pdf'])
                                                ->collection('certifications')
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
                                    Tabs\Tab::make('Retenciones')
                                        ->columns(3)
                                        ->schema([
                                            Forms\Components\TextInput::make('retention_iva')
                                                ->label('IVA')
                                                ->required()
                                                ->numeric()
                                                ->suffixIcon('heroicon-o-percent-badge')
                                                ->suffixIconColor('primary')
                                                ->minValue(0)
                                                ->default(0.00),
                                            Forms\Components\TextInput::make('retention_isr')
                                                ->label('ISR')
                                                ->required()
                                                ->numeric()
                                                ->suffixIcon('heroicon-o-percent-badge')
                                                ->suffixIconColor('primary')
                                                ->minValue(0)
                                                ->default(0.00),
                                            Forms\Components\TextInput::make('retention_another')
                                                ->label('OTRO')
                                                ->required()
                                                ->suffixIcon('heroicon-o-percent-badge')
                                                ->suffixIconColor('primary')
                                                ->numeric()
                                                ->minValue(0)
                                                ->default(0.00),
                                        ]),
                                    Tabs\Tab::make('Descuento del proveedor')
                                        ->columns(3)
                                        ->schema([
                                            MoneyInput::make('discount')
                                                ->label('Descuento')
                                                ->currency('MXN')
                                                ->locale('es_MX')
                                                ->required()
                                                ->minValue(0)
                                                ->numeric(),
                                        ]),
                                    Tabs\Tab::make('Fecha de entrega')
                                        ->columns(2)
                                        ->schema([
                                            Forms\Components\DatePicker::make('initial_delivery_date') //TODO: falta validar esta logica cuando se edita
                                                ->label('Inicial')
                                                ->required(),
                                            Forms\Components\DatePicker::make('final_delivery_date') //TODO: falta validar esta logica cuando se edita
                                                ->label('Final')
                                                ->required(),
                                        ]),
                                    Tabs\Tab::make('Observaciones')
                                        ->columns(2)
                                        ->schema([
                                            Forms\Components\Textarea::make('observations')
                                                ->label('Observaciones')
                                                ->required()
                                                ->columnSpanFull(),
                                        ]),
                                    Tabs\Tab::make('Resumen del total')
                                        ->columns(1)
                                        ->visible(fn(string $operation) => $operation == 'view')
                                        ->schema([
                                            Forms\Components\KeyValue::make('total')
                                                ->keyLabel('Concepto')
                                                ->valueLabel('Resultado')
                                        ]),
                                ])
                                ->contained(false)
                                ->activeTab(1)
                        ]),
                    Forms\Components\Tabs\Tab::make('Requisicion')
                        ->visible(in_array('requisicion', $options))
                        ->schema([])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provider.company_name')
                    ->label('Proveedor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('requisition.folio')
                    ->label('Requisición')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus')
                    ->searchable(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),

            ]);
    }
    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}/ver'),
            'add-item' => Pages\addItemPR::route('/{record}/agregar/partidas')
        ];
    }
}
