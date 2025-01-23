<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentAdminResource\Pages;

use App\Models\User;

use Filament\Actions\Action;
use Filament\Infolists\Infolist;
use App\Services\PRInfolistService;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentAdminResource;

class View extends ViewRecord
{
    use InteractsWithInfolists;
    use InteractsWithRecord;
    protected static string $resource = AssignmentAdminResource::class;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

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
                        ->options((User::whereNot('id',$this->record->purchaser?->id)->role('comprador')->pluck('name', 'id')))
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $this->record->assign_user_id = $data['responsible'];
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
    public function infolist(Infolist $infolist): Infolist
    {
        $service = new PRInfolistService();
        return $service->build($infolist, $this->record);
    }
}
