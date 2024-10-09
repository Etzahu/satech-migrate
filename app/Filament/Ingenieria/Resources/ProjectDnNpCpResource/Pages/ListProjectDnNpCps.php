<?php

namespace App\Filament\Ingenieria\Resources\ProjectDnNpCpResource\Pages;

use App\Filament\Ingenieria\Resources\ProjectDnNpCpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectDnNpCps extends ListRecords
{
    protected static string $resource = ProjectDnNpCpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
