<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition;


use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Management;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\PurchaseRequisition;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Rap2hpoutre\FastExcel\SheetCollection;
use Filament\Support\Enums\MaxWidth;
use App\Services\GoogleSheetsRequisitionService;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;
use App\Filament\Purchases\Resources\PurchaseRequisition\HistoryResource\Pages;


class HistoryResource extends Resource
{
    protected static ?string $model = PurchaseRequisition::class;
    protected static ?string $modelLabel = 'Historial de requisición';
    protected static ?string $pluralModelLabel = 'Historial de requisiciones';
    protected static ?string $navigationLabel = 'Historial';
    protected static ?string $slug = 'requisiciones-historial';
    protected static ?string $navigationGroup = 'Requisiciones';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 12;

    public static function canAccess(): bool
    {
        return
            auth()->user()->hasRole('solicita_requisicion_compra') ||
            auth()->user()->hasRole('revisa_almacen_requisicion_compra') ||
            auth()->user()->hasRole('revisa_requisicion_compra') ||
            auth()->user()->hasRole('aprueba_requisicion_compra') ||
            auth()->user()->hasRole('autoriza_requisicion_compra') ||
            auth()->user()->hasRole('gerente_compras') ||
            auth()->user()->hasRole('visor_requisiciones') ||
            auth()->user()->hasRole('comprador') ||
            auth()->user()->hasRole('administrador_compras');
    }
    public static function canCreate(): bool
    {
        return false;
    }
    public static function form(form $form): Form
    {
        return RequesterResource::form($form);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        $options = [];
        return RequesterResource::infolist($infolist, $options);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->label('Folio')
                    ->copyable()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('approvalChain.requester.name')
                    ->label('Solicitante')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project.name')
                    ->label('Proyecto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('motive')
                    ->label('Referencia')
                    ->words(5)
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_delivery')
                    ->label('Fecha deseable de entrega')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualización')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estatus')
                    ->options(PurchaseRequisition::select('id', 'status')->orderBy('status', 'asc')->get()->pluck('status', 'status')->unique())
                    ->attribute('status'),
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
                    }),
                Tables\Filters\Filter::make('gerencias')
                    ->form([
                        Forms\Components\Select::make('management_id')
                            ->label('Gerencia')
                            ->options(Management::all()->pluck('name', 'id'))
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['management_id'],
                                fn(Builder $query, $management): Builder => $query
                                    ->withWhereHas('approvalChain.requester', function ($query) use ($management) {
                                        $query->where('management_id', $management);
                                    })
                                    ->orderBy('created_at', 'ASC'),
                            );
                    }),
            ])
            ->headerActions([
                Tables\Actions\Action::make('Generar reporte')
                    ->slideOver()
                    ->modalWidth(MaxWidth::FiveExtraLarge)
                    ->visible(
                        auth()->user()->id == 106 ||
                            auth()->user()->hasRole('comprador') ||
                            auth()->user()->hasRole('gerente_compras') ||
                            auth()->user()->hasRole('super_admin') ||
                            auth()->user()->hasRole('visor_requisiciones') ||
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
                                ->label('Datos de la requisición')
                                ->bulkToggleable()
                                ->columns(4)
                                ->required()
                                ->options([
                                    'folio' => 'Folio',
                                    'motivo' => 'Motivo',
                                    'partidas' => 'Partidas',
                                    'prioridad' => 'Prioridad',
                                    'tipo' => 'Tipo',
                                    'observaciones' => 'Observaciones',
                                    'fecha de entrega' => 'Fecha de entrega',
                                    'dirección de entrega' => 'Dirección de entrega',
                                    'estatus' => 'Estatus',
                                    'empresa' => 'Empresa',
                                    'proyecto' => 'Proyecto',
                                    'solicitante' => 'Solicitante',
                                    'comprador' => 'Comprador',
                                    'fecha de creacion' => 'Fecha de creación',
                                ])
                                ->afterStateHydrated(function ($component, $state) {
                                    if (! filled($state)) {
                                        $component->state(['solicitante', 'motivo', 'comprador', 'folio', 'partidas', 'proyecto', 'partidas']);
                                    }
                                }),
                            Forms\Components\ToggleButtons::make('without_orders')
                                ->label('¿Sin órden?')
                                ->boolean()
                                ->default(false)
                                ->inline(),
                            Forms\Components\Grid::make([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 2,
                                'xl' => 2,
                            ])->schema([
                                Forms\Components\DatePicker::make('created_start')
                                    ->label('Creados desde')
                                    ->beforeOrEqual('created_end')
                                    ->required(),
                                Forms\Components\DatePicker::make('created_end')
                                    ->label('Creados hasta')
                                    ->afterOrEqual('created_start')
                                    ->default(now())
                                    ->required(),
                            ])
                        ]
                    )
                    ->action(function (array $data) {
                        $startDate = Carbon::createFromFormat('Y-m-d', $data['created_start'])->startOfDay();
                        $endDate = Carbon::createFromFormat('Y-m-d', $data['created_end'])->endOfDay();

                        if ($data['type_save'] == 'sheets') {
                            try {
                                $sheetsService = new GoogleSheetsRequisitionService();
                                $result_sheets = $sheetsService->processRequisitionsReport($data);

                                return Notification::make()
                                    ->title('Reporte cargado correctamente en tu hoja personal')
                                    ->success()
                                    ->body("Las requisiciones se han cargado en tu hoja personal <strong>{$result_sheets['user_sheet']}</strong><br>
                                           <a href='{$result_sheets['spreadsheet_url']}' target='_blank' class='font-bold text-blue-600 underline hover:text-blue-800'>
                                               🔗 Abrir Google Sheets
                                           </a><br>
                                           <small class='text-gray-600'>
                                               📊 Usuario: {$result_sheets['user_name']}<br>
                                               📅 Rango: {$result_sheets['date_range']}<br>
                                               📋 Total de requisiciones: {$result_sheets['total_requisitions']}
                                           </small>")
                                    ->persistent()
                                    ->send();
                            } catch (\Exception $e) {
                                return Notification::make()
                                    ->title('Error al cargar en Google Sheets')
                                    ->danger()
                                    ->body("❌ Error: {$e->getMessage()}")
                                    ->persistent()
                                    ->send();
                            }
                        } else {
                            // Exportación a Excel usando el servicio reestructurado
                            try {
                                $exportService = new GoogleSheetsRequisitionService();
                                $requisitionsData = $exportService->processRequisitionsReport($data);

                                // Preparar datos de items para la segunda hoja
                                $models = PurchaseRequisition::with(['company', 'project', 'approvalChain', 'purchaser', 'items.product'])
                                    ->where('company_id', session()->get('company_id'))
                                    ->whereBetween('created_at', [$startDate, $endDate]);

                                if ($data['without_orders']) {
                                    $models->whereDoesntHave('orders')
                                        ->whereIn('status', ['comprador asignado', 'comprador reasignado']);
                                }
                                $models = $models->get();

                                if (blank($models)) {
                                    return Notification::make()
                                        ->title('No se encontraron registros')
                                        ->danger()
                                        ->send();
                                }

                                $items = $models->pluck('items')->flatten();
                                $dataItems = [];

                                foreach ($items as $item) {
                                    $dataItems[] = [
                                        'Requisición' => $item->requisition->folio,
                                        'Cantidad' => $item->quantity_purchase,
                                        'Producto-Servicio' => $item->product->name,
                                        'Tipo' => $item->product->type_purchase,
                                        'Observaciones' => $item->observation
                                    ];
                                }

                                $sheets = new SheetCollection([
                                    'requisiciones' => $requisitionsData,
                                    'partidas' => $dataItems
                                ]);

                                return fastexcel($sheets)
                                    ->download("requisiciones de compra {$startDate->format('d-m-Y')} {$endDate->format('d-m-Y')}.xlsx");
                            } catch (\Exception $e) {
                                return Notification::make()
                                    ->title('Error al generar reporte Excel')
                                    ->danger()
                                    ->body("❌ Error: {$e->getMessage()}")
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
                        ->url(fn($record) => (string)route('requisition.pdf', ['id' => $record->id]))
                        ->openUrlInNewTab(),
                ]),
            ]);
    }
    public static function getRelations(): array
    {
        return [
            AuditsRelationManager::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePR::route('/'),
            'view' => Pages\View::route('/{record}'),
            'edit' => Pages\Edit::route('/{record}/edit'),
        ];
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
