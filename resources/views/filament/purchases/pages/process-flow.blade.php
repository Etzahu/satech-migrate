<x-filament-panels::page>

    @pushOnce('scripts')
        @vite('resources/js/flow-diagram.js')
    @endPushOnce

    <div x-data="{ tab: 'requisition' }" class="space-y-6">

        {{-- ── Encabezado ──────────────────────────────────────────────────── --}}
        <div class="relative p-8 overflow-hidden shadow-lg rounded-2xl bg-gradient-to-br from-gray-700 via-gray-800 to-gray-900">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-white/10">
                        <x-heroicon-o-map class="w-6 h-6 text-white" />
                    </div>
                    <span class="rounded-full bg-amber-400/20 px-3 py-0.5 text-xs font-semibold text-amber-300 ring-1 ring-amber-400/30">
                        Mapa del proceso
                    </span>
                </div>
                <h1 class="mt-1 text-3xl font-bold text-white">Flujo del proceso</h1>
                <p class="mt-2 text-gray-400">
                    Diagrama interactivo del ciclo de vida de las requisiciones y órdenes de compra:
                    quién participa en cada paso, qué notificaciones se envían y qué caminos puede tomar el proceso.
                </p>
                <p class="mt-3 text-sm text-gray-300">
                    🖱️ Arrastra para moverte · usa la rueda del mouse para hacer zoom · haz clic en un estado para ver su detalle
                </p>
            </div>
            <div class="absolute w-48 h-48 rounded-full -right-10 -top-10 bg-white/5"></div>
            <div class="absolute w-32 h-32 rounded-full -bottom-8 right-24 bg-white/5"></div>
        </div>

        {{-- ── Pestañas ─────────────────────────────────────────────────────── --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="inline-flex p-1 bg-gray-100 rounded-xl dark:bg-gray-800">
                <button type="button" @click="tab = 'requisition'"
                    :class="tab === 'requisition'
                        ? 'bg-white text-gray-900 shadow dark:bg-gray-700 dark:text-white'
                        : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                    class="px-4 py-2 text-sm font-semibold transition rounded-lg">
                    📋 Requisición de compra
                </button>
                <button type="button" @click="tab = 'order'"
                    :class="tab === 'order'
                        ? 'bg-white text-gray-900 shadow dark:bg-gray-700 dark:text-white'
                        : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                    class="px-4 py-2 text-sm font-semibold transition rounded-lg">
                    🛒 Orden de compra
                </button>
            </div>

            {{-- Leyenda --}}
            <div class="flex flex-wrap items-center gap-2">
                @foreach ([
                    'start' => 'Inicio',
                    'review' => 'Revisión',
                    'approval' => 'Aprobación',
                    'purchase' => 'Compra',
                    'final' => 'Final',
                    'return' => 'Devolución',
                    'cancel' => 'Cancelación',
                    'special' => 'Caso especial',
                ] as $type => $label)
                    <span class="fd-legend__chip">
                        <span class="fd-dot fd-dot--{{ $type }}"></span>{{ $label }}
                    </span>
                @endforeach
            </div>
        </div>

        {{-- ── Diagramas ────────────────────────────────────────────────────── --}}
        @foreach ([
            ['key' => 'requisition', 'flow' => $this->getRequisitionFlow(), 'notes' => [
                'Las requisiciones de servicio omiten la revisión por almacén y pasan directo a revisión.',
                'La «cadena reasignada» y el «comprador reasignado» pueden ocurrir desde cualquier estado del flujo.',
                'El porcentaje de cada tarjeta indica el avance de la requisición en el proceso.',
            ]],
            ['key' => 'order', 'flow' => $this->getOrderFlow(), 'notes' => [
                'La segunda autorización (DG nivel 2) solo aplica cuando el total supera $300,000 MXN o $15,000 USD; algunos proveedores están exentos.',
                'Los proveedores de la lista especial siguen el flujo directo de revisión con Dirección General.',
                'La «cadena reasignada», la «requisición reasignada» y el «devuelto por administrador» pueden ocurrir desde cualquier estado.',
            ]],
        ] as $diagram)
            <section x-show="tab === '{{ $diagram['key'] }}'" x-cloak class="space-y-4"
                data-flow-root="flow-data-{{ $diagram['flow']['id'] }}">

                <div class="fd-stage relative overflow-hidden bg-white border border-gray-200 shadow-sm rounded-2xl dark:bg-gray-900 dark:border-gray-700">
                    <div class="fd-canvas w-full"></div>

                    {{-- Controles de zoom --}}
                    <div class="absolute flex flex-col gap-1.5 top-3 right-3">
                        <button type="button" data-fd-zoom="in" class="fd-btn" title="Acercar">+</button>
                        <button type="button" data-fd-zoom="out" class="fd-btn" title="Alejar">−</button>
                        <button type="button" data-fd-zoom="reset" class="fd-btn" title="Restablecer vista">⤢</button>
                    </div>

                    {{-- Tooltip --}}
                    <div class="fd-tooltip"></div>
                </div>

                {{-- Panel de detalle --}}
                <div class="p-5 bg-white border border-gray-200 shadow-sm rounded-2xl dark:bg-gray-900 dark:border-gray-700">
                    <div data-flow-detail
                        data-placeholder="<p class='fd-detail__placeholder'>👆 Haz clic en cualquier estado del diagrama para ver quién actúa, qué notificaciones se envían y a qué estados puede avanzar.</p>">
                        <p class="fd-detail__placeholder">
                            👆 Haz clic en cualquier estado del diagrama para ver quién actúa, qué notificaciones se
                            envían y a qué estados puede avanzar.
                        </p>
                    </div>
                </div>

                {{-- Notas del flujo --}}
                <div class="flex flex-col gap-2">
                    @foreach ($diagram['notes'] as $note)
                        <div class="flex items-start gap-2 px-4 py-2.5 text-sm text-gray-600 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-800/60 dark:border-gray-700 dark:text-gray-300">
                            <x-heroicon-o-information-circle class="w-5 h-5 mt-0.5 shrink-0 text-amber-500" />
                            <span>{{ $note }}</span>
                        </div>
                    @endforeach
                </div>

                <script type="application/json" id="flow-data-{{ $diagram['flow']['id'] }}">@json($diagram['flow'])</script>
            </section>
        @endforeach

    </div>

    {{-- ── Estilos del diagrama ─────────────────────────────────────────────── --}}
    <style>[x-cloak] { display: none !important; }</style>
    @include('filament.purchases.pages.partials.flow-diagram-styles')

</x-filament-panels::page>
