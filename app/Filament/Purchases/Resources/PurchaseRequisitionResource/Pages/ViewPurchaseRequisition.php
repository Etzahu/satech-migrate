<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisitionResource\Pages;

use Filament\Actions;
use Filament\Infolists;
use Filament\Actions\Action;
use App\Services\PRMediaService;
use Filament\Actions\EditAction;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
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
                ->visible($this->record->status()->canBe('revisión por almacén') || $this->record->status()->canBe('aprobado por revisor') && $this->record->items->count() > 0)
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
                ->url(PurchaseRequisitionResource::getUrl('view-pdf', ['record' => $this->record->id]))
                ->openUrlInNewTab()
        ];
    }
    public function infolist(Infolist $infolist): Infolist
    {
        $service = new PRMediaService();
        return $service->generateInfolist($infolist, $this->record, false);
    }
}
