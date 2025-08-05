<x-filament-panels::page>
    <div class="grid grid-cols-2 gap-1">
        <div>
            <table class="w-full border border-collapse border-gray-400 table-fixed">
                <thead>
                    <tr>
                        <th colspan="3">
                            ORDEN
                        </th>
                    </tr>
                    <tr>
                        <th class="border border-gray-400">ID partida</th>
                        <th class="border border-gray-400">ID Producto</th>
                        <th class="border border-gray-400">ID item PR test</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($currentOrder->items as $item)
                        <tr>
                            <td class="border border-gray-400">{{ $item->id }}</td>
                            <td class="border border-gray-400">{{ $item->product_id }}</td>
                            <td class="border border-gray-400">{{ $item->pr_item_id_reference }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <table class="w-full border border-collapse border-gray-400 table-fixed">
                <thead>
                    <tr>
                        <th colspan="2">
                            REQUISICION
                        </th>
                    </tr>
                    <tr>
                        <th class="border border-gray-400">ID partida</th>
                        <th class="border border-gray-400">ID Producto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($currentOrder->requisition->items as $itemPR)
                        <tr>
                            <td class="border border-gray-400">{{ $itemPR->id }}</td>
                            <td class="border border-gray-400">{{ $itemPR->product_id }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    <div>
        <form wire:submit="create">
            {{ $this->form }}
        </form>

        <x-filament-actions::modals />
    </div>
</x-filament-panels::page>
