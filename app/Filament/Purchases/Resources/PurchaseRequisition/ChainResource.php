<?php

namespace App\Filament\Purchases\Resources\PurchaseRequisition;

use App\Filament\Purchases\Resources\PurchaseRequisition\ChainResource\Pages;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;
use Closure;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChainResource extends Resource
{
    protected static ?string $model = PurchaseRequisitionApprovalChain::class;

    protected static ?string $modelLabel = 'Cadena requisición';

    protected static ?string $pluralModelLabel = 'Cadena requisición';

    protected static ?string $navigationLabel = 'Cadena requisición';

    protected static ?string $slug = 'cadena-requisicion';

    protected static string|\UnitEnum|null $navigationGroup = 'Administración';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 8;

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Forms\Components\Select::make('requester_id')
                    ->label('Solicita')
                    ->relationship('requester', 'name', modifyQueryUsing: fn (Builder $query, string $operation) => $operation === 'create'
                        ? $query->where('active', 1)->where('email', 'like', '%@gptservices.com')
                        : $query->where('email', 'like', '%@gptservices.com'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('reviewer_id')
                    ->label('Revisa')
                    ->relationship('reviewer', 'name', modifyQueryUsing: fn (Builder $query, string $operation) => $operation === 'create'
                        ? $query->where('active', 1)->where('email', 'like', '%@gptservices.com')
                        : $query->where('email', 'like', '%@gptservices.com'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('approver_id')
                    ->label('Aprueba')
                    ->relationship('approver', 'name', modifyQueryUsing: fn (Builder $query, string $operation) => $operation === 'create'
                        ? $query->where('active', 1)->whereHas('roles', fn (Builder $q) => $q->where('name', 'aprueba_requisicion_compra'))
                        : $query->whereHas('roles', fn (Builder $q) => $q->where('name', 'aprueba_requisicion_compra')))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('authorizer_id')
                    ->label('Autoriza')
                    ->relationship('authorizer', 'name', modifyQueryUsing: fn (Builder $query, string $operation) => $operation === 'create'
                        ? $query->where('active', 1)->whereHas('roles', fn (Builder $q) => $q->where('name', 'autoriza_requisicion_compra'))
                        : $query->whereHas('roles', fn (Builder $q) => $q->where('name', 'autoriza_requisicion_compra')))
                    ->searchable()
                    ->preload()
                    ->required()
                    // Evita cadenas duplicadas: no puede existir otra con la misma
                    // combinación Solicita/Revisa/Aprueba/Autoriza (ignora el propio registro al editar).
                    ->rules([
                        fn (Get $get, ?PurchaseRequisitionApprovalChain $record): Closure => function (string $attribute, $value, Closure $fail) use ($get, $record) {
                            $exists = PurchaseRequisitionApprovalChain::query()
                                ->where('requester_id', $get('requester_id'))
                                ->where('reviewer_id', $get('reviewer_id'))
                                ->where('approver_id', $get('approver_id'))
                                ->where('authorizer_id', $value)
                                ->when($record, fn (Builder $query) => $query->whereKeyNot($record->getKey()))
                                ->exists();

                            if ($exists) {
                                $fail('Ya existe una cadena con esta misma combinación de Solicita, Revisa, Aprueba y Autoriza.');
                            }
                        },
                    ]),
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
                Tables\Columns\TextColumn::make('requisitions_count')
                    ->label('Requisiciones relacionadas')
                    ->counts('requisitions')
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
            ->filters([
                Tables\Filters\SelectFilter::make('requester_id')
                    ->label('Solicita')
                    ->relationship('requester', 'name', modifyQueryUsing: fn (Builder $query) => $query->where('active', 1)->where('email', 'like', '%@gptservices.com'))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('reviewer_id')
                    ->label('Revisa')
                    ->relationship('reviewer', 'name', modifyQueryUsing: fn (Builder $query) => $query->where('active', 1)->where('email', 'like', '%@gptservices.com'))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('approver_id')
                    ->label('Aprueba')
                    ->relationship('approver', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('authorizer_id')
                    ->label('Autoriza')
                    ->relationship('authorizer', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make()
                    ->visible(fn ($record) => $record->requisitions()->withTrashed()->count() == 0),
                Actions\Action::make('Borrar')
                    ->visible(fn ($record) => $record->requisitions()->withTrashed()->count() > 0)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->icon('heroicon-m-trash')
                    ->modalWidth(Width::FiveExtraLarge)
                    ->slideOver()
                    ->schema([
                        Schemas\Components\Section::make('Requisiciones relacionadas')
                            ->schema([
                                Forms\Components\TextInput::make('quantity')
                                    ->label('Cantidad')
                                    ->default(fn ($record) => $record->requisitions()->withTrashed()->count())
                                    ->numeric()
                                    ->readOnly(),
                                Forms\Components\Select::make('chain_replaced')
                                    ->label('Cadena de reemplazo')
                                    ->required()
                                    ->options(function (): array {
                                        return PurchaseRequisitionApprovalChain::all()->mapWithKeys(function ($model) {
                                            return [$model->id => '(Revisa)'.$model->reviewer->name.' (Aprueba)'.$model->approver->name.' (Autoriza)'.$model->authorizer->name];
                                        })->toArray();
                                    }),
                            ]),
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
            ]);
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
