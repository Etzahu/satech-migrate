<?php

namespace App\Filament\Purchases\Resources\ProviderEvaluationResource\Pages;

use App\Enums\ProviderEvaluationQuestion;
use App\Filament\Purchases\Resources\ProviderEvaluationResource;
use App\Models\ProviderEvaluation;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Rap2hpoutre\FastExcel\FastExcel;

class ListProviderEvaluations extends ListRecords
{
    protected static string $resource = ProviderEvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportar_excel')
                ->label('Exportar Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->visible(fn () => auth()->user()->hasAnyRole(['gerente_compras', 'comprador', 'super_admin']))
                ->action(function () {
                    $evaluations = ProviderEvaluation::with([
                        'order.provider',
                        'order.requisition',
                        'responses.respondent',
                    ])
                        ->whereHas('order', fn (Builder $q) => $q->where('company_id', session('company_id')))
                        ->get();

                    // Recopilar todas las preguntas únicas que aparecen en el conjunto
                    $allQuestions = collect(); // question_key => label
                    foreach ($evaluations as $evaluation) {
                        foreach ($evaluation->responses as $response) {
                            if (! $allQuestions->has($response->question)) {
                                $label = ProviderEvaluationQuestion::tryFrom($response->question)?->label()
                                    ?? $response->question;
                                $allQuestions->put($response->question, $label);
                            }
                        }
                    }

                    $rows = collect();

                    foreach ($evaluations as $evaluation) {
                        $row = [
                            'Folio OC' => $evaluation->order?->folio ?? '',
                            'Proveedor' => $evaluation->order?->provider?->company_name ?? '',
                            'Tipo' => $evaluation->type ?? '',
                            'Estado' => match ($evaluation->status) {
                                'pending' => 'Pendiente',
                                'completed' => 'Completada',
                                default => $evaluation->status,
                            },
                        ];

                        // Una columna por pregunta con la opción seleccionada
                        foreach ($allQuestions as $questionKey => $questionLabel) {
                            $response = $evaluation->responses->firstWhere('question', $questionKey);
                            $row[$questionLabel] = $response?->selected_option ?? '';
                        }

                        $row['Puntuación total'] = $evaluation->totalScore();

                        $rows->push($row);
                    }

                    $fileName = 'evaluaciones-proveedor-'.now()->format('Y-m-d').'.xlsx';

                    return (new FastExcel($rows))->download($fileName);
                }),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'pending' => Tab::make('Mis pendientes')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('responses', function (Builder $q) {
                    $q->forRespondent(auth()->user())
                        ->whereNull('answered_at');
                }))
                ->badge(
                    ProviderEvaluation::query()
                        ->whereHas('responses', fn (Builder $q) => $q
                            ->forRespondent(auth()->user())
                            ->whereNull('answered_at'))
                        ->count() ?: null
                )
                ->badgeColor('warning'),
        ];

        if (auth()->user()->hasAnyRole(['administrador_compras', 'gerente_compras', 'super_admin'])) {
            $tabs['all'] = Tab::make('Todas las evaluaciones');
        }

        return $tabs;
    }
}
