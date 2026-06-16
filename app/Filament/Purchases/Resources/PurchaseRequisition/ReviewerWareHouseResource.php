<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition;

use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource\Pages\ManagePRReviewWareHouses;
use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource\Pages\ViewPR;
use App\Filament\Purchases\Resources\PurchaseRequisition\ReviewerWareHouseResource\RelationManagers;
use App\Models\PurchaseRequisition;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Builder;

class ReviewerWareHouseResource extends Resource
{
    protected static ?string $model = PurchaseRequisition::class;

    protected static ?string $modelLabel = 'Requisición';

    protected static ?string $pluralModelLabel = 'Requisiciones';

    protected static ?string $navigationLabel = 'Revisar por almacén';

    protected static ?string $slug = 'requisiciones/revisar/almacen';

    protected static string|\UnitEnum|null $navigationGroup = 'Requisiciones';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return auth()->user()->can('view_review_warehouse_purchase::requisition::requester');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getCreateAuthorizationResponse(): Response
    {
        return Response::deny();
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

    public static function infolist(Schema $infolist): Schema
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
            ->recordActions([
                ActionGroup::make([
                    Actions\ViewAction::make(),
                    Actions\Action::make('Ver pdf')
                        ->icon('heroicon-m-document')
                        ->url(fn ($record) => (string) route('requisition.pdf', ['id' => $record->id]))
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
