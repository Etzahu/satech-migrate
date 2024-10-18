<?php

namespace App\Filament\Purchases\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\PurchaseRequisition;
use Illuminate\Database\Eloquent\Builder;
use App\Models\PurchaseRequisitionApprovalChain;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource\Pages;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource\RelationManagers;

class PurchaseRequisitionResource extends Resource
{
    protected static ?string $model = PurchaseRequisition::class;
    protected static ?string $modelLabel = 'Requisición';
    protected static ?string $pluralModelLabel = 'Solicitadas';
    protected static ?string $navigationLabel = 'Solicitadas';
    protected static ?string $slug = 'mis-requisiciones';
    protected static ?string $navigationGroup = 'Requisiciones';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
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
                            ->relationship('project', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('company_id', session()->get('company_id')))
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
                    ]),
                Forms\Components\Section::make('Documentacion adicional')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('document')
                            ->label('Documentos')
                            ->acceptedFileTypes(['application/pdf'])
                            ->collection('additional_documents')
                            ->multiple()
                    ])

            ]);
    }


    // public static function infolist(Infolist $infolist): Infolist
    // {
    //     return $infolist
    //         ->schema([
    //             SpatieMediaLibraryImageEntry::make('document')
    //             ->collection('additional_documents')
    //                 ->columnSpanFull(),
    //         ]);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_delivery')
                    ->label('Fecha deseable de entrega')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus')
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





// 
// php artisan make:filament-resource PurchaseRequisitionReviewResource --model=PurchaseRequisition --generate -S --panel=compras
// php artisan make:filament-resource PurchaseRequisitionReviewAuthorizeResource --model=PurchaseRequisition --generate -S --panel=compras
// php artisan make:filament-resource PurchaseRequisitionReviewAuthorizeDGResource --model=PurchaseRequisition --generate -S --panel=compras
