<?php

namespace App\Filament\Resources\RoleResource\RelationManagers;

use Filament\Actions;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\PermissionRegistrar;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $title = 'Usuarios';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return auth()->user()?->can('view', $ownerRecord) ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('puesto')
                    ->label('Puesto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('management.name')
                    ->label('Gerencia')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('active')
                    ->label('Activo')
                    ->boolean()
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('Solo activos')
                    ->query(fn (Builder $query): Builder => $query->where('active', true)),
            ])
            ->headerActions([
                Actions\AttachAction::make()
                    ->label('Adjuntar usuario')
                    ->modalHeading('Adjuntar usuarios al rol')
                    ->authorize(fn (): bool => $this->canManageRoleUsers())
                    ->multiple()
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name', 'email'])
                    ->after(fn () => $this->forgetCachedPermissions()),
            ])
            ->recordActions([
                Actions\DetachAction::make()
                    ->label('Quitar rol')
                    ->modalHeading('Quitar el rol a este usuario')
                    ->authorize(fn (): bool => $this->canManageRoleUsers())
                    ->after(fn () => $this->forgetCachedPermissions()),
            ])
            ->toolbarActions([
                Actions\DetachBulkAction::make()
                    ->label('Quitar rol')
                    ->authorize(fn (): bool => $this->canManageRoleUsers())
                    ->after(fn () => $this->forgetCachedPermissions()),
            ]);
    }

    protected function canManageRoleUsers(): bool
    {
        return auth()->user()?->can('update', $this->getOwnerRecord()) ?? false;
    }

    protected function forgetCachedPermissions(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
