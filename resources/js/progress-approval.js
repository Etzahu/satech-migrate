import * as d3 from "d3";

/**
 * Stepper de avance de aprobación (v2 del entry progress-approval).
 *
 * Lee los pasos {title, name, date, done} del JSON embebido en cada
 * [data-progress-approval] y dibuja una línea de tiempo animada:
 * línea de progreso, badges de fecha, paso actual pulsante, tooltips y
 * contadores animados. La orientación se controla con data-orientation
 * ("vertical" por defecto, "horizontal" opcional). Un MutationObserver
 * renderiza las entradas que aparecen después de la carga (modales de
 * Livewire).
 */

// Disposición horizontal
const STEP_W = 170;
const MARGIN_X = 86;
const CY = 38;
const H_HEIGHT = 132;

// Disposición vertical
const STEP_H = 86;
const MARGIN_Y = 34;
const CX = 40;
const V_WIDTH = 380;

const R = 21;

const STYLE_ID = "pa-stepper-styles";

const CSS = `
.pa-root { width: 100%; }
.pa-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 4px; }
.pa-head__title { font-size: 13px; font-weight: 700; color: #374151; }
.dark .pa-head__title { color: #e5e7eb; }
.pa-head__sub { font-size: 11.5px; color: #9ca3af; }
.pa-pct {
    display: inline-flex; align-items: baseline; gap: 1px;
    padding: 4px 12px; border-radius: 999px;
    font-size: 15px; font-weight: 800; color: #15803d;
    background: #f0fdf4; border: 1px solid #bbf7d0;
}
.dark .pa-pct { color: #4ade80; background: rgb(34 197 94 / .1); border-color: rgb(34 197 94 / .3); }
.pa-pct small { font-size: 10px; font-weight: 700; }
.pa-stage { position: relative; }
.pa-svg { display: block; width: 100%; height: auto; }
.pa-svg--vertical { max-width: 420px; }

.pa-track { stroke: #e5e7eb; stroke-width: 4; stroke-linecap: round; }
.dark .pa-track { stroke: #374151; }
.pa-fill { stroke: #22c55e; stroke-width: 4; stroke-linecap: round; }

.pa-node { cursor: default; }
.pa-node__circle--done { fill: #22c55e; }
.pa-node__circle--pending { fill: #f3f4f6; stroke: #d1d5db; stroke-width: 1.5; }
.dark .pa-node__circle--pending { fill: #1f2937; stroke: #4b5563; }
.pa-node--current .pa-node__circle--pending { stroke: #f59e0b; stroke-width: 2; }
.pa-halo { fill: none; stroke: #f59e0b; stroke-width: 2; opacity: .55; transform-box: fill-box; transform-origin: center; animation: pa-pulse 1.8s ease-out infinite; }
@keyframes pa-pulse {
    0% { transform: scale(.82); opacity: .55; }
    70% { transform: scale(1.18); opacity: 0; }
    100% { transform: scale(1.18); opacity: 0; }
}
@media (prefers-reduced-motion: reduce) { .pa-halo { animation: none; } }

.pa-node__month { font-size: 8.5px; font-weight: 700; letter-spacing: .06em; fill: #ffffff; }
.pa-node__day { font-size: 13px; font-weight: 800; fill: #ffffff; }
.pa-clock { stroke: #9ca3af; stroke-width: 1.6; fill: none; stroke-linecap: round; }
.dark .pa-clock { stroke: #6b7280; }
.pa-node--current .pa-clock { stroke: #f59e0b; }

.pa-check__bg { fill: #ffffff; stroke: #22c55e; stroke-width: 1.5; }
.pa-check__mark { fill: none; stroke: #16a34a; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

.pa-label__title { font-size: 11.5px; font-weight: 700; fill: #6b7280; }
.pa-label__title--done { fill: #15803d; }
.dark .pa-label__title { fill: #9ca3af; }
.dark .pa-label__title--done { fill: #4ade80; }
.pa-label__name { font-size: 10px; fill: #9ca3af; }
.pa-label__name--done { fill: #16a34a; }
.dark .pa-label__name--done { fill: #34d399; }

.pa-tooltip {
    position: absolute; top: 0; left: 0; z-index: 30;
    max-width: 240px; padding: 9px 12px;
    font-size: 11.5px; line-height: 1.45; color: #374151;
    background: #ffffff; border: 1px solid #e5e7eb; border-radius: 10px;
    box-shadow: 0 8px 20px rgb(0 0 0 / .14);
    opacity: 0; pointer-events: none;
    transition: opacity .15s ease;
}
.dark .pa-tooltip { color: #d1d5db; background: #1f2937; border-color: #374151; }
.pa-tooltip strong { color: #111827; }
.dark .pa-tooltip strong { color: #f9fafb; }
.pa-tooltip__status { display: inline-block; margin-top: 3px; padding: 0 8px; border-radius: 999px; font-size: 10px; font-weight: 700; color: #fff; }
`;

function injectStyles() {
    if (document.getElementById(STYLE_ID)) return;
    const style = document.createElement("style");
    style.id = STYLE_ID;
    style.textContent = CSS;
    document.head.appendChild(style);
}

const monthFmt = new Intl.DateTimeFormat("es-MX", { month: "short" });
const fullFmt = new Intl.DateTimeFormat("es-MX", { dateStyle: "long", timeStyle: "short" });

function wrapName(name, max) {
    const words = String(name || "").split(" ");
    const lines = [""];
    for (const w of words) {
        const cur = lines[lines.length - 1];
        if (cur && (cur + " " + w).length > max) {
            lines.push(w);
        } else {
            lines[lines.length - 1] = (cur + " " + w).trim();
        }
    }
    if (lines.length > 2) {
        lines[1] += "…";
    }
    return lines.slice(0, 2);
}

function render(root) {
    const dataEl = root.querySelector('script[type="application/json"]');
    const canvas = root.querySelector(".pa-canvas");
    const tooltip = root.querySelector(".pa-tooltip");
    if (!dataEl || !canvas) return;

    const steps = JSON.parse(dataEl.textContent);
    if (!steps.length) return;

    canvas.innerHTML = "";

    const vertical = (root.dataset.orientation || "vertical") !== "horizontal";

    const n = steps.length;
    const doneCount = steps.filter((s) => s.done).length;
    const pct = Math.round((doneCount / n) * 100);
    const lastDone = steps.reduce((acc, s, i) => (s.done ? i : acc), -1);
    const current = steps.findIndex((s) => !s.done);

    const width = vertical ? V_WIDTH : MARGIN_X * 2 + (n - 1) * STEP_W;
    const height = vertical ? MARGIN_Y * 2 + (n - 1) * STEP_H : H_HEIGHT;
    const pos = (i) => (vertical ? [CX, MARGIN_Y + i * STEP_H] : [MARGIN_X + i * STEP_W, CY]);

    const svg = d3
        .select(canvas)
        .append("svg")
        .attr("class", `pa-svg${vertical ? " pa-svg--vertical" : ""}`)
        .attr("viewBox", `0 0 ${width} ${height}`)
        .attr("preserveAspectRatio", "xMidYMid meet");

    // ── Línea base y línea de progreso ──────────────────────────────────
    const [x0, y0] = pos(0);
    const [xN, yN] = pos(n - 1);

    svg.append("line").attr("class", "pa-track").attr("x1", x0).attr("y1", y0).attr("x2", xN).attr("y2", yN);

    if (lastDone > 0) {
        const [xD, yD] = pos(lastDone);
        svg.append("line")
            .attr("class", "pa-fill")
            .attr("x1", x0)
            .attr("y1", y0)
            .attr("x2", x0)
            .attr("y2", y0)
            .transition()
            .duration(900)
            .delay(250)
            .ease(d3.easeCubicOut)
            .attr("x2", xD)
            .attr("y2", yD);
    }

    // ── Nodos ───────────────────────────────────────────────────────────
    const nodes = svg
        .selectAll("g.pa-node")
        .data(steps)
        .join("g")
        .attr("class", (s, i) => `pa-node${i === current ? " pa-node--current" : ""}`)
        .attr("transform", (s, i) => `translate(${pos(i)[0]}, ${pos(i)[1]}) scale(0)`);

    nodes
        .transition()
        .duration(500)
        .delay((s, i) => 150 + i * 110)
        .ease(d3.easeBackOut.overshoot(1.4))
        .attr("transform", (s, i) => `translate(${pos(i)[0]}, ${pos(i)[1]}) scale(1)`);

    nodes.each(function (s, i) {
        const g = d3.select(this);

        if (i === current) {
            g.append("circle").attr("class", "pa-halo").attr("r", R + 6);
        }

        g.append("circle")
            .attr("class", s.done ? "pa-node__circle--done" : "pa-node__circle--pending")
            .attr("r", R);

        if (s.done) {
            const date = new Date(s.date);
            g.append("text")
                .attr("class", "pa-node__month")
                .attr("y", -4)
                .attr("text-anchor", "middle")
                .text(monthFmt.format(date).replace(".", "").toUpperCase().slice(0, 3));
            g.append("text")
                .attr("class", "pa-node__day")
                .attr("y", 12)
                .attr("text-anchor", "middle")
                .text(date.getDate());

            const badge = g.append("g").attr("transform", `translate(15, -15)`);
            badge.append("circle").attr("class", "pa-check__bg").attr("r", 8);
            const mark = badge.append("path").attr("class", "pa-check__mark").attr("d", "M -3.5 0 L -1 2.8 L 3.5 -2.6");
            const len = mark.node().getTotalLength();
            mark.attr("stroke-dasharray", len)
                .attr("stroke-dashoffset", len)
                .transition()
                .duration(350)
                .delay(500 + i * 110)
                .attr("stroke-dashoffset", 0);
        } else {
            g.append("circle").attr("class", "pa-clock").attr("r", 8.5);
            g.append("path").attr("class", "pa-clock").attr("d", "M 0 -4.5 L 0 0 L 3.4 1.8");
        }
    });

    // ── Etiquetas ───────────────────────────────────────────────────────
    const labels = svg.append("g").attr("opacity", 0);
    labels.transition().duration(600).delay(450).attr("opacity", 1);

    steps.forEach((s, i) => {
        const [x, y] = pos(i);

        if (vertical) {
            // Título y nombre a la derecha del círculo
            const tx = x + R + 18;
            labels
                .append("text")
                .attr("class", `pa-label__title${s.done ? " pa-label__title--done" : ""}`)
                .attr("x", tx)
                .attr("y", y - 4)
                .text(s.title);

            wrapName(s.name, 38).forEach((line, li) => {
                labels
                    .append("text")
                    .attr("class", `pa-label__name${s.done ? " pa-label__name--done" : ""}`)
                    .attr("x", tx)
                    .attr("y", y + 11 + li * 13)
                    .text(line);
            });
        } else {
            // Título y nombre debajo del círculo
            labels
                .append("text")
                .attr("class", `pa-label__title${s.done ? " pa-label__title--done" : ""}`)
                .attr("x", x)
                .attr("y", y + R + 22)
                .attr("text-anchor", "middle")
                .text(s.title);

            wrapName(s.name, 19).forEach((line, li) => {
                labels
                    .append("text")
                    .attr("class", `pa-label__name${s.done ? " pa-label__name--done" : ""}`)
                    .attr("x", x)
                    .attr("y", y + R + 37 + li * 12)
                    .attr("text-anchor", "middle")
                    .text(line);
            });
        }
    });

    // ── Contadores animados ─────────────────────────────────────────────
    const pctEl = root.querySelector("[data-pa-pct]");
    const doneEl = root.querySelector("[data-pa-done]");
    if (pctEl) {
        d3.select(pctEl)
            .transition()
            .duration(900)
            .delay(250)
            .tween("count", function () {
                const interp = d3.interpolateRound(0, pct);
                return (t) => (this.textContent = interp(t));
            });
    }
    if (doneEl) doneEl.textContent = doneCount;

    // ── Tooltip ─────────────────────────────────────────────────────────
    const stage = root.querySelector(".pa-stage");
    nodes
        .on("mouseenter", function (event, s) {
            const date = s.done ? fullFmt.format(new Date(s.date)) : null;
            tooltip.innerHTML = `
                <div><strong>${s.title}</strong></div>
                ${s.name ? `<div>👤 ${s.name}</div>` : ""}
                ${date ? `<div>📅 ${date}</div>` : ""}
                <span class="pa-tooltip__status" style="background:${s.done ? "#22c55e" : "#9ca3af"}">
                    ${s.done ? "Completado" : "Pendiente"}
                </span>`;
            tooltip.style.opacity = "1";
        })
        .on("mousemove", function (event) {
            const [mx, my] = d3.pointer(event, stage);
            const rect = stage.getBoundingClientRect();
            let left = mx + 14;
            let top = my + 12;
            if (left + tooltip.offsetWidth > rect.width - 4) left = mx - tooltip.offsetWidth - 14;
            if (top + tooltip.offsetHeight > rect.height - 4) top = my - tooltip.offsetHeight - 12;
            tooltip.style.left = `${left}px`;
            tooltip.style.top = `${top}px`;
        })
        .on("mouseleave", () => (tooltip.style.opacity = "0"));
}

let initQueued = false;

function initAll() {
    initQueued = false;
    injectStyles();
    document.querySelectorAll("[data-progress-approval]").forEach((root) => {
        if (root.dataset.paRendered && root.querySelector("svg")) return;
        root.dataset.paRendered = "1";
        render(root);
    });
}

function scheduleInit() {
    if (initQueued) return;
    initQueued = true;
    requestAnimationFrame(initAll);
}

function boot() {
    initAll();
    // Renderiza entradas que llegan después (modales y actualizaciones de Livewire)
    new MutationObserver(scheduleInit).observe(document.body, { childList: true, subtree: true });
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", boot);
} else {
    boot();
}
