@php
    use Illuminate\Support\Str;

    $record = $getRecord();

    // Se precargan las relaciones que consume el flujo de aprobación de cada
    // orden (progress) para no repetir consultas por orden.
    $orders = $record
        ->orders()
        ->with([
            'provider',
            'purchaser',
            'requisition.approvalChain.requester',
            'requisition.approvalChain.approver',
            'requisition.approvalChain.authorizer',
        ])
        ->withCount('items')
        ->orderBy('id')
        ->get();

    // Resuelve icono y colores del estado de la orden. Se basa en palabras
    // clave para no romperse cuando el flujo agregue estados nuevos.
    $resolveStatus = function (?string $status): array {
        $status = Str::lower($status ?? '');

        return match (true) {
            Str::contains($status, 'cancel') => [
                'icon' => 'heroicon-m-x-circle',
                'dot' => 'bg-red-500',
                'badge' => 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/30',
            ],
            Str::contains($status, ['devuel', 'reabierta', 'reasignada']) => [
                'icon' => 'heroicon-m-arrow-uturn-left',
                'dot' => 'bg-orange-500',
                'badge' => 'bg-orange-50 text-orange-700 ring-orange-600/20 dark:bg-orange-400/10 dark:text-orange-400 dark:ring-orange-400/30',
            ],
            Str::contains($status, 'autorizada') => [
                'icon' => 'heroicon-m-check-badge',
                'dot' => 'bg-green-500',
                'badge' => 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-400/10 dark:text-green-400 dark:ring-green-400/30',
            ],
            Str::contains($status, 'aprob') => [
                'icon' => 'heroicon-m-check-circle',
                'dot' => 'bg-blue-500',
                'badge' => 'bg-blue-50 text-blue-700 ring-blue-600/20 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30',
            ],
            Str::contains($status, 'revis') => [
                'icon' => 'heroicon-m-clock',
                'dot' => 'bg-amber-500',
                'badge' => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-400 dark:ring-amber-400/30',
            ],
            default => [
                'icon' => 'heroicon-m-pencil-square',
                'dot' => 'bg-gray-400',
                'badge' => 'bg-gray-50 text-gray-600 ring-gray-500/20 dark:bg-gray-400/10 dark:text-gray-400 dark:ring-gray-400/30',
            ],
        };
    };

    $total = $orders->count();
    $authorized = $orders
        ->filter(fn ($order) => Str::contains(Str::lower($order->status ?? ''), 'autorizada'))
        ->count();
    $percent = $total > 0 ? (int) round(($authorized / $total) * 100) : 0;

    // Mensaje del estado vacío según en qué punto del flujo está la requisición,
    // para que el usuario sepa qué falta y no solo que "no hay nada".
    $requisitionStatus = Str::lower($record->status ?? '');
    $emptyMessage = match (true) {
        $requisitionStatus === 'borrador' => 'Esta requisición sigue en borrador. Envíala a revisión para que avance en el flujo de aprobación.',
        Str::contains($requisitionStatus, 'cancel') => 'La requisición fue cancelada, por lo que no se generarán órdenes de compra.',
        Str::contains($requisitionStatus, 'devuel') => 'La requisición fue devuelta y debe corregirse antes de continuar. Las órdenes se generan al finalizar el flujo de aprobación.',
        blank($record->purchaser) => 'Todavía no se asigna un comprador. Las órdenes aparecerán aquí en cuanto el comprador las genere.',
        default => $record->purchaser->name.' aún no ha generado órdenes de compra para esta requisición.',
    };
@endphp

<div class="w-full">
    @if ($total === 0)
        {{-- Estado vacío: aviso visual de que la requisición no tiene órdenes --}}
        <div
            class="flex flex-col items-center justify-center gap-3 px-4 py-10 text-center border-2 border-gray-200 border-dashed rounded-xl dark:border-gray-700">
            <span class="relative flex items-center justify-center w-12 h-12 rounded-full bg-gray-50 dark:bg-gray-800">
                <x-heroicon-o-shopping-cart class="w-6 h-6 text-gray-300 dark:text-gray-600" />
                <span
                    class="absolute flex items-center justify-center w-5 h-5 rounded-full -bottom-0.5 -right-0.5 bg-amber-100 ring-2 ring-white dark:bg-amber-400/20 dark:ring-gray-800">
                    <x-heroicon-m-clock class="w-3 h-3 text-amber-600 dark:text-amber-400" />
                </span>
            </span>

            <div class="max-w-md space-y-1">
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">Sin órdenes de compra</p>
                <p class="text-xs leading-relaxed text-gray-500 dark:text-gray-400">{{ $emptyMessage }}</p>
            </div>
        </div>
    @else
        <div x-data="{ tab: 0 }">
            {{-- Resumen: cuántas órdenes ya quedaron autorizadas para el proveedor --}}
            <div class="mb-4">
                <div class="flex items-baseline justify-between gap-2">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $total }}</span>
                        {{ $total === 1 ? 'orden generada' : 'órdenes generadas' }}
                    </p>
                    <p class="text-[11px] font-medium text-gray-400 dark:text-gray-500">
                        {{ $authorized }} de {{ $total }} {{ $total === 1 ? 'autorizada' : 'autorizadas' }}
                    </p>
                </div>

                <div class="w-full h-1.5 mt-2 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-700">
                    <div class="h-full transition-all duration-500 rounded-full bg-green-500"
                        style="width: {{ $percent }}%"></div>
                </div>
            </div>

            {{-- Pestañas: una por orden (solo si hay más de una) --}}
            @if ($total > 1)
                <div class="flex flex-wrap gap-1 p-1 mb-4 rounded-lg bg-gray-100 dark:bg-white/5" role="tablist">
                    @foreach ($orders as $order)
                        @php $meta = $resolveStatus($order->status); @endphp

                        <button type="button" role="tab" x-on:click="tab = {{ $loop->index }}"
                            :aria-selected="tab === {{ $loop->index }}"
                            :class="tab === {{ $loop->index }} ?
                                'bg-white text-gray-900 shadow-sm ring-1 ring-gray-200 dark:bg-gray-700 dark:text-white dark:ring-gray-600' :
                                'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                            class="inline-flex items-center gap-1.5 rounded-md px-3 py-1.5 text-xs font-semibold transition">
                            <span class="h-1.5 w-1.5 shrink-0 rounded-full {{ $meta['dot'] }}"></span>
                            {{ $order->folio }}
                        </button>
                    @endforeach
                </div>
            @endif

            {{-- Panel de cada orden: datos + su flujo de aprobación completo --}}
            @foreach ($orders as $order)
                @php
                    $meta = $resolveStatus($order->status);

                    // Un flujo incompleto (proveedor o cadena sin datos) no debe
                    // tumbar toda la página de la requisición.
                    try {
                        $stepper = view('filament.infolists.entries.partials.progress-approval-stepper', [
                            'record' => $order,
                            'orientation' => 'vertical',
                        ])->render();
                    } catch (\Throwable $exception) {
                        report($exception);
                        $stepper = null;
                    }
                @endphp

                <div x-show="tab === {{ $loop->index }}" @if (! $loop->first) style="display: none" @endif
                    class="overflow-hidden bg-white border border-gray-200 rounded-xl dark:border-gray-700 dark:bg-gray-800/50">
                    <div class="flex flex-col gap-6 p-4 lg:flex-row">

                        {{-- Datos de la orden --}}
                        <div class="flex-1 min-w-0 space-y-4">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span class="text-base font-bold text-gray-900 dark:text-white">
                                    {{ $order->folio }}
                                </span>

                                <span
                                    class="inline-flex items-center gap-1 rounded-md px-2 py-0.5 text-[11px] font-semibold ring-1 ring-inset {{ $meta['badge'] }}">
                                    <x-dynamic-component :component="$meta['icon']" class="w-3 h-3 shrink-0" />
                                    {{ Str::ucfirst($order->status) }}
                                </span>
                            </div>

                            <dl class="grid grid-cols-1 text-xs sm:grid-cols-2 gap-x-4 gap-y-3">
                                <div class="min-w-0">
                                    <dt class="text-gray-400 dark:text-gray-500">Proveedor</dt>
                                    <dd class="font-medium text-gray-700 truncate dark:text-gray-200"
                                        title="{{ $order->provider?->company_name }}">
                                        {{ $order->provider?->company_name ?? 'Sin proveedor' }}
                                    </dd>
                                </div>

                                <div class="min-w-0">
                                    <dt class="text-gray-400 dark:text-gray-500">Comprador</dt>
                                    <dd class="font-medium text-gray-700 truncate dark:text-gray-200">
                                        {{ $order->purchaser?->name ?? 'Sin asignar' }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-gray-400 dark:text-gray-500">Partidas</dt>
                                    <dd class="font-medium text-gray-700 dark:text-gray-200">
                                        {{ $order->items_count }}
                                        {{ $order->items_count === 1 ? 'partida' : 'partidas' }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-gray-400 dark:text-gray-500">Creada</dt>
                                    <dd class="font-medium text-gray-700 dark:text-gray-200"
                                        title="{{ $order->created_at?->format('d/m/Y H:i') }}">
                                        {{ $order->created_at?->format('d/m/Y') }}
                                    </dd>
                                </div>

                                @if (filled($order->final_delivery_date))
                                    <div>
                                        <dt class="text-gray-400 dark:text-gray-500">Entrega estimada</dt>
                                        <dd class="font-medium text-gray-700 dark:text-gray-200">
                                            {{ \Illuminate\Support\Carbon::parse($order->final_delivery_date)->format('d/m/Y') }}
                                        </dd>
                                    </div>
                                @endif

                                @if (filled($order->quote_folio))
                                    <div class="min-w-0">
                                        <dt class="text-gray-400 dark:text-gray-500">Cotización</dt>
                                        <dd class="font-medium text-gray-700 truncate dark:text-gray-200">
                                            {{ $order->quote_folio }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>

                            <a href="{{ route('order.pdf.show', ['id' => $order->id]) }}" target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-gray-50 px-3 py-1.5 text-xs font-semibold text-gray-700 ring-1 ring-inset ring-gray-200 transition hover:bg-gray-100 dark:bg-white/5 dark:text-gray-200 dark:ring-gray-600 dark:hover:bg-white/10">
                                <x-heroicon-m-document-text class="w-4 h-4" />
                                Ver documento
                                <x-heroicon-m-arrow-top-right-on-square class="w-3 h-3 opacity-60" />
                            </a>
                        </div>

                        {{-- Flujo de aprobación de la orden --}}
                        <div
                            class="shrink-0 border-t border-gray-100 pt-4 dark:border-gray-700 lg:w-[400px] lg:border-l lg:border-t-0 lg:pl-6 lg:pt-0">
                            @if ($stepper)
                                {!! $stepper !!}
                            @else
                                <div
                                    class="flex items-start gap-2 p-3 text-xs rounded-lg bg-amber-50 text-amber-700 dark:bg-amber-400/10 dark:text-amber-400">
                                    <x-heroicon-m-exclamation-triangle class="w-4 h-4 mt-px shrink-0" />
                                    <span>No se pudo calcular el flujo de aprobación de esta orden.</span>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
