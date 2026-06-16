<?php

namespace App\Filament\Purchases\Resources;

use App\Filament\Purchases\Resources\ProjectPurchaseResource\Pages;
use App\Models\ProjectPurchase;
use Closure;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProjectPurchaseResource extends Resource
{
    protected static ?string $model = ProjectPurchase::class;

    protected static ?string $modelLabel = 'Proyecto';

    protected static ?string $pluralModelLabel = 'Proyectos';

    protected static ?string $navigationLabel = 'Proyectos';

    protected static ?string $slug = 'proyectos';

    protected static string|\UnitEnum|null $navigationGroup = 'Administración';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 5;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('gerente_compras') || auth()->user()->hasRole('administrador_compras') || auth()->user()->hasRole('super_admin');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('company_id', session()->get('company_id'));
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pendiente')
            ->where('company_id', session()->get('company_id'))->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->columns(1)
            ->schema([
                Schemas\Components\Section::make('Información general')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Código')
                            ->helperText('Debe empezar con '.(session()->get('company_id') == 1 ? 'NP,'.' ejemplo NP-001/25' : 'DN,'.' ejemplo DN-001/25'))
                            ->unique(table: ProjectPurchase::class, ignoreRecord: true)
                            ->rules([
                                fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                    if (session()->get('company_id') == 1) {
                                        if (! str($value)->startsWith('NP-')) {
                                            $fail('El :attribute debe comenzar con NP-');
                                        }
                                    }
                                    if (session()->get('company_id') == 2) {
                                        if (! str($value)->startsWith('DN-')) {
                                            $fail('El :attribute debe comenzar con DN-');
                                        }
                                    }
                                },
                            ])
                            ->validationMessages([
                                'unique' => 'El :attribute ya esta registrado.',
                            ])
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre completo del proyecto')
                            ->unique(table: ProjectPurchase::class, ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'El :attribute ya esta registrado.',
                            ])
                            ->required()
                            ->maxLength(255),

                        Forms\Components\ToggleButtons::make('status')
                            ->label('Estado')
                            ->options([
                                'activo' => 'Activo',
                                'inactivo' => 'Inactivo',
                            ])
                            ->colors([
                                'activo' => 'success',
                                'inactivo' => 'danger',
                            ])
                            ->icons([
                                'activo' => 'heroicon-o-check-circle',
                                'inactivo' => 'heroicon-o-x-circle',
                            ])
                            ->visible(fn (?Model $record) => $record && in_array($record->status, ['activo', 'inactivo']))
                            ->live()
                            ->afterStateUpdated(function ($state, $old, ?Model $record) {
                                if ($record && $state !== $old && $record->status()->canBe($state)) {
                                    $record->status()->transitionTo($state);
                                }
                            })
                            ->dehydrated(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Código'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estatus'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d-m-Y')->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Actions\EditAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkAction::make('aceptar')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        try {
                            $records->each(function ($item) {
                                $item->status()->transitionTo('activo');
                            });
                            Notification::make()
                                ->title('Respuesta enviada')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            logger()->error($e->getMessages());
                            Notification::make()
                                ->title('Ocurrió un error.')
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->checkIfRecordIsSelectableUsing(
                fn (Model $record): bool => $record->status == 'pendiente',
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectPurchases::route('/'),
            'create' => Pages\CreateProjectPurchase::route('/create'),
            'view' => Pages\ViewProjectPurchase::route('/{record}'),
            'edit' => Pages\EditProjectPurchase::route('/{record}/edit'),
        ];
    }
}
