<?php

namespace App\Filament\Purchases\Resources\ManagementResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Models\Management;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
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

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if ($record->restriction_requisition !== $data['restriction_requisition']) {
            $record->projects()->detach();
        }
        $record->update($data);
        return $record;
    }

    protected function afterSave(): void
    {
        $this->dispatch('refreshRelationManagerItemsProjects');
    }

    // public function hasCombinedRelationManagerTabsWithContent(): bool
    // {
    //     return true;
    // }

    public function getRelationManagers(): array
    {
        $relationManagers = parent::getRelationManagers();
        // Ocultar todos los Relation Managers si el registro no está publicado
        if (blank($this->record->restriction_requisition)) {
            unset($relationManagers[0]);
        }
        // Devolver los Relation Managers normalmente
        return $relationManagers;
    }
}
