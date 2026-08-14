{{--
    Stepper de avance de aprobación (lo dibuja resources/js/progress-approval.js).

    Parámetros:
    - $record       PurchaseRequisition o PurchaseOrder del que se lee el flujo.
    - $orientation  'vertical' (por defecto) u 'horizontal'.
    - $heading      Título del encabezado.
--}}
@php
    $orientation = $orientation ?? 'vertical';
    $heading = $heading ?? 'Avance de aprobación';

    if ($record instanceof \App\Models\PurchaseOrder) {
        $progress = $record->provider?->approval_chain === 'especial' ? $record->progressSpecial : $record->progress;
    } else {
        $progress = $record->progress;
    }

    $steps = collect($progress)
        ->map(
            fn (array $step): array => [
                'title' => $step['title'],
                'name' => $step['name'],
                'date' => $step['date']?->toIso8601String(),
                'done' => filled($step['name']) && filled($step['date']),
            ],
        )
        ->values();

    $doneCount = $steps->where('done', true)->count();
    $total = $steps->count();
    $percent = $total > 0 ? (int) round(($doneCount / $total) * 100) : 0;
@endphp

<div data-progress-approval data-orientation="{{ $orientation }}" class="pa-root">

    {{-- Encabezado con resumen y porcentaje (el JS anima los contadores) --}}
    <div class="pa-head">
        <div>
            <p class="pa-head__title">{{ $heading }}</p>
            <p class="pa-head__sub">
                <span data-pa-done>{{ $doneCount }}</span> de {{ $total }} pasos completados
            </p>
        </div>
        <div class="pa-pct"><span data-pa-pct>{{ $percent }}</span><small>%</small></div>
    </div>

    {{-- Lienzo del stepper D3 --}}
    <div class="pa-stage">
        <div class="pa-canvas"></div>
        <div class="pa-tooltip"></div>
    </div>

    <script type="application/json">@json($steps)</script>
</div>
