<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder;


use App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource\Pages;
use App\Models\PurchaseOrder;
use App\Models\User;
use App\Services\OrderCalculationService;
use App\Services\GoogleSheetsService;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Rap2hpoutre\FastExcel\SheetCollection;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class HistoryResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;
    protected static ?string $modelLabel = 'Orden';
    protected static ?string $pluralModelLabel = 'Historial de órdenes';
    protected static ?string $navigationLabel = 'Historial';
    protected static ?string $slug = 'orden-historial';
    protected static ?string $navigationGroup = 'Orden';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
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
    public static function canEdit($record = null): bool
    {
        return
            auth()->user()->hasRole('super_admin') ||
            auth()->user()->hasRole('administrador_compras') ||
            auth()->user()->hasRole('gerente_compras');
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        $options = [];
        return PurchaserResource::infolist($infolist, $options);
    }

    public static function form(Form $form, array $options = []): Form
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
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Creados desde'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Creados hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->headerActions([
                Tables\Actions\Action::make('Generar reporte')
                    ->slideOver()
                    ->modalWidth(MaxWidth::FiveExtraLarge)
                    ->visible(
                        auth()->user()->id == 106 ||
                            auth()->user()->hasRole('comprador') ||
                            auth()->user()->hasRole('visor_ordenes') ||
                            auth()->user()->hasRole('gerente_compras') ||
                            auth()->user()->hasRole('super_admin') ||
                            auth()->user()->hasRole('administrador_compras')
                    )
                    ->form(
                        [
                            Forms\Components\ToggleButtons::make('type_save')
                                ->label('Guardar información en:')
                                ->required()
                                ->options([
                                    'excel' => 'Excel',
                                    'sheets' => 'Google Sheets',
                                ])
                                ->icons([
                                    'excel' => 'fileicon-microsoft-excel',
                                    'sheets' => 'si-googlesheets',
                                ])
                                ->colors([
                                    'excel' => 'info',
                                    'sheets' => 'success',
                                ])

                                ->default('excel')
                                ->inline()
                                ->disableOptionWhen(fn(string $value): bool => $value === 'sheets' &&  !auth()->user()->hasRole('comprador')),
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
                            Forms\Components\Grid::make([
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
                        $startDate = Carbon::createFromFormat('Y-m-d', $data['created_start'])->startOfDay();
                        $endDate = Carbon::createFromFormat('Y-m-d', $data['created_end'])->endOfDay();

                        if ($data['type_save'] == 'sheets') {
                            try {
                                $sheetsService = new GoogleSheetsService();
                                $result_sheets = $sheetsService->processOrdersReport($data);

                                // Sanitizar y codificar correctamente los datos para UTF-8
                                $userSheet = htmlspecialchars($result_sheets['user_sheet'], ENT_QUOTES, 'UTF-8');
                                $userName = htmlspecialchars($result_sheets['user_name'], ENT_QUOTES, 'UTF-8');
                                $dateRange = htmlspecialchars($result_sheets['date_range'], ENT_QUOTES, 'UTF-8');
                                $totalOrders = (int) $result_sheets['total_orders'];
                                $spreadsheetUrl = filter_var($result_sheets['spreadsheet_url'], FILTER_SANITIZE_URL);

                                return Notification::make()
                                    ->title('Reporte cargado correctamente en tu hoja personal')
                                    ->success()
                                    ->body("Las órdenes se han cargado en tu hoja personal <strong>{$userSheet}</strong><br>
                                           <a href='{$spreadsheetUrl}' target='_blank' class='font-bold text-blue-600 underline hover:text-blue-800'>
                                               Abrir Google Sheets
                                           </a><br>
                                           <small class='text-gray-600'>
                                               Usuario: {$userName}<br>
                                               Rango: {$dateRange}<br>
                                               Total de órdenes: {$totalOrders}
                                           </small>")
                                    ->persistent()
                                    ->send();
                            } catch (\Exception $e) {
                                $errorMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
                                return Notification::make()
                                    ->title('Error al cargar en Google Sheets')
                                    ->danger()
                                    ->body("Error: {$errorMessage}")
                                    ->persistent()
                                    ->send();
                            }
                        } else {
                            // Exportación a Excel usando el servicio reestructurado
                            try {
                                $exportService = new GoogleSheetsService();
                                $ordersData = $exportService->processOrdersReport($data);

                                // Preparar datos de items para la segunda hoja
                                $models = PurchaseOrder::with(['requisition', 'provider', 'company', 'purchaser'])
                                    ->where('company_id', session()->get('company_id'))
                                    ->whereBetween('created_at', [$startDate, $endDate]);

                                if (filled($data['buyers'])) {
                                    $models = $models->whereIn('purchaser_user_id', $data['buyers']);
                                }
                                if (filled($data['type_purchase'])) {
                                    $models->whereHas('items.product', function ($query) use ($data) {
                                        $query->whereIn('type_purchase', $data['type_purchase']);
                                    });
                                }
                                $models = $models->get();

                                $items = $models->pluck('items')->flatten();
                                $dataItems = [];
                                $service = new OrderCalculationService();

                                foreach ($items as $item) {
                                    $dataItems[] = [
                                        'Orden' => $item->purchase->folio,
                                        'Cantidad' => $item->quantity,
                                        'Precio unitario' => $service->brickFormatter($item->unit_price),
                                        'Subtotal' => $service->brickFormatter($item->sub_total),
                                        'Producto-Servicio' => $item->product->name,
                                        'Tipo' => $item->product->type_purchase,
                                        'Observaciones' => $item->observation
                                    ];
                                }

                                $sheets = new SheetCollection([
                                    'ordenes' => $ordersData,
                                    'partidas' => $dataItems
                                ]);

                                return fastexcel($sheets)
                                    ->download("ordenes de compra {$startDate->format('d-m-Y')} {$endDate->format('d-m-Y')}.xlsx");
                            } catch (\Exception $e) {
                                $errorMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
                                return Notification::make()
                                    ->title('Error al generar reporte Excel')
                                    ->danger()
                                    ->body("Error: {$errorMessage}")
                                    ->persistent()
                                    ->send();
                            }
                        }
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('Ver pdf')
                        ->icon('heroicon-m-document')
                        ->url(fn($record) => (string)route('order.pdf', ['id' => $record->id]))
                        ->openUrlInNewTab(),
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
        return  implode(',', array_column($model->documentation_delivery, 'name'));
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
