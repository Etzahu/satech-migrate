<?php

namespace App\Filament\Ingenieria\Resources\ProjectDnNpCpResource\Pages;

use App\Filament\Ingenieria\Resources\ProjectDnNpCpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectDnNpCp extends EditRecord
{
    protected static string $resource = ProjectDnNpCpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
