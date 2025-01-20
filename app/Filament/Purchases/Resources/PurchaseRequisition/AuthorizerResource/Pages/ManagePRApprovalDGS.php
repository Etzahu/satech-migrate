<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition\AuthorizerResource\Pages;

use App\Filament\Purchases\Resources\PurchaseRequisition\AuthorizerResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePRApprovalDGS extends ManageRecords
{
    protected static string $resource = AuthorizerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
