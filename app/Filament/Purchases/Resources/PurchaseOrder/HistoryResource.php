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
            auth()->user()->hasRole('comprador') ||
            auth()->user()->hasRole('gerente_solicitante_orden_compra') ||
            auth()->user()->hasRole('autoriza_nivel-1-orden_compra') ||
            auth()->user()->hasRole('autoriza_nivel-2-orden_compra') ||
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
                    ->form(
                        [
                            Forms\Components\CheckboxList::make('columns')
                                ->label('Datos de la requisición')
                                ->bulkToggleable()
                                ->columns(4)
                                ->required()
                                ->options([
                                    'folio' => 'Folio',
                                    'motivo' => 'Motivo',
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
                                ]),
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
                        $models = PurchaseOrder::with(['requisition', 'provider', 'company', 'items','purchaser'])
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
                            $result[] = [
                                'folio' => $model->folio,
                                'prioridad' => $model->priority,
                                'motivo' => $model->motive,
                                'tipo' => $model->type,
                                'observaciones' => $model->observation,
                                'fecha de entrega' => $model->date_delivery->format('d-m-Y'),
                                'dirección de entrega' => $model->delivery_address,
                                'estatus' => $model->status,
                                'empresa' => $model->company->name,
                                'proyecto' => $model->project->name,
                                'solicitante' => $model->approvalChain->requester->name,
                                'comprador' => $model->purchaser?->name,
                                'fecha de creacion' => $model->created_at->format('d-m-Y'),
                            ];
                        }
                        $result = collect($result);
                        $result = $result->map(function ($item) use ($data) {
                            return collect($item)->only($data['columns'])->toArray();
                        });

                        return  fastexcel($result)->download("requisiciones de comprad {$startDate->format('d-m-Y')} {$endDate->format('d-m-Y')}.xlsx");
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
}

/*
'folio',
'currency',
'type_payment',
'form_payment',
'condition_payment',
'quote_folio',
'use_cfdi',
'shipping_method',
'tax_iva',
'discount',
'retention_iva',
'retention_isr',
'retention_another',
'initial_delivery_date',
'final_delivery_date',
'delivery_address',
'documentation_delivery',
'observations',
'provider_id',
'provider_contact_id',
'purchaser_user_id',
'company_id',
'requisition_id',
'status'

        */
