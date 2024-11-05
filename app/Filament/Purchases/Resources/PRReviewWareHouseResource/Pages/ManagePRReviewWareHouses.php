<?php

namespace App\Filament\Purchases\Resources\PRReviewWareHouseResource\Pages;

use App\Filament\Purchases\Resources\PRReviewWareHouseResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePRReviewWareHouses extends ManageRecords
{
    protected static string $resource = PRReviewWareHouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
