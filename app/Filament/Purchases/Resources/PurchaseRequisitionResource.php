<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\PurchaseRequisitionResource\Pages;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource\RelationManagers;
use App\Models\PurchaseRequisition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseRequisitionResource extends Resource
{
    protected static ?string $model = PurchaseRequisition::class;
    protected static ?string $modelLabel = 'Requisición';
    protected static ?string $pluralModelLabel = 'Requisiciónes';
    protected static ?string $navigationLabel = 'Requisiciónes';
    protected static ?string $slug = 'requisiciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('folio')
                    ->required()
                    ->maxLength(255),
                // Forms\Components\Select::make('request_user_id')
                //     ->relationship('requestUser', 'name')
                //     ->required(),
                Forms\Components\DatePicker::make('date_delivery')
                    ->label('Fecha deseable de entrega')
                    ->default(now()->addDay(3))
                    ->required(),
                Forms\Components\Textarea::make('delivery_address')
                    ->label('Dirección de entrega')
                    ->required()
                    ->maxLength(500),
                Forms\Components\TextInput::make('type')
                    ->label('Tipo de requisición')
                    ->required()
                    ->maxLength(50),
                Forms\Components\Select::make('approval_chain_id')
                    ->label('Flujo de aprobación')
                    ->relationship('approvalChain', 'id')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('requestUser.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_delivery')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('approvalChain.id')
                    ->numeric()
                    ->sortable(),
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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPurchaseRequisitions::route('/'),
            'create' => Pages\CreatePurchaseRequisition::route('/create'),
            'edit' => Pages\EditPurchaseRequisition::route('/{record}/edit'),
        ];
    }
}
