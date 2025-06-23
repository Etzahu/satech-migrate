<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder;

use Closure;
use Money\Money;
use Filament\Forms;
use Money\Currency;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists;
use Filament\Forms\Form;
use Brick\Math\BigDecimal;
use Filament\Tables\Table;
use App\Models\PurchaseOrder;
use App\Models\ProviderContact;
use App\Models\PurchaseProvider;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use App\Models\PurchaseRequisition;
use Filament\Forms\Components\Tabs;
use Money\Currencies\ISOCurrencies;
use App\Forms\Components\MoneyInput;
use Illuminate\Support\Facades\Storage;
use Money\Formatter\IntlMoneyFormatter;
use Filament\Notifications\Notification;
use Filament\Support\Enums\IconPosition;
use App\Services\OrderCalculationService;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\Support\MediaStream;
use App\Infolists\Components\PRProgressApproval;
// use Pelmered\FilamentMoneyField\Infolists\Components\MoneyEntry;
use Filament\Infolists\Components\Actions\Action;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
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
                        Tabs\Tab::make('Datos generales')
                            ->columns(2)
                            ->schema([
                                Forms\Components\Select::make('currency')
                                    ->label('Moneda')
                                    ->required()
                                    ->live()
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
                                    ->options(PurchaseRequisition::myAssing()->whereNot('status', 'cerrada')->pluck('folio', 'id'))
                                    ->required()
                                    ->columnSpan('full'),
                            ]),
                        Tabs\Tab::make('Partidas')->schema([
                            // Es para que el administrador pueda editar las partidas cuando la orden este liberada
                            \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(RelationManagers\ItemsRelationManager::class)->lazy(true)
                        ])->visible(in_array('show_relation_items', $options)),
                        Tabs\Tab::make('Condiciones de pago')
                            ->schema([
                                Forms\Components\Repeater::make('condition_payment')
                                    ->label('Condiciones de pago')
                                    ->columns(2)
                                    ->columnSpan('full')
                                    ->hint('La suma de los conceptos debe ser 100%')
                                    ->hintColor('danger')
                                    ->schema([
                                        Forms\Components\TextInput::make('concept')
                                            ->label('Concepto')
                                            ->required(),
                                        Forms\Components\TextInput::make('value')
                                            ->label('Valor')
                                            ->numeric()
                                            ->integer()
                                            ->minValue(1)
                                            ->maxValue(100)
                                            ->live(onBlur: true)
                                            ->suffixIcon('heroicon-o-percent-badge')
                                            ->suffixIconColor('warning')
                                            ->required(),
                                    ])
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $collection = $get('condition_payment');
                                        $sum = 0;
                                        foreach ($collection as $item) {
                                            $sum += (int)$item['value'];
                                        }
                                        $set('total', $sum);
                                    }),
                                Forms\Components\TextInput::make('total')
                                    ->label('Total')
                                    ->disabled()
                                    ->suffixIcon('heroicon-o-percent-badge')
                                    ->suffixIconColor('warning')
                                    ->default(0),
                            ]),
                        Tabs\Tab::make('Proveedor')
                            ->schema([
                                Forms\Components\Select::make('provider_id')
                                    ->label('Proveedor')
                                    ->searchable()
                                    ->preload()
                                    ->options(PurchaseProvider::where('status', 'aprobado')->pluck('company_name', 'id'))
                                    ->required()
                                    ->live()
                                    ->columnSpan('full')
                                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                        $set('provider_contact_id', null);
                                    }),
                                Forms\Components\Select::make('provider_contact_id')
                                    ->label('Contacto')
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->options(function (Forms\Set $set, Forms\Get $get) {
                                        return ProviderContact::where('provider_id', $get('provider_id'))->pluck('name', 'id');
                                    })
                                    ->required()
                                    ->live()
                                    ->columnSpan('full'),
                            ]),
                        Tabs\Tab::make('Soporte')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('doc_1')
                                    // ->label('Justificación')
                                    ->label('Tabla comparativa o adjudicación directa en su lugar')
                                    ->required()
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->collection('justification'),
                                SpatieMediaLibraryFileUpload::make('doc_4')
                                    ->label('Cotización')
                                    ->required()
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->collection('quote'),

                                SpatieMediaLibraryFileUpload::make('doc_3')
                                    ->label('Certificaciones')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->collection('certifications'),
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
                                    ->visible(false)
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
                                    ->label('Precio unitario')
                                    ->helperText(new HtmlString("<p class='p-1 text-white bg-red-500 rounded-md'>La cantidad debe ser un número sin espacios ni comillas y con exactamente 4 decimales (ej: 0.0000).</p>"))
                                    ->required()
                                    ->rules([
                                        fn(): Closure => function (string $attribute, $value, Closure $fail) {
                                            if (preg_match('/^\d+\.\d{4}$/', $value)) {
                                                return true;
                                            } else {
                                                $fail('El :attribute no es válido.');
                                            }
                                        },
                                    ]),
                            ]),
                        Tabs\Tab::make('Entrega')
                            ->columns(1)
                            ->schema([
                                Forms\Components\DatePicker::make('initial_delivery_date') //TODO: falta validar esta logica cuando se edita
                                    ->label('Inicial')
                                    ->required(),
                                Forms\Components\DatePicker::make('final_delivery_date') //TODO: falta validar esta logica cuando se edita
                                    ->label('Final')
                                    ->required(),
                                Forms\Components\Textarea::make('delivery_address')
                                    ->label('Dirección de entrega')
                                    ->default('Almacén, Av. Santa Mónica No.33, Col El Mirador, Tlalnepantla de Baz, Estado de México 54080.'),
                                Forms\Components\Repeater::make('documentation_delivery')
                                    ->label('Documentación de entrega')
                                    ->reorderableWithDragAndDrop(false)
                                    ->reorderable(false)
                                    ->default([['name' => 'Copia de remisión y/o Factura'], ['name' => 'Orden de compra'], ['name' => 'Certificados de calidad']])
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nombre del documento')
                                            ->required(),
                                    ])
                            ]),
                        Tabs\Tab::make('Observaciones')
                            ->columns(2)
                            ->schema([
                                Forms\Components\Textarea::make('observations')
                                    ->label('Observaciones')
                                    ->default('Sin observaciones')
                                    ->required()
                                    ->autosize()
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->activeTab(1)
            ]);
    }
    public static function infolist(Infolist $infolist, $options = []): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                Infolists\Components\Tabs::make('tabs')
                    ->tabs([
                        Infolists\Components\Tabs\Tab::make('Orden de compra')
                            ->schema([
                                Infolists\Components\Tabs::make('Tabs')
                                    ->tabs([
                                        Infolists\Components\Tabs\Tab::make('Datos generales')
                                            ->columns(3)
                                            ->schema([
                                                Infolists\Components\TextEntry::make('folio')
                                                    ->label('Folio')
                                                    ->columnSpan('full'),
                                                Infolists\Components\TextEntry::make('status')
                                                    ->label('Estatus')
                                                    ->badge()
                                                    ->color('success'),
                                                Infolists\Components\TextEntry::make('currency')
                                                    ->label('Moneda'),
                                                Infolists\Components\TextEntry::make('requisition.project.name')
                                                    ->label('Proyecto de la requisición'),
                                                Infolists\Components\TextEntry::make('type_payment')
                                                    ->label('Tipo de pago'),
                                                Infolists\Components\TextEntry::make('form_payment')
                                                    ->label('Forma de pago'),
                                                Infolists\Components\TextEntry::make('quote_folio')
                                                    ->label('Folio de cotización'),
                                                Infolists\Components\TextEntry::make('use_cfdi')
                                                    ->label('Uso de CFDI'),
                                                Infolists\Components\TextEntry::make('shipping_method')
                                                    ->label('Método de envío'),
                                                Infolists\Components\TextEntry::make('tax_iva')
                                                    ->label('IVA')
                                                    ->icon('heroicon-o-percent-badge')
                                                    ->iconPosition(IconPosition::After)
                                                    ->iconColor('primary'),
                                                Infolists\Components\TextEntry::make('requisition.folio')
                                                    ->label('Requisición')
                                                    ->hidden($options['rq'] ?? false),
                                                Infolists\Components\TextEntry::make('created_at')
                                                    ->label('Fecha de creación')
                                                    ->date(),
                                            ]),
                                        Infolists\Components\Tabs\Tab::make('Partidas')
                                            ->schema([
                                                Infolists\Components\RepeatableEntry::make('items')
                                                    ->label('')
                                                    ->contained(false)
                                                    ->schema([
                                                        Infolists\Components\Fieldset::make('')
                                                            ->extraAttributes(function ($state, $record) {
                                                                if (auth()->user()->hasRole('comprador')) {
                                                                    if ($record->unit_price == 0) {
                                                                        return ['class' => 'border-2 border-red-600 bg-red-100 dark:bg-red-800  dark:border-red-800'];
                                                                    } else {
                                                                        return ['class' => 'border-2 border-green-600 bg-green-100 dark:bg-green-800  dark:border-green-800'];
                                                                    }
                                                                } else {
                                                                    return [];
                                                                }
                                                            })
                                                            ->schema([
                                                                Infolists\Components\TextEntry::make('product.name')
                                                                    ->label('Producto/Servicio'),
                                                                Infolists\Components\TextEntry::make('product.unit.acronym')
                                                                    ->label('Unidad'),
                                                                Infolists\Components\TextEntry::make('quantity')
                                                                    ->label('Cantidad'),
                                                                Infolists\Components\TextEntry::make('unit_price')
                                                                ->label('Precio unitario')
                                                                    ->formatStateUsing(function ($state) {
                                                                        if (blank($state)) {
                                                                            return '0.0000';
                                                                        }
                                                                        $state = BigDecimal::of($state)->dividedBy(10000, 4);
                                                                        return (string) $state;
                                                                    }),
                                                                Infolists\Components\TextEntry::make('sub_total')
                                                                    ->label('Subtotal')
                                                                    ->formatStateUsing(function ($state) {
                                                                        if (blank($state)) {
                                                                            return '0.0000';
                                                                        }
                                                                        $state = BigDecimal::of($state)->dividedBy(10000, 4);
                                                                        return (string) $state;
                                                                    }),
                                                                Infolists\Components\TextEntry::make('observation')
                                                                    ->label('Observación')
                                                                    ->columnSpanFull(),
                                                            ])
                                                            ->columns([
                                                                'xs' => 1,
                                                                'sm' => 2,
                                                                'xl' => 4,
                                                                '2xl' => 6,
                                                            ])
                                                    ])
                                                    ->grid(1)
                                            ]),
                                        Infolists\Components\Tabs\Tab::make('Condiciones de pago')
                                            ->schema([
                                                Infolists\Components\RepeatableEntry::make('condition_payment')
                                                    ->label('')
                                                    ->columns(2)
                                                    ->schema([
                                                        Infolists\Components\TextEntry::make('concept')
                                                            ->label('Concepto'),
                                                        Infolists\Components\TextEntry::make('value')
                                                            ->label('Valor')
                                                    ])
                                            ]),
                                        Infolists\Components\Tabs\Tab::make('Proveedor')
                                            ->schema([
                                                Infolists\Components\TextEntry::make('provider.company_name')
                                                    ->label('Proveedor'),
                                                Infolists\Components\TextEntry::make('providerContact.name')
                                                    ->label('Nombre'),
                                                Infolists\Components\TextEntry::make('providerContact.email')
                                                    ->label('Correo'),
                                                Infolists\Components\TextEntry::make('providerContact.cell_phone')
                                                    ->label('Teléfono'),
                                            ]),

                                        Infolists\Components\Tabs\Tab::make('Soporte')
                                            ->schema([
                                                Infolists\Components\TextEntry::make('doc_1')
                                                    // ->label('Justificación')
                                                    ->label('Tabla comparativa o adjudicación directa en su lugar')
                                                    ->state(function ($record) {
                                                        $media = Media::where('model_id', $record->id)
                                                            ->where('collection_name', 'justification')
                                                            ->first();
                                                        return $media->name;
                                                    })
                                                    ->hintActions([
                                                        Infolists\Components\Actions\Action::make('Ver documento')
                                                            ->url(function ($record) {
                                                                $media = Media::where('model_id', $record->id)
                                                                    ->where('collection_name', 'justification')
                                                                    ->first();
                                                                return  route('media.show', ['id' => $media->id]);
                                                            })
                                                            ->openUrlInNewTab(),
                                                        Action::make('Descargar')
                                                            ->action(function ($record) {
                                                                $media = Media::where('model_id', $record->id)
                                                                    ->where('collection_name', 'justification')
                                                                    ->first();
                                                                return response()->download($media->getPath(), $media->file_name);
                                                            }),
                                                    ]),
                                                Infolists\Components\TextEntry::make('doc_7')
                                                    ->label('Cotización')
                                                    ->state(function ($record) {
                                                        $media = Media::where('model_id', $record->id)
                                                            ->where('collection_name', 'quote')
                                                            ->first();
                                                        return $media->name;
                                                    })
                                                    ->hintActions([
                                                        Infolists\Components\Actions\Action::make('Ver documento')
                                                            ->url(function ($record) {
                                                                $media = Media::where('model_id', $record->id)
                                                                    ->where('collection_name', 'quote')
                                                                    ->first();
                                                                return  route('media.show', ['id' => $media->id]);
                                                            })
                                                            ->openUrlInNewTab(),
                                                        Action::make('Descargar')
                                                            ->action(function ($record) {
                                                                $media = Media::where('model_id', $record->id)
                                                                    ->where('collection_name', 'quote')
                                                                    ->first();
                                                                return response()->download($media->getPath(), $media->file_name);
                                                            }),
                                                    ]),
                                                // documentacion opcional
                                                Infolists\Components\TextEntry::make('doc_3')
                                                    ->label('Certificaciones')
                                                    ->visible(function ($record) {
                                                        $media = Media::where('model_id', $record->id)
                                                            ->where('collection_name', 'certifications')
                                                            ->first();
                                                        return filled($media);
                                                    })
                                                    ->state(function ($record) {
                                                        $media = Media::where('model_id', $record->id)
                                                            ->where('collection_name', 'certifications')
                                                            ->first();
                                                        return $media->name;
                                                    })
                                                    ->hintActions([
                                                        Infolists\Components\Actions\Action::make('Ver documento')
                                                            ->url(function ($record) {
                                                                $media = Media::where('model_id', $record->id)
                                                                    ->where('collection_name', 'certifications')
                                                                    ->first();
                                                                return  route('media.show', ['id' => $media->id]);
                                                            })
                                                            ->openUrlInNewTab(),
                                                        Action::make('Descargar')
                                                            ->action(function ($record) {
                                                                $media = Media::where('model_id', $record->id)
                                                                    ->where('collection_name', 'certifications')
                                                                    ->first();
                                                                return response()->download($media->getPath(), $media->file_name);
                                                            }),
                                                    ]),
                                            ]),

                                        Infolists\Components\Tabs\Tab::make('Retenciones')
                                            ->columns(3)
                                            ->schema([
                                                Infolists\Components\TextEntry::make('retention_iva')
                                                    ->label('IVA')
                                                    ->numeric()
                                                    ->icon('heroicon-o-percent-badge')
                                                    ->iconColor('primary'),
                                                Infolists\Components\TextEntry::make('retention_isr')
                                                    ->label('ISR')
                                                    ->numeric()
                                                    ->icon('heroicon-o-percent-badge')
                                                    ->iconPosition(IconPosition::After)
                                                    ->iconColor('primary'),
                                                Infolists\Components\TextEntry::make('retention_another')
                                                    ->label('OTRO')
                                                    ->icon('heroicon-o-percent-badge')
                                                    ->iconPosition(IconPosition::After)
                                                    ->iconColor('primary')
                                                    ->numeric(),
                                            ]),
                                        Infolists\Components\Tabs\Tab::make('Descuento del proveedor')
                                            ->columns(3)
                                            ->schema([
                                                Infolists\Components\TextEntry::make('discount')
                                                    ->label('Descuento')
                                                    ->formatStateUsing(function ($state) {
                                                        if (blank($state)) {
                                                            return '0.0000';
                                                        }
                                                        $state = BigDecimal::of($state)->dividedBy(10000, 4);
                                                        return (string) $state;
                                                    })
                                            ]),
                                        Infolists\Components\Tabs\Tab::make('Entrega')
                                            ->columns(1)
                                            ->schema([
                                                Infolists\Components\TextEntry::make('initial_delivery_date')
                                                    ->label('Inicial')
                                                    ->date(),
                                                Infolists\Components\TextEntry::make('final_delivery_date')
                                                    ->label('Final')
                                                    ->date(),
                                                Infolists\Components\Textentry::make('delivery_address')
                                                    ->label('Dirección de entrega'),
                                                Infolists\Components\RepeatableEntry::make('documentation_delivery')
                                                    ->label('Documentación de entrega')
                                                    ->schema([
                                                        Infolists\Components\TextEntry::make('name')
                                                            ->label('Nombre del documento'),
                                                    ]),
                                            ]),
                                        Infolists\Components\Tabs\Tab::make('Observaciones')
                                            ->columns(1)
                                            ->schema([
                                                Infolists\Components\Textentry::make('observations')
                                                    ->label('Observaciones'),
                                            ]),
                                        Infolists\Components\Tabs\Tab::make('Historial')
                                            ->schema([
                                                Infolists\Components\ViewEntry::make('status')
                                                    ->view('filament.infolists.entries.history'),
                                            ]),

                                        Infolists\Components\Tabs\Tab::make('Resumen del total')
                                            ->columns(1)
                                            ->schema([
                                                Infolists\Components\KeyValueEntry::make('total')
                                                    ->keyLabel('Concepto')
                                                    ->valueLabel('Resultado')
                                            ]),
                                    ])
                                    ->contained(false)
                                    ->activeTab(1)
                            ]),
                        Infolists\Components\Tabs\Tab::make('Requisición')
                            ->schema([
                                Infolists\Components\Tabs::make('Tabs')
                                    // inicio infolist
                                    ->contained(false)
                                    ->tabs([
                                        Infolists\Components\Tabs\Tab::make('Información general')
                                            ->schema([
                                                Infolists\Components\TextEntry::make('requisition.status')
                                                    ->label('Estatus')
                                                    ->badge()
                                                    ->color('success'),
                                                Infolists\Components\TextEntry::make('requisition.type')
                                                    ->label('Tipo de requisición')
                                                    ->badge()
                                                    ->color('success'),
                                                Infolists\Components\TextEntry::make('requisition.priority')
                                                    ->label('Prioridad')
                                                    ->badge()
                                                    ->color('success'),
                                                Infolists\Components\TextEntry::make('requisition.category')
                                                    ->label('Categoría de requisición')
                                                    ->badge()
                                                    ->color('success'),
                                                Infolists\Components\TextEntry::make('requisition.approvalChain.requester.name')
                                                    ->label('Solicitante'),
                                                Infolists\Components\TextEntry::make('requisition.motive')
                                                    ->label('Referencia'),
                                                Infolists\Components\TextEntry::make('requisition.folio')
                                                    ->label('Folio'),
                                                Infolists\Components\TextEntry::make('requisition.date_delivery')
                                                    ->label('Fecha deseable de entrega')
                                                    ->date(),
                                                Infolists\Components\TextEntry::make('requisition.project.name')
                                                    ->label('Proyecto'),
                                                Infolists\Components\TextEntry::make('requisition.delivery_address')
                                                    ->label('Dirección de entrega'),
                                            ])
                                            ->columns(3),
                                        Infolists\Components\Tabs\Tab::make('Partidas')
                                            ->schema([
                                                Infolists\Components\RepeatableEntry::make('requisition.items')
                                                    ->label('')
                                                    ->schema([
                                                        Infolists\Components\TextEntry::make('product.code')
                                                            ->label('Código'),
                                                        Infolists\Components\TextEntry::make('product.name')
                                                            ->label('Producto'),
                                                        Infolists\Components\TextEntry::make('quantity_warehouse')
                                                            ->label('Cantidad en almacén'),
                                                        Infolists\Components\TextEntry::make('quantity_purchase')
                                                            ->label('Cantidad para comprar'),
                                                        Infolists\Components\TextEntry::make('observation')
                                                            ->label('Observación')
                                                            ->columnSpan(2),
                                                    ])
                                                    ->columns(5)
                                            ]),
                                        // Infolists\Components\Tabs\Tab::make('Flujo de aprobación')
                                        //     ->schema([
                                        //         PRProgressApproval::make('progress')
                                        //     ])
                                        //     ->columns(1),
                                        Infolists\Components\Tabs\Tab::make('Observaciones')
                                            ->schema([
                                                Infolists\Components\TextEntry::make('observation')
                                                    ->label('Observaciones'),
                                            ]),
                                        Infolists\Components\Tabs\Tab::make('Fichas técnicas')
                                            ->visible(fn($record) => $record->requisition->getMedia('technical_data_sheets')->count() > 0)
                                            ->schema([
                                                Infolists\Components\RepeatableEntry::make('media')
                                                    ->state(function ($record) {
                                                        $record->media = $record->requisition->getMedia('technical_data_sheets');
                                                        return $record->media;
                                                    })
                                                    ->label('')
                                                    ->schema([
                                                        Infolists\Components\TextEntry::make('name')
                                                            ->label('Nombre del archivo'),
                                                    ]),
                                                Infolists\Components\Actions::make([
                                                    Infolists\Components\Actions\Action::make('Descargar fichas')
                                                        ->action(function ($record) {
                                                            $downloads = $record->requisition->getMedia('technical_data_sheets');
                                                            return MediaStream::create($record->requisition->folio . '-fichas-tecnicas.zip')->addMedia($downloads);
                                                        }),
                                                ]),
                                            ]),
                                        Infolists\Components\Tabs\Tab::make('Soportes')
                                            ->visible(fn($record) => $record->requisition->getMedia('supports')->count() > 0)
                                            ->schema([
                                                Infolists\Components\RepeatableEntry::make('media')
                                                    ->state(function ($record) {
                                                        $media = Media::where('model_id', $record->requisition->id)
                                                            ->where('collection_name', 'supports')
                                                            ->get();
                                                        $record->media = $media;
                                                        return $record->media;
                                                    })
                                                    ->label('')
                                                    ->schema([
                                                        Infolists\Components\TextEntry::make('name')
                                                            ->label('Nombre del archivo'),
                                                    ]),
                                                Infolists\Components\Actions::make([
                                                    Infolists\Components\Actions\Action::make('Descargar soportes')
                                                        ->action(function ($record) {
                                                            $downloads = Media::where('model_id', $record->requisition->id)
                                                                ->where('collection_name', 'supports')
                                                                ->get();
                                                            return MediaStream::create($record->requisition->folio . '-soportes.zip')->addMedia($downloads);
                                                        }),
                                                ]),
                                            ]),


                                    ])
                                // fin infolist

                            ]),
                    ])
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus')
                    ->searchable(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn($record) => $record->status == 'borrador'),
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
            'create' => Pages\CreatePurchaseOrder::route('/create/{requisition?}'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}/ver'),
            'add-item' => Pages\addItemPR::route('/{record}/agregar/partidas')
        ];
    }
}
