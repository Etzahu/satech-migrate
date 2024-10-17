<?php

namespace App\Filament\Purchases\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\PurchaseRequisition;
use Illuminate\Database\Eloquent\Builder;
use App\Models\PurchaseRequisitionApprovalChain;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource\Pages;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource\RelationManagers;

class PurchaseRequisitionResource extends Resource
{
    protected static ?string $model = PurchaseRequisition::class;
    protected static ?string $modelLabel = 'Requisición';
    protected static ?string $pluralModelLabel = 'Mis requisiciónes';
    protected static ?string $navigationLabel = 'Mis requisiciónes';
    protected static ?string $slug = 'requisiciones';


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('company_id', session()->get('company_id'))
            ->whereIn('approval_chain_id', auth()->user()->approvalChains->pluck('id')->toArray());
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información general')
                    ->schema([
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
                        Forms\Components\Select::make('project_id')
                            ->label('Proyecto')
                            ->relationship('project', 'name', modifyQueryUsing: fn (Builder $query) => $query->where('company_id',session()->get('company_id')))
                            ->searchable()
                            ->preload()
                            ->required(),

                    ]),
                Forms\Components\Section::make('Flujo de aprobación')
                    ->schema([
                        Forms\Components\Select::make('reviewer_id')
                            ->label('Revisa')
                            ->options(
                                PurchaseRequisitionApprovalChain::with(['reviewer'])
                                    ->where('requester_id', auth()->user()->id)->get()
                                    ->pluck('reviewer.name', 'reviewer.id')
                            )
                            ->required(),
                        Forms\Components\Select::make('approver_id')
                            ->label('Aprueba')
                            ->options(
                                PurchaseRequisitionApprovalChain::with(['approver'])
                                    ->where('requester_id', auth()->user()->id)->get()
                                    ->pluck('approver.name', 'approver.id')
                            )
                            ->required()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_delivery')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
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
                Tables\Actions\ViewAction::make(),
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
            'view' => Pages\ViewPurchaseRequisition::route('/{record}'),
            'edit' => Pages\EditPurchaseRequisition::route('/{record}/edit'),
        ];
    }
}
