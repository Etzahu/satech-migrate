<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder;

use App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource\Pages;
use App\Models\PurchaseOrder;
use App\Models\User;
use App\Services\OrderCalculationService;
use App\Services\PurchaseOrderReportService;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Forms;
use Filament\Infolists;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Builder;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class HistoryResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;

    protected static ?string $modelLabel = 'Orden';

    protected static ?string $pluralModelLabel = 'Historial de órdenes';

    protected static ?string $navigationLabel = 'Historial';

    protected static ?string $slug = 'orden-historial';

    protected static string|\UnitEnum|null $navigationGroup = 'Orden';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 12;

    public static function canAccess(): bool
    {
        return
            auth()->user()->hasRole('gerente_solicitante_orden_compra') ||
            auth()->user()->hasRole('autoriza_nivel-1-orden_compra') ||
            auth()->user()->hasRole('autoriza_nivel-2-orden_compra') ||
            auth()->user()->hasRole('comprador') ||
            auth()->user()->hasRole('gerente_compras') ||
            auth()->user()->hasRole('super_admin') ||
            auth()->user()->hasRole('visor_ordenes') ||
            auth()->user()->hasRole('administrador_compras');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getCreateAuthorizationResponse(): Response
    {
        return Response::deny();
    }

    public static function canEdit($record = null): bool
    {
        return
            auth()->user()->hasRole('super_admin');
    }

    public static function infolist(Schema $infolist): Schema
    {
        $options = [];

        return PurchaserResource::infolist($infolist, $options);
    }

    public static function form(Schema $form, array $options = []): Schema
    {
        $options['show_relation_items'] = true;

        return PurchaserResource::form($form, $options);
    }

    public static function getRelations(): array
    {
        return [
            AuditsRelationManager::class,
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('purchaser.name')
                    ->label('Comprador')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('provider.company_name')
                    ->label('Proveedor')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('requisition.folio')
                    ->label('Requisición')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('requisition.approvalChain.requester.name')
                    ->label('Solicitante')
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
                Tables\Filters\Filter::make('created_at')
                    ->schema([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Creados desde'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Creados hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->headerActions([
                Actions\Action::make('Generar reporte')
                    ->slideOver()
                    ->modalWidth(Width::FiveExtraLarge)
                    ->visible(
                        auth()->user()->id == 106 ||
                            auth()->user()->hasRole('comprador') ||
                            auth()->user()->hasRole('visor_ordenes') ||
                            auth()->user()->hasRole('gerente_compras') ||
                            auth()->user()->hasRole('super_admin') ||
                            auth()->user()->hasRole('administrador_compras')
                    )
                    ->schema(
                        [
                            Forms\Components\CheckboxList::make('columns')
                                ->label('Datos de la orden')
                                ->bulkToggleable()
                                ->columns(4)
                                ->required()
                                ->options([
                                    'fecha de creacion' => 'Fecha de creación',
                                    'comprador' => 'Comprador',
                                    'folio' => 'Folio',
                                    'proveedor' => 'Proveedor',
                                    'subtotal' => 'Subtotal',
                                    'total' => 'Total',
                                    'partidas' => 'Partidas',
                                    'moneda' => 'Moneda',
                                    'proyecto' => 'Proyecto',
                                    'tipo de pago' => 'Tipo de pago',
                                    'forma de pago' => 'Forma de pago',
                                    'condiciones de pago' => 'Condiciones de pago',
                                    'folio de cotización' => 'Folio de cotización',
                                    'uso de CFDI' => 'Uso de CFDI',
                                    'método de envío' => 'Método de envío',
                                    'iva' => 'IVA',
                                    'descuento por proveedor' => 'Descuento por proveedor',
                                    'retención de IVA' => 'Retención de IVA',
                                    'retención de ISR' => 'Retención de ISR',
                                    'fecha de entrega inicial' => 'Fecha de entrega inicial',
                                    'fecha de entrega final' => 'Fecha de entrega final',
                                    'dirección de entrega' => 'Dirección de entrega',
                                    'documentación de entrega' => 'Documentación de entrega',
                                    'observaciones' => 'Observaciones',
                                    'contacto de proveedor' => 'Contacto de proveedor',
                                    'empresa' => 'Empresa',
                                    'requisición' => 'Requisición',
                                    'estatus' => 'Estatus',
                                ])
                                ->afterStateHydrated(function ($component, $state) {
                                    if (! filled($state)) {
                                        $component->state(['fecha de creacion', 'comprador', 'folio', 'partidas', 'proveedor', 'subtotal', 'total', 'moneda', 'proyecto']);
                                    }
                                }),
                            Schemas\Components\Grid::make([
                                'default' => 2,
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 2,
                            ])
                                ->schema([
                                    Forms\Components\DatePicker::make('created_start')
                                        ->label('Creados desde')
                                        ->beforeOrEqual('created_end')
                                        ->required(),
                                    Forms\Components\DatePicker::make('created_end')
                                        ->label('Creados hasta')
                                        ->afterOrEqual('created_start')
                                        ->default(now())
                                        ->required(),
                                ]),
                            Forms\Components\Select::make('buyers')
                                ->label('Compradores (opcional)')
                                ->multiple()
                                ->nullable()
                                ->options(function () {
                                    return User::role('comprador')->pluck('name', 'id');
                                }),
                            Forms\Components\CheckboxList::make('type_purchase')
                                ->label('Tipo (opcional)')
                                ->columns(2)
                                ->options([
                                    'proveeduria' => 'Producto',
                                    'servicio' => 'Servicio',
                                ]),
                        ]
                    )
                    ->action(function (array $data) {
                        try {
                            // Forzar exportación a Excel
                            $data['type_save'] = 'excel';

                            $reportService = new PurchaseOrderReportService;
                            $result = $reportService->generateReport($data);

                            // Exportación a Excel
                            return fastexcel($result['sheets'])
                                ->download($result['filename']);
                        } catch (\Exception $e) {
                            $errorMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');

                            return Notification::make()
                                ->title('Error al generar reporte')
                                ->danger()
                                ->body("Error: {$errorMessage}")
                                ->persistent()
                                ->send();
                        }
                    }),
            ])
            ->recordActions([
                ActionGroup::make([
                    Actions\ViewAction::make(),
                    Actions\EditAction::make(),
                    Actions\Action::make('Ver pdf')
                        ->icon('heroicon-m-document')
                        ->url(fn ($record) => (string) route('order.pdf.show', ['id' => $record->id]))
                        ->openUrlInNewTab(),
                    Actions\Action::make('devolver_orden')
                        ->label('Devolver Orden')
                        ->icon('heroicon-m-arrow-uturn-left')
                        ->color('warning')
                        ->visible(fn () => auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('gerente_compras'))
                        ->requiresConfirmation()
                        ->modalHeading('¿Devolver orden al comprador?')
                        ->modalDescription('Esta acción devolverá la orden al comprador independientemente del estado actual. Se enviará una notificación por correo.')
                        ->modalSubmitActionLabel('Devolver')
                        ->action(function ($record) {
                            try {
                                $record->status()->transitionTo('devuelto por administrador', [
                                    'admin_id' => auth()->id(),
                                    'admin_name' => auth()->user()->name,
                                    'previous_state' => $record->status,
                                    'returned_at' => now(),
                                ]);

                                Notification::make()
                                    ->title('Orden devuelta exitosamente')
                                    ->body("La orden {$record->folio} ha sido devuelta al comprador.")
                                    ->success()
                                    ->send();
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title('Error al devolver la orden')
                                    ->body('No se pudo devolver la orden: '.$e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        }),
                    Actions\Action::make('ver_partidas')
                        ->label('Ver Partidas')
                        ->icon('heroicon-m-list-bullet')
                        ->color('info')
                        ->slideOver()
                        ->modalWidth(Width::FourExtraLarge)
                        ->modalSubmitAction(false)
                        ->schema(function ($record): array {
                            return [
                                Schemas\Components\Section::make('Partidas de la Orden')
                                    ->description('Detalle de los productos/servicios de la orden '.$record->folio)
                                    ->schema([
                                        Infolists\Components\RepeatableEntry::make('items')
                                            ->label('')
                                            ->contained(false)
                                            ->schema([
                                                Schemas\Components\Fieldset::make('')
                                                    ->schema([
                                                        Infolists\Components\TextEntry::make('product.name')
                                                            ->label('Producto/Servicio'),
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
                                                                $state = $service->brickFormatter($state, $record->order->currency);

                                                                return $state;
                                                            }),
                                                        Infolists\Components\TextEntry::make('sub_total')
                                                            ->label('Subtotal')
                                                            ->formatStateUsing(function ($state, $record) {
                                                                if (blank($state)) {
                                                                    return '0.0000';
                                                                }
                                                                $service = new OrderCalculationService;
                                                                $state = $service->brickFormatter($state, $record->order->currency);

                                                                return $state;
                                                            }),
                                                        Infolists\Components\TextEntry::make('observation')
                                                            ->label('Observación')
                                                            ->columnSpanFull()
                                                            ->placeholder('Sin observaciones'),
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
                            ];
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePR::route('/'),
            'view' => Pages\View::route('/{record}'),
            'edit' => Pages\Edit::route('/{record}/edit'),
        ];
    }

    public static function formatConditionPayment($model)
    {
        if (blank($model->condition_payment)) {
            return 'N/A';
        }
        if (is_array($model->condition_payment)) {
            $value = implode(',', array_column($model->condition_payment, 'concept'));

            return $value;
        } else {
            return $model->condition_payment;
        }
    }

    public static function documentation($model)
    {
        if (blank($model->documentation_delivery)) {
            return 'N/A';
        }

        return implode(',', array_column($model->documentation_delivery, 'name'));
    }

    public static function contactDataItems($model)
    {
        $result = '';
        $items = $model->items;
        foreach ($items as $item) {
            $resum = "{$item->product->name} ({$item->product->type_purchase})\n";
            $result .= $resum;
        }

        return $result;
    }
}
