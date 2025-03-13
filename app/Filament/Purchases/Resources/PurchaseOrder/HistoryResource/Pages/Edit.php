<?php

namespace App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource\Pages;

use Filament\Actions;
use App\Models\PurchaseOrder;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\MaxWidth;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Purchases\Resources\PurchaseOrder\HistoryResource;


class Edit extends EditRecord
{
    protected static string $resource = HistoryResource::class;

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
