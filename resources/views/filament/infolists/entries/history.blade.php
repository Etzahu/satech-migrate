<div>
    <div class="relative overflow-x-auto">
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
    </div>

</div>
