<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PurchaseOrder;
use Filament\Infolists\Infolist;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Storage;
use Filament\Support\Enums\IconPosition;
use Illuminate\Database\Eloquent\Builder;
use RelationManagers\ItemsRelationManager;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Resources\RelationManagers\RelationManager;
use Pelmered\FilamentMoneyField\Infolists\Components\MoneyEntry;
use App\Filament\Purchases\Resources\PurchaseOrder\PurchaserResource;
use Hugomyb\FilamentMediaAction\Infolists\Components\Actions\MediaAction as MediaActionInfolist;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';
    protected static ?string $modelLabel = 'Orden';
    protected static ?string $pluralModelLabel = 'Ordenes';
    protected static ?string $navigationLabel = 'Ordenes';
    protected static ?string $title = 'Orden';


    public function isReadOnly(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provider.company_name')
                    ->label('Proveedor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime()
                    ->sortable(),
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
                Tables\Actions\Action::make('Ver')
                    ->slideOver()
                    ->modalWidth(MaxWidth::FiveExtraLarge)
                    ->modalSubmitAction(false)
                    ->icon('heroicon-s-eye')
                    ->infolist([
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
                                        Infolists\Components\TextEntry::make('type_payment')
                                            ->label('Tipo de pago'),
                                        Infolists\Components\TextEntry::make('form_payment')
                                            ->label('Forma de pago'),
                                        Infolists\Components\TextEntry::make('term_payment')
                                            ->label('Término de pago'),
                                        Infolists\Components\TextEntry::make('condition_payment')
                                            ->label('Condiciones de pago'),
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
                                        MoneyEntry::make('discount')
                                            ->label('Descuento')
                                            ->currency('MXN')
                                            ->locale('es_MX'),
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
                                    ])
                            ])
                            ->contained(false)
                            ->activeTab(1)
                    ]),
                Tables\Actions\Action::make('Documento')
                    ->url(fn($record) => route('order.pdf', ['id' => $record->id]))
                    ->openUrlInNewTab()
            ]);
    }
}
