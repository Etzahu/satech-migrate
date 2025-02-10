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
                    ->url(route('requisition.pdf', ['id' => $this->record->id]))
                    ->openUrlInNewTab(),
                Action::make('Devolver')
                    ->requiresConfirmation()
                    ->visible($this->record->status()->canBe('devuelto por comprador'))
                    ->modalHeading('Devolver la requisición')
                    ->modalDescription(function ($record) {
                        $quantity = $record->orders->count();
                        if ($quantity > 0) {
                            return "¿Estás seguro de hacer esto?. La requisición contiene ordenes, las cuales se borrarán.";
                        } else {
                            return "¿Estás seguro de hacer?";
                        }
                    })
                    ->form([
                        Textarea::make('observation')
                            ->label('Motivo')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        try {
                            $this->record->status()->transitionTo('devuelto por comprador', ['respuesta' => $data['observation']]);
                            $this->record->orders()->delete();
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

            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(ActionSize::Small)
                ->color('primary')
                ->button(),
        ];
    }
}
