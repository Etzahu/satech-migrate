<?php

namespace App\Services;

use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Spatie\MediaLibrary\Support\MediaStream;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Filament\Purchases\Resources\PRAssingResource\RelationManagers;


class PRInfolistService
{
    public function build($infolist, $record, $tabItems = true, array $options = [])
    {

        return $infolist
            ->record($record)
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Información general')
                            ->schema([
                                TextEntry::make('status')
                                    ->label('Estatus')
                                    ->badge()
                                    ->color('success'),
                                TextEntry::make('approvalChain.requester.name')
                                    ->label('Solicitante'),
                                TextEntry::make('motive')
                                    ->label('Referencia'),
                                TextEntry::make('folio')
                                    ->label('Folio'),
                                TextEntry::make('date_delivery')
                                    ->label('Fecha deseable de entrega')
                                    ->date(),
                                TextEntry::make('project.name')
                                    ->label('Proyecto'),
                                TextEntry::make('delivery_address')
                                    ->label('Dirección de entrega'),
                                IconEntry::make('confidential')
                                    ->label('Confidencial')
                                    ->visible(false)
                                    ->boolean(),
                            ])
                            ->columns(3),
                        Tabs\Tab::make('Partidas')
                            ->visible($tabItems)
                            ->schema([
                                RepeatableEntry::make('items')
                                    ->label('')
                                    ->schema([
                                        TextEntry::make('product.code')
                                            ->label('Código'),
                                        TextEntry::make('product.name')
                                            ->label('Producto'),
                                        // TextEntry::make('quantity_purchase')
                                        //     ->label('Cantidad solicitada'),
                                        TextEntry::make('quantity_warehouse')
                                            ->label('Cantidad en almacén'),
                                        TextEntry::make('quantity_purchase')
                                            ->label('Cantidad para comprar'),
                                        TextEntry::make('observation')
                                            ->label('Observación')
                                            ->columnSpan(2),
                                    ])
                                    ->columns(5)
                            ]),
                            Tabs\Tab::make('Flujo de aprobación')
                            ->schema([
                                TextEntry::make('approvalChain.requester.name')
                                    ->label('Solicitante'),
                                TextEntry::make('approvalChain.reviewer.name')
                                    ->label('Revisor'),
                                TextEntry::make('approvalChain.approver.name')
                                    ->label('Aprobador'),
                                TextEntry::make('approvalChain.authorizer.name')
                                    ->label('Autoriza'),
                            ]),
                        Tabs\Tab::make('Fichas técnicas')
                            // ->visible($this->getMediaCount($record->id, 'technical_data_sheets') > 0)
                            ->visible($record->getMedia('technical_data_sheets')->count() > 0)
                            ->schema([
                                RepeatableEntry::make('media')
                                    ->state(function ($record) {
                                        // $record->media = $this->getMediaInfo($record->id, 'technical_data_sheets');
                                        $record->media = $record->getMedia('technical_data_sheets');
                                        return $record->media;
                                    })
                                    ->label('')
                                    ->schema([
                                        TextEntry::make('file_name')
                                            ->label('Nombre del archivo'),
                                    ]),
                                Actions::make([
                                    Action::make('Descargar fichas')
                                        ->action(function () use ($record) {
                                            // $downloads = $this->getMedia($record->id, 'technical_data_sheets');
                                            $downloads = $record->getMedia('technical_data_sheets');
                                            return MediaStream::create($record->folio . '-fichas-tecnicas.zip')->addMedia($downloads);
                                        }),
                                ]),
                            ]),
                        Tabs\Tab::make('Soportes')
                            // ->visible($this->getMediaCount($record->id, 'supports') > 0)
                            ->visible($record->getMedia('supports')->count() > 0)
                            ->schema([
                                RepeatableEntry::make('media')
                                    ->state(function ($record) {
                                        // $record->media = $this->getMediaInfo($record->id, 'supports');
                                        // return $record->media;
                                        $media = Media::where('model_id', $record->id)
                                            ->where('collection_name', 'supports')
                                            ->get();
                                        $record->media = $media;
                                        return $record->media;
                                    })
                                    ->label('')
                                    ->schema([
                                        TextEntry::make('name')
                                            ->label('Nombre del archivo'),
                                    ]),
                                Actions::make([
                                    Action::make('Descargar soportes')
                                        ->action(function () use ($record) {
                                            // $downloads = $this->getMedia($record->id, 'supports');
                                            $downloads = Media::where('model_id', $record->id)
                                                ->where('collection_name', 'supports')
                                                ->get();
                                            return MediaStream::create($record->folio . '-soportes.zip')->addMedia($downloads);
                                        }),
                                ]),
                            ]),

                        Tabs\Tab::make('Observaciones')
                            ->schema([
                                TextEntry::make('observation')
                                    ->label('Observaciones'),
                            ]),
                        Tabs\Tab::make('Historial')
                            ->schema([
                                ViewEntry::make('status')
                                    ->view('filament.infolists.entries.history'),
                            ]),
                        Tabs\Tab::make('Comprador')
                        ->visible(fn($record)=> filled($record->purchaser))
                        ->schema([
                            TextEntry::make('purchaser.name')
                            ->label('Asignado'),
                        ]),

                    ]),
                // Tabs\Tab::make('Ordenes')->schema([
                //     \Njxqlus\Filament\Components\Infolists\RelationManager::make()->manager(RelationManagers\OrdersRelationManager::class)
                // ]),

            ]);
    }
}
