@php
    use Illuminate\Support\Str;

    $history = $getRecord()->status()->history()->orderBy('id', 'desc')->get();

    // Resuelve icono, colores del nodo, del badge, del borde de la tarjeta y del
    // panel de observación según el estado destino. Se basa en palabras clave para
    // ser robusto ante nuevos estados.
    //
    // IMPORTANTE: las clases se devuelven como strings COMPLETOS (no interpolados)
    // para que Tailwind las detecte al compilar.
    $resolveStatus = function (?string $status): array {
        $status = Str::lower($status ?? '');

        return match (true) {
            Str::contains($status, ['rechaz', 'cancel', 'anul', 'declin', 'devuel']) => [
                'icon'  => 'heroicon-m-x-mark',
                'node'  => 'bg-red-500',
                'badge' => 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/30',
                'edge'  => 'border-l-red-500',
                'obs'   => [
                    'wrap'  => 'border-red-200 bg-red-50 dark:border-red-500/30 dark:bg-red-500/10',
                    'icon'  => 'bg-red-500',
                    'label' => 'text-red-700 dark:text-red-300',
                    'text'  => 'text-red-900 dark:text-red-100',
                ],
            ],
            Str::contains($status, ['aprob', 'autoriz', 'activ', 'complet', 'finaliz', 'acept', 'recib']) => [
                'icon'  => 'heroicon-m-check',
                'node'  => 'bg-green-500',
                'badge' => 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-400/10 dark:text-green-400 dark:ring-green-400/30',
                'edge'  => 'border-l-green-500',
                'obs'   => [
                    'wrap'  => 'border-green-200 bg-green-50 dark:border-green-500/30 dark:bg-green-500/10',
                    'icon'  => 'bg-green-500',
                    'label' => 'text-green-700 dark:text-green-300',
                    'text'  => 'text-green-900 dark:text-green-100',
                ],
            ],
            Str::contains($status, ['pendiente', 'revis', 'espera', 'borrador', 'proceso', 'tramit', 'reabier']) => [
                'icon'  => 'heroicon-m-clock',
                'node'  => 'bg-amber-500',
                'badge' => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-400 dark:ring-amber-400/30',
                'edge'  => 'border-l-amber-500',
                'obs'   => [
                    'wrap'  => 'border-amber-200 bg-amber-50 dark:border-amber-500/30 dark:bg-amber-500/10',
                    'icon'  => 'bg-amber-500',
                    'label' => 'text-amber-700 dark:text-amber-300',
                    'text'  => 'text-amber-900 dark:text-amber-100',
                ],
            ],
            default => [
                'icon'  => 'heroicon-m-arrow-path',
                'node'  => 'bg-primary-500',
                'badge' => 'bg-primary-50 text-primary-700 ring-primary-600/20 dark:bg-primary-400/10 dark:text-primary-400 dark:ring-primary-400/30',
                'edge'  => 'border-l-primary-500',
                'obs'   => [
                    'wrap'  => 'border-primary-200 bg-primary-50 dark:border-primary-500/30 dark:bg-primary-500/10',
                    'icon'  => 'bg-primary-500',
                    'label' => 'text-primary-700 dark:text-primary-300',
                    'text'  => 'text-primary-900 dark:text-primary-100',
                ],
            ],
        };
    };
@endphp

<div class="flow-root w-full">
    <ul role="list" class="-mb-6">
        @forelse ($history as $item)
            @php
                // La observación se captura bajo la clave "respuesta"; dejamos fallback por robustez.
                $comment     = $item->getCustomProperty('respuesta')
                    ?? $item->getCustomProperty('observaciones')
                    ?? $item->getCustomProperty('observacion');
                $hasComment  = filled($comment);
                $meta        = $resolveStatus($item->to);
                $responsible = $item->responsible?->name ?? 'Sistema';
                $initial     = Str::of($responsible)->trim()->substr(0, 1)->upper();
            @endphp

            <li>
                <div class="relative pb-6">
                    {{-- Línea conectora del timeline --}}
                    @unless ($loop->last)
                        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-white/10" aria-hidden="true"></span>
                    @endunless

                    <div class="relative flex items-start gap-x-3">
                        {{-- Nodo con icono del estado --}}
                        <span @class([
                            'relative z-10 flex h-8 w-8 flex-none items-center justify-center rounded-full text-white shadow-sm ring-4 ring-white dark:ring-gray-900',
                            $meta['node'],
                        ])>
                            <x-dynamic-component :component="$meta['icon']" class="h-4 w-4" />

                            {{-- Indicador: este evento trae observación --}}
                            @if ($hasComment)
                                <span class="absolute -right-0.5 -top-0.5 h-3 w-3 rounded-full bg-amber-400 ring-2 ring-white dark:ring-gray-900"></span>
                            @endif
                        </span>

                        {{-- Tarjeta del evento --}}
                        <div @class([
                            'min-w-0 flex-1 rounded-xl border-l-4 bg-white p-3 shadow-sm ring-1 ring-gray-200 dark:bg-gray-900 dark:ring-white/10',
                            $meta['edge'],
                            'ring-amber-300 dark:ring-amber-500/40' => $hasComment,
                        ])>
                            {{-- Cabecera: transición de estado + fecha --}}
                            <div class="flex flex-wrap items-center justify-between gap-x-2 gap-y-1">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    @if (filled($item->from))
                                        <span class="text-xs font-medium text-gray-400 line-through dark:text-gray-500">
                                            {{ Str::headline($item->from) }}
                                        </span>
                                        <x-heroicon-m-arrow-long-right class="h-4 w-4 shrink-0 text-gray-300 dark:text-gray-600" />
                                    @endif

                                    <span @class([
                                        'inline-flex items-center rounded-md px-2 py-0.5 text-xs font-semibold ring-1 ring-inset',
                                        $meta['badge'],
                                    ])>
                                        {{ Str::headline($item->to) }}
                                    </span>

                                    {{-- Chip de aviso cuando hay observación --}}
                                    @if ($hasComment)
                                        <span class="inline-flex items-center gap-1 rounded-md bg-amber-100 px-1.5 py-0.5 text-[10px] font-bold uppercase tracking-wide text-amber-700 ring-1 ring-inset ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-300 dark:ring-amber-400/30">
                                            <x-heroicon-m-exclamation-circle class="h-3 w-3" />
                                            Observación
                                        </span>
                                    @endif
                                </div>

                                <time
                                    class="shrink-0 text-[11px] font-medium text-gray-400 dark:text-gray-500"
                                    title="{{ $item->created_at->format('d/m/Y H:i') }}"
                                >
                                    {{ $item->created_at->diffForHumans() }}
                                </time>
                            </div>

                            {{-- Responsable --}}
                            <div class="mt-2 flex items-center gap-x-1.5">
                                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-gray-100 text-[10px] font-bold uppercase text-gray-500 dark:bg-gray-700 dark:text-gray-300">
                                    {{ $initial }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $responsible }}</span>
                            </div>

                            {{-- Observación resaltada (panel con color del estado) --}}
                            @if ($hasComment)
                                <div @class([
                                    'mt-3 rounded-lg border p-3',
                                    $meta['obs']['wrap'],
                                ])>
                                    <div class="mb-1.5 flex items-center gap-1.5">
                                        <span @class([
                                            'flex h-5 w-5 flex-none items-center justify-center rounded-full text-white',
                                            $meta['obs']['icon'],
                                        ])>
                                            <x-heroicon-m-chat-bubble-left-ellipsis class="h-3 w-3" />
                                        </span>
                                        <span @class([
                                            'text-[11px] font-bold uppercase tracking-wide',
                                            $meta['obs']['label'],
                                        ])>
                                            Observación
                                        </span>
                                    </div>
                                    <p @class([
                                        'whitespace-pre-line text-sm leading-relaxed',
                                        $meta['obs']['text'],
                                    ])>{{ $comment }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li>
                <div class="flex flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-gray-200 py-10 dark:border-gray-700">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-50 dark:bg-gray-800">
                        <x-heroicon-o-clock class="h-5 w-5 text-gray-300 dark:text-gray-600" />
                    </span>
                    <p class="text-xs font-medium text-gray-400 dark:text-gray-500">Sin historial disponible</p>
                </div>
            </li>
        @endforelse
    </ul>
</div>
