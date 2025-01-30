<html lang="es">

<head>
    <title>Orden</title>
    @vite('resources/css/order-pdf.css')
    <style>
        html {
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="w-full pt-7">
        <div class="flex justify-between">
            <div class="w-1/2 px-2">
                <table class="w-full border-black">
                    <thead class="border-b border-black">
                        <tr>
                            <th colspan="2" class="p-0 text-sm font-bold text-black">Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">Compañía:</td>
                            <td class="p-0 text-xs font-bold text-gray-700 ps-2">{{ $data['provider']['company_name'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">Para:</td>
                            <td class="p-0 text-xs text-gray-700 ps-2">{{ $data['providerContact']['name'] }}</td>
                        </tr>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">Correo:</td>
                            <td class="p-0 text-xs text-gray-700 ps-2">{{ $data['providerContact']['email'] }}</td>
                        </tr>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">No. Telefónico:</td>
                            <td class="p-0 text-xs text-gray-700 ps-2">{{ $data['providerContact']['cell_phone'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="w-1/2 px-2">
                <table class="w-full border-black">
                    <thead class="border-b border-black">
                        <tr>
                            <th colspan="2" class="p-0 text-sm font-bold text-black">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">Compañía:</td>
                            <td class="p-0 text-xs font-bold text-gray-700 ps-2">{{ $data['company']['name'] }}</td>
                        </tr>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">De:</td>
                            <td class="p-0 text-xs text-gray-700 ps-2">{{ $data['purchaser']['name'] }}</td>
                        </tr>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">Correo:</td>
                            <td class="p-0 text-xs text-gray-700 ps-2">{{ $data['purchaser']['email'] }}</td>
                        </tr>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">No. Telefónico:</td>
                            <td class="p-0 text-xs text-gray-700 ps-2">{{ $data['purchaser']['phone'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        {{-- partidas --}}
        <div class="mt-6">
            <table class="w-full border border-collapse border-black">
                <thead class="border border-black">
                    <tr>
                        <th class="px-1 text-sm font-bold text-black border border-black ">#</th>
                        <th class="px-1 text-sm font-bold text-black border border-black ">Código</th>
                        <th class="px-1 text-sm font-bold text-black border border-black ">Descripción</th>
                        <th class="px-1 text-sm font-bold text-black border border-black ">Marca</th>
                        <th class="px-1 text-sm font-bold text-black border border-black ">Unidad</th>
                        <th class="px-1 text-sm font-bold text-black border border-black ">Cantidad</th>
                        <th class="px-1 text-sm font-bold text-black border border-black ">P.U.</th>
                        <th class="px-1 text-sm font-bold text-black border border-black ">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['itemsFormatted'] as $item)
                        <tr>
                            <td class="px-1 text-xs text-center text-gray-700 border border-black ">
                                {{ $loop->iteration }}</td>
                            <td class="px-1 text-xs text-center text-gray-700 border border-black ">{{ $item['code'] }}
                            </td>
                            <td class="px-1 text-xs text-center text-gray-700 border border-black ">{{ $item['name'] }}
                            </td>
                            <td class="px-1 text-xs text-justify text-gray-700 border border-black ">
                                {{ $item['brand'] }}</td>
                            <td class="px-1 text-xs text-center text-gray-700 border border-black ">
                                {{ $item['unit'] }}/M</td>
                            <td class="px-1 text-xs text-center text-gray-700 border border-black ">
                                {{ $item['quantity'] }}</td>
                            <td class="px-1 text-xs text-center text-gray-700 border border-black ">
                                {{ $item['unit_price'] }}</td>
                            <td class="px-1 text-xs text-center text-gray-700 border border-black ">
                                {{ $item['sub_total'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white border-r-black"></td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">Subtotal:</td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">
                            {{ $data['total']['Subtotal'] }}</td>
                    </tr>
                    <tr>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white border-r-black"></td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">Descuento:</td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">
                            {{ $data['total']['Descuento'] }}</td>
                    </tr>
                    <tr>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white border-r-black"></td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">IVA:</td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">
                            {{ $data['total']['IVA'] }}</td>
                    </tr>
                    <tr>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white border-r-black"></td>
                        <td class="px-1 text-xs font-bold text-center text-gray-700 border border-black ">Total:</td>
                        <td class="px-1 text-xs font-bold text-center text-gray-700 border border-black ">
                            {{ $data['total']['Total'] }}</td>
                    </tr>
                    <tr>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white border-r-black"></td>
                        <td class="px-1 text-xs font-bold text-center text-gray-700 border border-black ">Moneda:</td>
                        <td class="px-1 text-xs font-bold text-center text-gray-700 border border-black ">
                            {{ $data['currency'] }}</td>
                    </tr>

                </tfoot>
            </table>
        </div>
        {{-- observaciones --}}
        <div class="mt-3">
            <table class="w-full">
                <thead>
                    <th colspan="2"
                        class="px-1 text-sm font-bold text-left text-black border border-white border-b-black">
                        Observaciones al proveedor</th>
                </thead>
                <tbody>
                    @foreach ($data['itemsFormatted'] as $item)
                        <tr>
                            <td class="w-16 px-1 text-xs text-left text-gray-700">Partida {{ $loop->iteration }}:</td>
                            <td class="px-1 text-xs text-left text-gray-700 ">{{ $item['observation'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{--  --}}
        <div class="grid grid-cols-2 mt-4">
            <div class="pr-3">
                <table class="w-full">
                    <thead>
                        <th class="px-1 text-sm font-bold text-left text-black border border-white border-b-black">
                            Archivos Anexos</th>
                    </thead>
                    <tbody>
                        @foreach ($data['media'] as $item)
                            <tr>
                                <td class="px-1 text-xs text-left text-gray-700 ms-2 ">
                                    <a href="{{ $item->getUrl() }}" target="_blank" class="underline">
                                        {{ $item->name }} ({{ $item->extension }})
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <table class="w-full mt-5">
                    {{-- <thead>
                        <th class="px-1 text-sm font-bold text-left text-black border border-white border-b-black">
                            Ítems de Pago</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-1 text-xs text-left text-gray-700 ms-2 ">{{ $data['condition_payment'] }}</td>
                        </tr>
                    </tbody> --}}
                </table>
            </div>
            {{-- Condiciones de entrega --}}
            <div class="pl-4">
                <table class="w-full">
                    <thead>
                        <th colspan="2"
                            class="px-1 text-sm font-bold text-left text-black border border-white border-b-black">
                            Condiciones de entrega</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-1 text-xs text-right text-gray-700 w-28">Método de envío:</td>
                            <td class="px-1 text-xs text-left text-gray-700 ms-2 ">{{ $data['shipping_method'] }}</td>
                        </tr>
                        {{-- <tr>
                            <td class="px-1 text-xs text-right text-gray-700 w-28">Tiempo de entrega:</td>
                            <td class="px-1 text-xs text-left text-gray-700 ms-2 ">{{ $data['initial_delivery_date'] }}</td>
                        </tr> --}}
                    </tbody>
                </table>
                <div class="grid w-full grid-cols-2">
                    <table class="border-r border-black ">
                        <thead>
                            <th class="px-1 text-xs text-center text-black underline border-white decoration-solid">
                                Dirección de entrega</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-1 text-xs text-left text-gray-700 ms-2 ">
                                    <p>{{ $data['delivery_address'] }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="pl-3">
                        <thead>
                            <th class="px-1 text-xs text-center text-black underline border-white decoration-solid">
                                Documentación para entrega</th>
                        </thead>
                        <tbody>
                            @if (filled($data['documentation_delivery']))
                                @foreach ($data['documentation_delivery'] as $item)
                                    <tr>
                                        <td class="px-1 text-xs text-left text-gray-700 ms-2 ">{{ $item['name'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- facturacion --}}
        <div class="grid grid-cols-3 gap-5 mt-4">
            <table class="w-full">
                <thead>
                    <th colspan="2"
                        class="px-1 text-sm font-bold text-left text-black border border-white border-b-black">
                        Facturación</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-1 text-xs font-bold text-left text-gray-700">RFC: {{ $data['company']['rfc'] }}
                        </td>
                    </tr>
                    <tr>
                        <td class="px-1 text-xs font-bold text-left text-gray-700">{{ $data['company']['name'] }}</td>
                    </tr>
                    <tr>
                        <td class="px-1 text-xs text-left text-gray-700">{{ $data['company']['street'] }}</td>
                    </tr>
                    <tr>
                        <td class="px-1 text-xs text-left text-gray-700">{{ $data['company']['neighborhood'] }}</td>
                    </tr>
                    <tr>
                        <td class="px-1 text-xs text-left text-gray-700">{{ $data['company']['municipality'] }}</td>
                    </tr>
                    <tr>
                        <td class="px-1 text-xs text-left text-gray-700">{{ $data['company']['state'] }},
                            {{ $data['company']['cp'] }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="w-full">
                <thead>
                    <th colspan="2"
                        class="px-1 text-sm font-bold text-left text-black border border-white border-b-black">
                        Datos para facturación</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="w-24 px-1 text-xs text-left text-gray-700">Uso de CFDI:</td>
                        <td class="px-1 text-xs text-left text-gray-700 ">{{ $data['use_cfdi'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-24 px-1 text-xs text-left text-gray-700">Método de Pago:</td>
                        <td class="px-1 text-xs text-left text-gray-700 ">{{ $data['form_payment'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-24 px-1 text-xs text-left text-gray-700">Tipo de Pago:</td>
                        <td class="px-1 text-xs text-left text-gray-700 ">{{ $data['type_payment'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-24 px-1 text-xs text-left text-gray-700">Condiciones de Pago:</td>
                        <td class="px-1 text-xs text-left text-gray-700 ">{{ $data['condition_payment'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-24 px-1 text-xs text-left text-gray-700">Enviar a:</td>
                        <td class="px-1 text-xs text-left text-gray-700 ">{{ $data['purchaser']['email'] }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="w-full">
                <thead>
                    <th colspan="2"
                        class="px-1 text-sm font-bold text-left text-black border border-white border-b-black">
                        Cuenta de proveedor</th>
                </thead>
                <tbody>
                    <tr>
                        <td VALIGN="top" class="px-1 py-0 text-xs text-left text-gray-700">
                            <div>
                                <p>&nbsp;&nbsp;Banco:&nbsp;{{ $data['provider']['bank'] }}</p>
                                <p>&nbsp;Cuenta:&nbsp;{{ $data['provider']['bank_account'] }}</p>
                                <p>&nbsp;&nbsp;&nbsp;Clabe:&nbsp;{{ $data['provider']['bank_account_number'] }}</p>
                                <p>Enviar a:&nbsp;{{ $data->providerContact->email }}</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
