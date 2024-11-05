<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisitionResource\Pages;

use Filament\Actions;
use Filament\Infolists;
use Filament\Actions\Action;
use App\Services\PRMediaService;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Spatie\MediaLibrary\Support\MediaStream;
use Filament\Actions\Concerns\InteractsWithRecord;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource;



class ViewPurchaseRequisition extends ViewRecord
{
    use InteractsWithInfolists;

    protected static string $resource = PurchaseRequisitionResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Action::make('Enviar requisición')
                ->color('success')
                ->requiresConfirmation()
                // ->visible($this->record->status()->canBe('revisión por almacén') && $this->record->items->count() > 0)
                ->visible($this->record->status()->canBe('revisión por almacén'))
                ->action(function () {
                    if($this->record->status()->canBe('revisión por almacén')){
                        $this->record->status()->transitionTo('revisión por almacén');
                    }
                }),
            Action::make('Ver pdf')
                ->color('danger')
                ->icon('heroicon-m-document')
                // ->url(fn(): string => route('compras.requisiciones.pdf', ['id' => $this->record->id]))
                ->url(fn(): string => route('filament.compras.resources.mis-requisiciones.pdf', ['record' => $this->record->id]))
                ->openUrlInNewTab()
        ];
    }
    public function infolist(Infolist $infolist): Infolist
    {
        $service = new PRMediaService();
        return $service->generateInfolist($infolist, $this->record);
        return $infolist
            ->schema([
                Section::make('Información general')
                    ->columns(2)
                    ->compact()
                    ->schema([
                        TextEntry::make('motive')
                            ->label('Referencia')
                            ->columnSpan('full'),
                        TextEntry::make('folio')
                            ->label('Folio'),
                        TextEntry::make('date_delivery')
                            ->label('Fecha deseable de entrega')
                            ->date(),
                        TextEntry::make('project.name')
                            ->label('Proyecto'),
                        TextEntry::make('delivery_address')
                            ->label('Dirección de entrega'),
                        TextEntry::make('observation')
                            ->label('Observación adicionales')
                            ->columnSpan('full'),
                    ]),
                Section::make('Flujo de aprobación')
                    ->compact()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('approvalChain.reviewer.name')
                            ->label('Revisa'),
                        TextEntry::make('approvalChain.approver.name')
                            ->label('Aprueba'),
                    ]),
                Section::make('Fichas técnicas')
                    ->visible($this->record->getMedia('technical_data_sheets')->count() > 0)
                    ->headerActions([
                        Infolists\Components\Actions\Action::make('Descargar')
                            ->action(function () {
                                $downloads = $this->record->getMedia('additional_documents');
                                return MediaStream::create($this->record->folio . '-fichas-tecnicas.zip')->addMedia($downloads);
                            }),
                    ])
                    ->compact()
                    ->columns(2)
                    ->schema([
                        RepeatableEntry::make('media')
                            ->state(function ($record) {
                                return $record->getMedia('technical_data_sheets');
                            })
                            ->label('')
                            ->schema([
                                TextEntry::make('file_name')
                                    ->label('Nombre del archivo'),
                            ])
                    ]),
                Section::make('Soportes')
                    ->visible($this->record->getMedia('supports')->count() > 0)
                    ->headerActions([
                        Infolists\Components\Actions\Action::make('Descargar')
                            ->action(function () {
                                $downloads = $this->record->getMedia('supports');
                                return MediaStream::create($this->record->folio . '-soportes.zip')->addMedia($downloads);
                            }),
                    ])
                    ->compact()
                    ->columns(2)
                    ->schema([
                        RepeatableEntry::make('media')
                            ->state(function ($record) {
                                return $record->getMedia('technical_data_sheets');
                            })
                            ->label('')
                            ->schema([
                                TextEntry::make('file_name')
                                    ->label('Nombre del archivo'),
                            ])
                    ]),
            ]);
    }
}
