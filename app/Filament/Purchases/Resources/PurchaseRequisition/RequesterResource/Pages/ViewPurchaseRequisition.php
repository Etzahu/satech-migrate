<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\Pages;


use App\Models\Company;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\ActionSize;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource;


class ViewPurchaseRequisition extends ViewRecord
{
    protected static string $resource = RequesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('Enviar requisición')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(
                        $this->record->status()->canBe('revisión por almacén') && $this->record->items->count() > 0 && filled($this->record->category)
                    )
                    ->action(function () {
                        if (session()->get('company_id') == 1) { //ID 1:GPT IM
                             $this->record->status()->transitionTo('revisión por almacén');
                        }
                        if ($this->record->category == 'servicio') {
                             $this->record->status()->transitionTo('revisión');
                        } else {
                             $this->record->status()->transitionTo('revisión por almacén');
                        }
                        Notification::make()
                            ->title('Requisición enviada')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('Ver pdf')
                    ->color('danger')
                    ->icon('heroicon-m-document')
                    ->url(route('requisition.pdf', ['id' => $this->record->id]))
                    ->openUrlInNewTab(),
            ])
                ->label('Opciones')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(ActionSize::Small)
                ->color('primary')
                ->button(),
        ];
    }
}
