<?php

namespace App\Filament\Purchases\Resources\ManagementResource\RelationManagers;

use Filament\Actions;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    protected static ?string $modelLabel = 'Proyecto';

    protected static ?string $pluralModelLabel = 'Proyectos';

    protected static ?string $navigationLabel = 'Proyecto';

    protected static ?string $title = 'Proyectos';

    #[On('refreshRelationManagerItemsProjects')]
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Codigo'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Proyecto'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Actions\CreateAction::make(),
                Actions\AttachAction::make()
                    ->recordSelectOptionsQuery(fn (Builder $query) => $query->where('company_id', session()->get('company_id'))->where('status', 'activo'))
                    ->multiple(),
            ])
            ->recordActions([
                // Actions\EditAction::make(),
                Actions\DetachAction::make(),
                // Actions\DeleteAction::make(),
            ])
            ->inverseRelationship('managements');
    }
}
