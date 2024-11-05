<?php

namespace App\Filament\Purchases\Resources\PRReviewResource\Pages;

use App\Filament\Purchases\Resources\PRReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePRReviews extends ManageRecords
{
    protected static string $resource = PRReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
