<div class="w-full">
    @php
        if (get_Class($getRecord()) == 'App\Models\PurchaseOrder') {
            $progress =
                $getRecord()->provider->approval_chain == 'especial'
                    ? $getRecord()->progressSpecial
                    : $getRecord()->progress;
        } else {
            $progress = $getRecord()->progress;
        }
    @endphp

    <div class="w-full space-y-1">
        @foreach ($progress as $step)
            @php $done = filled($step['name']) && isset($step['date']); @endphp

            <div class="relative flex items-start w-full gap-3">
                {{-- Línea conectora --}}
                @if (!$loop->last)
                    <div class="absolute w-px h-full bg-gray-200 left-5 top-10 dark:bg-gray-600"></div>
                @endif

                {{-- Badge --}}
                @if ($done)
                    <div
                        class="z-10 flex flex-col items-center justify-center w-10 h-10 text-white bg-green-500 rounded-full shadow-sm shrink-0">
                        <span
                            class="text-[10px] font-medium uppercase leading-none">{{ $step['date']->shortMonthName }}</span>
                        <span class="text-sm font-bold leading-none">{{ $step['date']->day }}</span>
                    </div>
                @else
                    <div
                        class="z-10 flex items-center justify-center w-10 h-10 text-gray-400 bg-gray-100 rounded-full shadow-sm shrink-0 dark:bg-gray-700 dark:text-gray-500">
                        <x-heroicon-o-clock class="w-5 h-5" />
                    </div>
                @endif

                {{-- Contenido --}}
                <div
                    class="mb-4 flex-1 rounded-lg px-3 py-2
                    {{ $done
                        ? 'border-l-2 border-green-400 bg-green-50 dark:border-green-600 dark:bg-green-900/20'
                        : 'border-l-2 border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700/30' }}">
                    <p
                        class="text-xs font-semibold {{ $done ? 'text-green-700 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">
                        {{ $step['title'] }}
                    </p>
                    @if (filled($step['name']))
                        <p class="mt-0.5 text-xs {{ $done ? 'text-green-600 dark:text-green-500' : 'text-gray-400' }}">
                            {{ $step['name'] }}
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
