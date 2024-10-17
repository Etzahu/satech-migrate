<?php

namespace App\Filament\Purchases\Resources\ProjectPurchaseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsageRelationManager extends RelationManager
{
    protected $listeners = ['refresh' => '$refresh'];
    protected static string $relationship = 'usage';
    protected static ?string $modelLabel = 'Necesidad de proyecto';
    protected static ?string $pluralModelLabel = 'Necesidad de proyectos';
    protected static ?string $navigationLabel = 'Necesidad de proyectos';
    protected static ?string $slug = 'proyectos-necesidad';
    protected static ?string $title = 'Necesidades de proyecto';

    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {

        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->label('Agregar uso')
                    ->visible($this->getOwnerRecord()->status)
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
