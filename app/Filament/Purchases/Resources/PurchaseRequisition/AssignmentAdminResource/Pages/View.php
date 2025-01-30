<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentAdminResource\Pages;

use App\Models\User;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

use App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentAdminResource;

class View extends ViewRecord
{
    protected static string $resource = AssignmentAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Asignar comprador')
                ->visible($this->record->status()->canBe('comprador asignado') && blank($this->record->responsiblePurchaseOrder))
                ->form([
                    Select::make('responsible')
                        ->label('Responsable')
                        ->options(User::role('comprador')->pluck('name', 'id'))
                        ->required(),
                ])
                ->action(function (array $data): void {
                    // dd($data,$record);
                    $this->record->assign_user_id = $data['responsible'];
                    $this->record->save();
                    $this->record->status()->transitionTo('comprador asignado');
                    Notification::make()
                        ->title('Se ha asignado comprador')
                        ->success()
                        ->send();
                }),
            Action::make('Reasignar comprador')
                ->visible((filled($this->record->responsiblePurchaseOrder)))
                ->form([
                    Select::make('responsible')
                        ->label('Responsable')
                        ->options((User::whereNot('id', $this->record->purchaser?->id)->role('comprador')->pluck('name', 'id')))
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $this->record->assign_user_id = $data['responsible'];
                    $orders = $this->record->orders;
                    if (filled($orders)) {
                        foreach ($orders as $order) {
                            $order->purchaser_user_id = $data['responsible'];
                            $order->save();
                        }
                    }
                    $this->record->save();
                    $this->record->status()->transitionTo('comprador reasignado');
                    Notification::make()
                        ->title('Se ha reasignado comprador')
                        ->success()
                        ->send();
                }),
            Action::make('Ver pdf')
                ->color('danger')
                ->url(route('requisition.pdf', ['id' => $this->record->id]))
                ->icon('heroicon-m-document')
                ->openUrlInNewTab()
        ];
    }
}
