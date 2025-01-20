<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition;


use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Actions;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Models\PurchaseRequisitionApprovalChain;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource\Pages;
use App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource\RelationManagers;

class ChainResource extends Resource
{
    protected static ?string $model = PurchaseRequisitionApprovalChain::class;
    protected static ?string $modelLabel = 'Cadena requisición';
    protected static ?string $pluralModelLabel = 'Cadena requisición';
    protected static ?string $navigationLabel = 'Cadena requisición';
    protected static ?string $slug = 'cadena-requisicion';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 8;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('requester_id')
                    ->label('Solicita')
                    ->relationship('requester', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('active', 1)->where('email', 'like', '%@gptservices.com'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('reviewer_id')
                    ->label('Revisa')
                    ->relationship('reviewer', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('active', 1)->where('email', 'like', '%@gptservices.com'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('approver_id')
                    ->label('Aprueba')
                    ->options(User::approvers()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('authorizer_id')
                    ->label('Autoriza')
                    ->options(User::role('autoriza_requisicion_compra')->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('requester.name')
                    ->label('Solicita')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewer.name')
                    ->label('Revisa')
                    ->sortable(),
                Tables\Columns\TextColumn::make('approver.name')
                    ->label('Aprueba')
                    ->sortable(),
                Tables\Columns\TextColumn::make('approver.name')
                    ->label('Autoriza')
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
            'index' => Pages\ListPurchaseRequisitionApprovalChains::route('/'),
            'create' => Pages\CreatePurchaseRequisitionApprovalChain::route('/create'),
            'edit' => Pages\EditPurchaseRequisitionApprovalChain::route('/{record}/edit'),
        ];
    }
}
