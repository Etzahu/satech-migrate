import * as d3 from "d3";

/**
 * Renderizador de diagramas de flujo de proceso (requisiciones y órdenes de compra).
 *
 * Lee la definición del flujo (nodos con posición en cuadrícula + transiciones)
 * desde un <script type="application/json"> y dibuja un SVG interactivo:
 * zoom/pan, tooltips, panel de detalle y resaltado de conexiones al hacer clic.
 */

const COL_W = 290; // ancho de columna de la cuadrícula
const ROW_H = 190; // alto de fila de la cuadrícula
const NODE_W = 196;
const NODE_H = 88;

const TYPE_LABELS = {
    start: "Inicio",
    review: "Revisión",
    approval: "Aprobación",
    purchase: "Compra",
    final: "Final",
    cancel: "Cancelación",
    return: "Devolución",
    special: "Caso especial",
};

const EDGE_STYLE = {
    forward: { cls: "fd-edge--forward", marker: "forward" },
    alt: { cls: "fd-edge--alt", marker: "alt" },
    cancel: { cls: "fd-edge--cancel", marker: "cancel" },
    cancelGap: { cls: "fd-edge--cancel", marker: "cancel" },
    return: { cls: "fd-edge--return", marker: "return" },
    loop: { cls: "fd-edge--return", marker: "return" },
    special: { cls: "fd-edge--special", marker: "special" },
    overpass: { cls: "fd-edge--special", marker: "special" },
};

function wrapLabel(label, max = 19) {
    const words = String(label).split(" ");
    const lines = [""];
    for (const w of words) {
        const cur = lines[lines.length - 1];
        if (cur && (cur + " " + w).length > max) {
            lines.push(w);
        } else {
            lines[lines.length - 1] = (cur + " " + w).trim();
        }
    }
    return lines.slice(0, 2);
}

/** Polilínea con esquinas redondeadas. */
function orthoPath(pts, r = 14) {
    let d = `M ${pts[0][0]} ${pts[0][1]}`;
    for (let i = 1; i < pts.length - 1; i++) {
        const [x0, y0] = pts[i - 1];
        const [x1, y1] = pts[i];
        const [x2, y2] = pts[i + 1];
        const d1 = Math.hypot(x1 - x0, y1 - y0);
        const d2 = Math.hypot(x2 - x1, y2 - y1);
        const rr = Math.min(r, d1 / 2, d2 / 2);
        const xa = x1 - ((x1 - x0) / d1) * rr;
        const ya = y1 - ((y1 - y0) / d1) * rr;
        const xb = x1 + ((x2 - x1) / d2) * rr;
        const yb = y1 + ((y2 - y1) / d2) * rr;
        d += ` L ${xa} ${ya} Q ${x1} ${y1} ${xb} ${yb}`;
    }
    const [lx, ly] = pts[pts.length - 1];
    return d + ` L ${lx} ${ly}`;
}

/** Punto de anclaje sobre el borde de un nodo. */
function anchor(node, side, off = 0) {
    switch (side) {
        case "left":
            return [node.x - NODE_W / 2, node.y + off];
        case "right":
            return [node.x + NODE_W / 2, node.y + off];
        case "top":
            return [node.x + off, node.y - NODE_H / 2];
        case "bottom":
            return [node.x + off, node.y + NODE_H / 2];
    }
}

function edgePath(e, s, t) {
    switch (e.type) {
        case "forward":
        case "alt": {
            const [sx, sy] = anchor(s, "right");
            const [tx, ty] = anchor(t, "left");
            if (e.arc) {
                const m = (sx + tx) / 2;
                return `M ${sx} ${sy} C ${m} ${sy + e.arc}, ${m} ${ty + e.arc}, ${tx} ${ty}`;
            }
            return `M ${sx} ${sy} L ${tx} ${ty}`;
        }
        case "cancel": {
            const dir = t.y < s.y ? -1 : 1;
            const [sx, sy] = anchor(s, dir < 0 ? "top" : "bottom");
            const [tx, ty] = anchor(t, dir < 0 ? "bottom" : "top");
            return `M ${sx} ${sy} L ${tx} ${ty}`;
        }
        case "cancelGap": {
            const [sx, sy] = anchor(s, "right", 26);
            const [tx, ty] = anchor(t, "top");
            return orthoPath(
                [
                    [sx, sy],
                    [tx, sy],
                    [tx, ty],
                ],
                16
            );
        }
        case "return":
        case "loop": {
            const lane = e.type === "return" ? -1 : 1;
            if (s.col === t.col) {
                const dir = t.y > s.y ? 1 : -1;
                const dx = lane * 26;
                const [sx, sy] = anchor(s, dir > 0 ? "bottom" : "top", dx);
                const [tx, ty] = anchor(t, dir > 0 ? "top" : "bottom", dx);
                return `M ${sx} ${sy} L ${tx} ${ty}`;
            }
            const dir = t.x > s.x ? 1 : -1;
            const dy = lane * 18;
            const [sx, sy] = anchor(s, dir > 0 ? "right" : "left", dy);
            const [tx, ty] = anchor(t, dir > 0 ? "left" : "right", dy);
            return `M ${sx} ${sy} L ${tx} ${ty}`;
        }
        case "overpass": {
            const [sx, sy] = anchor(s, "right");
            const [tx, ty] = anchor(t, "top");
            return orthoPath(
                [
                    [sx, sy],
                    [tx, sy],
                    [tx, ty],
                ],
                48
            );
        }
        case "special": {
            const dx = t.x - s.x;
            const dy = t.y - s.y;
            let exitSide = e.exit;
            let enterSide = e.enter;
            if (!exitSide || !enterSide) {
                if (Math.abs(dx) > Math.abs(dy)) {
                    exitSide = exitSide || (dx > 0 ? "right" : "left");
                    enterSide = enterSide || (dx > 0 ? "left" : "right");
                } else {
                    exitSide = exitSide || (dy > 0 ? "bottom" : "top");
                    enterSide = enterSide || (dy > 0 ? "top" : "bottom");
                }
            }
            const exitOff = exitSide === "left" || exitSide === "right" ? (dy === 0 ? 0 : dy < 0 ? -24 : 24) : 0;
            const enterOff = enterSide === "left" || enterSide === "right" ? (dy === 0 ? 0 : dy < 0 ? 32 : -32) : 0;
            const p0 = anchor(s, exitSide, exitOff);
            const p1 = anchor(t, enterSide, enterOff);
            const via = (e.via || []).map((v) => [v[0] * COL_W, v[1] * ROW_H]);
            const pts = [p0, ...via, p1];
            if (pts.length === 2) {
                return `M ${p0[0]} ${p0[1]} L ${p1[0]} ${p1[1]}`;
            }
            return d3.line().curve(d3.curveCatmullRom.alpha(0.8))(pts);
        }
    }
}

function buildTooltipHtml(n) {
    let html = `<div class="fd-tip__title">${n.icon} ${n.label}</div>`;
    html += `<div class="fd-tip__chip fd-chip--${n.type}">${TYPE_LABELS[n.type]}</div>`;
    if (n.actor) html += `<div class="fd-tip__row"><strong>👤 Actúa:</strong> ${n.actor}</div>`;
    html += `<div class="fd-tip__desc">${n.description}</div>`;
    if (n.notify) html += `<div class="fd-tip__row">✉️ ${n.notify}</div>`;
    if (n.progress !== undefined && n.progress !== null) {
        html += `<div class="fd-tip__row">📊 Avance: <strong>${n.progress}%</strong></div>`;
    }
    return html;
}

function buildDetailHtml(n, data) {
    const outgoing = data.edges.filter((e) => e.from === n.id);
    const byId = new Map(data.nodes.map((d) => [d.id, d]));

    let html = `
        <div class="fd-detail__head">
            <span class="fd-detail__icon fd-iconbg--${n.type}">${n.icon}</span>
            <div>
                <h4 class="fd-detail__title">${n.label}</h4>
                <span class="fd-tip__chip fd-chip--${n.type}">${TYPE_LABELS[n.type]}</span>
                ${n.progress !== undefined && n.progress !== null ? `<span class="fd-tip__chip fd-chip--progress">Avance: ${n.progress}%</span>` : ""}
            </div>
        </div>
        <p class="fd-detail__desc">${n.description}</p>
        <div class="fd-detail__meta">
            ${n.actor ? `<div><strong>👤 Quién actúa:</strong> ${n.actor}</div>` : ""}
            ${n.notify ? `<div><strong>✉️ Notificación:</strong> ${n.notify}</div>` : ""}
        </div>`;

    if (outgoing.length) {
        const items = outgoing
            .map((e) => {
                const target = byId.get(e.to);
                if (!target) return "";
                const action = e.label ? `<em>${e.label}</em> → ` : "→ ";
                return `<li>${action}<strong>${target.label}</strong></li>`;
            })
            .join("");
        html += `<div class="fd-detail__next"><strong>Transiciones posibles:</strong><ul>${items}</ul></div>`;
    } else {
        html += `<div class="fd-detail__next"><strong>Estado final:</strong> no tiene transiciones de salida.</div>`;
    }
    return html;
}

function render(root) {
    const dataEl = document.getElementById(root.dataset.flowRoot);
    if (!dataEl) return;
    const data = JSON.parse(dataEl.textContent);

    const canvas = root.querySelector(".fd-canvas");
    const tooltip = root.querySelector(".fd-tooltip");
    const detail = root.querySelector("[data-flow-detail]");

    const nodes = data.nodes.map((n) => ({ ...n, x: n.col * COL_W, y: n.row * ROW_H }));
    const byId = new Map(nodes.map((n) => [n.id, n]));

    const plainEdges = data.edges.filter((e) => e.type !== "bus");
    const busEdges = data.edges.filter((e) => e.type === "bus");

    // ── Dimensiones y carril de reingreso ───────────────────────────────
    const maxNodeBottom = d3.max(nodes, (n) => n.y) + NODE_H / 2;
    const busY = maxNodeBottom + 46;
    const busTarget = busEdges.length ? byId.get(busEdges[0].to) : null;

    const minX = d3.min(nodes, (n) => n.x) - NODE_W / 2 - 60;
    const maxX = Math.max(
        d3.max(nodes, (n) => n.x) + NODE_W / 2,
        d3.max(busEdges, (e) => byId.get(e.from).x + (e.busDx || 0)) || -Infinity
    ) + 60;
    const minY = d3.min(nodes, (n) => n.y) - NODE_H / 2 - 50;
    const maxY = busEdges.length ? busY + 50 : maxNodeBottom + 50;

    const width = maxX - minX;
    const height = maxY - minY;

    canvas.style.aspectRatio = `${width} / ${height}`;

    const svg = d3
        .select(canvas)
        .append("svg")
        .attr("viewBox", `${minX} ${minY} ${width} ${height}`)
        .attr("preserveAspectRatio", "xMidYMid meet")
        .attr("class", "fd-svg");

    // ── Marcadores de flecha ────────────────────────────────────────────
    const defs = svg.append("defs");
    for (const kind of ["forward", "alt", "cancel", "return", "special"]) {
        defs.append("marker")
            .attr("id", `fd-arrow-${data.id}-${kind}`)
            .attr("viewBox", "0 0 10 10")
            .attr("refX", 9)
            .attr("refY", 5)
            .attr("markerWidth", 7)
            .attr("markerHeight", 7)
            .attr("orient", "auto-start-reverse")
            .append("path")
            .attr("d", "M 0 0 L 10 5 L 0 10 z")
            .attr("class", `fd-marker--${kind}`);
    }

    const gRoot = svg.append("g");
    const gEdges = gRoot.append("g");
    const gNodes = gRoot.append("g");
    const gLabels = gRoot.append("g");

    // ── Carril de reingreso (devoluciones → vuelve al inicio) ───────────
    if (busEdges.length && busTarget) {
        const drops = busEdges.map((e) => {
            const s = byId.get(e.from);
            return { x: s.x + (e.busDx || 0), y: s.y + NODE_H / 2, edge: e };
        });
        const riserX = busTarget.x - NODE_W / 2 - 40;
        const entryY = busTarget.y + 30;
        const railStartX = d3.max(drops, (d) => d.x);

        for (const d of drops) {
            gEdges
                .append("path")
                .attr("class", "fd-edge fd-edge--return")
                .attr("data-from", d.edge.from)
                .attr("data-to", d.edge.to)
                .attr("d", `M ${d.x} ${d.y} L ${d.x} ${busY}`);
            gEdges.append("circle").attr("class", "fd-busdot").attr("cx", d.x).attr("cy", busY).attr("r", 3.5);
        }

        gEdges
            .append("path")
            .attr("class", "fd-edge fd-edge--return fd-edge--rail")
            .attr(
                "d",
                orthoPath(
                    [
                        [railStartX, busY],
                        [riserX, busY],
                        [riserX, entryY],
                        [busTarget.x - NODE_W / 2, entryY],
                    ],
                    18
                )
            )
            .attr("marker-end", `url(#fd-arrow-${data.id}-return)`);

        gLabels
            .append("text")
            .attr("class", "fd-edge-label fd-edge-label--return")
            .attr("x", (railStartX + riserX) / 2)
            .attr("y", busY - 9)
            .attr("text-anchor", "middle")
            .text(data.reentryLabel || "Corrige y reenvía al flujo");
    }

    // ── Transiciones ────────────────────────────────────────────────────
    for (const e of plainEdges) {
        const s = byId.get(e.from);
        const t = byId.get(e.to);
        if (!s || !t) continue;

        const style = EDGE_STYLE[e.type] || EDGE_STYLE.forward;
        const path = gEdges
            .append("path")
            .attr("class", `fd-edge ${style.cls}${e.main ? " fd-edge--main" : ""}`)
            .attr("data-from", e.from)
            .attr("data-to", e.to)
            .attr("d", edgePath(e, s, t))
            .attr("marker-end", `url(#fd-arrow-${data.id}-${style.marker})`);

        if (e.label) {
            const node = path.node();
            const p = node.getPointAtLength(node.getTotalLength() * (e.labelAt ?? 0.5));
            const vertical = s.col === t.col && ["cancel", "return", "loop"].includes(e.type);
            gLabels
                .append("text")
                .attr("class", `fd-edge-label fd-edge-label--${style.marker}`)
                .attr("x", p.x + (vertical ? 8 : 0))
                .attr("y", p.y + (e.labelDy ?? -7))
                .attr("text-anchor", vertical ? "start" : "middle")
                .text(e.label);
        }
    }

    // ── Nodos ───────────────────────────────────────────────────────────
    const nodeSel = gNodes
        .selectAll("g.fd-node")
        .data(nodes)
        .join("g")
        .attr("class", (n) => `fd-node fd-node--${n.type}`)
        .attr("transform", (n) => `translate(${n.x - NODE_W / 2}, ${n.y - NODE_H / 2})`);

    nodeSel.append("rect").attr("class", "fd-node__card").attr("width", NODE_W).attr("height", NODE_H).attr("rx", 14);

    nodeSel
        .append("rect")
        .attr("class", "fd-node__accent")
        .attr("x", 0)
        .attr("y", 8)
        .attr("width", 5)
        .attr("height", NODE_H - 16)
        .attr("rx", 2.5);

    nodeSel.append("circle").attr("class", "fd-node__iconbg").attr("cx", 30).attr("cy", NODE_H / 2).attr("r", 16);

    nodeSel
        .append("text")
        .attr("class", "fd-node__icon")
        .attr("x", 30)
        .attr("y", NODE_H / 2 + 5)
        .attr("text-anchor", "middle")
        .text((n) => n.icon);

    nodeSel.each(function (n) {
        const g = d3.select(this);
        const lines = wrapLabel(n.label);
        const title = g.append("text").attr("class", "fd-node__title").attr("x", 56);
        const firstY = lines.length > 1 ? 30 : 38;
        lines.forEach((line, i) => {
            title.append("tspan").attr("x", 56).attr("y", firstY + i * 15).text(line);
        });
        g.append("text")
            .attr("class", "fd-node__actor")
            .attr("x", 56)
            .attr("y", NODE_H - 16)
            .text(`👤 ${n.actor || ""}`);

        if (n.progress !== undefined && n.progress !== null) {
            g.append("rect")
                .attr("class", "fd-node__pill")
                .attr("x", NODE_W - 48)
                .attr("y", -10)
                .attr("width", 44)
                .attr("height", 20)
                .attr("rx", 10);
            g.append("text")
                .attr("class", "fd-node__pilltext")
                .attr("x", NODE_W - 26)
                .attr("y", 4)
                .attr("text-anchor", "middle")
                .text(`${n.progress}%`);
        }
    });

    // ── Interacción: tooltip, detalle y resaltado ───────────────────────
    let selectedId = null;

    function applyHighlight() {
        nodeSel.classed("fd-dim", (n) => selectedId && n.id !== selectedId && !isConnected(n.id));
        gEdges
            .selectAll("path.fd-edge")
            .classed("fd-dim", function () {
                if (!selectedId) return false;
                const el = d3.select(this);
                return el.attr("data-from") !== selectedId && el.attr("data-to") !== selectedId;
            })
            .classed("fd-edge--active", function () {
                if (!selectedId) return false;
                const el = d3.select(this);
                return el.attr("data-from") === selectedId || el.attr("data-to") === selectedId;
            });
        nodeSel.classed("fd-selected", (n) => n.id === selectedId);
    }

    function isConnected(id) {
        return data.edges.some(
            (e) => (e.from === selectedId && e.to === id) || (e.to === selectedId && e.from === id)
        );
    }

    nodeSel
        .on("mouseenter", function (event, n) {
            tooltip.innerHTML = buildTooltipHtml(n);
            tooltip.style.opacity = "1";
        })
        .on("mousemove", function (event) {
            const [mx, my] = d3.pointer(event, root.querySelector(".fd-stage"));
            const stage = root.querySelector(".fd-stage").getBoundingClientRect();
            const tw = tooltip.offsetWidth;
            const th = tooltip.offsetHeight;
            let left = mx + 18;
            let top = my + 14;
            if (left + tw > stage.width - 8) left = mx - tw - 18;
            if (top + th > stage.height - 8) top = my - th - 14;
            tooltip.style.left = `${left}px`;
            tooltip.style.top = `${top}px`;
        })
        .on("mouseleave", function () {
            tooltip.style.opacity = "0";
        })
        .on("click", function (event, n) {
            event.stopPropagation();
            selectedId = selectedId === n.id ? null : n.id;
            applyHighlight();
            if (detail) {
                detail.innerHTML = selectedId
                    ? buildDetailHtml(n, data)
                    : detail.dataset.placeholder || "";
            }
        });

    svg.on("click", () => {
        selectedId = null;
        applyHighlight();
        if (detail) detail.innerHTML = detail.dataset.placeholder || "";
    });

    // ── Zoom y paneo ────────────────────────────────────────────────────
    const zoom = d3
        .zoom()
        .scaleExtent([0.35, 2.5])
        .on("zoom", (event) => gRoot.attr("transform", event.transform));

    svg.call(zoom).on("dblclick.zoom", null);

    root.querySelectorAll("[data-fd-zoom]").forEach((btn) => {
        btn.addEventListener("click", () => {
            const action = btn.dataset.fdZoom;
            if (action === "in") svg.transition().duration(250).call(zoom.scaleBy, 1.35);
            if (action === "out") svg.transition().duration(250).call(zoom.scaleBy, 1 / 1.35);
            if (action === "reset") svg.transition().duration(350).call(zoom.transform, d3.zoomIdentity);
        });
    });
}

function initAll() {
    document.querySelectorAll("[data-flow-root]").forEach((root) => {
        if (root.dataset.fdRendered) return;
        root.dataset.fdRendered = "1";
        render(root);
    });
    // Señal para entornos sin interacción (p. ej. Browsershot/Puppeteer al
    // exportar a PDF): permite esperar a que los diagramas estén dibujados.
    window.__flowDiagramsReady = true;
}

document.addEventListener("DOMContentLoaded", initAll);
document.addEventListener("livewire:navigated", initAll);

// Si el script se evalúa cuando el DOM ya está listo (módulo diferido en
// Browsershot, navegación SPA, etc.), renderiza de inmediato.
if (document.readyState !== "loading") initAll();
