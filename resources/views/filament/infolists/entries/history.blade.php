@php
    use Illuminate\Support\Str;

    $history = $getRecord()->status()->history()->orderBy('id', 'desc')->get();

    // Resuelve icono, color del nodo y estilos del badge según el estado destino.
    // Se basa en palabras clave para ser robusto ante nuevos estados.
    $resolveStatus = function (?string $status): array {
        $status = Str::lower($status ?? '');

        return match (true) {
            Str::contains($status, ['rechaz', 'cancel', 'anul', 'declin', 'devuel']) => [
                'icon'   => 'heroicon-m-x-mark',
                'node'   => 'bg-red-500',
                'badge'  => 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/30',
                'accent' => 'border-red-300 dark:border-red-500/40',
            ],
            Str::contains($status, ['aprob', 'autoriz', 'activ', 'complet', 'finaliz', 'acept', 'recib']) => [
                'icon'   => 'heroicon-m-check',
                'node'   => 'bg-green-500',
                'badge'  => 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-400/10 dark:text-green-400 dark:ring-green-400/30',
                'accent' => 'border-green-300 dark:border-green-500/40',
            ],
            Str::contains($status, ['pendiente', 'revis', 'espera', 'borrador', 'proceso', 'tramit']) => [
                'icon'   => 'heroicon-m-clock',
                'node'   => 'bg-amber-500',
                'badge'  => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-400 dark:ring-amber-400/30',
                'accent' => 'border-amber-300 dark:border-amber-500/40',
            ],
            default => [
                'icon'   => 'heroicon-m-arrow-path',
                'node'   => 'bg-primary-500',
                'badge'  => 'bg-primary-50 text-primary-700 ring-primary-600/20 dark:bg-primary-400/10 dark:text-primary-400 dark:ring-primary-400/30',
                'accent' => 'border-primary-300 dark:border-primary-500/40',
            ],
        };
    };
@endphp

<div class="w-full lowercase">
    @forelse ($history as $item)
        @php
            $comment     = $item->getCustomProperty('respuesta');
            $hasComment  = filled($comment);
            $meta        = $resolveStatus($item->to);
            $responsible = $item->responsible?->name ?? 'Sistema';
            $initial     = Str::of($responsible)->trim()->substr(0, 1)->upper();
        @endphp

        <div class="relative flex pb-6 gap-x-3 last:pb-0">
            {{-- Línea conectora del timeline --}}
            @unless ($loop->last)
                <div class="absolute top-0 left-0 flex justify-center -bottom-6 w-7" aria-hidden="true">
                    <span class="w-px bg-gray-200 dark:bg-gray-700"></span>
                </div>
            @endunless

            {{-- Nodo con icono del estado --}}
            <span @class([
                'relative z-10 mt-0.5 flex h-7 w-7 flex-none items-center justify-center rounded-full text-white shadow-sm ring-4 ring-white dark:ring-gray-900',
                $meta['node'],
            ])>
                <x-dynamic-component :component="$meta['icon']" class="w-4 h-4" />
            </span>

            {{-- Contenido del evento --}}
            <div class="flex-1 min-w-0">
                {{-- Cabecera: transición de estado + fecha --}}
                <div class="flex flex-wrap items-center justify-between gap-x-2 gap-y-1">
                    <div class="flex items-center gap-x-1.5">
                        @if (filled($item->from))
                            <span class="text-xs font-medium text-gray-400 line-through dark:text-gray-500">
                                {{ Str::headline($item->from) }}
                            </span>
                            <x-heroicon-m-arrow-long-right class="w-4 h-4 text-gray-300 shrink-0 dark:text-gray-600" />
                        @endif

                        <span @class([
                            'inline-flex items-center rounded-md px-2 py-0.5 text-xs font-semibold ring-1 ring-inset',
                            $meta['badge'],
                        ])>
                            {{ Str::headline($item->to) }}
                        </span>
                    </div>

                    <time
                        class="shrink-0 text-[11px] font-medium text-gray-400 dark:text-gray-500"
                        title="{{ $item->created_at->format('d/m/Y H:i') }}"
                    >
                        {{ $item->created_at->diffForHumans() }}
                    </time>
                </div>

                {{-- Responsable --}}
                <div class="mt-1.5 flex items-center gap-x-1.5">
                    <span class="flex h-4 w-4 items-center justify-center rounded-full bg-gray-100 text-[9px] font-bold uppercase text-gray-500 dark:bg-gray-700 dark:text-gray-300">
                        {{ $initial }}
                    </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $responsible }}</span>
                </div>

                {{-- Comentario / respuesta (resaltado con el color del estado) --}}
                @if ($hasComment)
                    <div @class([
                        'mt-2 rounded-r-md border-l-2 bg-gray-50 py-2 pl-3 pr-3 dark:bg-gray-800/40',
                        $meta['accent'],
                    ])>
                        <div class="flex items-start gap-x-2">
                            <x-heroicon-m-chat-bubble-left-ellipsis class="mt-px h-3.5 w-3.5 shrink-0 text-gray-400 dark:text-gray-500" />
                            <p class="text-xs leading-relaxed text-gray-600 dark:text-gray-300">{{ $comment }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="flex flex-col items-center justify-center gap-2 py-10 border border-gray-200 border-dashed rounded-xl dark:border-gray-700">
            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-50 dark:bg-gray-800">
                <x-heroicon-o-clock class="w-5 h-5 text-gray-300 dark:text-gray-600" />
            </span>
            <p class="text-xs font-medium text-gray-400 dark:text-gray-500">Sin historial disponible</p>
        </div>
    @endforelse
</div>
