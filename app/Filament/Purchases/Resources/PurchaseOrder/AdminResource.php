<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder;

use App\Filament\Purchases\Resources\PurchaseOrder\AdminResource\Pages;
use App\Mail\PurchaseOrder\Notification as OrderMail;
use App\Models\ProviderEvaluation;
use App\Models\PurchaseOrder;
use App\Services\OrderService;
use App\Services\ProviderEvaluationService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Mail;

class AdminResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;

    protected static ?string $modelLabel = 'Orden';

    protected static ?string $pluralModelLabel = 'Orden';

    protected static ?string $navigationLabel = 'Administración';

    protected static ?string $slug = 'admin/ordenes';

    protected static string|\UnitEnum|null $navigationGroup = 'Orden';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return auth()->user()->can('view_approve-level-1_purchase::order::purchaser');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('company_id', session()->get('company_id'))
            ->orderBy('id', 'desc');
    }

    // Permite resolver órdenes borradas (soft-deleted) por URL/botón "Ver",
    // solo en este resource. No afecta los listados de los tabs.
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        if (auth()->user()->hasRole('gerente_compras')) {
            return static::getModel()::where('status', 'revisión gerente de compras')
                ->where('company_id', session()->get('company_id'))
                ->count();
        } else {
            return false;
        }
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $form, array $options = []): Schema
    {
        $options['show_relation_items'] = true;

        return PurchaserResource::form($form, $options);
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
                Tables\Columns\TextColumn::make('purchaser.name')
                    ->label('Comprador')
                    ->numeric()
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
            ->filters([])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\Action::make('restaurar')
                    ->label('Restaurar')
                    ->icon('heroicon-m-arrow-uturn-left')
                    ->color('success')
                    ->visible(fn (PurchaseOrder $record) => $record->trashed())
                    ->requiresConfirmation()
                    ->modalHeading('Restaurar orden')
                    ->modalDescription('Se restaurará la orden y se notificará al comprador asignado por correo.')
                    ->modalSubmitActionLabel('Sí, restaurar')
                    ->action(function (PurchaseOrder $record) {
                        $record->restore();

                        $purchaser = $record->purchaser;
                        $notifiedByEmail = false;

                        // Notificar por correo al comprador asignado, salvo que sea gerente de compras.
                        if ($purchaser && $purchaser->email && ! $purchaser->hasRole('gerente_compras')) {
                            $data = (new OrderService)->generateDataEmail($record->id, 'restaurada');
                            Mail::to($purchaser->email)->send(new OrderMail($data));
                            $notifiedByEmail = true;
                        }

                        Notification::make()
                            ->title('Orden restaurada')
                            ->body($notifiedByEmail
                                ? "Se notificó por correo a {$purchaser->name}."
                                : 'No se envió correo (el comprador es gerente de compras).')
                            ->success()
                            ->send();
                    }),
                Actions\Action::make('crear_evaluacion_proveedor')
                    ->label('Crear evaluación')
                    ->icon('heroicon-m-star')
                    ->color('warning')
                    ->visible(fn (PurchaseOrder $record) => $record->status === 'autorizada para proveedor')
                    ->requiresConfirmation()
                    ->modalHeading('Crear evaluación de proveedor')
                    ->modalDescription('Se creará una evaluación de proveedor para esta orden y se notificará a los evaluadores.')
                    ->action(function (PurchaseOrder $record) {
                        $existing = ProviderEvaluation::where('purchase_order_id', $record->id)
                            ->where('status', 'pending')
                            ->exists();

                        if ($existing) {
                            Notification::make()
                                ->title('Ya existe una evaluación en curso')
                                ->body('Esta orden ya tiene una evaluación de proveedor pendiente.')
                                ->warning()
                                ->send();

                            return;
                        }

                        $evaluation = ProviderEvaluationService::createForOrder($record);

                        if (! $evaluation) {
                            Notification::make()
                                ->title('No es posible crear la evaluación')
                                ->body('La categoría de la requisición no permite evaluaciones de proveedor.')
                                ->danger()
                                ->send();

                            return;
                        }

                        Notification::make()
                            ->title('Evaluación creada correctamente')
                            ->success()
                            ->send();
                    }),
            ]);
    }

    public static function infolist(Schema $infolist): Schema
    {
        $options[] = 'show_relation_items';

        return PurchaserResource::infolist($infolist, $options);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}/ver'),
        ];
    }
}
