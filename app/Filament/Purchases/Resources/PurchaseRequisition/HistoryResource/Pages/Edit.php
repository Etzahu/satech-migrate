<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\HistoryResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\HistoryResource;
use App\Filament\Purchases\Resources\PurchaseRequisition\RequesterResource\RelationManagers\ItemsRelationManager;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

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

    /**
     * En el historial, la edición solo está disponible para super_admin
     * (ver EditAction en la página View). A diferencia de la página View
     * —que hereda solo el AuditsRelationManager del recurso— aquí mostramos
     * además el gestor de partidas para poder editarlas sin importar el estado.
     */
    protected function getAllRelationManagers(): array
    {
        return [
            ItemsRelationManager::class,
            AuditsRelationManager::class,
        ];
    }
    // protected function afterSave(): void
    // {
    //     $this->dispatch('refreshRelationManagerItems');
    // }
}
