<?php

namespace App\Filament\Ingenieria\Resources;

use App\Filament\Ingenieria\Resources\ProjectDnNpCpResource\Pages;
use App\Filament\Ingenieria\Resources\ProjectDnNpCpResource\RelationManagers;
use App\Models\ProjectDnNpCp;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectDnNpCpResource extends Resource
{
    protected static ?string $model = ProjectDnNpCp::class;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(60),
                Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->options([
                        'DN' => 'DN',
                        'NP' => 'NP',
                        'CP' => 'CP',
                    ]),
                Forms\Components\TextInput::make('client')
                    ->label('Cliente')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectDnNpCps::route('/'),
            // 'create' => Pages\CreateProjectDnNpCp::route('/create'),
            // 'edit' => Pages\EditProjectDnNpCp::route('/{record}/edit'),
        ];
    }
}
