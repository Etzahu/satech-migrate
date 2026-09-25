@php
    /**
     * Guía de flujos de aprobación.
     *
     * Todo el contenido sale de ProcessFlow::getRequisitionFlow() y
     * getOrderFlow(), los mismos arreglos que dibuja la página «Flujo del
     * proceso». No se redacta aquí ningún estado, actor ni notificación: si el
     * flujo cambia, se edita ProcessFlow y esta guía se regenera.
     */

    // Alto aproximado de una tarjeta de estado, para repartir las hojas sin
    // que ninguna se desborde. Se calibró contra el render real; si el texto
    // crece, `guias:pdf` avisa del desbordamiento.
    $altoTarjeta = function (array $node): int {
        $texto = strlen($node['description'] ?? '') + strlen($node['notify'] ?? '');

        return 50 + (int) ceil($texto / 122) * 15;
    };

    /**
     * Reparte elementos en hojas sin pasarse del presupuesto de cada una.
     *
     * @param  callable  $alto  Alto estimado de un elemento
     */
    $repartir = function (array $items, int $presupuestoInicial, int $presupuesto, callable $alto): array {
        $hojas = [];
        $actual = [];
        $resta = $presupuestoInicial;

        foreach ($items as $item) {
            $medida = $alto($item);

            if ($actual && $medida > $resta) {
                $hojas[] = $actual;
                $actual = [];
                $resta = $presupuesto;
            }

            $actual[] = $item;
            $resta -= $medida;
        }

        if ($actual) {
            $hojas[] = $actual;
        }

        return $hojas;
    };

    /** Alto aproximado de un renglón de tabla según su texto más largo. */
    $altoFila = fn (string $texto): int => 20 + (int) ceil(strlen($texto) / 104) * 15;

    /** Recorre las aristas marcadas como camino principal, en orden. */
    $caminoPrincipal = function (array $flow): array {
        $porId = collect($flow['nodes'])->keyBy('id');
        $ruta = [];

        foreach ($flow['edges'] as $edge) {
            if (! ($edge['main'] ?? false)) {
                continue;
            }

            if (! $ruta && $porId->has($edge['from'])) {
                $ruta[] = $porId->get($edge['from']);
            }

            if ($porId->has($edge['to'])) {
                $ruta[] = $porId->get($edge['to']);
            }
        }

        return $ruta;
    };

    /** Aristas de un tipo, con las etiquetas de sus nodos resueltas. */
    $aristas = function (array $flow, string $tipo): array {
        $porId = collect($flow['nodes'])->keyBy('id');

        return collect($flow['edges'])
            ->where('type', $tipo)
            ->map(fn (array $edge) => [
                'desde' => $porId->get($edge['from'])['label'] ?? $edge['from'],
                'hacia' => $porId->get($edge['to'])['label'] ?? $edge['to'],
                'actorDesde' => $porId->get($edge['from'])['actor'] ?? '',
                'etiqueta' => $edge['label'] ?? '',
            ])
            ->values()
            ->all();
    };

    $flujos = [
        ['num' => 1, 'flow' => $requisitionFlow],
        ['num' => 2, 'flow' => $orderFlow],
    ];
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Flujos de aprobación</title>
    @include('pdf.guides._estilos')
</head>

<body>

{{-- ══════════════════════════════════════════════════════════════════════
     PORTADA
══════════════════════════════════════════════════════════════════════ --}}
<div class="page cover">
    <header class="cover-header">
        <div class="cover-logo-plate"><img src="{{ $logo }}" alt="SA-TECH"></div>
        <div class="cover-date">Versión 2.0<br>{{ $fecha }}</div>
    </header>

    <div class="cover-main">
        <div class="cover-eyebrow">Guía de uso · Recorrido de los documentos</div>
        <h1 class="cover-title">Flujos de<br>aprobación</h1>
        <div class="cover-rule"></div>
        <p class="cover-subtitle">Requisición de compra y orden de compra</p>
        <p class="cover-lead">El recorrido completo de los dos documentos del sistema: cada estado, quién actúa en
            él, qué puede hacer y a quién avisa el sistema. Incluye las devoluciones, las
            cancelaciones y los casos especiales.</p>
    </div>

    <footer class="cover-footer">
        <div><span class="cover-meta-k">Sistema</span><span class="cover-meta-v">SA-TECH · Compras</span></div>
        <div><span class="cover-meta-k">Dirigida a</span><span class="cover-meta-v">Todos los perfiles</span></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     CÓMO LEER ESTA GUÍA
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Flujos de aprobación · Requisición y orden de compra</div>
        <div class="page-header-right">SA-TECH</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Cómo leer esta guía</h2>

        <p class="lead-text">Qué contiene y dónde está la versión interactiva.</p>

    <p>
        El sistema mueve dos documentos por cadenas de aprobación: la
        <strong>requisición de compra</strong>, con la que un área pide algo, y la
        <strong>orden de compra</strong>, con la que Compras se lo pide a un proveedor. Una
        requisición autorizada puede dar origen a varias órdenes, y cada una recorre su propio
        flujo.
    </p>

    <table class="data">
        <thead>
            <tr>
                <th style="width:24%">Flujo</th>
                <th style="width:19%">Arranca en</th>
                <th style="width:22%">Termina en</th>
                <th>Estados en total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($flujos as $f)
                <tr>
                    <td><strong>{{ $f['flow']['title'] }}</strong></td>
                    <td>{{ collect($f['flow']['nodes'])->firstWhere('type', 'start')['label'] ?? '—' }}</td>
                    <td>{{ collect($f['flow']['nodes'])->firstWhere('type', 'final')['label'] ?? '—' }}</td>
                    <td>{{ count($f['flow']['nodes']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Cómo está organizado cada flujo</h3>

    <table class="data">
        <thead>
            <tr>
                <th style="width:26%">Apartado</th>
                <th>Qué encontrarás</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Camino principal</strong></td>
                <td>La secuencia que sigue un documento cuando todo se aprueba a la primera.</td>
            </tr>
            <tr>
                <td><strong>Estado por estado</strong></td>
                <td>Una ficha por cada estado posible: quién tiene el documento en ese momento, qué puede hacer y qué correo dispara el sistema al llegar ahí.</td>
            </tr>
            <tr>
                <td><strong>Devoluciones</strong></td>
                <td>Desde qué estados se puede regresar el documento y a dónde cae.</td>
            </tr>
            <tr>
                <td><strong>Cancelaciones y casos especiales</strong></td>
                <td>Las salidas definitivas y las situaciones que se salen del camino normal.</td>
            </tr>
        </tbody>
    </table>

    <div class="note info">
        <span class="note-title">Hay una versión interactiva dentro del sistema</span>
        <p>
            En el menú lateral, la página <strong>Flujo del proceso</strong> muestra estos mismos
            flujos como diagramas navegables: puedes hacer clic en cada estado para leer su
            detalle. Desde ahí, el botón <strong>Exportar PDF</strong> descarga los dos diagramas
            en una hoja ancha, cómoda para imprimir y pegar en la pared.
        </p>
    </div>

    <div class="note warn">
        <span class="note-title">Este documento se genera, no se redacta</span>
        <p>
            Los estados, los actores y las notificaciones de esta guía se toman directamente de la
            configuración de la página <strong>Flujo del proceso</strong>. Si el flujo cambia, se
            actualiza ahí y esta guía se vuelve a generar: no hay una segunda versión del proceso
            que pueda quedar desfasada.
        </p>
    </div>

    <h3>Código de color de los estados</h3>

    <p style="font-size:9pt;line-height:1.9">
        <span class="chip c-gray">Inicio</span> el documento se está capturando &nbsp;
        <span class="chip c-yellow">Revisión</span> alguien valida el contenido &nbsp;
        <span class="chip c-navy">Aprobación</span> un nivel de la cadena tiene que firmar &nbsp;
        <span class="chip c-green">Cierre</span> llegó a su destino &nbsp;
        <span class="chip c-red">Devolución</span> regresó para corrección, es reversible &nbsp;
        <span class="chip c-gray">Cancelación</span> salida definitiva &nbsp;
        <span class="chip c-violet">Caso especial</span> fuera del camino normal
    </p>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     UN BLOQUE POR FLUJO
══════════════════════════════════════════════════════════════════════ --}}
@foreach ($flujos as $f)
    @php
        $flow = $f['flow'];
        $num = $f['num'];
        $ruta = $caminoPrincipal($flow);
        $principales = collect($flow['nodes'])->whereNotIn('type', ['return', 'cancel', 'special'])->values()->all();
        $devoluciones = collect($flow['nodes'])->where('type', 'return')->values()->all();
        $cancelaciones = collect($flow['nodes'])->where('type', 'cancel')->values()->all();
        $especiales = collect($flow['nodes'])->where('type', 'special')->values()->all();
        // La primera hoja lleva encabezado, intro y el camino principal.
        $hojas = $repartir($principales, 610, 880, $altoTarjeta);

        // Las salidas del camino principal son tres bloques de tabla; se
        // reparten en las hojas que hagan falta según su largo.
        $bloques = [];

        if ($devoluciones) {
            $bloques[] = [
                'tipo' => 'dev',
                'alto' => 160 + collect($devoluciones)->sum(fn ($n) => $altoFila($n['description'])),
            ];
        }

        if ($cancelaciones) {
            $bloques[] = [
                'tipo' => 'can',
                'alto' => 108 + collect($cancelaciones)->sum(fn ($n) => $altoFila($n['description'])),
            ];
        }

        if ($especiales) {
            $bloques[] = [
                'tipo' => 'esp',
                'alto' => 68 + collect($especiales)->sum(fn ($n) => $altoFila($n['description'])),
            ];
        }

        $hojasSalidas = $repartir($bloques, 780, 860, fn (array $b) => $b['alto']);
    @endphp

    @foreach ($hojas as $i => $hoja)
        <div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Flujos de aprobación · Requisición y orden de compra</div>
        <div class="page-header-right">Apartado {{ $num }}</div>
    </header>
    <div class="page-body">
            @if ($i === 0)
                <h2 class="section-title">{{ $flow['title'] }}</h2>

        <p class="lead-text">Camino principal y detalle de cada estado.</p>

                <h3>Camino principal</h3>

                <div class="ruta">
                    @foreach ($ruta as $paso)
                        <span class="paso">{{ $paso['label'] }}</span>@if (! $loop->last)<span class="flecha">&rsaquo;</span>@endif
                    @endforeach
                </div>

                <p style="font-size:10px;color:#6b7280">
                    {{ $flow['reentryLabel'] }} cuando el documento se devuelve en cualquier punto.
                </p>

                <h3>Estado por estado</h3>
            @else
                <div class="continues">{{ $num }} · {{ $flow['title'] }} · estado por estado <span style="float:right">continuación</span></div>
            @endif

            @foreach ($hoja as $node)
                <div class="step-row">
                    <div class="step-num">·</div>
                    <div>
                        <div class="step-head"><span class="step-name">{{ $node['label'] }}</span><span class="step-who">{{ $node['actor'] }}</span></div>
                        <div class="step-body">{{ $node['description'] }}
                        @if (filled($node['notify']))
                            <span class="step-mail">{{ $node['notify'] }}</span>
                        @endif</div>
                    </div>
                </div>
            @endforeach
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>
    @endforeach

    {{-- Devoluciones, cancelaciones y casos especiales --}}
    @foreach ($hojasSalidas as $hojaSalida)
        @php $tipos = collect($hojaSalida)->pluck('tipo')->all(); @endphp

        <div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Flujos de aprobación · Requisición y orden de compra</div>
        <div class="page-header-right">SA-TECH</div>
    </header>
    <div class="page-body">
        <div class="continues">{{ $num }} · {{ $flow['title'] }} <span style="float:right">salidas del camino principal</span></div>

        @if (in_array('dev', $tipos))
            <h3>Devoluciones</h3>

            <p>
                Una devolución no cancela nada: regresa el documento a quien lo levantó para que lo
                corrija. Quien devuelve tiene que escribir el motivo, y ese texto queda en el
                historial del documento.
            </p>

            <table class="data">
                <thead>
                    <tr>
                        <th style="width:30%">Estado al que cae</th>
                        <th style="width:26%">Quién lo devolvió</th>
                        <th>Qué sigue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devoluciones as $node)
                        <tr>
                            <td><span class="chip c-red">{{ $node['label'] }}</span></td>
                            <td>{{ str($node['label'])->after('Devuelto por ')->ucfirst() }}</td>
                            <td>{{ $node['description'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="note warn">
                <span class="note-title">Al corregir, el recorrido vuelve a empezar</span>
                <p>
                    {{ $flow['reentryLabel'] }}: el documento entra otra vez por el primer paso del
                    camino principal y todas las firmas se piden de nuevo. Por eso conviene atender
                    de una sola vez todo lo que se señaló en la devolución.
                </p>
            </div>
        @endif

        @if (in_array('can', $tipos))
            <h3>Cancelaciones</h3>

            <p>
                La cancelación es definitiva: el documento no vuelve a ser editable y el proceso no
                puede reanudarse. Si el gasto sigue siendo necesario, se levanta uno nuevo.
            </p>

            <table class="data">
                <thead>
                    <tr>
                        <th style="width:30%">Estado</th>
                        <th style="width:26%">Quién cancela</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cancelaciones as $node)
                        <tr>
                            <td><span class="chip c-gray">{{ $node['label'] }}</span></td>
                            <td>{{ $node['actor'] }}</td>
                            <td>{{ $node['description'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if (in_array('esp', $tipos))
            <h3>Casos especiales</h3>

            <table class="data">
                <thead>
                    <tr>
                        <th style="width:30%">Estado</th>
                        <th style="width:26%">Quién interviene</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($especiales as $node)
                        <tr>
                            <td><span class="chip c-violet">{{ $node['label'] }}</span></td>
                            <td>{{ $node['actor'] }}</td>
                            <td>{{ $node['description'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>
    @endforeach
@endforeach

{{-- ══════════════════════════════════════════════════════════════════════
     CIERRE
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Flujos de aprobación · Requisición y orden de compra</div>
        <div class="page-header-right">SA-TECH</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Para tener a la mano</h2>

        <p class="lead-text">Lo que más se consulta de estos dos flujos.</p>

    <div class="duo">
            <div class="duo-card">
                <div class="duo-title">¿Dónde está detenido mi documento?</div>
                <div class="duo-sub">En tres clics</div>
                <ul>
                    <li>Abre el detalle del documento.</li>
                    <li>Ve a <strong>Flujo de aprobación</strong> en la columna derecha.</li>
                    <li>El primer paso sin fecha es quien lo tiene.</li>
                    <li>Para el motivo de una devolución, pestaña <strong>Historial</strong>.</li>
                </ul>
            </div>
            <div class="duo-card">
                <div class="duo-title">Devolución vs. cancelación</div>
                <div class="duo-sub">No son lo mismo</div>
                <ul>
                    <li><strong>Devolución:</strong> vuelve a quien lo levantó, se corrige y se reenvía.</li>
                    <li><strong>Cancelación:</strong> cierre definitivo, no se reactiva.</li>
                    <li>Ambas exigen que se escriba un motivo.</li>
                </ul>
            </div>
        </div>

    <h3>Preguntas que se repiten</h3>

    <table class="data">
        <thead>
            <tr>
                <th style="width:34%">Pregunta</th>
                <th>Respuesta</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>¿Por qué mi requisición no pasó por almacén?</td>
                <td>Porque es de categoría <strong>Servicio</strong>. Un servicio no se guarda en inventario, así que no tiene sentido preguntar por existencias. Las de proveeduría sí se detienen ahí.</td>
            </tr>
            <tr>
                <td>Mi cadena no tiene nivel de autorización, ¿está incompleta?</td>
                <td>No. Hay cadenas donde ese nivel se eliminó a propósito. En ellas la aprobación de gerencia es el último paso y la requisición avanza sola por el nivel vacío.</td>
            </tr>
            <tr>
                <td>¿Cuándo hace falta la última aprobación de Dirección General en una orden?</td>
                <td>Cuando el total supera <strong>$300,000 MXN</strong> o <strong>$15,000 USD</strong>. Por debajo de eso la orden queda autorizada en cuanto Dirección Administrativa la libera. Algunos proveedores están exentos de ese nivel.</td>
            </tr>
            <tr>
                <td>¿Qué es el flujo especial de una orden?</td>
                <td>La ruta corta que toma una orden cuando el proveedor está en la lista especial que define el gerente de compras: pasa directo a Dirección General, sin las aprobaciones intermedias ni el nivel de monto.</td>
            </tr>
            <tr>
                <td>¿Por qué mi requisición volvió al inicio sin que nadie la devolviera?</td>
                <td>Le reasignaron la cadena de aprobación, normalmente porque alguno de los firmantes quedó inactivo. Recibes un correo con la cadena anterior y la nueva.</td>
            </tr>
        </tbody>
    </table>

    <div class="closing">
        <strong>SA-TECH · Sistema de Compras</strong> — Guía de flujos de aprobación, versión 2.0,
        {{ $fecha }}. Generada a partir de la configuración de la página
        <strong>Flujo del proceso</strong>.<br>
        Las guías de <em>requisiciones</em>, <em>alta de productos y proyectos</em> y
        <em>órdenes de compra</em> están en la sección <strong>Guías de uso</strong> del menú lateral.
    </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

</body>

</html>
