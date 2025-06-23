<div>
    <div class="flex">
        @foreach ($getRecord()->progress as $step)
            {{-- step --}}
            <div class="w-1/3 px-6 text-center">
                @if (filled($step['name']) && isset($step['date']))
                    <div
                        class="flex flex-col items-center justify-center truncate bg-green-400 border border-gray-200 rounded-lg dark:bg-green-700">
                        <div class="flex items-center justify-center w-full py-4 bg-transparent h-1/3 icon-step">
                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd"
                                clip-rule="evenodd">
                                <path
                                    d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z" />
                            </svg>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-full h-24 px-1 bg-green-300 rounded-b-lg dark:bg-green-600 body-step">
                            <h2 class="text-sm font-bold"> {{ $step['title'] }}</h2>
                            <p class="text-xs text-gray-600">
                                {{ $step['name'] }}
                            </p>
                            <p class="mt-2 text-xs text-gray-500">
                                {{ $step['date'] }}
                            </p>
                        </div>
                    </div>
                @else
                    <div
                        class="flex flex-col items-center justify-center truncate bg-gray-400 border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-center w-full py-4 bg-transparent h-1/3 icon-step">
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
                        <div
                            class="flex flex-col items-center justify-center w-full h-24 px-1 bg-gray-300 rounded-b-lg body-step">
                            <h2 class="text-sm font-bold"> {{ $step['title'] }}</h2>
                            <p class="text-xs text-gray-600">
                                {{ $step['name'] }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>
            @if (!$loop->last)
                <div class="flex items-center justify-center flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M14 2h-7.229l7.014 7h-13.785v6h13.785l-7.014 7h7.229l10-10z" />
                    </svg>
                </div>
            @endif
        @endforeach
    </div>
</div>
