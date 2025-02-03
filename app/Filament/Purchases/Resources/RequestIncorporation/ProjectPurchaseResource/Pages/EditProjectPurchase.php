<?php

namespace App\Filament\Purchases\Resources\RequestIncorporation\ProjectPurchaseResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Purchases\Resources\RequestIncorporation\ProjectPurchaseResource;

class EditProjectPurchase extends EditRecord
{
    protected static string $resource = ProjectPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

}
