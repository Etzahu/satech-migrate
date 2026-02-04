<?php

namespace App\Filament\Purchases\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Management;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Purchases\Resources\ManagementResource\Pages;
use App\Filament\Purchases\Resources\ManagementResource\RelationManagers;

class ManagementResource extends Resource
{
    protected static ?string $model = Management::class;
    protected static ?string $modelLabel = 'Gerencia';
    protected static ?string $pluralModelLabel = 'Gerencias';
    protected static ?string $navigationLabel = 'Gerencias';
    protected static ?string $slug = 'gerencias';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 2;


    // public static function canView(Model $ownerRecord): bool
    // {
    //     return false;
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Información general')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre')
                                    ->validationMessages([
                                        'unique' => 'El :attribute ya esta registrado.',
                                    ])
                                    ->required()
                                    ->unique(table: Management::class, ignoreRecord: true)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('acronym')
                                    ->label('Codigo')
                                    ->validationMessages([
                                        'unique' => 'El :attribute ya esta registrado.',
                                    ])
                                    ->required()
                                    ->unique(table: Management::class, ignoreRecord: true)
                                    ->maxLength(10),
                                Forms\Components\Select::make('responsible_id')
                                    ->label('Responsable')
                                    ->relationship('responsible', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\Select::make('restriction_requisition')
                                    ->label('Restricción para proyectos')
                                    ->options(['limitar' => 'Limitar', 'excluir' => 'Excluir'])
                                    ->nullable()
                            ]),
                    ])
                // Forms\Components\Section::make('Restricciones')
                //     ->visible(fn($record, $operation) => filled($record->restriction_requisition) && $operation == 'edit')
                //     ->schema([
                //         \Njxqlus\Filament\Components\Forms\RelationManager::make()
                //             ->manager(RelationManagers\ProjectsRelationManager::class)
                //             ->lazy(true)
                //     ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Gerencia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('responsible.name')
                    ->label('Responsable')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('acronym')
                    ->label('Código')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
        ;
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProjectsRelationManager::class,
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListManagement::route('/'),
            'create' => Pages\CreateManagement::route('/create'),
            'edit' => Pages\EditManagement::route('/{record}/edit'),
        ];
    }
}
