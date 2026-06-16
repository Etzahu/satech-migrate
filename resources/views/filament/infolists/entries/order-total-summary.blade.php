@php
    use App\Services\OrderCalculationService;

    $order = $getRecord();
    $svc = new OrderCalculationService($order->id);

    $subtotal = $svc->getSubtotalItems(true);
    $discount = $svc->getDiscountProvider(true);
    $subtotalNet = $svc->subtotalDiscount(true);
    $iva = $svc->getTaxIva(true);
    $retIva = $svc->getRetentionIva(true);
    $retIsr = $svc->getRetentionIsr(true);
    $total = $svc->getTotal(true);

    $hasDiscount = $order->discount > 0;
    $hasRetIva = $order->retention_iva > 0;
    $hasRetIsr = $order->retention_isr > 0;
@endphp

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

    {{-- Header --}}
    <div
        class="flex items-center gap-2 border-b border-gray-100 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-700/50">
        <x-heroicon-o-calculator class="h-4 w-4 text-gray-500 dark:text-gray-400" />
        <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
            Desglose del total
        </span>
        <span
            class="ml-auto rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-600 dark:text-gray-300">
            {{ $order->currency }}
        </span>
    </div>

    {{-- Rows --}}
    <div class="divide-y divide-gray-100 dark:divide-gray-700">

        {{-- Subtotal --}}
        <div class="flex items-center justify-between px-4 py-3">
            <span class="text-sm text-gray-600 dark:text-gray-400">Subtotal partidas</span>
            <span class="text-sm font-medium tabular-nums text-gray-800 dark:text-gray-200">
                {{ $subtotal }}
            </span>
        </div>

        {{-- Descuento (solo si aplica) --}}
        @if ($hasDiscount)
            <div class="flex items-center justify-between bg-red-50 px-4 py-3 dark:bg-red-900/10">
                <span class="flex items-center gap-1.5 text-sm text-red-600 dark:text-red-400">
                    <x-heroicon-o-minus-circle class="h-3.5 w-3.5" />
                    Descuento proveedor
                </span>
                <span class="text-sm font-medium tabular-nums text-red-600 dark:text-red-400">
                    − {{ $discount }}
                </span>
            </div>

            <div class="flex items-center justify-between px-4 py-3">
                <span class="text-sm text-gray-600 dark:text-gray-400">Subtotal neto</span>
                <span class="text-sm font-medium tabular-nums text-gray-800 dark:text-gray-200">
                    {{ $subtotalNet }}
                </span>
            </div>
        @endif

        {{-- IVA --}}
        <div class="flex items-center justify-between px-4 py-3">
            <span class="flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400">
                <x-heroicon-o-plus-circle class="h-3.5 w-3.5 text-blue-400" />
                IVA ({{ $order->tax_iva }}%)
            </span>
            <span class="text-sm font-medium tabular-nums text-gray-800 dark:text-gray-200">
                + {{ $iva }}
            </span>
        </div>

        {{-- Retención IVA (solo si aplica) --}}
        @if ($hasRetIva)
            <div class="flex items-center justify-between bg-orange-50 px-4 py-3 dark:bg-orange-900/10">
                <span class="flex items-center gap-1.5 text-sm text-orange-600 dark:text-orange-400">
                    <x-heroicon-o-minus-circle class="h-3.5 w-3.5" />
                    Retención IVA ({{ $order->retention_iva }}%)
                </span>
                <span class="text-sm font-medium tabular-nums text-orange-600 dark:text-orange-400">
                    − {{ $retIva }}
                </span>
            </div>
        @endif

        {{-- Retención ISR (solo si aplica) --}}
        @if ($hasRetIsr)
            <div class="flex items-center justify-between bg-orange-50 px-4 py-3 dark:bg-orange-900/10">
                <span class="flex items-center gap-1.5 text-sm text-orange-600 dark:text-orange-400">
                    <x-heroicon-o-minus-circle class="h-3.5 w-3.5" />
                    Retención ISR ({{ $order->retention_isr }}%)
                </span>
                <span class="text-sm font-medium tabular-nums text-orange-600 dark:text-orange-400">
                    − {{ $retIsr }}
                </span>
            </div>
        @endif

    </div>

    {{-- Total --}}
    <div
        class="flex items-center justify-between border-t-2 border-gray-200 bg-gray-50 px-4 py-4 dark:border-gray-600 dark:bg-gray-700/50">
        <span class="text-sm font-bold text-gray-700 dark:text-gray-200">Total</span>
        <span class="text-lg font-bold tabular-nums text-gray-900 dark:text-white">
            {{ $total }}
        </span>
    </div>

</div>
