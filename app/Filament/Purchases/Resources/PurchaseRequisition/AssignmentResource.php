<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition;

use App\Filament\Purchases\Resources\PurchaseRequisition\AssignmentResource\Pages;
use App\Models\PurchaseRequisition;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Builder;

class AssignmentResource extends Resource
{
    protected static ?string $model = PurchaseRequisition::class;

    protected static ?string $modelLabel = 'Requisición';

    protected static ?string $pluralModelLabel = 'Requisiciones';

    protected static ?string $navigationLabel = 'Mis asignaciones';

    protected static ?string $slug = 'requisiciones/asignacion';

    protected static string|\UnitEnum|null $navigationGroup = 'Requisiciones';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 7;
    // protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('comprador');
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
            ->myAssing();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::doesntHave('orders')->myAssing()->whereNot('status', 'cerrada')->count();
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
                Tables\Columns\TextColumn::make('orders_count')
                    ->counts('orders')
                    ->label('Ordenes')
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
            ->filters([])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePRAssingResource::route('/'),
            'view' => Pages\View::route('/{record}'),
        ];
    }
}
