<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource\Pages;

use App\Models\User;

use Filament\Forms\Get;
use Filament\Actions\Action;
use App\Services\PRMediaService;
use Filament\Infolists\Infolist;
use Filament\Actions\ActionGroup;
use App\Models\PurchaseRequisition;
use App\Services\PRInfolistService;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Tabs;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Spatie\MediaLibrary\Support\MediaStream;
use Filament\Infolists\Components\RepeatableEntry;
use App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Components\Actions as ActionsInfo;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Infolists\Components\Actions\Action as ActionInfo;
use App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource\RelationManagers;

class View extends ViewRecord
{
    use InteractsWithInfolists;
    protected static string $resource = AssignmentResource::class;

    protected function getHeaderActions(): array
    {

        return [
            ActionGroup::make([
                //TODO: tiene un error intenta llamar al relation manager
                // Action::make('Crear orden de compra')
                //     ->visible(blank($this->record->status_order))
                //     ->url(fn(PurchaseRequisition $record): string => AssignmentResource::getUrl('orders.create', ['record' => $record->id])),
                Action::make('Ver pdf')
                    ->color('danger')
                    ->icon('heroicon-m-document')
                    ->openUrlInNewTab(),
                Action::make('Devolver')
                    ->form([
                        Textarea::make('observation')
                            ->label('Motivo')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        try {
                            $this->record->status()->transitionTo('devuelto por comprador', ['respuesta' => $data['observation']]);
                            Notification::make()
                                ->title('Se devolvió la requisición')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            logger($e->getMessage());
                            Notification::make()
                                ->title('Ocurrió un error')
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(blank($this->record->orders) && $this->record->status()->canBe('devuelto por comprador'))
                    ->requiresConfirmation()
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
        // $service = new PRInfolistService();
        // return $service->build($infolist, $this->record);
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
                            // ->visible($tabItems)
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
                            ->visible(fn($record) => filled($record->purchaser))
                            ->schema([
                                TextEntry::make('purchaser.name')
                                    ->label('Asignado'),
                            ]),
                        Tabs\Tab::make('Ordenes')->schema([
                            \Njxqlus\Filament\Components\Infolists\RelationManager::make()->manager(RelationManagers\OrdersRelationManager::class)->lazy(false)
                        ]),
                    ]),

            ]);
    }
}
