<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\PurchaseRequisition;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Models\PurchaseRequisitionApprovalChain;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource\Pages\ViewPR;
use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource\Pages\ViewPdf;
use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource\RelationManagers;
use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource\Pages\ManagePRReviewWareHouses;

class ReviewerWareHouseResource extends Resource
{
    protected static ?string $model = PurchaseRequisition::class;
    protected static ?string $modelLabel = 'Requisición';
    protected static ?string $pluralModelLabel = 'Requisiciones';
    protected static ?string $navigationLabel = 'Revisar por almacén';
    protected static ?string $slug = 'requisiciones/revisar/almacen';
    protected static ?string $navigationGroup = 'Requisiciones';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 2;



    public static function canAccess(): bool
    {
        return auth()->user()->can('view_review_warehouse_purchase::requisition::requester');
    }
    public static function canCreate(): bool
    {
        return false;
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->reviewWarehouse();
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::reviewWarehouse()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        $options = [];
        return RequesterResource::infolist($infolist, $options);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->label('Folio')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('approvalChain.requester.name')
                    ->label('Solicitante')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project.name')
                    ->label('Proyecto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_delivery')
                    ->label('Fecha deseable de entrega')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualización')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('Ver pdf')
                        ->icon('heroicon-m-document')
                        ->url(fn($record) => (string)route('requisition.pdf', ['id' => $record->id]))
                        ->openUrlInNewTab(),
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
            'index' => ManagePRReviewWareHouses::route('/'),
            'view' => ViewPR::route('/{record}'),
        ];
    }
}
