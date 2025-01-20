<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages;


use App\Models\Company;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Infolists\Infolist;
use Filament\Actions\ActionGroup;
use App\Services\PRInfolistService;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\ActionSize;
use Filament\Infolists\Components\Tabs;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Spatie\MediaLibrary\Support\MediaStream;
use Filament\Infolists\Components\RepeatableEntry;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Components\Actions as InfolistAction;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource;
use Filament\Infolists\Components\Actions\Action as InfolistComponentAction;

class ViewPurchaseRequisition extends ViewRecord
{
    use InteractsWithInfolists;

    protected static string $resource = RequesterResource::class;

    protected function getHeaderActions(): array
    {

        return [
            ActionGroup::make([
                Action::make('Enviar requisición')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(
                        $this->record->status()->canBe('revisión por almacén') && $this->record->items->count() > 0 ||
                            $this->record->status()->canBe('aprobado por revisor') && $this->record->items->count() > 0
                    )
                    ->action(function () {
                        if ($this->record->confidential) {
                            $this->record->status()->transitionTo('aprobado por revisor');
                        } else {
                            $this->record->status()->transitionTo('revisión por almacén');
                        }
                        Notification::make()
                            ->title('Requisición enviada')
                            ->success()
                            ->send();
                    }),
                EditAction::make()
                    ->visible(function () {
                        $states = [
                            'borrador',
                            'devuelto por revisor',
                            'devuelto por gerencia',
                            'devuelto por DG',
                        ];
                        return in_array($this->record->status, $states);
                    }),
                Action::make('Ver pdf')
                    ->color('danger')
                    ->icon('heroicon-m-document')
                    ->url(RequesterResource::getUrl('view-pdf', ['record' => $this->record->id]))
                    ->openUrlInNewTab(),
                Action::make('Cambiar de empresa')
                    ->requiresConfirmation()
                    ->visible($this->record->status == 'borrador')
                    ->form([
                        Select::make('company_id')
                            ->label('Empresa')
                            ->options(Company::query()->whereNot('id', $this->record->company_id)->pluck('name', 'id'))
                            ->required(),
                    ])
                    ->action(function (array $data, $record) {
                        try {
                            $record->company_id = $data['company_id'];
                            $record->save();
                            Notification::make()
                                ->title('Se ha cambiado de empresa')
                                ->success()
                                ->send();
                            return redirect(RequesterResource::getUrl('index'));
                        } catch (\Exception $e) {
                            logger($e->getMessage());
                            Notification::make()
                                ->title('Ocurrió un error')
                                ->danger()
                                ->send();
                        }
                    })

            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(ActionSize::Small)
                ->color('primary')
                ->button(),
        ];
    }
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Información general')
                            ->schema([
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
                                    ->boolean(),
                            ])
                            ->columns(3),
                        Tabs\Tab::make('Partidas')
                            ->visible(true)
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
                            ->visible(!$this->record->confidential)
                            ->schema([
                                TextEntry::make('approvalChain.requester.name')
                                    ->label('Solicitante'),
                                TextEntry::make('approvalChain.reviewer.name')
                                    ->label('Revisor'),
                                TextEntry::make('approvalChain.approver.name')
                                    ->label('Aprobador'),
                            ])
                            ->columns(3),
                        Tabs\Tab::make('Fichas técnicas')
                            ->visible($this->record->getMedia('technical_data_sheets')->count() > 0)
                            ->schema([
                                RepeatableEntry::make('media')
                                    ->state(function ($record) {
                                        $this->record->media = $this->record->getMedia('technical_data_sheets');
                                        return $this->record->media;
                                    })
                                    ->label('')
                                    ->schema([
                                        TextEntry::make('name')
                                            ->label('Nombre del archivo'),
                                    ]),
                                InfolistAction::make([
                                    InfolistComponentAction::make('Descargar fichas')
                                        ->action(function () {
                                            $downloads = $this->record->getMedia('technical_data_sheets');
                                            return MediaStream::create($this->record->folio . '-fichas-tecnicas.zip')->addMedia($downloads);
                                        }),
                                ]),
                            ]),
                        Tabs\Tab::make('Soportes')
                            ->visible($this->record->getMedia('supports')->count() > 0)
                            ->schema([
                                RepeatableEntry::make('media')
                                    ->state(function ($record) {
                                        $media = Media::where('model_id', $record->id)
                                            ->where('collection_name', 'supports')
                                            ->get();
                                        $this->record->media = $media;
                                        return $this->record->media;
                                    })
                                    ->label('')
                                    ->schema([
                                        TextEntry::make('name')
                                            ->label('Nombre del archivo'),
                                    ]),
                                InfolistAction::make([
                                    InfolistComponentAction::make('Descargar soportes')
                                        ->action(function () {
                                            // $downloads = $this->record->getMedia('supports');
                                            $downloads = Media::where('model_id', $this->record->id)
                                                ->where('collection_name', 'supports')
                                                ->get();
                                            return MediaStream::create($this->record->folio . '-soportes.zip')->addMedia($downloads);
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
                    ]),
            ]);
        $service = new PRInfolistService();
        return $service->build($infolist, $this->record, false);
    }
}
