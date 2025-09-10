<div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="w-full max-w-2xl mx-auto">
        <!-- Tarjeta de cronología -->
        <div class="overflow-hidden bg-white shadow-lg rounded-xl">
            <!-- Contenido -->
            <div class="p-6">
                @foreach ($getRecord()->progress as $step)
                    @if (filled($step['name']) && isset($step['date']))
                        <!-- Etapa  Completada -->
                        <div class="relative flex mb-8">
                            @if (!$loop->last)
                                <!-- Línea conectora -->
                                <div class="absolute left-8 top-14 h-16 w-0.5 bg-gray-200"></div>
                            @endif
                            <!-- Badge de fecha -->
                            <div
                                class="z-10 flex flex-col items-center justify-center w-16 h-16 mr-5 text-white bg-green-500 rounded-full shadow-md">
                                <span class="text-xs font-medium uppercase"> {{ $step['date']->shortMonthName }} </span>
                                <span class="text-xl font-bold">{{ $step['date']->day }}</span>
                            </div>
                            <!-- Contenido -->
                            <div class="flex-1 p-4 border-l-4 border-green-500 rounded-lg bg-green-50">
                                <h3 class="flex items-center font-semibold text-green-800">
                                    <i class="mr-2 fas fa-check-circle"></i>
                                    {{ $step['title'] }}
                                </h3>
                                <p class="mt-1 text-sm text-green-600"> {{ $step['name'] }}</p>
                            </div>
                        </div>
                    @else
                        <div class="relative flex mb-8">
                            @if (!$loop->last)
                                <!-- Línea conectora -->
                                <div class="absolute left-8 top-14 h-16 w-0.5 bg-gray-200"></div>
                            @endif

                            <!-- Badge de fecha -->
                            <div
                                class="z-10 flex flex-col items-center justify-center w-16 h-16 mr-5 text-gray-500 bg-gray-200 rounded-full shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24"
                                    height="24" stroke-width="2" data-darkreader-inline-stroke=""
                                    style="--darkreader-inline-stroke: currentColor;">
                                    <path d="M20.986 12.502a9 9 0 1 0 -5.973 7.98"></path>
                                    <path d="M12 7v5l3 3"></path>
                                    <path d="M19 16v3"></path>
                                    <path d="M19 22v.01"></path>
                                </svg>
                            </div>

                            <!-- Contenido -->
                            <div class="flex-1 p-4 border-l-4 border-gray-300 rounded-lg bg-gray-50">
                                <h3 class="flex items-center font-semibold text-gray-500">
                                    <i class="mr-2 fas fa-clock"></i>
                                    {{ $step['title'] }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-400">{{ $step['name'] }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
