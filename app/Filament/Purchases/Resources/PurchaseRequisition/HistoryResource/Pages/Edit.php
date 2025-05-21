<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\HistoryResource\Pages;

use Filament\Actions;
use App\Models\PurchaseRequisition;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;

use Filament\Support\Enums\MaxWidth;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Purchases\Resources\PurchaseRequisition\HistoryResource;


class Edit extends EditRecord
{
    protected static string $resource = HistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
        ];
    }
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }
    // protected function afterSave(): void
    // {
    //     $this->dispatch('refreshRelationManagerItems');
    // }
}
