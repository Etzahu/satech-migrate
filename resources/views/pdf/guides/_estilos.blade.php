{{-- Sistema de diseño de las guías en PDF.

     Hoja tamaño carta con el patrón del skill document-design: cada `.page` es
     una rejilla auto/1fr/auto (encabezado, cuerpo, pie), así que el pie nunca
     se encima con el contenido. La paleta sale de pdf-playground.local.md y los
     colores son los del logotipo de GPT Services.

     Las fuentes llegan incrustadas en `$fuentes` desde BuildGuidePdf: Chrome
     headless no espera a que Google Fonts responda y el PDF saldría en Arial. --}}
<style>{!! $fuentes !!}</style>
<style>
:root {
    --red: #D0112B;
    --red-dark: #8f0c1d;
    --yellow: #F7BE07;
    --navy: #162d4d;
    --white: #ffffff;
    --cream: #faf9f7;
    --gray-100: #f5f4f2;
    --gray-200: #e8e6e3;
    --gray-400: #9a9590;
    --gray-600: #5c5754;
    --gray-800: #343a40;
}

@page { size: letter; margin: 0; }

@media print {
    body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; background: white; }
    .page { page-break-after: always; page-break-inside: avoid; box-shadow: none; margin: 0; }
    .page:last-child { page-break-after: auto; }
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'Source Sans 3', Arial, sans-serif;
    font-size: 10pt;
    line-height: 1.45;
    color: var(--gray-800);
    background: var(--gray-200);
    counter-reset: pg 1;
}

.page {
    width: 8.5in;
    min-height: 11in;
    background: var(--white);
    margin: 0 auto 20px;
    display: grid;
    grid-template-rows: auto 1fr auto;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.12);
}

/* ── Portada ─────────────────────────────────────────────────────────── */
.cover {
    height: 11in;
    display: flex;
    flex-direction: column;
    background: linear-gradient(135deg, var(--red) 0%, var(--red-dark) 100%);
    color: var(--white);
    position: relative;
    overflow: hidden;
}

.cover::after {
    content: '';
    position: absolute;
    right: -1.6in; top: -1.6in;
    width: 5in; height: 5in;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}

.cover-header {
    padding: 0.55in 0.75in;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    position: relative;
    z-index: 2;
}

/* El logotipo es negro y rojo: sobre la portada necesita su placa blanca. */
.cover-logo-plate { background: var(--white); border-radius: 6px; padding: 0.11in 0.17in; line-height: 0; }
.cover-logo-plate img { height: 0.3in; display: block; }

.cover-date { font-size: 9pt; opacity: 0.85; text-align: right; padding-top: 0.06in; }

.cover-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 0 0.75in;
    position: relative;
    z-index: 2;
}

.cover-eyebrow {
    font-size: 9.5pt;
    font-weight: 600;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--yellow);
    margin-bottom: 0.18in;
}

.cover-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 48pt;
    font-weight: 800;
    line-height: 1.05;
    margin-bottom: 0.22in;
}

.cover-rule { width: 0.9in; height: 4px; background: var(--yellow); margin-bottom: 0.26in; }

.cover-subtitle { font-size: 15pt; opacity: 0.92; max-width: 5.2in; line-height: 1.45; }

.cover-lead { font-size: 11pt; opacity: 0.85; max-width: 5in; margin-top: 0.25in; line-height: 1.6; }

.cover-footer {
    padding: 0.4in 0.75in 0.55in;
    border-top: 1px solid rgba(255,255,255,0.22);
    position: relative;
    z-index: 2;
    display: flex;
    gap: 0.6in;
}

.cover-meta-k {
    font-size: 7.5pt;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    opacity: 0.7;
    display: block;
    margin-bottom: 0.03in;
}

.cover-meta-v { font-size: 10pt; font-weight: 600; }

/* ── Páginas de contenido ────────────────────────────────────────────── */
.content-page { counter-increment: pg; }

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    padding: 0.5in 0.75in 0.09in;
    border-bottom: 1px solid var(--gray-200);
}

.page-header-left {
    font-size: 7.5pt;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--gray-400);
}

.page-header-right { font-family: 'Playfair Display', Georgia, serif; font-size: 8pt; color: var(--red); }

.page-body { padding: 0.22in 0.75in 0.26in; overflow: hidden; }

.page-footer {
    padding: 0.09in 0.75in 0.34in;
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    border-top: 1px solid var(--gray-200);
    background: var(--white);
}

.footer-left { font-size: 7.5pt; color: var(--gray-400); }

.footer-page {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 9pt;
    font-weight: 700;
    color: var(--red);
}

.footer-page::after { content: counter(pg); }

/* ── Títulos ─────────────────────────────────────────────────────────── */
.section-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 21pt;
    font-weight: 700;
    color: var(--navy);
    line-height: 1.1;
    margin-bottom: 0.12in;
}

.section-title::after {
    content: '';
    display: block;
    width: 0.5in;
    height: 3px;
    background: var(--red);
    margin-top: 0.1in;
}

.continues {
    font-size: 8pt;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--gray-400);
    border-bottom: 1px solid var(--gray-200);
    padding-bottom: 0.07in;
    margin-bottom: 0.16in;
}

h3 {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 12pt;
    font-weight: 700;
    color: var(--navy);
    margin: 0.15in 0 0.06in;
}

h3:first-child { margin-top: 0; }

.lead-text { font-size: 11pt; line-height: 1.4; color: var(--gray-600); margin-bottom: 0.13in; }

p { margin-bottom: 0.09in; }
p:last-child { margin-bottom: 0; }

code {
    font-family: 'Consolas', 'Courier New', monospace;
    font-size: 8.5pt;
    background: var(--gray-100);
    border: 1px solid var(--gray-200);
    border-radius: 2px;
    padding: 0 3px;
    color: var(--red-dark);
    white-space: nowrap;
}

strong { color: var(--navy); font-weight: 600; }

.muted { color: var(--gray-600); }

/* El botón de radio se dibuja con CSS: ese glifo no está en la fuente. */
.radio {
    display: inline-block;
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: var(--red);
    box-shadow: inset 0 0 0 2px var(--white);
}

/* ── Tablas ──────────────────────────────────────────────────────────── */
table.data {
    width: 100%;
    border-collapse: collapse;
    margin: 0.08in 0 0.12in;
    font-size: 8.5pt;
    line-height: 1.38;
}

table.data th {
    background: var(--navy);
    color: var(--white);
    padding: 0.05in 0.08in;
    text-align: left;
    font-weight: 600;
    font-size: 8pt;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

table.data td {
    padding: 0.045in 0.08in;
    border-bottom: 1px solid var(--gray-200);
    vertical-align: top;
}

table.data tbody tr:nth-child(even) td { background: var(--cream); }

table.data td.center { text-align: center; }

/* ── Avisos ──────────────────────────────────────────────────────────── */
.note {
    border-left: 4px solid var(--red);
    background: var(--cream);
    padding: 0.11in 0.15in;
    margin: 0.11in 0;
    font-size: 9pt;
    line-height: 1.42;
}

.note-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 11pt;
    font-weight: 700;
    color: var(--red);
    display: block;
    margin-bottom: 0.05in;
}

.note p { margin-bottom: 0.08in; }
.note p:last-child { margin-bottom: 0; }

.note.warn { border-left-color: var(--yellow); }
.note.warn .note-title { color: #a37a00; }
.note.info { border-left-color: var(--navy); }
.note.info .note-title { color: var(--navy); }
.note.ok { border-left-color: #2f7d32; }
.note.ok .note-title { color: #2f7d32; }

/* ── Pasos y listas ──────────────────────────────────────────────────── */
ol.steps { counter-reset: st; list-style: none; margin: 0.08in 0 0.12in; }

ol.steps li {
    counter-increment: st;
    position: relative;
    padding: 0 0 0.055in 0.3in;
    font-size: 9.5pt;
}

ol.steps li::before {
    content: counter(st);
    position: absolute;
    left: 0; top: 0.01in;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 10pt;
    font-weight: 700;
    color: var(--red);
}

ul.bullets { margin: 0.06in 0 0.12in; padding-left: 0.2in; font-size: 9.5pt; }
ul.bullets li { margin-bottom: 0.035in; }

/* ── Chips de estado ─────────────────────────────────────────────────── */
.chip {
    display: inline-block;
    font-size: 7.5pt;
    font-weight: 600;
    letter-spacing: 0.03em;
    padding: 1px 6px;
    border-radius: 2px;
    white-space: nowrap;
    border: 1px solid;
}

.c-gray   { background: var(--gray-100); color: var(--gray-600); border-color: var(--gray-200); }
.c-yellow { background: #fef6dc; color: #8a6900; border-color: #f4dc9a; }
.c-navy   { background: #e7ecf3; color: var(--navy); border-color: #c2cfdf; }
.c-green  { background: #e6f2e7; color: #2f7d32; border-color: #bcdcbe; }
.c-red    { background: #fbe7ea; color: var(--red-dark); border-color: #f0c0c8; }
.c-violet { background: #eee9f7; color: #5b21b6; border-color: #cfc2e8; }

/* ── Cajas de dos columnas ───────────────────────────────────────────── */
.duo { display: grid; grid-template-columns: 1fr 1fr; gap: 0.15in; margin: 0.1in 0 0.12in; }

.duo-card { border-top: 3px solid var(--red); background: var(--cream); padding: 0.12in 0.14in; }
.duo-card.alt { border-top-color: var(--navy); }
.duo-card.warnc { border-top-color: var(--yellow); }
.duo-card.okc { border-top-color: #2f7d32; }

.duo-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 11.5pt;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 0.03in;
}

.duo-sub { font-size: 8pt; color: var(--gray-600); text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 0.08in; }

.duo-card ul { padding-left: 0.16in; font-size: 8.5pt; line-height: 1.4; }
.duo-card li { margin-bottom: 0.04in; }

/* ── Recorrido paso a paso ───────────────────────────────────────────── */
.step-row {
    display: grid;
    grid-template-columns: 0.42in 1fr;
    gap: 0.1in;
    padding: 0.075in 0;
    border-bottom: 1px solid var(--gray-200);
}

.step-row:last-child { border-bottom: none; }

.step-num {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 19pt;
    font-weight: 700;
    color: var(--gray-200);
    line-height: 1;
    text-align: right;
}

.step-head { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.03in; gap: 0.15in; }

.step-name { font-family: 'Playfair Display', Georgia, serif; font-size: 11.5pt; font-weight: 700; color: var(--navy); }

.step-who { font-size: 8pt; color: var(--gray-400); text-transform: uppercase; letter-spacing: 0.06em; text-align: right; white-space: nowrap; }

.step-body { font-size: 9pt; line-height: 1.42; }
.step-body p { margin-bottom: 0.04in; }

.step-mail { display: block; margin-top: 0.03in; font-size: 8pt; color: var(--red-dark); }

/* ── Anatomía del folio ──────────────────────────────────────────────── */
.folio {
    background: var(--navy);
    padding: 0.22in 0.2in 0.16in;
    text-align: center;
    margin: 0.14in 0 0.16in;
}

.folio-code {
    font-family: 'Consolas', 'Courier New', monospace;
    font-size: 24pt;
    font-weight: 700;
    letter-spacing: 0.06em;
    color: var(--white);
}

.folio-code .p1 { color: var(--yellow); }
.folio-code .p2 { color: #8fb8ff; }
.folio-code .p3 { color: #9fe6a8; }
.folio-code .p4 { color: #ffb3c6; }

.folio-legend { display: grid; grid-template-columns: repeat(4, 1fr); margin-top: 0.12in; }
.folio-legend div { font-size: 7.5pt; color: rgba(255,255,255,0.7); line-height: 1.35; padding: 0 0.04in; }
.folio-legend b { display: block; font-size: 8pt; margin-bottom: 0.01in; }
.folio-legend div:nth-child(1) b { color: var(--yellow); }
.folio-legend div:nth-child(2) b { color: #8fb8ff; }
.folio-legend div:nth-child(3) b { color: #9fe6a8; }
.folio-legend div:nth-child(4) b { color: #ffb3c6; }

/* ── Índice ──────────────────────────────────────────────────────────── */
.toc-row { display: grid; grid-template-columns: 0.32in 1fr; padding: 0.055in 0; border-bottom: 1px solid var(--gray-200); }
.toc-n { font-family: 'Playfair Display', Georgia, serif; font-size: 11pt; font-weight: 700; color: var(--red); }
.toc-t { font-size: 10pt; font-weight: 600; color: var(--navy); }
.toc-d { font-size: 8.5pt; color: var(--gray-600); line-height: 1.35; }

/* ── Barra de avance ─────────────────────────────────────────────────── */
.bar { display: inline-block; width: 0.42in; height: 5px; background: var(--gray-200); vertical-align: middle; margin-right: 0.05in; }
.bar span { display: block; height: 5px; background: var(--red); }

/* ── Ruta del flujo ──────────────────────────────────────────────────── */
.ruta { margin: 0.08in 0 0.12in; }

.ruta .paso {
    display: inline-block;
    font-size: 8.5pt;
    font-weight: 600;
    color: var(--navy);
    background: var(--cream);
    border: 1px solid var(--gray-200);
    padding: 0.03in 0.07in;
    margin: 0 0.015in 0.04in 0;
}

.ruta .flecha { display: inline-block; color: var(--red); font-weight: 700; margin: 0 0.015in 0.04in 0; }

/* ── Cierre ──────────────────────────────────────────────────────────── */
.closing { border-top: 3px solid var(--red); padding-top: 0.14in; margin-top: 0.2in; font-size: 9pt; color: var(--gray-600); line-height: 1.5; }
</style>
