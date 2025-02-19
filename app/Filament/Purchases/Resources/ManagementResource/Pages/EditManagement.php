<?php

namespace App\Filament\Purchases\Resources\ManagementResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Models\Management;
use Illuminate\Support\Str;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Purchases\Resources\ManagementResource;

class EditManagement extends EditRecord
{
    protected static string $resource = ManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     $data['name'] = Str::of($data['name'])->squish()->title();
    //     $data['acronym'] = Str::of($data['acronym'])->upper()->replace(' ', '');
    //     return $data;
    // }

    protected function beforeSave(): void
    {
        $modelDB = Management::with('responsible')->find($this->record->id);
        if ($modelDB->responsible_id !== $this->data['responsible_id']) {
            $modelDB->responsible->removeRole('gerente_solicitante_orden_compra');
            $user = User::find($this->data['responsible_id']);
            $user->assignRole('gerente_solicitante_orden_compra');
        }
    }
}
