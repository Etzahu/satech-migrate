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
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource\Pages;
use App\Filament\Purchases\Resources\PurchaseRequisitionResource\RelationManagers;



class PurchaseRequisitionResource extends Resource
{
    protected static ?string $model = PurchaseRequisition::class;
    protected static ?string $modelLabel = 'Requisición';
    protected static ?string $pluralModelLabel = 'Requisiciones';
    protected static ?string $navigationLabel = 'Mis requisiciones';
    protected static ?string $slug = 'mis-requisiciones';
    protected static ?string $navigationGroup = 'Requisiciones';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 1;




    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->myRequisitions()
            ->where('company_id', session()->get('company_id'));
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::myRequisitions()->count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información general')
                    ->schema([
                        Forms\Components\Textarea::make('motive')
                            ->label('Motivo')
                            ->maxLength(600)
                            ->required(),
                        Forms\Components\DatePicker::make('date_delivery')
                            ->label('Fecha deseable de entrega')
                            ->minDate(now())
                            ->default(now()->addDay(3))
                            ->required(),
                        Forms\Components\Textarea::make('delivery_address')
                            ->label('Dirección de entrega')
                            ->required()
                            ->maxLength(500),
                        Forms\Components\Select::make('project_id')
                            ->label('Proyecto')
                            ->relationship('project', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('company_id', session()->get('company_id')))
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Textarea::make('observation')
                            ->label('Observación adicionales')
                            ->maxLength(600)
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
                Forms\Components\Section::make('Documentación adicional')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('document')
                            ->label('Fichas técnicas')
                            ->acceptedFileTypes(['application/pdf'])
                            ->collection('technical_data_sheets')
                            ->multiple(),
                        SpatieMediaLibraryFileUpload::make('supports')
                            ->label('Soportes')
                            ->acceptedFileTypes(['application/pdf'])
                            ->collection('supports')
                            ->multiple()
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
                Tables\Actions\EditAction::make()
                    ->visible(function (PurchaseRequisition $record) {
                        return $record->status == 'borrador';
                    }),
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\Action::make('ver')
                //     ->url(fn(PurchaseRequisition $record): string => route('filament.compras.resources.requisiciones.flow-approval', $record->id)),
                // Tables\Actions\Action::make('revision')
                //     ->url(fn(PurchaseRequisition $record): string => route('filament.compras.resources.requisiciones.warehouse-revision', $record->id)),
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
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseRequisitions::route('/'),
            'create' => Pages\CreatePurchaseRequisition::route('/create'),
            'view' => Pages\ViewPurchaseRequisition::route('/{record}'),
            'edit' => Pages\EditPurchaseRequisition::route('/{record}/edit'),
            'flow-approval' => Pages\RevisionFlow::route('/{record}/flujo-de-aprobaciones'),
            'warehouse-revision' => Pages\RevisionFlow::route('/{record}/revision-almacen'),
        ];
    }
}



// php artisan make:filament-resource PurchaseRequisitionReviewWareHouseResource --model-namespace=App\\Models\\PurchaseRequisition --generate -S --panel=compras
// php artisan make:filament-resource PurchaseRequisitionReviewResource --model-namespace=App\\Models\\PurchaseRequisition --generate -S --panel=compras
// php artisan make:filament-resource PurchaseRequisitionApprovalResource --model-namespace=App\\Models\\PurchaseRequisition --generate -S --panel=compras
