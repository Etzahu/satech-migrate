<?php
namespace App\Filament\Purchases\Resources\PurchaseRequisition;


use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\PurchaseRequisition;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Purchases\Resources\PurchaseRequisition\HistoryResource\Pages;

class HistoryResource extends Resource
{
    protected static ?string $model = PurchaseRequisition::class;
    protected static ?string $modelLabel = 'Historial de requisición';
    protected static ?string $pluralModelLabel = 'Historial de requisiciónes';
    protected static ?string $navigationLabel = 'Historial';
    protected static ?string $slug = 'requisiciones-historial';
    protected static ?string $navigationGroup = 'Requisiciones';
    protected static ?string $navigationIcon = 'heroicon-o-minus';
    protected static ?int $navigationSort = 12;

    public static function canAccess(): bool
    {
        return
         auth()->user()->hasRole('solicita_requisicion_compra')||
         auth()->user()->hasRole('revisa_almacen_requisicion_compra')||
         auth()->user()->hasRole('revisa_requisicion_compra')||
         auth()->user()->hasRole('aprueba_requisicion_compra')||
        auth()->user()->hasRole('autoriza_requisicion_compra')||
        auth()->user()->hasRole('administrador_compras');
    }
    public static function canCreate(): bool
    {
        return false;
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
                        ->url(fn($record) => (string)route('requisition.pdf', ['id' => $record->id]))
                        ->openUrlInNewTab(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePR::route('/'),
            'view' => Pages\View::route('/{record}'),
        ];
    }
}
