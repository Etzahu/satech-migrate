<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition;

use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\RelationManagers;
use App\Models\ProjectPurchase;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use App\Services\PurchaseRequisitionCreationService;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Infolists;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Components\Icon;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Njxqlus\Filament\Components\Infolists\RelationManager;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

class RequesterResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = PurchaseRequisition::class;

    protected static ?string $modelLabel = 'Requisición';

    protected static ?string $pluralModelLabel = 'Requisiciones';

    protected static ?string $navigationLabel = 'Mis requisiciones';

    protected static ?string $slug = 'mis-requisiciones';

    protected static string|\UnitEnum|null $navigationGroup = 'Requisiciones';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('solicita_requisicion_compra');
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
            'view_review_warehouse',
            'view_review',
            'view_approve',
            'view_authorize',
            'view_assing',
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->myRequisitions();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::myRequisitionsDraft()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $form, ?\Closure $flujoAprobacionTab = null): Schema
    {
        return $form
            ->columns(1)
            ->schema([
                Tabs::make('tabs')
                    ->tabs([
                        Tabs\Tab::make('Información general')
                            ->schema([
                                Forms\Components\Select::make('category')
                                    ->label('Categoría de requisición')
                                    ->belowContent([
                                        Icon::make(Heroicon::InformationCircle),
                                        Text::make('Seleccione si la requisición es para solicitar productos o servicios. Esto determinará el tipo de partidas que puede cargar.')->color('danger')->weight(FontWeight::Medium),
                                    ])
                                    ->options([
                                        'servicio' => 'Servicio',
                                        'proveeduria' => 'Proveeduría',
                                    ])
                                    ->disabled(fn ($operation) => $operation == 'edit')
                                    ->hintAction(
                                        Actions\Action::make('Cambiar categoría')
                                            ->icon('heroicon-m-arrow-path')
                                            ->visible(fn ($operation) => $operation == 'edit')
                                            ->requiresConfirmation()
                                            ->schema([
                                                Forms\Components\Select::make('selected')
                                                    ->label('Categoría de requisición')
                                                    ->options(function ($record) {
                                                        if (filled($record->category)) {
                                                            if ($record->category == 'servicio') {
                                                                return ['proveeduria' => 'Proveeduría'];
                                                            }
                                                            if ($record->category == 'proveeduria') {
                                                                return ['servicio' => 'Servicio'];
                                                            }
                                                        }
                                                        if (blank($record->category)) {
                                                            return [
                                                                'servicio' => 'Servicio',
                                                                'proveeduria' => 'Proveeduría',
                                                            ];
                                                        }

                                                        return [];
                                                    })
                                                    ->required(),
                                            ])
                                            ->modalDescription('Al cambiar la categoría de Servicio a Proveeduría o viceversa , todas las partidas actuales serán eliminadas.')
                                            ->color('danger')
                                            ->action(function (Set $set, $record, $livewire, $data) {
                                                try {
                                                    $record->category = $data['selected'];
                                                    $set('category', $data['selected']);
                                                    $record->save();
                                                    if ($data['selected'] == 'servicio') {
                                                        if (session()->get('company_id') == 2) { // ID 2:TECHENERGY
                                                            $record->items()
                                                                ->whereHas('product', function ($query) {
                                                                    $query->where('type_purchase', 'proveeduria');
                                                                })
                                                                ->forceDelete();
                                                        }
                                                    }
                                                    if ($data['selected'] == 'proveeduria') {
                                                        if (session()->get('company_id') == 2) { // ID 2:TECHENERGY
                                                            $record->items()
                                                                ->whereHas('product', function ($query) {
                                                                    $query->where('type_purchase', 'servicio');
                                                                })
                                                                ->forceDelete();
                                                        }
                                                    }
                                                    Notification::make()
                                                        ->title('Se aplicó el cambio')
                                                        ->success()
                                                        ->send();

                                                    return redirect(request()->header('Referer'));
                                                } catch (\Exception $e) {
                                                    logger()->error($e->getMessage());
                                                    Notification::make()
                                                        ->title('Ocurrió un error')
                                                        ->danger()
                                                        ->send();
                                                }
                                            })

                                    )
                                    ->required(),
                                Forms\Components\Textarea::make('motive')
                                    ->label('Referencia')
                                    ->maxLength(600)
                                    ->required(),
                                Forms\Components\Select::make('priority')
                                    ->label('Prioridad')
                                    ->options([
                                        'baja' => 'Baja',
                                        'media' => 'Media',
                                        'alta' => 'Alta',
                                    ])
                                    ->default('baja')
                                    ->required(),
                                Forms\Components\Select::make('type')
                                    ->label('Tipo de requisición')
                                    ->options([
                                        'compra' => 'Compra',
                                        'cotización' => 'Cotización',
                                    ])
                                    ->required(),
                                Forms\Components\DatePicker::make('date_delivery')
                                    ->label('Fecha deseable de entrega')
                                    ->default(now()->addDay(3))
                                    ->required(),
                                Forms\Components\Textarea::make('delivery_address')
                                    ->label('Dirección de entrega')
                                    ->required()
                                    ->maxLength(500),
                                Forms\Components\Select::make('project_id')
                                    ->label('Proyecto')
                                    ->options(function (?Model $record) {
                                        $management = auth()->user()->management;
                                        $result = [];
                                        if (filled($management->restriction_requisition)) {
                                            $projects = auth()->user()->management->projects->pluck('id');
                                            if ($management->restriction_requisition == 'excluir') {
                                                $result = ProjectPurchase::where('company_id', session()->get('company_id'))
                                                    ->whereNotIn('id', $projects)
                                                    ->where('status', 'activo')
                                                    ->orderBy('created_at', 'desc')
                                                    ->get();
                                            }
                                            if ($management->restriction_requisition == 'limitar') {
                                                $result = ProjectPurchase::where('company_id', session()->get('company_id'))
                                                    ->whereIn('id', $projects)
                                                    ->where('status', 'activo')
                                                    ->orderBy('created_at', 'desc')
                                                    ->get();
                                            }
                                        } else {
                                            $result = ProjectPurchase::where('company_id', session()->get('company_id'))
                                                ->where('status', 'activo')
                                                ->orderBy('created_at', 'desc')
                                                ->get();
                                        }
                                        $result = collect($result);
                                        // Si el proyecto actual está inactivo, incluirlo para no perder la selección
                                        if ($record?->project_id && ! $result->contains('id', $record->project_id)) {
                                            $current = ProjectPurchase::find($record->project_id);
                                            if ($current) {
                                                $result->prepend($current);
                                            }
                                        }
                                        $result = $result->mapWithKeys(function ($item) {
                                            $label = "($item->code)".$item->name;
                                            if ($item->status !== 'activo') {
                                                $label .= ' [Inactivo]';
                                            }

                                            return [$item->id => $label];
                                        })->toArray();

                                        return $result;
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),
                        $flujoAprobacionTab
                            ? ($flujoAprobacionTab)()
                            : static::flujoAprobacionTab(),
                        Tabs\Tab::make('Fichas técnicas')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('technical_data_sheets')
                                    ->label('Fichas técnica')
                                    ->multiple()
                                    ->maxParallelUploads(1)
                                    ->hint('Puedes adjuntar más de un documento.')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->collection('technical_data_sheets'),
                            ]),

                        Tabs\Tab::make('Soportes')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('supports')
                                    ->label('Soportes')
                                    // ->acceptedFileTypes(['application/pdf'])
                                    ->maxParallelUploads(1)
                                    ->multiple()
                                    ->hintColor('danger')
                                    ->collection('supports'),
                            ]),
                        Tabs\Tab::make('Observación')
                            ->schema([
                                Forms\Components\Textarea::make('observation')
                                    ->label('Observación adicionales')
                                    ->maxLength(2000)
                                    ->default('Sin observaciones')
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    /**
     * Cadenas del usuario autenticado que pueden usarse en una requisición:
     * todas sus participantes deben estar activos. Al editar se conserva la
     * cadena ya asignada aunque alguien se haya desactivado, para no dejar el
     * formulario sin opción seleccionada.
     */
    public static function selectableChains(?PurchaseRequisition $record = null): \Illuminate\Database\Eloquent\Collection
    {
        return PurchaseRequisitionApprovalChain::query()
            ->with(['reviewer', 'approver', 'authorizer'])
            ->where('requester_id', auth()->id())
            ->where(fn (Builder $query) => $query
                ->fullyActive()
                ->when(
                    $record?->approval_chain_id,
                    fn (Builder $q, $chainId) => $q->orWhere($q->getModel()->getQualifiedKeyName(), $chainId)
                ))
            ->get();
    }

    public static function flujoAprobacionTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Flujo de aprobación')
            ->columns([
                'sm' => 1,
                'xl' => 2,
            ])
            ->schema([
                Forms\Components\Select::make('reviewer_id')
                    ->label('Revisa')
                    // Solo se ofrecen cadenas cuyos participantes (revisa/aprueba/autoriza)
                    // siguen activos, para no generar requisiciones que nazcan bloqueadas.
                    ->options(
                        fn (?PurchaseRequisition $record) => static::selectableChains($record)
                            ->pluck('reviewer.name', 'reviewer.id')
                    )
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('approver_id', null))
                    ->required(),
                Forms\Components\Select::make('approver_id')
                    ->label('Aprueba')
                    ->options(function (Get $get, ?PurchaseRequisition $record) {
                        $reviewerId = $get('reviewer_id');
                        if (! $reviewerId) {
                            return [];
                        }

                        return static::selectableChains($record)
                            ->where('reviewer_id', $reviewerId)
                            ->pluck('approver.name', 'approver.id');
                    })
                    ->live()
                    ->required(),
                // Último eslabón de la cadena: se muestra solo lectura porque
                // queda determinado por la combinación revisa/aprueba elegida.
                Forms\Components\Placeholder::make('authorizer_name')
                    ->label('Autoriza')
                    ->content(function (Get $get, ?PurchaseRequisition $record) {
                        $reviewerId = $get('reviewer_id');
                        $approverId = $get('approver_id');

                        if (! $reviewerId || ! $approverId) {
                            return 'Seleccione quién revisa y quién aprueba.';
                        }

                        return static::selectableChains($record)
                            ->where('reviewer_id', $reviewerId)
                            ->where('approver_id', $approverId)
                            ->first()?->authorizer?->name
                            ?? 'Sin autorizador definido para este flujo.';
                    }),
            ]);
    }

    public static function infolist(Schema $infolist, $options = []): Schema
    {
        return $infolist
            ->columns(3)
            ->schema([
                // ── Columna principal (izquierda) ─────────────────────────────
                Schemas\Components\Group::make()
                    ->columnSpan(2)
                    ->schema([
                        // Header: datos clave siempre visibles
                        Schemas\Components\Fieldset::make('')
                            ->extraAttributes(['class' => 'bg-white dark:bg-gray-800 rounded-xl shadow-sm'])
                            ->schema([
                                Infolists\Components\TextEntry::make('folio')
                                    ->label('Folio')
                                    ->weight(FontWeight::Bold),
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Estatus')
                                    ->badge()
                                    ->color('success'),
                                Infolists\Components\TextEntry::make('priority')
                                    ->label('Prioridad')
                                    ->badge()
                                    ->color('success'),
                                Infolists\Components\TextEntry::make('category')
                                    ->label('Categoría')
                                    ->badge()
                                    ->color('success'),
                                Infolists\Components\TextEntry::make('project.name')
                                    ->label('Proyecto'),
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
                                Tabs\Tab::make('Datos generales')
                                    ->icon('heroicon-o-document-text')
                                    ->columns(3)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('type')
                                            ->label('Tipo de requisición')
                                            ->badge()
                                            ->color('success'),
                                        Infolists\Components\TextEntry::make('approvalChain.requester.name')
                                            ->label('Solicitante'),
                                        Infolists\Components\TextEntry::make('motive')
                                            ->label('Referencia'),
                                        Infolists\Components\TextEntry::make('date_delivery')
                                            ->label('Fecha deseable de entrega')
                                            ->date(),
                                        Infolists\Components\TextEntry::make('delivery_address')
                                            ->label('Dirección de entrega')
                                            ->columnSpan(2),
                                        Infolists\Components\TextEntry::make('observation')
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
                                            ->schema([
                                                Infolists\Components\TextEntry::make('product.code')
                                                    ->label('Código'),
                                                Infolists\Components\TextEntry::make('product.name')
                                                    ->label(fn ($record) => $record->requisition?->item_label ?? 'Producto'),
                                                Infolists\Components\TextEntry::make('quantity_warehouse')
                                                    ->label('Cantidad en almacén')
                                                    ->numeric(decimalPlaces: 2),
                                                Infolists\Components\TextEntry::make('quantity_purchase')
                                                    ->label('Cantidad para comprar')
                                                    ->numeric(decimalPlaces: 2),
                                                Infolists\Components\TextEntry::make('observation')
                                                    ->label('Observación')
                                                    ->columnSpan(2),
                                            ])
                                            ->columns(5),
                                    ]),

                                // 3. Adjuntos (fichas técnicas y soportes)
                                Tabs\Tab::make('Adjuntos')
                                    ->icon('heroicon-o-paper-clip')
                                    ->visible(
                                        fn ($record) => $record->getMedia('technical_data_sheets')->count() > 0
                                            || $record->getMedia('supports')->count() > 0
                                    )
                                    ->schema([
                                        Schemas\Components\Fieldset::make('Fichas técnicas')
                                            ->visible(fn ($record) => $record->getMedia('technical_data_sheets')->count() > 0)
                                            ->schema([
                                                Infolists\Components\RepeatableEntry::make('media')
                                                    ->state(fn ($record) => $record->getMedia('technical_data_sheets'))
                                                    ->label('')
                                                    ->schema([
                                                        Infolists\Components\TextEntry::make('name')
                                                            ->label('Nombre del archivo')
                                                            ->hintActions([
                                                                Actions\Action::make('Ver documento')
                                                                    ->url(fn ($record): string => route('media.show', ['id' => $record->id]))
                                                                    ->openUrlInNewTab(),
                                                            ]),
                                                    ]),
                                                Schemas\Components\Actions::make([
                                                    Actions\Action::make('Descargar fichas')
                                                        ->action(function ($record) {
                                                            $downloads = $record->getMedia('technical_data_sheets');

                                                            return MediaStream::create($record->folio.'-fichas-tecnicas.zip')->addMedia($downloads);
                                                        }),
                                                ]),
                                            ]),
                                        Schemas\Components\Fieldset::make('Soportes')
                                            ->visible(fn ($record) => $record->getMedia('supports')->count() > 0)
                                            ->schema([
                                                Infolists\Components\RepeatableEntry::make('media')
                                                    ->state(fn ($record) => Media::where('model_id', $record->id)
                                                        ->where('collection_name', 'supports')
                                                        ->get())
                                                    ->label('')
                                                    ->schema([
                                                        Infolists\Components\TextEntry::make('name')
                                                            ->label('Nombre del archivo')
                                                            ->hintActions([
                                                                Actions\Action::make('Ver documento')
                                                                    ->url(fn ($record): string => route('media.show', ['id' => $record->id]))
                                                                    ->openUrlInNewTab(),
                                                            ]),
                                                    ]),
                                                Schemas\Components\Actions::make([
                                                    Actions\Action::make('Descargar soportes')
                                                        ->action(function ($record) {
                                                            $downloads = Media::where('model_id', $record->id)
                                                                ->where('collection_name', 'supports')
                                                                ->get();

                                                            return MediaStream::create($record->folio.'-soportes.zip')->addMedia($downloads);
                                                        }),
                                                ]),
                                            ]),
                                    ]),

                                // 4. Órdenes de compra generadas
                                Tabs\Tab::make('Órdenes de compra')
                                    ->icon('heroicon-o-shopping-cart')
                                    ->visible(fn ($record) => filled($record->orders))
                                    ->schema([
                                        RelationManager::make()->manager(RelationManagers\OrdersRelationManager::class)->lazy(false),
                                    ]),
                            ]),
                    ]),

                // ── Columna lateral derecha (siempre visible) ─────────────────
                Schemas\Components\Group::make()
                    ->columns(1)
                    ->schema([
                        // Resumen
                        Schemas\Components\Fieldset::make('Resumen')
                            ->extraAttributes(['class' => 'bg-white dark:bg-gray-800 rounded-xl shadow-sm'])
                            ->columns(1)
                            ->schema([
                                Infolists\Components\TextEntry::make('purchaser.name')
                                    ->label('Comprador asignado')
                                    ->placeholder('Sin asignar'),
                                Infolists\Components\TextEntry::make('date_delivery')
                                    ->label('Fecha deseable de entrega')
                                    ->date(),
                                Infolists\Components\TextEntry::make('orders_count')
                                    ->label('Órdenes de compra generadas')
                                    ->state(fn ($record) => $record->orders->count()),
                            ]),

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
                    ->label('Folio')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('project.name')
                    ->label('Proyecto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('motive')
                    ->label('Motivo')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('date_delivery')
                    ->label('Fecha deseable de entrega')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                ActionGroup::make([
                    Actions\ViewAction::make(),
                    Actions\EditAction::make()
                        ->visible(function (PurchaseRequisition $record) {
                            $states = [
                                'borrador',
                                'cadena reasignada',
                                'devuelto por almacén',
                                'devuelto por revisor',
                                'devuelto por gerencia',
                                'devuelto por DG',
                                'devuelto por comprador',
                            ];

                            return in_array($record->status, $states);
                        }),
                    Actions\Action::make('Ver pdf')
                        ->icon('heroicon-m-document')
                        ->url(fn ($record) => (string) route('requisition.pdf', ['id' => $record->id]))
                        ->openUrlInNewTab(),
                    Actions\Action::make('Replicar')
                        ->fillForm(fn (PurchaseRequisition $record): array => [
                            'project_id' => $record->project_id,
                            'motive' => '(replicado) '.$record->motive,
                            'date_delivery' => now()->addDays(1),
                            'priority' => $record->priority,
                            'type' => $record->type,
                            'category' => $record->category,
                            'delivery_address' => $record->delivery_address,
                            'reviewer_id' => $record->approvalChain->reviewer_id,
                            'approver_id' => $record->approvalChain->approver_id,
                            'observation' => $record->observation,
                        ])
                        ->schema(fn (Schema $form) => static::form($form)->columns(1))
                        ->slideOver()
                        ->action(function (array $data, PurchaseRequisition $record) {
                            try {
                                // Crear nueva requisición con los datos del formulario
                                $newRequisition = new PurchaseRequisition;

                                // Llenar con los datos del formulario (respeta cambios del usuario)
                                $newRequisition->fill($data);

                                // Asignar valores que no vienen del formulario
                                $newRequisition->company_id = $record->company_id;
                                $newRequisition->approval_chain_id = $record->approval_chain_id;
                                $newRequisition->status = 'borrador';
                                $newRequisition->assign_user_id = null;

                                // Generar nuevo folio
                                $service = new PurchaseRequisitionCreationService;
                                $newRequisition->folio = $service->generateFolio();

                                // Guardar la nueva requisición
                                $newRequisition->save();

                                // Replicar las relaciones

                                // Replicar items (partidas)
                                foreach ($record->items as $item) {
                                    $newItem = $item->replicate();
                                    $newItem->requisition_id = $newRequisition->id;
                                    $newItem->save();
                                }

                                Notification::make()
                                    ->title('Requisición replicada correctamente')
                                    ->body("Nueva requisición creada: {$newRequisition->folio}")
                                    ->success()
                                    ->send();

                                // Opcional: Redirigir a la nueva requisición
                                return redirect()->to(static::getUrl('edit', ['record' => $newRequisition]));
                            } catch (\Exception $e) {
                                logger()->error('Error al replicar requisición: '.$e->getMessage(), [
                                    'original_id' => $record->id,
                                    'user_id' => auth()->id(),
                                    'form_data' => $data,
                                    'trace' => $e->getTraceAsString(),
                                ]);

                                Notification::make()
                                    ->title('Error al replicar requisición')
                                    ->body('Ocurrió un error: '.$e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->icon('heroicon-s-document-duplicate'),
                ]),
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
            'index' => Pages\ListPurchaseRequisitions::route('/'),
            'create' => Pages\CreatePurchaseRequisition::route('/create'),
            'view' => Pages\ViewPurchaseRequisition::route('/{record}'),
            'edit' => Pages\EditPurchaseRequisition::route('/{record}/edit'),
        ];
    }
}
