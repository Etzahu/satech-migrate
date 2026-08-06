<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder;

use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\Pages;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource\RelationManagers;
use App\Forms\Components\MoneyInput;
use App\Models\ProviderContact;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProvider;
use App\Models\PurchaseRequisition;
use App\Services\OrderCalculationService;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Brick\Math\BigDecimal;
use Closure;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Actions as SchemaActions;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
// use Pelmered\FilamentMoneyField\Infolists\Components\MoneyEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Njxqlus\Filament\Components\Forms\RelationManager;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

class PurchaserResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = PurchaseOrder::class;

    protected static ?string $modelLabel = 'Orden';

    protected static ?string $pluralModelLabel = 'Orden';

    protected static ?string $navigationLabel = 'Mis ordenes';

    protected static ?string $slug = 'ordenes';

    protected static string|\UnitEnum|null $navigationGroup = 'Orden';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

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
            'view_approve-level-1', // Revisar gerente de compras
            'view_approve_level-2', // Revisar gerente relacionado a la requisicion
            'view_approve-level-3', // Revisar por direccion (Denisse)
            'view_approve_level-4', // Si el total de la orden es mayor a X de valor revisa Carlos
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->myRequisitions();
    }

    /**
     * Requisiciones que se pueden seleccionar en una orden.
     * El comprador solo ve las que tiene asignadas y siguen abiertas;
     * el super_admin ve todas las de la empresa para poder corregir órdenes ya creadas.
     */
    public static function requisitionQuery(): Builder
    {
        if (auth()->user()->hasRole('super_admin')) {
            return PurchaseRequisition::query()
                ->where('company_id', session()->get('company_id'))
                ->orderBy('id', 'desc');
        }

        return PurchaseRequisition::myAssing()->whereNot('status', 'cerrada');
    }

    public static function requisitionOptions(?PurchaseOrder $record = null): array
    {
        $options = static::requisitionQuery()->limit(50)->pluck('folio', 'id');

        // La requisición ya guardada suele quedar fuera del listado (cerrada o asignada
        // a otro comprador), así que se agrega para que el select muestre su folio.
        if (filled($record?->requisition_id) && ! $options->has($record->requisition_id)) {
            $options->put($record->requisition_id, $record->requisition?->folio ?? $record->requisition_id);
        }

        return $options->all();
    }

    public static function form(Schema $form, array $options = []): Schema
    {
        return $form
            ->columns(1)
            ->schema([
                Tabs::make('Tabs')
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
                                        'transferencia' => 'Transferencia',
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('quote_folio')
                                    ->label('Folio de cotización')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\Select::make('use_cfdi')
                                    ->label('Uso de CFDI')
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
                                    ->options(fn (?PurchaseOrder $record) => static::requisitionOptions($record))
                                    ->getSearchResultsUsing(fn (string $search) => static::requisitionQuery()
                                        ->where('folio', 'like', "%{$search}%")
                                        ->limit(50)
                                        ->pluck('folio', 'id'))
                                    ->getOptionLabelUsing(fn ($value) => PurchaseRequisition::find($value)?->folio)
                                    ->required()
                                    ->columnSpan('full'),
                            ]),
                        Tabs\Tab::make('Partidas')->schema([
                            // Es para que el administrador pueda editar las partidas cuando la orden este liberada
                            RelationManager::make()->manager(RelationManagers\ItemsRelationManager::class)->lazy(true),
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
                                            $sum += (int) $item['value'];
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
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $set('provider_contact_id', null);
                                    }),
                                Forms\Components\Select::make('provider_contact_id')
                                    ->label('Contacto')
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->options(function (Set $set, Get $get) {
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
                                        fn (): Closure => function (string $attribute, $value, Closure $fail) {
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
                                Forms\Components\TextInput::make('delivery_days')
                                    ->label('Tiempo de entrega (días)')
                                    ->required()
                                    ->numeric()
                                    ->integer()
                                    ->minValue(1)
                                    ->suffixIcon('heroicon-o-calendar-days')
                                    ->helperText('Días calendario a partir de la fecha de aprobación de la orden.'),
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
                                    ]),
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
                    ->activeTab(1),
            ]);
    }

    public static function infolist(Schema $infolist, $options = []): Schema
    {
        return $infolist
            ->columns(3)
            ->schema([
                // ── Columna principal (izquierda) ─────────────────────────────
                Group::make()
                    ->columnSpan(2)
                    ->schema([
                        // Header: datos clave siempre visibles
                        Fieldset::make('')
                            ->extraAttributes(['class' => 'bg-white dark:bg-gray-800 rounded-xl shadow-sm'])
                            ->schema([
                                Infolists\Components\TextEntry::make('folio')
                                    ->label('Folio')
                                    ->weight(FontWeight::Bold),
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Estatus')
                                    ->badge()
                                    ->color('success'),
                                Infolists\Components\TextEntry::make('currency')
                                    ->label('Moneda')
                                    ->badge()
                                    ->color('gray'),
                                Infolists\Components\TextEntry::make('provider.company_name')
                                    ->label('Proveedor'),
                                Infolists\Components\TextEntry::make('requisition.folio')
                                    ->label('Requisición')
                                    ->hidden($options['rq'] ?? false),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Creada el')
                                    ->date('d/m/Y'),
                            ])
                            ->columns([
                                'sm' => 2,
                                'lg' => 3,
                                'xl' => 6,
                            ]),

                        // Tabs de un solo nivel
                        Tabs::make('tabs')
                            ->tabs([
                                // 1. Datos generales
                                Tabs\Tab::make(
                                    'Datos generales'
                                )
                                    ->icon('heroicon-o-document-text')
                                    ->columns(3)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('type_payment')
                                            ->label('Tipo de pago'),
                                        Infolists\Components\TextEntry::make('form_payment')
                                            ->label('Forma de pago'),
                                        Infolists\Components\TextEntry::make('quote_folio')
                                            ->label('Folio de cotización'),
                                        Infolists\Components\TextEntry::make('use_cfdi')
                                            ->label('Uso de CFDI'),
                                        Infolists\Components\TextEntry::make('shipping_method')
                                            ->label('Método de envío'),
                                        Infolists\Components\TextEntry::make('tax_iva')
                                            ->label('IVA')
                                            ->icon('heroicon-o-percent-badge')
                                            ->iconPosition(IconPosition::After)
                                            ->iconColor('primary'),
                                        Infolists\Components\TextEntry::make('requisition.project.name')
                                            ->label('Proyecto'),
                                        Infolists\Components\TextEntry::make('observations')
                                            ->label('Observaciones')
                                            ->columnSpanFull()
                                            ->placeholder('Sin observaciones'),
                                    ]),

                                // 2. Partidas
                                Tabs\Tab::make('Partidas')
                                    ->icon('heroicon-o-list-bullet')
                                    ->schema([
                                        Infolists\Components\RepeatableEntry::make('items')
                                            ->label('')
                                            ->contained(false)
                                            ->schema([
                                                Fieldset::make('')
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
                                                            ->label(fn ($record) => $record->purchase?->requisition?->item_label ?? 'Producto'),
                                                        Infolists\Components\TextEntry::make('product.unit.acronym')
                                                            ->label('Unidad'),
                                                        Infolists\Components\TextEntry::make('quantity')
                                                            ->label('Cantidad')
                                                            ->numeric(decimalPlaces: 2),
                                                        Infolists\Components\TextEntry::make('unit_price')
                                                            ->label('Precio unitario')
                                                            ->formatStateUsing(function ($state, $record) {
                                                                if (blank($state)) {
                                                                    return '0.0000';
                                                                }
                                                                $service = new OrderCalculationService;
                                                                $state = $service->brickFormatter($state, 'MXN');

                                                                return $state;
                                                            }),
                                                        Infolists\Components\TextEntry::make('sub_total')
                                                            ->label('Subtotal')
                                                            ->formatStateUsing(function ($state, $record) {
                                                                if (blank($state)) {
                                                                    return '0.0000';
                                                                }
                                                                $service = new OrderCalculationService;
                                                                $state = $service->brickFormatter($state, 'MXN');

                                                                return $state;
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
                                                    ]),
                                            ])
                                            ->grid(1),
                                    ]),

                                // 3. Proveedor
                                Tabs\Tab::make('Proveedor')
                                    ->icon('heroicon-o-building-storefront')
                                    ->columns(2)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('provider.company_name')
                                            ->label('Empresa')
                                            ->columnSpanFull(),
                                        Infolists\Components\TextEntry::make('providerContact.name')
                                            ->label('Contacto'),
                                        Infolists\Components\TextEntry::make('providerContact.email')
                                            ->label('Correo')
                                            ->icon('heroicon-o-envelope'),
                                        Infolists\Components\TextEntry::make('providerContact.cell_phone')
                                            ->label('Teléfono')
                                            ->icon('heroicon-o-phone'),
                                    ]),

                                // 4. Finanzas
                                Tabs\Tab::make('Finanzas')
                                    ->icon('heroicon-o-banknotes')
                                    ->schema([
                                        Fieldset::make('Retenciones')
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
                                                    ->label('Otro')
                                                    ->icon('heroicon-o-percent-badge')
                                                    ->iconPosition(IconPosition::After)
                                                    ->iconColor('primary')
                                                    ->numeric(),
                                            ]),
                                        Fieldset::make('Descuento del proveedor')
                                            ->columns(1)
                                            ->schema([
                                                Infolists\Components\TextEntry::make('discount')
                                                    ->label('Descuento')
                                                    ->formatStateUsing(function ($state) {
                                                        if (blank($state)) {
                                                            return '0.0000';
                                                        }
                                                        $state = BigDecimal::of($state)->dividedBy(10000, 4);

                                                        return (string) $state;
                                                    }),
                                            ]),
                                        Fieldset::make('Condiciones de pago')
                                            ->schema([
                                                Infolists\Components\RepeatableEntry::make('condition_payment')
                                                    ->label('')
                                                    ->columns(2)
                                                    ->schema([
                                                        Infolists\Components\TextEntry::make('concept')
                                                            ->label('Concepto'),
                                                        Infolists\Components\TextEntry::make('value')
                                                            ->label('Valor'),
                                                    ]),
                                            ]),
                                    ]),

                                // 5. Entrega
                                Tabs\Tab::make('Entrega')
                                    ->icon('heroicon-o-truck')
                                    ->columns(1)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('delivery_days')
                                            ->label('Tiempo de entrega')
                                            ->suffix(' días'),
                                        Infolists\Components\TextEntry::make('final_delivery_date')
                                            ->label('Fecha de entrega (calculada)')
                                            ->date()
                                            ->placeholder('Pendiente de aprobación')
                                            ->visible(fn ($record) => filled($record->final_delivery_date)),
                                        Infolists\Components\TextEntry::make('delivery_address')
                                            ->label('Dirección de entrega'),
                                        Infolists\Components\RepeatableEntry::make('documentation_delivery')
                                            ->label('Documentación de entrega')
                                            ->schema([
                                                Infolists\Components\TextEntry::make('name')
                                                    ->label('Nombre del documento'),
                                            ]),
                                    ]),

                                // 6. Soporte
                                Tabs\Tab::make('Soporte')
                                    ->icon('heroicon-o-paper-clip')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('doc_1')
                                            ->label('Tabla comparativa o adjudicación directa')
                                            ->state(function ($record) {
                                                $media = Media::where('model_id', $record->id)
                                                    ->where('collection_name', 'justification')
                                                    ->first();
                                                if (! filled($media)) {
                                                    return 'Sin documento';
                                                }

                                                return $media->name;
                                            })
                                            ->hintActions([
                                                Action::make('Ver documento')
                                                    ->url(function ($record) {
                                                        $media = Media::where('model_id', $record->id)
                                                            ->where('collection_name', 'justification')
                                                            ->first();
                                                        if (! filled($media)) {
                                                            return '#';
                                                        }

                                                        return route('media.show', ['id' => $media->id]);
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
                                                if (! filled($media)) {
                                                    return 'Sin documento';
                                                }

                                                return $media->name;
                                            })
                                            ->hintActions([
                                                Action::make('Ver documento')
                                                    ->url(function ($record) {
                                                        $media = Media::where('model_id', $record->id)
                                                            ->where('collection_name', 'quote')
                                                            ->first();
                                                        if (! filled($media)) {
                                                            return '#';
                                                        }

                                                        return route('media.show', ['id' => $media->id]);
                                                    })
                                                    ->openUrlInNewTab(),
                                                Action::make('Descargar')
                                                    ->action(function ($record) {
                                                        $media = Media::where('model_id', $record->id)
                                                            ->where('collection_name', 'quote')
                                                            ->first();
                                                        if (! filled($media)) {
                                                            return 'Sin documento';
                                                        }

                                                        return response()->download($media->getPath(), $media->file_name);
                                                    }),
                                            ]),
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
                                                Action::make('Ver documento')
                                                    ->url(function ($record) {
                                                        $media = Media::where('model_id', $record->id)
                                                            ->where('collection_name', 'certifications')
                                                            ->first();

                                                        return route('media.show', ['id' => $media->id]);
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

                                // 7. Requisición
                                Tabs\Tab::make('Requisición')
                                    ->icon('heroicon-o-clipboard-document-list')
                                    ->schema([
                                        Fieldset::make('Información general')
                                            ->columns(3)
                                            ->schema([
                                                Infolists\Components\TextEntry::make('requisition.status')
                                                    ->label('Estatus')
                                                    ->badge()
                                                    ->color('success'),
                                                Infolists\Components\TextEntry::make('requisition.type')
                                                    ->label('Tipo')
                                                    ->badge()
                                                    ->color('success'),
                                                Infolists\Components\TextEntry::make('requisition.priority')
                                                    ->label('Prioridad')
                                                    ->badge()
                                                    ->color('success'),
                                                Infolists\Components\TextEntry::make('requisition.category')
                                                    ->label('Categoría')
                                                    ->badge()
                                                    ->color('success'),
                                                Infolists\Components\TextEntry::make('requisition.approvalChain.requester.name')
                                                    ->label('Solicitante'),
                                                Infolists\Components\TextEntry::make('requisition.motive')
                                                    ->label('Referencia'),
                                                Infolists\Components\TextEntry::make('requisition.folio')
                                                    ->label('Folio'),
                                                Infolists\Components\TextEntry::make('requisition.date_delivery')
                                                    ->label('Fecha deseada de entrega')
                                                    ->date(),
                                                Infolists\Components\TextEntry::make('requisition.project.name')
                                                    ->label('Proyecto'),
                                                Infolists\Components\TextEntry::make('requisition.delivery_address')
                                                    ->label('Dirección de entrega')
                                                    ->columnSpanFull(),
                                            ]),
                                        Fieldset::make('Partidas de la requisición')
                                            ->columns(1)
                                            ->schema([
                                                Infolists\Components\RepeatableEntry::make('requisition.items')
                                                    ->label('')
                                                    ->columns(5)
                                                    ->schema([
                                                        Infolists\Components\TextEntry::make('product.code')
                                                            ->label('Código'),
                                                        Infolists\Components\TextEntry::make('product.name')
                                                            ->label(fn ($record) => $record->requisition?->item_label ?? 'Producto'),
                                                        Infolists\Components\TextEntry::make('quantity_warehouse')
                                                            ->numeric(decimalPlaces: 2)
                                                            ->label('En almacén'),
                                                        Infolists\Components\TextEntry::make('quantity_purchase')
                                                            ->numeric(decimalPlaces: 2)
                                                            ->label('A comprar'),
                                                        Infolists\Components\TextEntry::make('observation')
                                                            ->label('Observación'),
                                                    ]),
                                            ]),
                                        Fieldset::make('Fichas técnicas')
                                            ->visible(fn ($record) => $record->requisition->getMedia('technical_data_sheets')->count() > 0)
                                            ->schema([
                                                Infolists\Components\RepeatableEntry::make('media')
                                                    ->state(fn ($record) => $record->requisition->getMedia('technical_data_sheets'))
                                                    ->label('')
                                                    ->schema([
                                                        Infolists\Components\TextEntry::make('name')
                                                            ->label('Nombre del archivo'),
                                                    ]),
                                                SchemaActions::make([
                                                    Action::make('Descargar fichas')
                                                        ->action(function ($record) {
                                                            $downloads = $record->requisition->getMedia('technical_data_sheets');

                                                            return MediaStream::create($record->requisition->folio.'-fichas-tecnicas.zip')->addMedia($downloads);
                                                        }),
                                                ]),
                                            ]),
                                        Fieldset::make('Soportes')
                                            ->visible(fn ($record) => $record->requisition->getMedia('supports')->count() > 0)
                                            ->schema([
                                                Infolists\Components\RepeatableEntry::make('media')
                                                    ->state(fn ($record) => Media::where('model_id', $record->requisition->id)
                                                        ->where('collection_name', 'supports')
                                                        ->get())
                                                    ->label('')
                                                    ->schema([
                                                        Infolists\Components\TextEntry::make('name')
                                                            ->label('Nombre del archivo'),
                                                    ]),
                                                SchemaActions::make([
                                                    Action::make('Descargar soportes')
                                                        ->action(function ($record) {
                                                            $downloads = Media::where('model_id', $record->requisition->id)
                                                                ->where('collection_name', 'supports')
                                                                ->get();

                                                            return MediaStream::create($record->requisition->folio.'-soportes.zip')->addMedia($downloads);
                                                        }),
                                                ]),
                                            ]),
                                        Fieldset::make('Observaciones de la requisición')
                                            ->schema([
                                                Infolists\Components\TextEntry::make('observation')
                                                    ->label('')
                                                    ->placeholder('Sin observaciones')
                                                    ->columnSpanFull(),
                                            ]),
                                    ]),

                            ]),
                    ]),
                // ── Columna lateral derecha (siempre visible) ─────────────────
                Group::make()
                    // ->columnSpan(1)
                    ->columns(1)
                    ->schema([
                        // Resumen del total
                        Infolists\Components\ViewEntry::make('total_summary')
                            ->label('')
                            ->view('filament.infolists.entries.order-total-summary'),

                        // Flujo de aprobación e Historial en pestañas
                        Tabs::make('Seguimiento')
                            ->visible(fn ($record) => $record->status !== 'borrador')
                            ->extraAttributes(['class' => 'bg-white dark:bg-gray-800 rounded-xl shadow-sm'])
                            ->schema([
                                Tabs\Tab::make('Flujo de aprobación')
                                    ->schema([
                                        Infolists\Components\ViewEntry::make('progress')
                                            ->label('')
                                            ->columnSpanFull()
                                            ->view('filament.infolists.entries.progress-approval-v2'),
                                    ]),

                                Tabs\Tab::make('Historial')
                                    ->schema([
                                        Infolists\Components\ViewEntry::make('status')
                                            ->label('')
                                            ->columnSpanFull()
                                            ->view('filament.infolists.entries.history'),
                                    ]),
                            ]),
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
            ->recordActions([
                Actions\EditAction::make(),
                Actions\ViewAction::make(),
                Actions\DeleteAction::make()
                    ->visible(fn ($record) => $record->status == 'borrador'),
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
            'add-item' => Pages\AddItemPR::route('/{record}/agregar/partidas'),
        ];
    }
}
