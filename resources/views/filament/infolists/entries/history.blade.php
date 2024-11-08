<div>
    {{-- <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        Fecha
                    </th>
                    <th scope="col" class="p-4">
                        Usuario
                    </th>
                    <th scope="col" class="p-4">
                        Estatus anterior
                    </th>
                    <th scope="col" class="p-4">
                        Estatus actual
                    </th>
                    <th scope="col" class="p-4">
                        Comentarios
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($getRecord()->status()->history()->orderBy('created_at', 'desc')->get() as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="p-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->created_at->format('d-m-Y H:i') }}
                        </th>
                        <td class="p-3">
                            {{ $item->responsible->name }}
                        </td>
                        <td class="p-3">
                            @if (filled($item->from))
                                {{ $item->from }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="p-3">
                            {{ $item->to }}
                        </td>
                        <td class="p-3">
                            @if (filled($item->getCustomProperty('respuesta')))
                                {{ $item->getCustomProperty('respuesta') }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}
    <div>
        <div class="flex flex-col p-6 bg-gray-100 sm:py-12">
            <ul class="list-none">
                @foreach ($getRecord()->status()->history()->orderBy('created_at', 'desc')->get() as $item)
                    <li class="rounded-lg cursor-pointer group">
                        <div class="flex flex-row">
                            <div class="flex flex-col items-center justify-around">
                                <div class="h-full border-l-2 border-gray-400"></div>
                                <div
                                    class="flex justify-around flex-grow w-8 h-8 bg-green-400 border-2 border-gray-400 rounded-full">
                                    <svg class="flex-none w-4 h-4 m-2 opacity-100 group-hover:opacity-100" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </div>
                                <div class="h-full border-l-2 border-gray-400"></div>
                            </div>
                            <div class="flex flex-col p-2 pr-6 ml-2 group-hover:bg-white rounded-xl">
                                <div class="ml-4 text-xl font-medium capitalize">
                                    @if (filled($item->from))
                                        {{ $item->from }}
                                    @else
                                        N/A
                                    @endif
                                    -> {{ $item->to }}
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
