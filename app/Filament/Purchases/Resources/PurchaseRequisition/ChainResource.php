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
use Illuminate\Database\Eloquent\Model;

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
                    // Opcional a propósito: el correo de Operaciones del
                    // 18-ago-2026 elimina este nivel en las requisiciones de
                    // Soldadura y Servicios Técnicos. Dejarlo vacío no rompe la
                    // cadena; la requisición avanza sola por ese paso.
                    ->placeholder('N/A — sin nivel de autorización')
                    ->helperText('Déjalo vacío si esta cadena no lleva nivel de autorización.')
                    // Evita cadenas duplicadas: no puede existir otra con la misma
                    // combinación Solicita/Revisa/Aprueba/Autoriza (ignora el propio registro al editar).
                    ->rules([
                        fn (Get $get, ?PurchaseRequisitionApprovalChain $record): Closure => function (string $attribute, $value, Closure $fail) use ($get, $record) {
                            $exists = PurchaseRequisitionApprovalChain::query()
                                ->where('requester_id', $get('requester_id'))
                                ->where('reviewer_id', $get('reviewer_id'))
                                ->where('approver_id', $get('approver_id'))
                                // NULL = NULL nunca es verdadero en SQL, así que
                                // el nivel vacío necesita su propia comparación.
                                ->when(
                                    $value === null,
                                    fn (Builder $query) => $query->whereNull('authorizer_id'),
                                    fn (Builder $query) => $query->where('authorizer_id', $value),
                                )
                                ->when($record, fn (Builder $query) => $query->whereKeyNot($record->getKey()))
                                ->exists();

                            if ($exists) {
                                $fail('Ya existe una cadena con esta misma combinación de Solicita, Revisa, Aprueba y Autoriza.');
                            }
                        },
                    ]),
                Forms\Components\Toggle::make('po_flow_excluded')
                    ->label('Excluir del flujo de orden por rol')
                    ->helperText('Marcar solo si esta cadena debe conservar su propio aprobador y autorizador en las órdenes, pese a que su gerencia use el flujo por rol.')
                    ->visible(fn ($record) => (bool) $record?->requester?->management?->purchase_order_flow),
            ]);
    }

    /**
     * Columna de un participante de la cadena, resaltada en rojo cuando el
     * usuario fue desactivado (la cadena queda inutilizable hasta reemplazarlo).
     */
    protected static function participantColumn(string $role, string $label): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make("{$role}.name")
            ->label($label)
            ->searchable()
            ->sortable()
            ->color(fn ($record) => $record->{$role}?->active ? null : 'danger')
            ->icon(fn ($record) => $record->{$role}?->active ? null : 'heroicon-m-exclamation-triangle')
            ->tooltip(fn ($record) => $record->{$role}?->active ? null : 'Usuario inactivo');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                static::participantColumn('requester', 'Solicita'),
                static::participantColumn('reviewer', 'Revisa'),
                static::participantColumn('approver', 'Aprueba'),
                static::participantColumn('authorizer', 'Autoriza'),
                Tables\Columns\TextColumn::make('archived_at')
                    ->label('Estado')
                    ->badge()
                    ->state(fn ($record) => $record->isArchived() ? 'Desactivada' : ($record->hasInactiveUsers() ? 'Bloqueada' : 'Activa'))
                    ->color(fn ($state) => match ($state) {
                        'Desactivada' => 'gray',
                        'Bloqueada' => 'danger',
                        default => 'success',
                    })
                    ->tooltip(fn ($record) => $record->unavailabilityReason()),
                Tables\Columns\TextColumn::make('requisitions_count')
                    ->label('Requisiciones relacionadas')
                    ->counts(['requisitions' => fn (Builder $query) => $query->withTrashed()])
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'gray')
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
                Tables\Filters\TernaryFilter::make('archived_at')
                    ->label('Desactivadas')
                    ->placeholder('Todas')
                    ->trueLabel('Solo desactivadas')
                    ->falseLabel('Solo activas')
                    ->queries(
                        true: fn (Builder $query) => $query->archived(),
                        false: fn (Builder $query) => $query->notArchived(),
                    ),
            ])
            ->recordActions([
                // Una cadena que ya se usó solo se consulta: editar sus
                // participantes reescribiría el flujo de las requisiciones que
                // ya la recorrieron.
                Actions\ViewAction::make()
                    ->visible(fn ($record) => $record->isInUse()),
                Actions\EditAction::make()
                    ->visible(fn ($record) => ! $record->isInUse()),
                Actions\Action::make('archive')
                    ->label('Desactivar')
                    ->icon('heroicon-m-pause-circle')
                    ->color('gray')
                    ->visible(fn ($record) => ! $record->isArchived())
                    ->requiresConfirmation()
                    ->modalHeading('Desactivar cadena de aprobación')
                    ->modalDescription('Los solicitantes dejarán de poder elegir esta cadena. Las requisiciones que ya la usan conservan su historial y siguen su curso.')
                    ->action(function ($record) {
                        $record->update(['archived_at' => now()]);

                        Notification::make()
                            ->title('Cadena desactivada')
                            ->success()
                            ->send();
                    }),
                Actions\Action::make('unarchive')
                    ->label('Reactivar')
                    ->icon('heroicon-m-play-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->isArchived())
                    ->requiresConfirmation()
                    ->modalHeading('Reactivar cadena de aprobación')
                    ->action(function ($record) {
                        $record->update(['archived_at' => null]);

                        Notification::make()
                            ->title('Cadena reactivada')
                            ->success()
                            ->send();
                    }),
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
                                    ->helperText('Solo se listan cadenas activas y con todos sus participantes activos.')
                                    ->required()
                                    ->searchable()
                                    ->options(function ($record): array {
                                        return PurchaseRequisitionApprovalChain::query()
                                            ->with(['reviewer', 'approver', 'authorizer'])
                                            ->selectable()
                                            ->whereKeyNot($record->getKey())
                                            ->get()
                                            ->mapWithKeys(fn ($model) => [
                                                $model->id => '(Revisa)'.$model->reviewer->name.' (Aprueba)'.$model->approver->name.' (Autoriza)'.$model->authorizer->name,
                                            ])
                                            ->toArray();
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

    /**
     * Cerrar el permiso aquí, y no solo ocultar el botón, bloquea también la
     * URL directa de edición de una cadena que ya se usó.
     */
    public static function canEdit(Model $record): bool
    {
        return ! $record->isInUse() && parent::canEdit($record);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(PurchaseRequisitionApprovalChain::ROLES);
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
