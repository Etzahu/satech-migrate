<div>
    <div>
        <div class="flex flex-col p-6 bg-gray-100 sm:py-12">
            <ul class="list-none">
                @foreach ($getRecord()->status()->history()->orderBy('id', 'desc')->get() as $item)
                    <li class="rounded-lg cursor-pointer group">
                        <div class="flex flex-row">
                            <div class="flex flex-col items-center justify-around">
                                <div class="h-full border-l-2 border-gray-400"></div>
                                <div
                                    class="flex justify-around flex-grow w-8 h-8 bg-green-300 border-2 border-gray-400 rounded-full ">
                                    <svg class="flex-none w-4 h-4 m-2 opacity-100 group-hover:opacity-100" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </div>
                                <div class="h-full border-l-2 border-gray-400"></div>
                            </div>
                            <div class="flex flex-col p-2 pr-6 ml-2 group-hover:bg-white rounded-xl">
                                <div class="ml-4 text-xl font-medium capitalize-first">
                                    @if (filled($item->from))
                                        {{ ucfirst(strtolower($item->from))  }}
                                    @else
                                        N/A
                                    @endif
                                    -> {{  ucfirst(strtolower($item->to)) }}
                                </div>
                                <div class="mb-2 ml-4 text-xs">
                                    <p> {{ $item->created_at->format('d-m-Y H:i') }}</p>
                                    <p>{{ $item->responsible->name }}</p>
                                </div>
                                @if (filled($item->getCustomProperty('respuesta')))
                                    <div class="ml-4 text-sm">
                                        <p class="text-gray-500">Comentarios/Observaciones:</p>
                                        {{ $item->getCustomProperty('respuesta') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>
