<?php

namespace App\Filament\Purchases\Resources\UserResource\Pages;

use App\Filament\Purchases\Resources\UserResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\Models\Role;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Un usuario inactivo se queda sin roles.
     *
     * Al guardar la baja el observer ya los retira, pero la casilla de roles
     * seguía mostrándolos y, si se volvía a guardar —o se le marcaban roles a
     * alguien que ya estaba inactivo—, el formulario se los ponía de nuevo.
     */
    protected function afterSave(): void
    {
        if ($this->record->active) {
            return;
        }

        $this->record->revokeAllRoles();

        $checkedRoles = $this->data['roles'] ?? [];

        if (blank($checkedRoles)) {
            return;
        }

        $this->fillForm();

        Notification::make()
            ->title('Se le retiraron sus roles')
            ->body('El usuario está inactivo. Roles retirados: '.Role::whereKey($checkedRoles)->pluck('name')->implode(', ').'.')
            ->warning()
            ->send();
    }
}
