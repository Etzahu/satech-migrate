<?php

namespace App\Filament\Purchases\Resources;

use App\Enums\ProviderEvaluationQuestion;
use App\Filament\Purchases\Resources\ProviderEvaluationResource\Pages;
use App\Models\ProviderEvaluation;
use App\Models\ProviderEvaluationResponse;
use App\Services\ProviderEvaluationService;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Infolists;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProviderEvaluationResource extends Resource
{
    protected static ?string $model = ProviderEvaluation::class;

    protected static ?string $modelLabel = 'Evaluación de proveedor';

    protected static ?string $pluralModelLabel = 'Evaluaciones de proveedor';

    protected static ?string $navigationLabel = 'Evaluaciones';

    protected static ?string $slug = 'evaluaciones-proveedor';

    protected static string|\UnitEnum|null $navigationGroup = 'Orden';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-minus';

    protected static ?int $navigationSort = 20;

    public static function canAccess(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('order', fn (Builder $query) => $query->where('company_id', session('company_id')));
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::whereHas('order', fn (Builder $query) => $query->where('company_id', session('company_id')))
            ->whereHas('responses', function (Builder $query) {
                $query->where('respondent_id', auth()->id())
                    ->whereNull('answered_at');
            })->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $form): Schema
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.folio')
                    ->label('Folio OC')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order.provider.company_name')
                    ->label('Proveedor'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'pending' => 'Pendiente',
                        'completed' => 'Completada',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state) => match ($state) {
                        'pending' => 'warning',
                        'completed' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('pending_count')
                    ->label('Secciones pendientes')
                    ->state(
                        fn (ProviderEvaluation $record) => $record->responses
                            ->where('respondent_id', auth()->id())
                            ->whereNull('answered_at')
                            ->count()
                    )
                    ->badge()
                    ->color('warning')
                    ->visible(fn () => ! auth()->user()->hasAnyRole(['administrador_compras', 'gerente_compras', 'super_admin'])),
            ])
            ->recordActions([
                Action::make('ver_respuestas')
                    ->label('Ver respuestas')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->slideOver()
                    ->modalWidth(Width::ScreenLarge)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Cerrar')
                    ->visible(fn () => auth()->user()->hasAnyRole(['administrador_compras', 'gerente_compras', 'super_admin']))
                    ->schema(function (ProviderEvaluation $record): array {
                        return [
                            Schemas\Components\Section::make('Detalle de la evaluación')
                                ->description('OC: '.$record->order?->folio.' — '.$record->order?->provider?->company_name)
                                ->schema([
                                    Infolists\Components\RepeatableEntry::make('responses')
                                        ->label('')
                                        ->contained(false)
                                        ->schema([
                                            Schemas\Components\Fieldset::make('')
                                                ->schema([
                                                    Infolists\Components\TextEntry::make('question')
                                                        ->label('Pregunta')
                                                        ->columnSpanFull()
                                                        ->formatStateUsing(fn (string $state) => ProviderEvaluationQuestion::from($state)->label()),
                                                    Infolists\Components\TextEntry::make('respondent.name')
                                                        ->label('Evaluador')
                                                        ->placeholder('Sin asignar'),
                                                    Infolists\Components\TextEntry::make('respondent_role')
                                                        ->label('Rol'),
                                                    Infolists\Components\TextEntry::make('selected_option')
                                                        ->label('Respuesta')
                                                        ->badge()
                                                        ->color(fn (?string $state) => $state ? 'primary' : 'gray')
                                                        ->formatStateUsing(fn (?string $state, ProviderEvaluationResponse $record): string => $state
                                                            ? ($record->questionEnum()->formOptions()[$state] ?? $state)
                                                            : 'Sin responder'),
                                                    Infolists\Components\TextEntry::make('score')
                                                        ->label('Puntuación')
                                                        ->badge()
                                                        ->color(fn (?int $state) => match (true) {
                                                            $state >= 9 => 'success',
                                                            $state >= 6 => 'warning',
                                                            default => 'danger',
                                                        }),
                                                    Infolists\Components\TextEntry::make('answered_at')
                                                        ->label('Respondido')
                                                        ->dateTime('d/m/Y H:i')
                                                        ->placeholder('Pendiente'),
                                                ])
                                                ->columns(2),
                                        ]),
                                    Infolists\Components\TextEntry::make('total_score')
                                        ->label('Puntuación total')
                                        ->state(fn (ProviderEvaluation $record): int => $record->totalScore())
                                        ->badge()
                                        ->color('info'),
                                ]),
                        ];
                    }),
                Action::make('evaluar')
                    ->label('Evaluar')
                    ->icon('heroicon-o-pencil-square')
                    ->slideOver()
                    ->modalWidth(Width::ScreenLarge)
                    ->color('primary')
                    ->schema(function (ProviderEvaluation $record) {
                        $pendingResponses = $record->responses
                            ->where('respondent_id', auth()->id())
                            ->whereNull('answered_at');

                        return $pendingResponses->map(function (ProviderEvaluationResponse $response) {
                            $question = $response->questionEnum();

                            return Radio::make('question_'.$response->id)
                                ->label($question->label())
                                ->options($question->formOptions())
                                ->required();
                        })->values()->all();
                    })
                    ->action(function (array $data, ProviderEvaluation $record) {
                        $pendingResponses = $record->responses
                            ->where('respondent_id', auth()->id())
                            ->whereNull('answered_at');

                        foreach ($pendingResponses as $response) {
                            $key = 'question_'.$response->id;
                            if (isset($data[$key])) {
                                ProviderEvaluationService::answer($response, $data[$key]);
                            }
                        }

                        Notification::make()
                            ->title('Evaluación guardada')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProviderEvaluations::route('/'),
        ];
    }
}
