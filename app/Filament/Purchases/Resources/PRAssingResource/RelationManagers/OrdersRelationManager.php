<?php

namespace App\Filament\Purchases\Resources\PRAssingResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PurchaseOrder;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Purchases\Resources\PurchaseOrderResource;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form
    {

        $options['rq'] = true;
        return PurchaseOrderResource::form($form, $options);
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }
    public function isReadOnly(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provider.company_name')
                    ->label('Proveedor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Ver')
                        ->icon('heroicon-s-eye')
                        ->url(fn(PurchaseOrder $record): string => PurchaseOrderResource::getUrl('view', ['record' => $record->id]))
            ]);
    }
}
