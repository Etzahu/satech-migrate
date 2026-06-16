{{-- Estilos del diagrama de flujo de proceso.
     Fuente única usada por la página interactiva (process-flow.blade.php)
     y por la vista de exportación a PDF (pdf/process-flow.blade.php). --}}
<style>
    .fd-stage {
        --fd-canvas-bg: #fafafa;
        --fd-dot: #e2e8f0;
        --fd-card: #ffffff;
        --fd-title: #1f2937;
        --fd-actor: #6b7280;
        --fd-halo: #fafafa;
        --fd-forward: #475569;
        --fd-alt: #94a3b8;
        --fd-start: #64748b;   --fd-start-soft: #f8fafc;   --fd-start-line: #cbd5e1;
        --fd-review: #3b82f6;  --fd-review-soft: #eff6ff;  --fd-review-line: #93c5fd;
        --fd-approval: #22c55e;--fd-approval-soft: #f0fdf4;--fd-approval-line: #86efac;
        --fd-purchase: #06b6d4;--fd-purchase-soft: #ecfeff;--fd-purchase-line: #67e8f9;
        --fd-final: #10b981;   --fd-final-soft: #ecfdf5;   --fd-final-line: #6ee7b7;
        --fd-cancel: #ef4444;  --fd-cancel-soft: #fef2f2;  --fd-cancel-line: #fca5a5;
        --fd-return: #f59e0b;  --fd-return-soft: #fffbeb;  --fd-return-line: #fcd34d;
        --fd-special: #8b5cf6; --fd-special-soft: #f5f3ff; --fd-special-line: #c4b5fd;
    }

    .dark .fd-stage {
        --fd-canvas-bg: #0b1120;
        --fd-dot: #1e293b;
        --fd-card: #111827;
        --fd-title: #f3f4f6;
        --fd-actor: #9ca3af;
        --fd-halo: #0b1120;
        --fd-forward: #94a3b8;
        --fd-alt: #64748b;
        --fd-start-soft: #1e293b;   --fd-start-line: #475569;
        --fd-review-soft: #172554;  --fd-review-line: #1e40af;
        --fd-approval-soft: #052e16;--fd-approval-line: #166534;
        --fd-purchase-soft: #083344;--fd-purchase-line: #155e75;
        --fd-final-soft: #022c22;   --fd-final-line: #065f46;
        --fd-cancel-soft: #450a0a;  --fd-cancel-line: #991b1b;
        --fd-return-soft: #451a03;  --fd-return-line: #92400e;
        --fd-special-soft: #2e1065; --fd-special-line: #5b21b6;
    }

    .fd-canvas {
        background-color: var(--fd-canvas-bg);
        background-image: radial-gradient(var(--fd-dot) 1.5px, transparent 1.5px);
        background-size: 26px 26px;
        max-height: 72vh;
    }

    .fd-svg { display: block; width: 100%; height: 100%; cursor: grab; }
    .fd-svg:active { cursor: grabbing; }

    /* ── Nodos ─────────────────────────────────────────────────────── */
    .fd-node { cursor: pointer; transition: opacity .25s ease; }
    .fd-node.fd-dim { opacity: .18; }
    .fd-node__card {
        fill: var(--fd-card);
        stroke-width: 1.5;
        filter: drop-shadow(0 2px 3px rgb(0 0 0 / .10));
        transition: stroke-width .15s ease;
    }
    .fd-node:hover .fd-node__card, .fd-node.fd-selected .fd-node__card { stroke-width: 3; }
    .fd-node__title { font-size: 12.5px; font-weight: 700; fill: var(--fd-title); }
    .fd-node__actor { font-size: 10px; fill: var(--fd-actor); }
    .fd-node__icon { font-size: 15px; }
    .fd-node__pilltext { font-size: 10px; font-weight: 700; fill: #ffffff; }

    .fd-node--start .fd-node__card    { stroke: var(--fd-start-line); }
    .fd-node--review .fd-node__card   { stroke: var(--fd-review-line); }
    .fd-node--approval .fd-node__card { stroke: var(--fd-approval-line); }
    .fd-node--purchase .fd-node__card { stroke: var(--fd-purchase-line); }
    .fd-node--final .fd-node__card    { stroke: var(--fd-final-line); }
    .fd-node--cancel .fd-node__card   { stroke: var(--fd-cancel-line); }
    .fd-node--return .fd-node__card   { stroke: var(--fd-return-line); }
    .fd-node--special .fd-node__card  { stroke: var(--fd-special-line); }

    .fd-node--start .fd-node__accent, .fd-node--start .fd-node__pill       { fill: var(--fd-start); }
    .fd-node--review .fd-node__accent, .fd-node--review .fd-node__pill     { fill: var(--fd-review); }
    .fd-node--approval .fd-node__accent, .fd-node--approval .fd-node__pill { fill: var(--fd-approval); }
    .fd-node--purchase .fd-node__accent, .fd-node--purchase .fd-node__pill { fill: var(--fd-purchase); }
    .fd-node--final .fd-node__accent, .fd-node--final .fd-node__pill       { fill: var(--fd-final); }
    .fd-node--cancel .fd-node__accent, .fd-node--cancel .fd-node__pill     { fill: var(--fd-cancel); }
    .fd-node--return .fd-node__accent, .fd-node--return .fd-node__pill     { fill: var(--fd-return); }
    .fd-node--special .fd-node__accent, .fd-node--special .fd-node__pill   { fill: var(--fd-special); }

    .fd-node--start .fd-node__iconbg    { fill: var(--fd-start-soft); }
    .fd-node--review .fd-node__iconbg   { fill: var(--fd-review-soft); }
    .fd-node--approval .fd-node__iconbg { fill: var(--fd-approval-soft); }
    .fd-node--purchase .fd-node__iconbg { fill: var(--fd-purchase-soft); }
    .fd-node--final .fd-node__iconbg    { fill: var(--fd-final-soft); }
    .fd-node--cancel .fd-node__iconbg   { fill: var(--fd-cancel-soft); }
    .fd-node--return .fd-node__iconbg   { fill: var(--fd-return-soft); }
    .fd-node--special .fd-node__iconbg  { fill: var(--fd-special-soft); }

    /* ── Transiciones ──────────────────────────────────────────────── */
    .fd-edge { fill: none; stroke-width: 2; transition: opacity .25s ease, stroke-width .15s ease; }
    .fd-edge.fd-dim { opacity: .08; }
    .fd-edge--active { stroke-width: 3.2 !important; }
    .fd-edge--forward { stroke: var(--fd-forward); stroke-width: 2.2; }
    .fd-edge--main { stroke-dasharray: 9 5; animation: fd-dash 1.1s linear infinite; stroke-width: 2.6; }
    .fd-edge--alt { stroke: var(--fd-alt); stroke-dasharray: 4 4; stroke-width: 1.8; }
    .fd-edge--cancel { stroke: var(--fd-cancel); }
    .fd-edge--return { stroke: var(--fd-return); stroke-dasharray: 7 5; }
    .fd-edge--rail { stroke-width: 2.4; }
    .fd-edge--special { stroke: var(--fd-special); stroke-dasharray: 1 6; stroke-linecap: round; stroke-width: 2.4; }
    .fd-busdot { fill: var(--fd-return); }

    @keyframes fd-dash { to { stroke-dashoffset: -14; } }
    @media (prefers-reduced-motion: reduce) { .fd-edge--main { animation: none; } }

    .fd-marker--forward { fill: var(--fd-forward); }
    .fd-marker--alt { fill: var(--fd-alt); }
    .fd-marker--cancel { fill: var(--fd-cancel); }
    .fd-marker--return { fill: var(--fd-return); }
    .fd-marker--special { fill: var(--fd-special); }

    .fd-edge-label {
        font-size: 10.5px;
        font-weight: 600;
        paint-order: stroke;
        stroke: var(--fd-halo);
        stroke-width: 4px;
        stroke-linejoin: round;
    }
    .fd-edge-label--forward { fill: var(--fd-forward); }
    .fd-edge-label--alt { fill: var(--fd-alt); }
    .fd-edge-label--cancel { fill: var(--fd-cancel); }
    .fd-edge-label--return { fill: #b45309; }
    .dark .fd-edge-label--return { fill: var(--fd-return); }
    .fd-edge-label--special { fill: var(--fd-special); }

    /* ── Controles de zoom ─────────────────────────────────────────── */
    .fd-btn {
        width: 34px; height: 34px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 700; line-height: 1;
        color: #374151; background: #ffffff;
        border: 1px solid #e5e7eb; border-radius: 10px;
        box-shadow: 0 1px 2px rgb(0 0 0 / .08);
        transition: background .15s ease;
    }
    .fd-btn:hover { background: #f3f4f6; }
    .dark .fd-btn { color: #d1d5db; background: #1f2937; border-color: #374151; }
    .dark .fd-btn:hover { background: #374151; }

    /* ── Tooltip ───────────────────────────────────────────────────── */
    .fd-tooltip {
        position: absolute; top: 0; left: 0; z-index: 30;
        max-width: 300px; padding: 12px 14px;
        font-size: 12px; line-height: 1.45; color: #374151;
        background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px;
        box-shadow: 0 10px 24px rgb(0 0 0 / .14);
        opacity: 0; pointer-events: none;
        transition: opacity .15s ease;
    }
    .dark .fd-tooltip { color: #d1d5db; background: #1f2937; border-color: #374151; }
    .fd-tip__title { font-size: 13px; font-weight: 700; color: #111827; margin-bottom: 4px; }
    .dark .fd-tip__title { color: #f9fafb; }
    .fd-tip__desc { margin: 6px 0; }
    .fd-tip__row { margin-top: 4px; }

    .fd-tip__chip {
        display: inline-block; padding: 1px 9px; margin: 2px 4px 2px 0;
        font-size: 10px; font-weight: 700; color: #ffffff; border-radius: 999px;
    }
    .fd-chip--start { background: #64748b; }
    .fd-chip--review { background: #3b82f6; }
    .fd-chip--approval { background: #22c55e; }
    .fd-chip--purchase { background: #06b6d4; }
    .fd-chip--final { background: #10b981; }
    .fd-chip--cancel { background: #ef4444; }
    .fd-chip--return { background: #f59e0b; }
    .fd-chip--special { background: #8b5cf6; }
    .fd-chip--progress { background: #6b7280; }

    /* ── Leyenda ───────────────────────────────────────────────────── */
    .fd-legend__chip {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 3px 10px; font-size: 11px; font-weight: 600;
        color: #4b5563; background: #ffffff;
        border: 1px solid #e5e7eb; border-radius: 999px;
    }
    .dark .fd-legend__chip { color: #d1d5db; background: #1f2937; border-color: #374151; }
    .fd-dot { width: 9px; height: 9px; border-radius: 999px; display: inline-block; }
    .fd-dot--start { background: #64748b; }
    .fd-dot--review { background: #3b82f6; }
    .fd-dot--approval { background: #22c55e; }
    .fd-dot--purchase { background: #06b6d4; }
    .fd-dot--final { background: #10b981; }
    .fd-dot--cancel { background: #ef4444; }
    .fd-dot--return { background: #f59e0b; }
    .fd-dot--special { background: #8b5cf6; }

    /* ── Panel de detalle ──────────────────────────────────────────── */
    .fd-detail__placeholder { font-size: 13px; color: #9ca3af; }
    .fd-detail__head { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 10px; }
    .fd-detail__icon {
        display: flex; align-items: center; justify-content: center;
        width: 42px; height: 42px; font-size: 20px; border-radius: 12px; flex-shrink: 0;
    }
    .fd-iconbg--start { background: #f1f5f9; }
    .fd-iconbg--review { background: #dbeafe; }
    .fd-iconbg--approval { background: #dcfce7; }
    .fd-iconbg--purchase { background: #cffafe; }
    .fd-iconbg--final { background: #d1fae5; }
    .fd-iconbg--cancel { background: #fee2e2; }
    .fd-iconbg--return { background: #fef3c7; }
    .fd-iconbg--special { background: #ede9fe; }
    .dark .fd-detail__icon { background: #374151; }
    .fd-detail__title { font-size: 15px; font-weight: 700; color: #111827; margin-bottom: 3px; }
    .dark .fd-detail__title { color: #f9fafb; }
    .fd-detail__desc { font-size: 13px; line-height: 1.55; color: #4b5563; }
    .dark .fd-detail__desc { color: #d1d5db; }
    .fd-detail__meta { display: flex; flex-direction: column; gap: 4px; margin-top: 10px; font-size: 12.5px; color: #4b5563; }
    .dark .fd-detail__meta { color: #d1d5db; }
    .fd-detail__next { margin-top: 12px; padding-top: 10px; border-top: 1px dashed #e5e7eb; font-size: 12.5px; color: #4b5563; }
    .dark .fd-detail__next { border-color: #374151; color: #d1d5db; }
    .fd-detail__next ul { margin-top: 5px; padding-left: 18px; list-style: disc; }
    .fd-detail__next li { margin-top: 2px; }
    .fd-detail__next em { color: #9ca3af; font-style: normal; }
</style>
