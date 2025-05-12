<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder;


use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PurchaseOrder;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use App\Services\OrderCalculationService;
use Illuminate\Database\Eloquent\Builder;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;
use App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource\Pages;

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
                    ->visible(auth()->user()->hasRole('comprador') ||
                        auth()->user()->hasRole('gerente_compras') ||
                        auth()->user()->hasRole('super_admin') ||
                        auth()->user()->hasRole('administrador_compras'))
                    ->form(
                        [
                            Forms\Components\CheckboxList::make('columns')
                                ->label('Datos de la requisición')
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
                                    'moneda' => 'Moneda',
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
                                        $component->state(['fecha de creacion', 'comprador', 'folio', 'proveedor', 'subtotal', 'total', 'moneda']);
                                    }
                                }),
                            Forms\Components\DatePicker::make('created_start')
                                ->label('Creados desde')
                                ->beforeOrEqual('created_end')
                                ->required(),
                            Forms\Components\DatePicker::make('created_end')
                                ->label('Creados hasta')
                                ->afterOrEqual('created_start')
                                ->required(),
                        ]
                    )
                    ->action(function (array $data) {
                        // dd($data);
                        $startDate = Carbon::createFromFormat('Y-m-d', $data['created_start'])->startOfDay();
                        $endDate = Carbon::createFromFormat('Y-m-d', $data['created_end'])->endOfDay();
                        $models = PurchaseOrder::with(['requisition', 'provider', 'company', 'items', 'purchaser'])
                            ->where('company_id', session()->get('company_id'))
                            ->whereBetween('created_at', [$startDate, $endDate])
                            ->get();
                        if (blank($models)) {
                            return   Notification::make()
                                ->title('No se encontraron registros')
                                ->danger()
                                ->send();
                        }
                        $result = [];
                        foreach ($models as $model) {
                            $service = new OrderCalculationService($model->id);
                            $result[] = [
                                'fecha de creacion' => $model->created_at->format('d-m-Y'),
                                'comprador' => $model->purchaser->name,
                                'folio' => $model->folio,
                                'proveedor' => $model->provider->company_name,
                                'subtotal' => $service->getSubtotalItems(true),
                                'total' =>  $service->getTotal(true),
                                'moneda' => $model->currency,
                                'tipo de pago' => $model->type_payment,
                                'forma de pago' => $model->form_payment,
                                'condiciones de pago' => static::formatConditionPayment($model),
                                'forma de pago' => $model->form_payment,
                                'folio de cotización' => $model->quote_folio,
                                'uso de CFDI' => $model->use_cfdi,
                                'método de envío' => $model->shipping_method,
                                'descuento por proveedor' => $model->discount,
                                'descuento' =>  $service->getDiscountProvider(true),
                                'iva' =>  $service->getTaxIva(true),
                                'retención de IVA' =>  $service->getRetentionIva(true),
                                'retención de ISR' =>  $service->getRetentionIsr(true),
                                'fecha de entrega inicial' => $model->initial_delivery_date,
                                'fecha de entrega final' => $model->final_delivery_date,
                                'dirección de entrega' => $model->delivery_address,
                                'documentación de entrega' => static::documentation($model),
                                'observaciones' => $model->observations,
                                'contacto de proveedor' => $model->providerContact->cell_phone,
                                'empresa' => $model->company->name,
                                'requisición' => $model->requisition->folio,
                                'estatus' => $model->status,
                            ];
                        }
                        $result = collect($result);
                        $result = $result->map(function ($item) use ($data) {
                            return collect($item)->only($data['columns'])->toArray();
                        });

                        return  fastexcel($result)->download("ordenes de compra {$startDate->format('d-m-Y')} {$endDate->format('d-m-Y')}.xlsx");
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
}
