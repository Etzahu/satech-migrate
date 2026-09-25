{{--
    Armazón común de las páginas de error.

    Cada vista hija fija cuatro variables antes de `@extends` y rellena las
    secciones. Todo va en línea (CSS y JS) porque estas páginas se sirven
    cuando la aplicación puede estar caída: sin Vite, sin CDN, sin red.

    @var string $code   Código HTTP. Sale en el módulo de estado y en el numeral del panel.
    @var string $state  Rótulo corto del estado.
    @var string $tone   'live' (ámbar, late), 'fault' (rojo) o 'idle' (neutro).
    @var string $line   Estado de la tubería: 'open', 'closed', 'capped', 'uncoupled' o 'broken'.
--}}
@php
    $tone ??= 'idle';
    $line ??= 'open';
    $hot = $line === 'broken';
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#f6f7f8" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#101215" media="(prefers-color-scheme: dark)">
    <title>@yield('title') | SA-TECH</title>
    <link rel="icon" href="/favicon.png">

    <style>
        /* ═══ Tokens ══════════════════════════════════════════════════════
           Un solo acento (el rojo de marca) con una variante por modo, para
           mantener el contraste AA sin cambiar de color. Radio único de 2px
           en toda la página: lenguaje técnico, nada de mezclar píldoras y
           tarjetas redondeadas. */
        :root {
            color-scheme: light dark;

            --surface: #f6f7f8;
            --ink: #15171b;
            --ink-muted: #565d66;
            --ink-faint: #7b828b;
            --line: rgba(21, 23, 27, .14);
            --line-soft: rgba(21, 23, 27, .07);

            --accent: #c8102e;
            --accent-ink: #ffffff;
            --signal: #b07c00;

            --panel: #15171b;
            --panel-line: rgba(255, 255, 255, .13);

            --radius: 2px;
            --ease: cubic-bezier(.16, 1, .3, 1);
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --surface: #101215;
                --ink: #e9ebee;
                --ink-muted: #969ca4;
                --ink-faint: #6e757d;
                --line: rgba(255, 255, 255, .13);
                --line-soft: rgba(255, 255, 255, .07);

                --accent: #e3173e;
                --accent-ink: #ffffff;
                --signal: #f6be00;

                --panel: #0b0d10;
                --panel-line: rgba(255, 255, 255, .11);
            }
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            height: 100%;
        }

        body {
            margin: 0;
            min-height: 100dvh;
            background: var(--surface);
            color: var(--ink);
            font-family: "Open Sans", "Segoe UI", system-ui, -apple-system, "Helvetica Neue", Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* Los datos técnicos van en monoespaciada: código, reloj, referencia. */
        .mono {
            font-family: ui-monospace, "Cascadia Mono", "Segoe UI Mono", "SF Mono", Consolas, "Liberation Mono", monospace;
            font-variant-numeric: tabular-nums;
        }

        ::selection {
            background: var(--accent);
            color: var(--accent-ink);
        }

        /* ═══ Estructura asimétrica 7/5, a sangre por la derecha ═══════════ */
        .page {
            min-height: 100dvh;
            display: grid;
            grid-template-columns: minmax(0, 7fr) minmax(0, 5fr);
        }

        .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
            padding: clamp(32px, 5vw, 76px) clamp(24px, 5vw, 88px);
        }

        .content__inner {
            width: 100%;
            min-width: 0;
            max-width: 34rem;
        }

        /* ═══ Entrada en cascada ══════════════════════════════════════════ */
        .reveal {
            opacity: 0;
            transform: translateY(14px);
            animation: reveal 620ms var(--ease) forwards;
            animation-delay: calc(var(--i, 0) * 70ms);
        }

        @keyframes reveal {
            to {
                opacity: 1;
                transform: none;
            }
        }

        /* ═══ Marca ═══════════════════════════════════════════════════════ */
        .brand {
            display: flex;
            align-items: baseline;
            gap: 10px;
            margin: 0 0 clamp(36px, 6vw, 60px);
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .brand__sa {
            color: var(--accent);
        }

        .brand__note {
            font-size: 13px;
            font-weight: 400;
            letter-spacing: 0;
            color: var(--ink-faint);
        }

        /* ═══ Módulo de estado ════════════════════════════════════════════
           Una sola pieza: qué pasa, qué código es y, cuando lo hay, cuánto
           falta. Agrupada con filetes, sin tarjeta flotante. */
        .status {
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            padding: 14px 0;
        }

        .status__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .status__state {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        /* Único punto de color de la página. Solo late cuando hay algo en
           curso al otro lado; si late siempre deja de significar nada. */
        .status__dot {
            position: relative;
            width: 8px;
            height: 8px;
            flex: none;
            background: var(--ink-faint);
        }

        .status__dot--live {
            background: var(--signal);
        }

        .status__dot--fault {
            background: var(--accent);
        }

        .status__dot--live::after {
            content: "";
            position: absolute;
            inset: 0;
            background: inherit;
            animation: signal 2.6s var(--ease) infinite;
        }

        @keyframes signal {
            0% {
                opacity: .75;
                transform: scale(1);
            }

            70%,
            100% {
                opacity: 0;
                transform: scale(3);
            }
        }

        .status__code {
            font-size: 12px;
            letter-spacing: .08em;
            color: var(--ink-faint);
        }

        .status__clock {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 16px;
            margin-top: 12px;
        }

        .status__label {
            font-size: 13px;
            color: var(--ink-muted);
        }

        .status__time {
            font-size: 22px;
            font-weight: 600;
            letter-spacing: -.01em;
        }

        /* Filete de 1px, sin canal de fondo relleno. */
        .status__rule {
            position: relative;
            height: 1px;
            margin-top: 12px;
            background: var(--line-soft);
        }

        .status__rule::after {
            content: "";
            position: absolute;
            inset: 0;
            background: var(--accent);
            transform-origin: left center;
            transform: scaleX(0);
            animation: elapse var(--duration, 60s) linear forwards;
        }

        @keyframes elapse {
            to {
                transform: scaleX(1);
            }
        }

        /* ═══ Mensaje ═════════════════════════════════════════════════════ */
        .headline {
            margin: clamp(28px, 5vw, 40px) 0 0;
            font-size: clamp(34px, 5.2vw, 56px);
            font-weight: 700;
            line-height: 1.04;
            letter-spacing: -.035em;
            text-wrap: balance;
        }

        .lede {
            margin: 18px 0 0;
            max-width: 46ch;
            color: var(--ink-muted);
            text-wrap: pretty;
        }

        /* ═══ Detalle técnico (solo con APP_DEBUG) ════════════════════════ */
        .trace {
            margin: 24px 0 0;
            padding: 14px 16px;
            border: 1px solid var(--line);
            border-left: 1px solid var(--line);
            border-radius: var(--radius);
            background: var(--line-soft);
            overflow-x: auto;
        }

        .trace__type {
            margin: 0;
            overflow-wrap: anywhere;
            font-size: 13px;
            font-weight: 700;
            color: var(--accent);
        }

        .trace__message {
            margin: 6px 0 0;
            overflow-wrap: anywhere;
            font-size: 13px;
            color: var(--ink);
        }

        .trace__where {
            margin: 10px 0 0;
            font-size: 12px;
            color: var(--ink-muted);
            white-space: nowrap;
        }

        /* ═══ Acciones ════════════════════════════════════════════════════ */
        .actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px 24px;
            margin-top: clamp(28px, 5vw, 40px);
        }

        .btn {
            position: relative;
            display: inline-block;
            overflow: hidden;
            isolation: isolate;
            padding: 13px 26px;
            border: 0;
            border-radius: var(--radius);
            background: var(--accent);
            color: var(--accent-ink);
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .02em;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
            transition: transform 140ms var(--ease);
        }

        /* Relleno que entra por el borde exacto donde llegó el puntero. */
        .btn::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            z-index: -1;
            width: 260%;
            aspect-ratio: 1;
            border-radius: 50%;
            background: rgba(255, 255, 255, .17);
            transform: translate(-50%, -50%) scale(0);
            transform-origin: var(--ox, 50%) var(--oy, 50%);
            transition: transform 420ms var(--ease);
        }

        .btn:active {
            transform: translateY(1px);
        }

        /* Barra indeterminada al pie del botón en lugar de un spinner genérico. */
        .btn__progress {
            position: absolute;
            inset: auto 0 0 0;
            height: 2px;
            overflow: hidden;
            opacity: 0;
            transition: opacity 160ms linear;
        }

        .btn__progress::after {
            content: "";
            position: absolute;
            inset: 0;
            background: var(--accent-ink);
            transform: translateX(-100%);
        }

        .btn[data-busy] {
            pointer-events: none;
        }

        .btn[data-busy] .btn__progress {
            opacity: .85;
        }

        .btn[data-busy] .btn__progress::after {
            animation: indeterminate 900ms var(--ease) infinite;
        }

        @keyframes indeterminate {
            to {
                transform: translateX(100%);
            }
        }

        .quiet {
            color: var(--ink-muted);
            font-size: 14px;
            font-weight: 600;
            text-decoration: underline;
            text-decoration-color: var(--line);
            text-underline-offset: 5px;
            transition: color 180ms var(--ease), text-decoration-color 180ms var(--ease);
        }

        @media (hover: hover) and (pointer: fine) {
            .btn:hover::before {
                transform: translate(-50%, -50%) scale(1);
            }

            .quiet:hover {
                color: var(--ink);
                text-decoration-color: currentColor;
            }
        }

        :focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 3px;
        }

        /* ═══ Pie ═════════════════════════════════════════════════════════ */
        .foot {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 18px;
            margin-top: clamp(40px, 7vw, 72px);
            padding-top: 18px;
            border-top: 1px solid var(--line-soft);
            font-size: 12px;
            color: var(--ink-faint);
        }

        .foot span + span {
            padding-left: 18px;
            border-left: 1px solid var(--line-soft);
        }

        /* ═══ Panel de marca ══════════════════════════════════════════════
           Superficie oscura en ambos modos, como se comporta una fotografía.
           Si existe /images/error-panel.jpg queda de fondo tratada; si no,
           el degradado de marca la sustituye sin dejar hueco. */
        .panel {
            position: relative;
            overflow: hidden;
            background-color: var(--panel);
            background-image:
                linear-gradient(200deg, rgba(200, 16, 46, .5), rgba(11, 13, 16, .94) 62%),
                url('/images/error-panel.jpg');
            background-size: cover;
            background-position: center;
        }

        .panel__grid {
            position: absolute;
            inset: -1px;
            background-image:
                linear-gradient(to right, var(--panel-line) 1px, transparent 1px),
                linear-gradient(to bottom, var(--panel-line) 1px, transparent 1px);
            background-size: 72px 72px;
            opacity: .5;
        }

        /* La tubería es el mismo dibujo en las cuatro páginas, declinado:
           válvula abierta con producto pasando (503), válvula cerrada (403),
           línea ciega (404), brida desacoplada (419) y línea rota (500). El
           oficio de la casa es
           intervenir tuberías, así que el estado del servicio se cuenta con
           una tubería. */
        .panel__line {
            position: absolute;
            top: 50%;
            left: clamp(22px, 4vw, 52px);
            right: clamp(22px, 4vw, 52px);
            max-width: 430px;
            margin-inline: auto;
            transform: translateY(-50%);
        }

        .panel__flow {
            animation: flow 1.15s linear infinite;
        }

        @keyframes flow {
            to {
                stroke-dashoffset: -20;
            }
        }

        .panel__code {
            position: absolute;
            right: clamp(-10px, -1vw, 0px);
            bottom: clamp(-18px, -2vw, 0px);
            font-size: clamp(120px, 20vw, 240px);
            font-weight: 700;
            line-height: .78;
            letter-spacing: -.06em;
            color: rgba(255, 255, 255, .08);
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0 0 0 0);
            white-space: nowrap;
        }

        /* ═══ Colapso móvil explícito ═════════════════════════════════════ */
        @media (max-width: 900px) {
            .page {
                grid-template-columns: minmax(0, 1fr);
                grid-template-rows: 1fr auto;
            }

            .content {
                padding: clamp(40px, 9vw, 64px) 24px;
            }

            .panel {
                min-height: 188px;
            }

            /* En banda el numeral chocaba con la válvula, y el módulo de estado
               ya dice el código unos centímetros más arriba. */
            .panel__code {
                display: none;
            }
        }

        /* ═══ Movimiento reducido ═════════════════════════════════════════ */
        @media (prefers-reduced-motion: reduce) {

            .status__dot--live::after,
            .panel__flow,
            .btn[data-busy] .btn__progress::after {
                animation: none;
            }

            .reveal {
                animation: appear 180ms linear forwards;
                animation-delay: calc(var(--i, 0) * 30ms);
            }

            @keyframes appear {
                to {
                    opacity: 1;
                    transform: none;
                }
            }

            .btn,
            .btn::before,
            .quiet {
                transition-duration: 1ms;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <section class="content">
            <div class="content__inner">
                <p class="brand reveal" style="--i:0">
                    <span><span class="brand__sa">SA</span>TECH</span>
                    <span class="brand__note">Sistema de Administración</span>
                </p>

                <div class="status reveal" style="--i:1">
                    <div class="status__head">
                        <span class="status__state">
                            <span class="status__dot status__dot--{{ $tone }}" aria-hidden="true"></span>
                            {{ $state }}
                        </span>
                        <span class="status__code mono">HTTP {{ $code }}</span>
                    </div>

                    @yield('status-extra')
                </div>

                <h1 class="headline reveal" style="--i:2">@yield('headline')</h1>

                <p class="lede reveal" style="--i:3">@yield('lede')</p>

                @hasSection('trace')
                    <div class="reveal" style="--i:4">@yield('trace')</div>
                @endif

                <div class="actions reveal" style="--i:5">
                    @section('actions')
                        <a class="btn" href="{{ route('login') }}">Volver al inicio</a>
                        <a class="quiet" href="mailto:ahernandezm@gptservices.com?subject=Error%20{{ $code }}%20en%20SA-TECH">
                            Escribir a soporte
                        </a>
                    @show
                </div>

                <p class="foot reveal" style="--i:6">
                    <span>GPT Services</span>
                    <span>Ingeniería y manufactura</span>
                </p>
            </div>
        </section>

        <aside class="panel" aria-hidden="true">
            <div class="panel__grid"></div>

            <svg class="panel__line" viewBox="0 0 300 82" fill="none" focusable="false">
                <defs>
                    <linearGradient id="wall" x1="0" x2="300" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="#fff" stop-opacity="0" />
                        <stop offset=".16" stop-color="#fff" stop-opacity=".26" />
                        <stop offset=".84" stop-color="#fff" stop-opacity=".26" />
                        <stop offset="1" stop-color="#fff" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="stream" x1="0" x2="300" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="#fff" stop-opacity="0" />
                        <stop offset=".24" stop-color="#fff" stop-opacity=".85" />
                        <stop offset=".7" stop-color="#f6be00" stop-opacity=".95" />
                        <stop offset="1" stop-color="#f6be00" stop-opacity="0" />
                    </linearGradient>
                    <radialGradient id="halo" cx=".5" cy=".5" r=".5">
                        <stop offset="0" stop-color="{{ $hot ? '#e3173e' : '#f6be00' }}" stop-opacity=".2" />
                        <stop offset="1" stop-color="{{ $hot ? '#e3173e' : '#f6be00' }}" stop-opacity="0" />
                    </radialGradient>
                </defs>

                @switch($line)
                    {{-- 503: válvula abierta, el producto sigue circulando mientras se interviene. --}}
                    @case('open')
                        <ellipse cx="150" cy="56" rx="95" ry="28" fill="url(#halo)" />
                        <path d="M0 46h300M0 66h300" stroke="url(#wall)" stroke-width="1.5" />
                        <path class="panel__flow" d="M0 56h300" stroke="url(#stream)" stroke-width="4"
                            stroke-linecap="round" stroke-dasharray="1.5 18.5" />
                        <path d="M120 42v28M180 42v28" stroke="#fff" stroke-opacity=".28" stroke-width="1.8"
                            stroke-linecap="round" />
                        <path d="M126 43v26l24-13zM174 43v26l-24-13z" fill="#0c0e11" stroke="#f6be00"
                            stroke-width="2.2" stroke-linejoin="round" />
                        <path d="M150 56V28M137 28h26" stroke="#f6be00" stroke-width="2.2" stroke-linecap="round" />
                        @break

                    {{-- 403: la línea está sana, la compuerta está cerrada. El producto
                         llega hasta la válvula y ahí se detiene. --}}
                    @case('closed')
                        <ellipse cx="110" cy="56" rx="95" ry="28" fill="url(#halo)" />
                        <path d="M0 46h300M0 66h300" stroke="url(#wall)" stroke-width="1.5" />
                        <path class="panel__flow" d="M0 56h118" stroke="url(#stream)" stroke-width="4"
                            stroke-linecap="round" stroke-dasharray="1.5 18.5" />
                        <path d="M120 42v28M180 42v28" stroke="#fff" stroke-opacity=".28" stroke-width="1.8"
                            stroke-linecap="round" />
                        <path d="M126 43v26l24-13zM174 43v26l-24-13z" fill="#f6be00" fill-opacity=".88"
                            stroke="#f6be00" stroke-width="2.2" stroke-linejoin="round" />
                        <path d="M150 56V28M137 28h26" stroke="#f6be00" stroke-width="2.2" stroke-linecap="round" />
                        @break

                    {{-- 404: brida ciega. La línea termina aquí; lo que sigue es el
                         trazo fantasma de algo que no existe. --}}
                    @case('capped')
                        <ellipse cx="96" cy="56" rx="95" ry="28" fill="url(#halo)" />
                        <path d="M0 46h150M0 66h150" stroke="url(#wall)" stroke-width="1.5" />
                        <path d="M158 46h142M158 66h142" stroke="#fff" stroke-opacity=".12" stroke-width="1.5"
                            stroke-dasharray="3 7" />
                        <path class="panel__flow" d="M0 56h140" stroke="url(#stream)" stroke-width="4"
                            stroke-linecap="round" stroke-dasharray="1.5 18.5" />
                        <path d="M150 38v36" stroke="#f6be00" stroke-width="5" stroke-linecap="round" />
                        <path d="M140 42v28" stroke="#fff" stroke-opacity=".28" stroke-width="1.8"
                            stroke-linecap="round" />
                        @break

                    {{-- 419: desacople. La línea no está rota, se soltó por la brida.
                         Los dos tramos siguen alineados; solo hay que volver a unirlos. --}}
                    @case('uncoupled')
                        <ellipse cx="96" cy="56" rx="95" ry="28" fill="url(#halo)" />
                        <path d="M0 46h130M0 66h130" stroke="url(#wall)" stroke-width="1.5" />
                        <path d="M178 46h122M178 66h122" stroke="url(#wall)" stroke-width="1.5" />
                        <path class="panel__flow" d="M0 56h122" stroke="url(#stream)" stroke-width="4"
                            stroke-linecap="round" stroke-dasharray="1.5 18.5" />
                        <path d="M130 36v40M178 36v40" stroke="#f6be00" stroke-width="5"
                            stroke-linecap="round" />
                        @break

                    {{-- 500: rotura. Los dos tramos ya no casan y el producto se
                         interrumpe en el corte. --}}
                    @case('broken')
                        <ellipse cx="150" cy="58" rx="80" ry="30" fill="url(#halo)" />
                        <path d="M0 46h134M0 66h134" stroke="url(#wall)" stroke-width="1.5" />
                        <path d="M166 56h134M166 76h134" stroke="url(#wall)" stroke-width="1.5" />
                        <path class="panel__flow" d="M0 56h126" stroke="url(#stream)" stroke-width="4"
                            stroke-linecap="round" stroke-dasharray="1.5 18.5" />
                        <path d="M134 44l-5 6 5 6-5 6 5 6" stroke="#e3173e" stroke-width="2.2"
                            stroke-linejoin="round" stroke-linecap="round" />
                        <path d="M166 54l5 6-5 6 5 6-5 6" stroke="#e3173e" stroke-width="2.2"
                            stroke-linejoin="round" stroke-linecap="round" />
                        @break
                @endswitch
            </svg>

            <span class="panel__code mono">{{ $code }}</span>
        </aside>
    </div>

    <script>
        (function () {
            var retry = document.querySelector('[data-retry]');

            function reload() {
                if (retry) {
                    retry.setAttribute('data-busy', '');
                }

                window.location.reload();
            }

            if (retry) {
                retry.addEventListener('click', reload);
            }

            // El relleno del botón arranca en el punto exacto por donde entró el puntero.
            document.querySelectorAll('.btn').forEach(function (btn) {
                btn.addEventListener('pointerenter', function (event) {
                    var box = btn.getBoundingClientRect();
                    var x = ((event.clientX - box.left) / box.width) * 100;
                    var y = ((event.clientY - box.top) / box.height) * 100;

                    btn.style.setProperty('--ox', x.toFixed(1) + '%');
                    btn.style.setProperty('--oy', y.toFixed(1) + '%');
                });
            });

            // La cuenta atrás se mide contra un instante fijo: si la pestaña pasa a
            // segundo plano el navegador frena los temporizadores, pero al volver el
            // tiempo mostrado sigue siendo el correcto.
            var clock = document.querySelector('[data-countdown]');

            if (clock) {
                var deadline = Date.now() + parseInt(clock.dataset.countdown, 10) * 1000;
                var timer;

                var tick = function () {
                    var left = Math.max(0, Math.round((deadline - Date.now()) / 1000));

                    clock.textContent = ('0' + Math.floor(left / 60)).slice(-2) + ':' + ('0' + (left % 60)).slice(-2);

                    if (left === 0) {
                        clearInterval(timer);
                        reload();
                    }
                };

                tick();
                timer = setInterval(tick, 1000);
            }

            // Al volver con el botón "atrás" el navegador sirve la página desde su
            // caché: se recarga para comprobar si el servicio ya está disponible.
            window.addEventListener('pageshow', function (event) {
                if (event.persisted) {
                    window.location.reload();
                }
            });
        })();
    </script>
</body>

</html>
