<!DOCTYPE html>
<html lang="es">

<head>
    <title>Orden de Compra - {{ $data['folio'] }}</title>
    @vite('resources/css/order-pdf.css')
    <style>
        html {
            font-size: 13px;
        }

        /* Estilos para saltos de página */
        .page-break-before {
            page-break-before: always;
        }

        .page-break-after {
            page-break-after: always;
        }

        .no-page-break {
            page-break-inside: avoid;
        }

        /* Asegurar que las tablas no se corten */
        table {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    {{-- Contenido principal de la orden de compra --}}
    @include('pdf.purchase-order.content', ['data' => $data, 'stages' => $stages])

    {{-- Anexo de Proveeduría --}}
    @if ($includeSupplier)
        @include('pdf.purchase-order.annexes.supplier', ['data' => $data])
    @endif

    {{-- Anexo de Servicios --}}
    @if ($includeService)
        @include('pdf.purchase-order.annexes.service', ['data' => $data])
    @endif

    {{-- Términos y Condiciones --}}
    @if (filled($includeTerms))
        @include($includeTerms, ['data' => $data])
    @endif
</body>

</html>
