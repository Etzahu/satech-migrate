<html lang="es">

<head>
    <title>Orden</title>
    @vite('resources/css/order-pdf.css')
</head>

<body>
    {{-- <div class="max-w-3xl px-2 py-8 mx-auto"> --}}
    <div class="w-full">
        {{-- <div class="flex items-center justify-between mb-8" style="margin-top: 100px;">
            <div class="flex items-center">
                    <img src="{{ asset('images/logo/companies/G.jpg') }}" alt="logo" class="w-48">
            </div>
            <div class="text-end">
                <p class="text-lg font-bold leading-none text-red-600 ">Orden de Compra: G203-24</p>
                <p class="text-lg font-bold leading-none text-black ">Revisión: 0</p>
                <p class="text-lg font-bold leading-none text-black ">Cotización: C123-6</p>
                <p class="text-xs leading-none text-black ">26 de noviembre del 2024</p>
                <p class="text-xs leading-none text-black ">Requisición: T-SG24-375</p>
                <p class="text-xs leading-none text-black ">Página 1 de 4</p>
            </div>
        </div> --}}
        <div class="text-start">
            <p class="text-lg font-bold leading-none text-black">Tech Energy Control, S.A. de C.V.</p>
            <p class="text-xs leading-none text-black ">Av. Santa Mónica No.33</p>
            <p class="text-xs leading-none text-black ">Col El Mirador</p>
            <p class="text-xs leading-none text-black ">Tlalnepantla de Baz</p>
            <p class="text-xs leading-none text-black ">Estado de Mexico, 54080</p>
        </div>
        <div class="flex justify-between mt-3">
            <div class="w-1/2 px-2">
                <table class="w-full border border-collapse border-black">
                    <thead class="bg-yellow-400">
                        <tr>
                            <th colspan="2" class="p-0 text-sm font-bold text-black">Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">Compañía:</td>
                            <td class="p-0 text-xs font-bold text-gray-700 ps-2">Ferretería Santander, S.A. de C.V</td>
                        </tr>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">Para:</td>
                            <td class="p-0 text-xs text-gray-700 ps-2">Ferretería Santander, S.A. de C.V</td>
                        </tr>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">Correo:</td>
                            <td class="p-0 text-xs text-gray-700 ps-2">Ferretería Santander, S.A. de C.V</td>
                        </tr>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">No. Telefónico:</td>
                            <td class="p-0 text-xs text-gray-700 ps-2">Ferretería Santander, S.A. de C.V</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="w-1/2 px-2">
                <table class="w-full border border-collapse border-black">
                    <thead class="bg-yellow-400">
                        <tr>
                            <th colspan="2" class="p-0 text-sm font-bold text-black">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">Compañía:</td>
                            <td class="p-0 text-xs font-bold text-gray-700 ps-2">Ferretería Santander, S.A. de C.V</td>
                        </tr>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">De:</td>
                            <td class="p-0 text-xs text-gray-700 ps-2">Ferretería Santander, S.A. de C.V</td>
                        </tr>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">Correo:</td>
                            <td class="p-0 text-xs text-gray-700 ps-2">Ferretería Santander, S.A. de C.V</td>
                        </tr>
                        <tr>
                            <td class="p-0 text-xs text-gray-700 w-13 text-end">No. Telefónico:</td>
                            <td class="p-0 text-xs text-gray-700 ps-2">Ferretería Santander, S.A. de C.V</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        {{-- partidas --}}
        <div class="mt-4">
            <table class="w-full border border-collapse border-black">
                <thead class="border border-red-500">
                    <tr>
                        <th class="px-1 text-sm font-bold text-black border border-red-600 ">#</th>
                        <th class="px-1 text-sm font-bold text-black border border-red-600 ">Código</th>
                        <th class="px-1 text-sm font-bold text-black border border-red-600 ">Descripción</th>
                        <th class="px-1 text-sm font-bold text-black border border-red-600 ">Marca</th>
                        <th class="px-1 text-sm font-bold text-black border border-red-600 ">Unidad</th>
                        <th class="px-1 text-sm font-bold text-black border border-red-600 ">Cantidad</th>
                        <th class="px-1 text-sm font-bold text-black border border-red-600 ">P.U.</th>
                        <th class="px-1 text-sm font-bold text-black border border-red-600 ">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">1</td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">TCN004</td>
                        <td class="px-1 text-xs text-justify text-gray-700 border border-black ">Junta espiro metálica
                            P/brida 24" 600# RF ASME B16.5 – doble
                            anillo CGI acero inoxidable 316 o 304 C/relleno de grafito flexible
                            (libre de asbesto)</td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">S/M</td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">PZA</td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">3.0</td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">$2,510.00</td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">$7,530.00</td>
                    </tr>
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
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">$7,530.00</td>
                    </tr>
                    <tr>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white border-r-black"></td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">Descuento:</td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">$7,530.00</td>
                    </tr>
                    <tr>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white border-r-black"></td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">IVA:</td>
                        <td class="px-1 text-xs text-center text-gray-700 border border-black ">$7,530.00</td>
                    </tr>
                    <tr>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white border-r-black"></td>
                        <td class="px-1 text-xs font-bold text-center text-gray-700 border border-black ">Total:</td>
                        <td class="px-1 text-xs font-bold text-center text-gray-700 border border-black ">$7,530.00</td>
                    </tr>
                    <tr>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white"></td>
                        <td class="px-1 border border-white border-r-black"></td>
                        <td class="px-1 text-xs font-bold text-center text-gray-700 border border-black ">Moneda:</td>
                        <td class="px-1 text-xs font-bold text-center text-gray-700 border border-black ">MXN</td>
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
                    <tr>
                        <td class="w-16 px-1 text-xs text-right text-gray-700">Partida 1:</td>
                        <td class="px-1 text-xs text-left text-gray-700 ms-2 ">Debe ser de 24”</td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{--  --}}
        <div class="grid grid-cols-2 mt-4">
            <div class="pr-3">
                <table class="w-full">
                    <thead>
                        <th
                            class="px-1 text-sm font-bold text-left text-black border border-white border-b-black">
                            Archivos Anexos</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-1 text-xs text-left text-gray-700 ms-2 ">Debe ser de 24”</td>
                        </tr>
                    </tbody>
                </table>
                <table class="w-full mt-5">
                    <thead>
                        <th
                            class="px-1 text-sm font-bold text-left text-black border border-white border-b-black">
                            Ítems de Pago</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-1 text-xs text-left text-gray-700 ms-2 ">Debe ser de 24”</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="pl-4">
                <table class="w-full">
                    <thead>
                        <th colspan="2"
                            class="px-1 text-sm font-bold text-left text-black border border-white border-b-black">
                            Condiciones de entrega</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="w-16 px-1 text-xs text-right text-gray-700">Partida 1:</td>
                            <td class="px-1 text-xs text-left text-gray-700 ms-2 ">Debe ser de 24”</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</body>

</html>
