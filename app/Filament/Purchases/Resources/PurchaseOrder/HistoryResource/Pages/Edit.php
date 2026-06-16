<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource\Pages;

use App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class Edit extends EditRecord
{
    protected static string $resource = HistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    protected function afterSave(): void
    {
        $this->dispatch('refreshRelationManagerItems');
    }
}
