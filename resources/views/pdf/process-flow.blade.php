<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Flujo del proceso</title>

    {{-- Mismo renderizador D3 que la página interactiva. Browsershot/Puppeteer
         lo ejecuta para dibujar los diagramas antes de generar el PDF. --}}
    @vite('resources/js/flow-diagram.js')

    {{-- Estilos compartidos del diagrama (nodos, transiciones, etiquetas). --}}
    @include('filament.purchases.pages.partials.flow-diagram-styles')

    <style>
        @page { margin: 0; }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Cada flujo ocupa una página completa en horizontal. */
        .flow-page {
            width: 100%;
            height: 100vh;
            padding: 9mm 11mm;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            page-break-after: always;
            break-after: page;
        }
        .flow-page:last-child { page-break-after: auto; break-after: auto; }

        .flow-head { display: flex; align-items: center; gap: 12px; margin-bottom: 6px; }
        .flow-head__badge {
            display: flex; align-items: center; justify-content: center;
            width: 42px; height: 42px; font-size: 22px;
            border-radius: 12px; background: #f3f4f6;
        }
        .flow-head__title { margin: 0; font-size: 22px; font-weight: 800; color: #111827; line-height: 1.1; }
        .flow-head__sub { margin: 2px 0 0; font-size: 12.5px; color: #6b7280; }

        /* El escenario ocupa todo el espacio restante de la página. */
        .flow-page .fd-stage {
            position: relative;
            flex: 1 1 auto;
            min-height: 0;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
        }
        .flow-page .fd-canvas {
            aspect-ratio: auto !important;
            width: 100% !important;
            height: 100% !important;
            max-height: none !important;
            background-image: none;
            background-color: #ffffff;
            border-radius: 14px;
        }
        .flow-page .fd-svg { cursor: default; }

        .flow-legend {
            display: flex; flex-wrap: wrap; align-items: center;
            gap: 6px 10px; margin-top: 7px;
        }
        .flow-legend .fd-legend__chip { border-color: #e5e7eb; }
    </style>
</head>

<body class="pdf">
    @php
        $diagrams = [
            ['flow' => $requisitionFlow, 'badge' => '📋', 'subtitle' => 'Ciclo de vida de la requisición de compra'],
            ['flow' => $orderFlow, 'badge' => '🛒', 'subtitle' => 'Ciclo de vida de la orden de compra'],
        ];
        $legend = [
            'start' => 'Inicio',
            'review' => 'Revisión',
            'approval' => 'Aprobación',
            'purchase' => 'Compra',
            'final' => 'Final',
            'return' => 'Devolución',
            'cancel' => 'Cancelación',
            'special' => 'Caso especial',
        ];
    @endphp

    @foreach ($diagrams as $diagram)
        <section class="flow-page">
            <div class="flow-head">
                <span class="flow-head__badge">{{ $diagram['badge'] }}</span>
                <div>
                    <h1 class="flow-head__title">{{ $diagram['flow']['title'] }}</h1>
                    <p class="flow-head__sub">{{ $diagram['subtitle'] }}</p>
                </div>
            </div>

            <div class="fd-stage" data-flow-root="flow-data-{{ $diagram['flow']['id'] }}">
                <div class="fd-canvas"></div>
                <div class="fd-tooltip"></div>
            </div>

            <div class="flow-legend">
                @foreach ($legend as $type => $label)
                    <span class="fd-legend__chip">
                        <span class="fd-dot fd-dot--{{ $type }}"></span>{{ $label }}
                    </span>
                @endforeach
            </div>

            <script type="application/json" id="flow-data-{{ $diagram['flow']['id'] }}">@json($diagram['flow'])</script>
        </section>
    @endforeach
</body>

</html>
