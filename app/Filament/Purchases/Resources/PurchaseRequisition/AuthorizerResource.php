<?php
namespace App\Filament\Purchases\Resources\PurchaseRequisition;


use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\PurchaseRequisition;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Purchases\Resources\PurchaseRequisition\AuthorizerResource\Pages;

class AuthorizerResource extends Resource
{
    protected static ?string $model = PurchaseRequisition::class;
    protected static ?string $modelLabel = 'Requisición';
    protected static ?string $pluralModelLabel = 'Requisiciones';
    protected static ?string $navigationLabel = 'Aprobar por DG';
    protected static ?string $slug = 'requisiciones-aprobar-dg';
    protected static ?string $navigationGroup = 'Requisiciones';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 5;

    public static function canAccess(): bool
    {
        return auth()->user()->can('view_authorize_purchase::requisition');
    }
    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->approveDG();
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::approveDG()->count();
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
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('Ver pdf')
                        ->icon('heroicon-m-document')
                        ->url(fn(PurchaseRequisition $record): string => AuthorizerResource::getUrl('view-pdf', ['record' => $record->id]))
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePRApprovalDGS::route('/'),
            'view' => Pages\View::route('/{record}'),
            'view-pdf' => Pages\ViewPdf::route('/{record}/pdf'),
        ];
    }
}
