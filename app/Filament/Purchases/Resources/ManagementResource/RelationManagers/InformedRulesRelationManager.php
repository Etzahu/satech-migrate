<?php

namespace App\Filament\Purchases\Resources\ManagementResource\RelationManagers;

use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Mantenimiento del nivel informativo de una gerencia.
 *
 * Existe para que cambiar quién está informado no requiera un despliegue: el
 * gerente de compras lo edita aquí. Una gerencia puede tener varias reglas y
 * todas las que casan aplican a la vez —en Manufactura, el titular ve todo y
 * Jennifer además los servicios—.
 */
class InformedRulesRelationManager extends RelationManager
{
    protected static string $relationship = 'informedRules';

    protected static ?string $title = 'Informativos';

    protected static ?string $modelLabel = 'informativo';

    protected static ?string $pluralModelLabel = 'informativos';

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Usuario informado')
                    ->helperText('Solo ve los documentos: no aprueba, no autoriza y no libera.')
                    // Al crear solo se ofrecen usuarios activos; al editar se
                    // conservan los dados de baja para no romper reglas viejas,
                    // igual que hace ChainResource con la cadena.
                    ->options(fn (string $operation) => User::query()
                        ->when($operation === 'create', fn (Builder $query) => $query->where('active', 1))
                        ->orderBy('name')
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('category')
                    ->label('Categoría')
                    ->helperText('Vacío = todas las categorías de la gerencia.')
                    ->options([
                        'servicio' => 'Solo servicios',
                        'proveeduria' => 'Solo proveeduría',
                    ])
                    ->placeholder('Todas')
                    ->native(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario informado')
                    ->searchable()
                    ->sortable()
                    // Un informativo dado de baja deja de recibir el correo:
                    // conviene que se vea a simple vista.
                    ->color(fn ($record) => $record->user?->active ? null : 'danger')
                    ->description(fn ($record) => $record->user?->active ? null : 'Usuario dado de baja'),

                Tables\Columns\TextColumn::make('category')
                    ->label('Categoría')
                    ->badge()
                    ->placeholder('Todas')
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'servicio' => 'Solo servicios',
                        'proveeduria' => 'Solo proveeduría',
                        default => 'Todas',
                    }),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Correo de aviso')
                    ->searchable()
                    ->toggleable(),
            ])
            ->headerActions([
                Actions\CreateAction::make()
                    ->label('Agregar informativo'),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make()
                    ->label('Quitar'),
            ]);
    }
}
