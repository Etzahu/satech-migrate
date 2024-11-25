<?php

namespace App\Filament\Purchases\Resources\PRAssingResource\Pages;

use App\Models\User;

use Filament\Forms\Get;
use Filament\Actions\Action;
use App\Services\PRMediaService;
use Filament\Infolists\Infolist;
use App\Models\PurchaseRequisition;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Purchases\Resources\PRAssingResource;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class View extends ViewRecord
{
    use InteractsWithInfolists;
    // use InteractsWithRecord;

    protected static string $resource = PRAssingResource::class;

    // public function mount(int | string $record): void
    // {
    //     $this->record = $this->resolveRecord($record);
    // }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Crear orden de compra')
                ->visible(blank($this->record->status_order))
                ->url(fn(PurchaseRequisition $record): string => PRAssingResource::getUrl('orders.create', ['record' => $record->id])),
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
