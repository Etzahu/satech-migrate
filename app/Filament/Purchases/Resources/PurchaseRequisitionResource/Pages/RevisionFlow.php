<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisitionResource\Pages;

use Filament\Actions;
use Filament\Infolists;
use Filament\Actions\Action;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Infolists\Components\Actions\Action as InfolistAction;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Spatie\MediaLibrary\Support\MediaStream;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource;

class RevisionFlow extends Page implements HasInfolists
{
    use InteractsWithRecord;
    use InteractsWithInfolists;
    protected static string $resource = PurchaseRequisitionResource::class;
    protected static ?string $title = 'Revisión';


    protected static string $view = 'filament.purchases.resources.purchase-requisition-resource.pages.revision-flow';
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Section::make('Información general')
                    ->columns(2)
                    ->compact()
                    ->schema([
                        TextEntry::make('folio')
                            ->label('Folio'),
                        TextEntry::make('date_delivery')
                            ->label('Fecha deseable de entrega')
                            ->date(),
                        TextEntry::make('type')
                            ->label('Tipo de requisición'),
                        TextEntry::make('project.name')
                            ->label('Proyecto'),
                        TextEntry::make('delivery_address')
                            ->label('Dirección de entrega')
                            ->columnSpan('full'),
                    ]),

                Section::make('Documentacion')
                    ->visible($this->record->getMedia('additional_documents')->count() > 0)
                    ->compact()
                    ->columns(2)
                    ->schema([
                        RepeatableEntry::make('media')
                            ->state(function ($record) {
                                return $record->getMedia('additional_documents');
                            })
                            ->label('')
                            ->schema([
                                TextEntry::make('file_name')
                                    ->label('Nombre del archivo'),
                            ])
                    ]),
                Section::make('Partidas')
                    ->compact()
                    ->columns(4)
                    ->schema([
                        RepeatableEntry::make('items')
                            ->schema([
                                TextEntry::make('product.name')
                                    ->label('Producto'),
                                TextEntry::make('quantity')
                                    ->label('Cantidad'),
                            ])
                    ]),
            ]);
    }
}
