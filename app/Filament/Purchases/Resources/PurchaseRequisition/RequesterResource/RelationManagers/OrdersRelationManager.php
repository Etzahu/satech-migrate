<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\RelationManagers;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Infolists;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Enums\Width;
use Filament\Tables;
use Filament\Tables\Table;
use Pelmered\FilamentMoneyField\Infolists\Components\MoneyEntry;

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
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable(),
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
                // Actions\Action::make('Ver')
                //     ->slideOver()
                //     ->modalWidth(Width::FiveExtraLarge)
                //     ->modalSubmitAction(false)
                //     ->icon('heroicon-s-eye')
                //     ->schema([
                //         Schemas\Components\Tabs::make('Tabs')
                //             ->tabs([
                //                 Schemas\Components\Tabs\Tab::make('Datos generales')
                //                     ->columns(3)
                //                     ->schema([
                //                         Infolists\Components\TextEntry::make('folio')
                //                             ->label('Folio')
                //                             ->columnSpan('full'),
                //                         Infolists\Components\TextEntry::make('status')
                //                             ->label('Estatus')
                //                             ->badge()
                //                             ->color('success'),
                //                         Infolists\Components\TextEntry::make('currency')
                //                             ->label('Moneda'),
                //                         Infolists\Components\TextEntry::make('type_payment')
                //                             ->label('Tipo de pago'),
                //                         Infolists\Components\TextEntry::make('form_payment')
                //                             ->label('Forma de pago'),
                //                         Infolists\Components\TextEntry::make('term_payment')
                //                             ->label('Término de pago'),
                //                         Infolists\Components\TextEntry::make('condition_payment')
                //                             ->label('Condiciones de pago'),
                //                         Infolists\Components\TextEntry::make('quote_folio')
                //                             ->label('Folio de cotización'),
                //                         Infolists\Components\TextEntry::make('use_cfdi')
                //                             ->label('Uso de CFDI'),
                //                         Infolists\Components\TextEntry::make('shipping_method')
                //                             ->label('Método de envío'),
                //                         Infolists\Components\TextEntry::make('tax_iva')
                //                             ->label('IVA')
                //                             ->icon('heroicon-o-percent-badge')
                //                             ->iconPosition(IconPosition::After)
                //                             ->iconColor('primary'),
                //                         Infolists\Components\TextEntry::make('requisition.folio')
                //                             ->label('Requisición')
                //                             ->hidden($options['rq'] ?? false),
                //                         Infolists\Components\TextEntry::make('created_at')
                //                             ->label('Fecha de creación')
                //                             ->date(),
                //                     ]),
                //                 Schemas\Components\Tabs\Tab::make('Proveedor')
                //                     ->schema([
                //                         Infolists\Components\TextEntry::make('provider.company_name')
                //                             ->label('Proveedor'),
                //                         Infolists\Components\TextEntry::make('providerContact.name')
                //                             ->label('Nombre'),
                //                         Infolists\Components\TextEntry::make('providerContact.email')
                //                             ->label('Correo'),
                //                         Infolists\Components\TextEntry::make('providerContact.cell_phone')
                //                             ->label('Teléfono'),
                //                     ]),
                //                 Schemas\Components\Tabs\Tab::make('Retenciones')
                //                     ->columns(3)
                //                     ->schema([
                //                         Infolists\Components\TextEntry::make('retention_iva')
                //                             ->label('IVA')
                //                             ->numeric()
                //                             ->icon('heroicon-o-percent-badge')
                //                             ->iconColor('primary'),
                //                         Infolists\Components\TextEntry::make('retention_isr')
                //                             ->label('ISR')
                //                             ->numeric()
                //                             ->icon('heroicon-o-percent-badge')
                //                             ->iconPosition(IconPosition::After)
                //                             ->iconColor('primary'),
                //                         Infolists\Components\TextEntry::make('retention_another')
                //                             ->label('OTRO')
                //                             ->icon('heroicon-o-percent-badge')
                //                             ->iconPosition(IconPosition::After)
                //                             ->iconColor('primary')
                //                             ->numeric(),
                //                     ]),
                //                 Schemas\Components\Tabs\Tab::make('Descuento del proveedor')
                //                     ->columns(3)
                //                     ->schema([
                //                         MoneyEntry::make('discount')
                //                             ->label('Descuento')
                //                             ->currency('MXN')
                //                             ->locale('es_MX'),
                //                     ]),
                //                 Schemas\Components\Tabs\Tab::make('Entrega')
                //                     ->columns(1)
                //                     ->schema([
                //                         Infolists\Components\TextEntry::make('initial_delivery_date')
                //                             ->label('Inicial')
                //                             ->date(),
                //                         Infolists\Components\TextEntry::make('final_delivery_date')
                //                             ->label('Final')
                //                             ->date(),
                //                         Infolists\Components\Textentry::make('delivery_address')
                //                             ->label('Dirección de entrega'),
                //                         Infolists\Components\RepeatableEntry::make('documentation_delivery')
                //                             ->label('Documentación de entrega')
                //                             ->schema([
                //                                 Infolists\Components\TextEntry::make('name')
                //                                     ->label('Nombre del documento'),
                //                             ]),
                //                     ]),
                //                 Schemas\Components\Tabs\Tab::make('Observaciones')
                //                     ->columns(1)
                //                     ->schema([
                //                         Infolists\Components\Textentry::make('observations')
                //                             ->label('Observaciones'),
                //                     ]),
                //                 Schemas\Components\Tabs\Tab::make('Historial')
                //                     ->schema([
                //                         Infolists\Components\ViewEntry::make('status')
                //                             ->view('filament.infolists.entries.history'),
                //                     ])
                //             ])
                //             ->contained(false)
                //             ->activeTab(1)
                //     ]),
                Action::make('Documento')
                    ->url(fn ($record) => route('order.pdf.show', ['id' => $record->id]))
                    ->openUrlInNewTab(),
            ]);
    }
}
