<?php

namespace App\Filament\Purchases\Resources\ManagementResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Purchases\Resources\ManagementResource;

class CreateManagement extends CreateRecord
{
    protected static string $resource = ManagementResource::class;
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data['name'] = Str::of($data['name'])->squish()->title();
    //     $data['acronym'] = Str::of($data['acronym'])->upper()->replace(' ', '');
    //     return $data;
    // }
    protected function afterCreate(): void
    {
        $this->record->responsible->assignRole('aprueba_requisicion_compra');
        $this->record->responsible->assignRole('gerente_solicitante_orden_compra');
    }
}
