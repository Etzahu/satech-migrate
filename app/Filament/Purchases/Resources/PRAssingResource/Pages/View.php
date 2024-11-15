<?php

namespace App\Filament\Purchases\Resources\PRAssingResource\Pages;

use App\Models\User;

use Filament\Forms\Get;
use Filament\Actions\Action;
use App\Services\PRMediaService;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Purchases\Resources\PRAssingResource;
use App\Models\PurchaseRequisition;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class View extends ViewRecord
{
    use InteractsWithInfolists;
    use InteractsWithRecord;
    protected static string $resource = PRAssingResource::class;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Asignar al comprador')
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
            Action::make('Ver pdf')
                ->color('danger')
                ->icon('heroicon-m-document')
                ->openUrlInNewTab()
        ];
    }
    public function infolist(Infolist $infolist): Infolist
    {
        $service = new PRMediaService();
        return $service->generateInfolist($infolist, $this->record);
    }
}
