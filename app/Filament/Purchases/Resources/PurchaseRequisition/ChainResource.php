<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition;


use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Management;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\PurchaseRequisition;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Actions;
use Filament\Notifications\Notification;
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
                    ->options(User::role('aprueba_requisicion_compra')->pluck('name', 'id'))
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewer.name')
                    ->label('Revisa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approver.name')
                    ->label('Aprueba')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('authorizer.name')
                    ->label('Autoriza')
                    ->searchable()
                    ->sortable(),
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
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Borrar')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->icon('heroicon-m-trash')
                    ->modalWidth(MaxWidth::FiveExtraLarge)
                    ->slideOver()
                    ->form([
                        Forms\Components\Section::make('Requisiciones relacionadas')
                            ->visible(fn($record) => $record->requisitions()->withTrashed()->count() > 0)
                            ->schema([
                                Forms\Components\TextInput::make('quantity')
                                    ->label('Cantidad')
                                    ->default(fn($record) => $record->requisitions()->withTrashed()->count())
                                    ->numeric()
                                    ->readOnly(),
                                Forms\Components\Select::make('chain_replaced')
                                    ->label('Cadena de reemplazo')
                                    ->required()
                                    ->options(function (): array {
                                        return PurchaseRequisitionApprovalChain::all()->mapWithKeys(function ($model) {
                                            return [$model->id => '(Revisa)' . $model->reviewer->name . ' (Aprueba)' . $model->approver->name . ' (Autoriza)' . $model->authorizer->name];
                                        })->toArray();
                                    })
                            ])
                    ])
                    ->action(function (array $data, $record) {
                        if ($record->requisitions()->withTrashed()->count() <= 0) {
                            $record->delete();
                            Notification::make()
                                ->title('Borrado')
                                ->success()
                                ->send();
                            return;
                        }
                        try {
                            // $chains = PurchaseRequisition::where('approval_chain_id', $record->id)->update(['approval_chain_id'=> $data['chain_replaced']]);
                            $chains = PurchaseRequisition::where('approval_chain_id', $record->id)->get();
                            foreach ($chains as $chain) {
                                $chain->approval_chain_id = $data['chain_replaced'];
                                $chain->save();
                            }
                            $record->delete();
                            Notification::make()
                                ->title('Cadena remplazada')
                                ->success()
                                ->send();
                            Notification::make()
                                ->title('Borrado')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            logger()->error($e->getMessage());
                            Notification::make()
                                ->title('Ocurrió un error')
                                ->danger()
                                ->send();
                        }
                    }),
            ])
        ;
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
