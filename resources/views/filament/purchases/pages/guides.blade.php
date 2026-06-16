<x-filament-panels::page>

    {{-- ── Estilos y scripts de Video.js ─────────────────────────────────── --}}
    @pushOnce('scripts')
        @vite('resources/js/video-player.js')
    @endPushOnce

    <div class="space-y-8">

        {{-- ── Encabezado ──────────────────────────────────────────────────── --}}
        <div
            class="relative p-8 overflow-hidden shadow-lg rounded-2xl bg-gradient-to-br from-gray-700 via-gray-800 to-gray-900">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-white/10">
                        <x-heroicon-o-book-open class="w-6 h-6 text-white" />
                    </div>
                    <span
                        class="rounded-full bg-amber-400/20 px-3 py-0.5 text-xs font-semibold text-amber-300 ring-1 ring-amber-400/30">
                        Centro de ayuda
                    </span>
                </div>
                <h1 class="mt-1 text-3xl font-bold text-white">Guías de uso</h1>
                <p class="mt-2 text-gray-400">
                    Aprende a usar la plataforma con estos videos paso a paso. Disponibles en cualquier momento.
                </p>
            </div>
            <div class="absolute w-48 h-48 rounded-full -right-10 -top-10 bg-white/5"></div>
            <div class="absolute w-32 h-32 rounded-full -bottom-8 right-24 bg-white/5"></div>
        </div>

        {{-- ── Grid de guías ────────────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            @foreach ($this->getGuides() as $guide)
                @php
                    $colorMap = [
                        'amber' => [
                            'bg' => 'bg-amber-50 dark:bg-amber-900/30',
                            'icon' => 'text-amber-500',
                            'ring' => 'ring-amber-200 dark:ring-amber-700',
                        ],
                        'blue' => [
                            'bg' => 'bg-blue-50 dark:bg-blue-900/30',
                            'icon' => 'text-blue-500',
                            'ring' => 'ring-blue-200 dark:ring-blue-700',
                        ],
                        'green' => [
                            'bg' => 'bg-green-50 dark:bg-green-900/30',
                            'icon' => 'text-green-500',
                            'ring' => 'ring-green-200 dark:ring-green-700',
                        ],
                        'orange' => [
                            'bg' => 'bg-orange-50 dark:bg-orange-900/30',
                            'icon' => 'text-orange-500',
                            'ring' => 'ring-orange-200 dark:ring-orange-700',
                        ],
                        'rose' => [
                            'bg' => 'bg-rose-50 dark:bg-rose-900/30',
                            'icon' => 'text-rose-500',
                            'ring' => 'ring-rose-200 dark:ring-rose-700',
                        ],
                        'indigo' => [
                            'bg' => 'bg-indigo-50 dark:bg-indigo-900/30',
                            'icon' => 'text-indigo-500',
                            'ring' => 'ring-indigo-200 dark:ring-indigo-700',
                        ],
                    ];
                    $c = $colorMap[$guide['color']] ?? $colorMap['amber'];
                    $hasVideo = !empty($guide['video']);
                    $hasPdf   = !empty($guide['pdf']);
                @endphp

                <div
                    class="flex flex-col overflow-hidden bg-white border border-gray-200 shadow-sm rounded-2xl dark:border-gray-700 dark:bg-gray-800">

                    {{-- Cabecera del card --}}
                    <div class="flex items-center gap-4 p-6 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl {{ $c['bg'] }} shrink-0">
                            <x-dynamic-component :component="$guide['icon']" class="w-6 h-6 {{ $c['icon'] }}" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="font-semibold text-gray-800 truncate dark:text-gray-100">
                                    {{ $guide['title'] }}
                                </h3>
                                @if ($hasVideo)
                                    <span
                                        class="shrink-0 rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700 dark:bg-green-900 dark:text-green-300">
                                        Video disponible
                                    </span>
                                @endif
                                @if ($hasPdf)
                                    <span
                                        class="shrink-0 rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700 dark:bg-red-900 dark:text-red-300">
                                        Guía PDF
                                    </span>
                                @endif
                                @if (!$hasVideo && !$hasPdf)
                                    <span
                                        class="shrink-0 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-700 dark:bg-amber-900 dark:text-amber-300">
                                        Próximamente
                                    </span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ $guide['description'] }}
                            </p>
                        </div>
                    </div>

                    {{-- Área de contenido --}}
                    <div class="p-6 space-y-4">

                        {{-- Video --}}
                        @if ($hasVideo)
                            <video id="guide-{{ $guide['slug'] }}"
                                class="video-js vjs-big-play-centered w-full rounded-xl overflow-hidden" controls
                                preload="metadata" data-setup="{}">
                                <source src="{{ Storage::url('guides/' . $guide['video']) }}" type="video/mp4">
                                <p class="vjs-no-js text-sm text-gray-500">
                                    Tu navegador no soporta HTML5 video.
                                    <a href="https://videojs.com/html5-video-support/" target="_blank"
                                        class="underline">Más info</a>.
                                </p>
                            </video>
                        @elseif (!$hasPdf)
                            <div
                                class="flex flex-col items-center justify-center gap-3 rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 py-12 dark:border-gray-600 dark:bg-gray-700/30">
                                <div
                                    class="flex items-center justify-center w-14 h-14 rounded-full bg-gray-100 dark:bg-gray-700">
                                    <x-heroicon-o-video-camera class="w-7 h-7 text-gray-400 dark:text-gray-500" />
                                </div>
                                <div class="text-center">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Video en preparación</p>
                                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                        Este video estará disponible próximamente
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- Botón de descarga PDF --}}
                        @if ($hasPdf)
                            <a href="{{ Storage::url('guides/' . $guide['pdf']) }}"
                               target="_blank"
                               class="flex items-center justify-center gap-2 w-full rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700 hover:bg-red-100 transition dark:border-red-800 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/40">
                                <x-heroicon-o-document-arrow-down class="w-5 h-5 shrink-0" />
                                Descargar guía en PDF
                            </a>
                        @endif

                    </div>

                </div>
            @endforeach

        </div>

    </div>

</x-filament-panels::page>
