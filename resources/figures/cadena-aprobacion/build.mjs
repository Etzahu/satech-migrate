/**
 * Figura isométrica de la cadena de aprobación de requisiciones.
 *
 * Una línea de sellado: la requisición es una carpeta sobre un carro que
 * recorre un riel y se detiene bajo cuatro pórticos (almacén, revisor,
 * gerencia y DG). Cada pórtico tiene un tope retráctil en el riel y un
 * cabezal de sello montado en un carro transversal. Aprobar sella la carpeta
 * y baja el tope; devolver la regresa al solicitante; cancelar la sella con
 * una cruz. Un nivel que no existe en la cadena (almacén en servicios, DG sin
 * autorizador) tiene su cabezal estacionado y el tope abajo.
 *
 * Las reglas salen de PurchaseRequisitionStateMachine y de
 * PurchaseRequisitionFlowService.
 *
 * Uso: node build.mjs            → cadena-aprobacion.html (oscuro)
 *      node build.mjs --light    → cadena-aprobacion-light.html
 *
 * El kit vive en la skill anatomy; ANATOMY_KIT apunta a otra copia si hace falta.
 */
import { readFileSync, writeFileSync } from "node:fs";
import { homedir } from "node:os";
import { dirname, join } from "node:path";
import { fileURLToPath, pathToFileURL } from "node:url";

const KIT = process.env.ANATOMY_KIT ?? join(homedir(), ".claude", "skills", "anatomy");
const k = await import(pathToFileURL(join(KIT, "kit", "iso-kit.mjs")).href);
const { kitScript } = await import(pathToFileURL(join(KIT, "scripts", "inline-kit.mjs")).href);

const HERE = dirname(fileURLToPath(import.meta.url));
const theme = process.argv.includes("--light") ? "light" : "dark";
const LIVE = readFileSync(join(HERE, "live.js"), "utf8");

const WIDTH = 640;
const HEIGHT = 350;

// ── Mundo ─────────────────────────────────────────────────────────────────
const BASE = { x: -192, y: -54, w: 384, d: 104, r: 10 };
const BASE_H = 12;
const FOOT_H = 5;

const BED = { x: -179, y: -10, w: 358, d: 20, r: 2 };
const BED_TOP = 4;
const RAILS = [-8.5, 4.5].map((y) => ({ x: -177, y, w: 354, d: 4, r: 1 }));
const RAIL_TOP = 7;

const CAR = { x: -21, y: -13, w: 42, d: 26, r: 2 };
const CAR_Z = 8.4;
const CAR_TOP = 11.4;
const FOLDER = { x: -16, y: -11, w: 32, d: 22, r: 1 };
const FOLD_TOP = CAR_TOP + 2.6;
const SLOT_X = [-10.5, -3.5, 3.5, 10.5];
const SEAL_R = 2.6;

const ST = [-100, -36, 28, 92];
const HX = ST.map((s) => s + 10);
const STOP = HX.map((h, i) => h - SLOT_X[i]);
const PIN_R = 2;
const PIN = STOP.map((x) => x + CAR.w / 2 + 1 + PIN_R + 0.2);
const PIN_UP = 7.6;
const DOCK_A = -150;
const DOCK_B = 150;

const POST_Y = 24;
const POST_TOP = 62;
const BEAM_Z = 62;
const BEAM_H = 7;
const PARK = -20;
const PAD_REST = 27;
const STROKE = PAD_REST - FOLD_TOP;
const HOUSING = [41, 58];

const END_A = { x: -186, y: -12, w: 5, d: 24, r: 1.2 };
const END_B = { x: 181, y: -12, w: 5, d: 24, r: 1.2 };

const P = k.fitProjection(
  [
    ...k.boxCorners(BASE, -BASE_H - FOOT_H, 0),
    ...[ST[0], ST[3]].flatMap((s) => k.boxCorners({ x: s - 4, y: -30, w: 20, d: 60, r: 0 }, 0, BEAM_Z + BEAM_H + 3)),
  ],
  WIDTH,
  HEIGHT,
  { pad: 24, azimuth: 58, elevation: 32 },
);

const at = (point) => k.iso(point, P);
const S = (paths, style) => k.solidSvg(paths, style);
const L = (d, style) => k.lineSvg(d, style);
const D = (points, style) => k.dotsSvg(points, style);
const slab = (plan, z, h, steps = 3, bevel = 0) => k.slabOf(plan, z, h, P, steps, bevel);
const cyl = (x, y, r, z, h, steps = 24, bevel = 0) => k.cylinder(x, y, r, z, h, P, steps, bevel);
const byDepth = (points) => [...points].sort((a, b) => k.depthOf([a[0], a[1], 0], P) - k.depthOf([b[0], b[1], 0], P));

// ── Base, riel y topes de fin de carrera ──────────────────────────────────
function base() {
  const out = [`<path class="iso-halo" d="${k.haloOf(BASE, -BASE_H - FOOT_H, BASE_H, P)}"/>`];
  for (const [x, y] of byDepth(k.corners(BASE, 24))) {
    out.push(S(cyl(x, y, 7, -BASE_H - FOOT_H, 1.6, 28), { tone: "lo" }));
    out.push(S(cyl(x, y, 5.4, -BASE_H - FOOT_H + 1.6, FOOT_H - 1.6, 28), { tone: "mid" }));
  }
  out.push(S(slab(BASE, -BASE_H, BASE_H, 8, 1.6), { tone: "mid", inner: L(k.sideSeam(BASE, -BASE_H + 4, P, 8), { tone: "faint" }) }));
  out.push(L(k.planOutline(k.insetPlan(BASE, 5), 0, P), { tone: "lo" }));
  const screws = k.corners(BASE, 10);
  out.push(L(screws.map(([x, y]) => k.ring(x, y, 2.2, 0, P, 16)).join(""), { tone: "lo" }));
  out.push(D(screws.map(([x, y]) => at([x, y, 0])), { size: 0.5 }));

  const strip = { x: -178, y: 37, w: 356, d: 7, r: 1 };
  out.push(S(slab(strip, 0, 0.6, 3), { tone: "lo", crease: "none" }));
  const ticks = k.topTicks(strip.x + 4, strip.x + strip.w - 4, 4, 5, strip.y + 0.8, 0.6, [2, 3.6], P);
  out.push(L(ticks.minor, { tone: "lo" }), L(ticks.major, { tone: "mid" }));
  out.push(D([at([strip.x + 2, strip.y + 3.5, 0.6]), at([strip.x + strip.w - 2, strip.y + 3.5, 0.6])], { size: 0.45 }));
  for (const x of STOP) {
    out.push(L(k.lineOnTop([x, strip.y + 0.8], [x, strip.y + 5.6], 0.6, P), { tone: "hi" }));
  }

  const plate = { x: 120, y: 17, w: 44, d: 14, r: 1.2 };
  out.push(S(slab(plate, 0, 0.8, 4), { tone: "lo", crease: "none" }));
  out.push(L(k.planOutline(k.insetPlan(plate, 1.6), 0.8, P, 4), { tone: "faint" }));
  out.push(k.faceTextSvg(k.topMatrix([plate.x + 4, plate.y + 6.4], 0.8, P, "x"), "RQ · CADENA", { size: 3.1, tone: "mid" }));
  out.push(L(k.lineOnTop([plate.x + 4, plate.y + 8.6], [plate.x + 30, plate.y + 8.6], 0.8, P), { tone: "lo", free: true }));
  out.push(L(k.lineOnTop([plate.x + 4, plate.y + 10.6], [plate.x + 22, plate.y + 10.6], 0.8, P), { tone: "lo", free: true }));
  out.push(D([at([plate.x + 2.2, plate.y + 7, 0.8]), at([plate.x + plate.w - 2.2, plate.y + 7, 0.8])], { size: 0.45 }));

  // Canaleta de cableado: lleva el aviso de correo a cada nivel.
  const duct = { x: -178, y: -46, w: 356, d: 8, r: 1.5 };
  out.push(S(slab(duct, 0, 4, 3, 0.4), { tone: "mid", inner: L(k.sideSeam(duct, 3, P, 3), { tone: "faint" }) }));
  out.push(D([-150, -68, 0, 60, 150].map((x) => at([x, duct.y + 4, 4])), { size: 0.45 }));
  return out.join("");
}

function rail() {
  const out = [];
  out.push(S(slab(BED, 0, BED_TOP, 3, 0.5), { tone: "mid" }));
  for (const x of PIN) {
    out.push(S(cyl(x, 0, 3, BED_TOP, 0.35, 24), { tone: "lo", crease: "none" }));
    out.push(L(k.ring(x, 0, PIN_R + 0.15, BED_TOP + 0.35, P, 24), { tone: "faint" }));
  }
  for (const plan of RAILS) {
    out.push(S(slab(plan, BED_TOP, RAIL_TOP - BED_TOP, 3, 0.4), { tone: "mid" }));
    const screws = [];
    for (let x = plan.x + 8; x < plan.x + plan.w - 4; x += 22) {
      screws.push(at([x, plan.y + 2, RAIL_TOP]));
    }
    out.push(D(screws, { size: 0.38, tone: "lo" }));
  }
  return out.join("");
}

function endStop(plan) {
  return [
    S(slab(plan, 0, 16, 3, 0.5), { tone: "mid" }),
    D([at([plan.x + plan.w / 2, plan.y + 3.5, 16]), at([plan.x + plan.w / 2, plan.y + plan.d - 3.5, 16])], { size: 0.45 }),
  ].join("");
}

/** Amortiguador: varilla con resorte que recibe al carro en cada extremo. */
function bumper(from, to) {
  const lo = Math.min(from, to);
  const hi = Math.max(from, to);
  const capX = to > from ? to - 1.6 : to;
  const seat = to > from ? from : from - 1.2;
  const coil = k.coil(to > from ? from + 1.2 : from - 1.2, to > from ? to - 1.6 : to + 1.6, [0, 9.9], 2.4, 3, "x", P);
  return [
    S(slab({ x: seat, y: -2.8, w: 1.2, d: 5.6, r: 1 }, 7.1, 5.6, 3), { tone: "mid" }),
    L(coil.back, { tone: "lo" }),
    S(slab({ x: lo, y: -1.1, w: hi - lo, d: 2.2, r: 1 }, 8.8, 2.2, 3), { tone: "mid", crease: "none" }),
    S(slab({ x: capX, y: -3.2, w: 1.6, d: 6.4, r: 1 }, 7.6, 4.6, 3), { tone: "mid" }),
    L(coil.front, { tone: "mid" }),
  ].join("");
}

/** Pedestal con lámpara: el solicitante en un extremo, compras en el otro. */
function pedestal(x, y, part) {
  return [
    S(cyl(x, y, 5.4, 0, 1.6, 28), { tone: "lo" }),
    S(cyl(x, y, 2.2, 1.6, 15, 20), { tone: "mid", crease: "none" }),
    L(k.sideArc(x, y, 2.2, 9, P, 14), { tone: "faint" }),
    S(cyl(x, y, 3.6, 16.6, 4.4, 28, 0.4), { tone: "mid" }),
    L(k.sideArc(x, y, 3.6, 18.8, P, 20), { tone: "faint" }),
    L(k.ring(x, y, 2, 21, P, 20), { tone: "lo" }),
    `<g data-lamp="${part}">${D([at([x, y, 21])], { size: 1.1, tone: "hi" })}</g>`,
  ].join("");
}

// ── Pórtico de un nivel ───────────────────────────────────────────────────
function backOf(s) {
  const out = [];
  // Canaleta de aviso: del ducto trasero, por el piso, sube por el poste a la lámpara.
  const floor = { x: s + 3.6, y: -38, w: 3.2, d: 13.6, r: 0.6 };
  out.push(S(slab(floor, 0, 1.4, 2), { tone: "lo", crease: "none" }));
  out.push(D([at([floor.x + 1.6, floor.y + 4, 1.4]), at([floor.x + 1.6, floor.y + 10, 1.4])], { size: 0.36, tone: "lo" }));
  out.push(S(cyl(s, -POST_Y, 5, 0, 1.6, 28), { tone: "lo" }));
  out.push(D([at([s - 3.4, -POST_Y + 3.4, 1.6]), at([s + 3.4, -POST_Y + 3.4, 1.6])], { size: 0.4 }));
  out.push(S(slab({ x: s - 3, y: -POST_Y - 3, w: 6, d: 6, r: 1 }, 1.6, POST_TOP - 1.6, 3, 0.4), { tone: "mid", inner: L(k.sideSeam({ x: s - 3, y: -POST_Y - 3, w: 6, d: 6, r: 1 }, 30, P, 3), { tone: "faint" }) }));
  const duct = { x: s + 3, y: -26.2, w: 1.4, d: 2.8, r: 0.4 };
  out.push(S(slab(duct, 1.4, POST_TOP - 1.4, 2), { tone: "lo", crease: "none" }));
  out.push(D([12, 32, 52].map((z) => at([duct.x + 1.4, duct.y + 1.4, z])), { size: 0.34, tone: "lo" }));
  return out.join("");
}

function frontOf(s, i) {
  const out = [`<g data-pin="${i}">${S(cyl(PIN[i], 0, PIN_R, BED_TOP + 0.35, PIN_UP, 20, 0.3), { tone: "hi" })}</g>`];
  out.push(S(cyl(s, POST_Y, 5, 0, 1.6, 28), { tone: "lo" }));
  out.push(D([at([s - 3.4, POST_Y + 3.4, 1.6]), at([s + 3.4, POST_Y + 3.4, 1.6])], { size: 0.4 }));
  out.push(S(slab({ x: s - 3, y: POST_Y - 3, w: 6, d: 6, r: 1 }, 1.6, POST_TOP - 1.6, 3, 0.4), { tone: "mid", inner: L(k.sideSeam({ x: s - 3, y: POST_Y - 3, w: 6, d: 6, r: 1 }, 30, P, 3), { tone: "faint" }) }));
  // Placa del nivel en la cara frontal del poste: las líneas hacen de texto.
  const face = POST_Y + 3;
  out.push(S(slab({ x: s - 2.4, y: face, w: 4.8, d: 0.6, r: 0.2 }, 38, 12, 2), { tone: "lo", crease: "none" }));
  out.push(L([47.5, 45.5, 43.5].map((z, n) => k.segment([s - 1.6, face + 0.6, z], [s + 1.6 - n * 0.9, face + 0.6, z], P)).join(""), { tone: "lo", free: true }));

  const beam = { x: s - 4, y: -30, w: 8, d: 60, r: 1.5 };
  out.push(S(slab(beam, BEAM_Z, BEAM_H, 3, 0.6), { tone: "mid" }));
  out.push(D([at([s, -27, BEAM_Z + BEAM_H]), at([s, 27, BEAM_Z + BEAM_H]), at([s, -6, BEAM_Z + BEAM_H]), at([s, 6, BEAM_Z + BEAM_H])], { size: 0.42 }));
  out.push(S(slab({ x: s + 4, y: -28, w: 1, d: 56, r: 0.4 }, BEAM_Z + 1.5, 4, 2), { tone: "lo", crease: "none" }));
  // Lámpara de aviso: se enciende cuando el correo llega a este nivel.
  out.push(S(cyl(s, -22, 2.1, BEAM_Z + BEAM_H, 2.4, 20, 0.3), { tone: "mid" }));
  out.push(`<g data-lamp="${i}">${D([at([s, -22, BEAM_Z + BEAM_H + 2.4])], { size: 0.95, tone: "hi" })}</g>`);

  out.push(`<g data-head="${i}">${head(s)}</g>`);
  return out.join("");
}

/** Cabezal de sello montado en su carro transversal, construido en y = 0. */
function head(s) {
  const hx = s + 10;
  const out = [];
  const stamp = [];
  stamp.push(S(cyl(hx, 0, 1.1, PAD_REST + 5.2, HOUSING[1] - 2 - PAD_REST - 5.2, 14), { tone: "hi", crease: "none" }));
  stamp.push(S(slab({ x: hx - 3.5, y: -3.5, w: 7, d: 7, r: 1.4 }, PAD_REST + 1.2, 4, 3, 0.4), { tone: "mid" }));
  stamp.push(D([at([hx - 2, 2, PAD_REST + 5.2]), at([hx + 2, 2, PAD_REST + 5.2])], { size: 0.38, tone: "lo" }));
  stamp.push(S(cyl(hx, 0, 3, PAD_REST, 1.2, 24), { tone: "lo" }));
  out.push(`<g data-stamp>${stamp.join("")}</g>`);
  out.push(S(cyl(hx, 0, 2.2, HOUSING[0] - 2, 2, 18), { tone: "mid" }));
  out.push(S(cyl(hx, 0, 4.5, HOUSING[0], HOUSING[1] - HOUSING[0], 32), { tone: "mid", inner: L(k.sideArc(hx, 0, 4.5, 50, P, 24), { tone: "faint" }) }));
  out.push(L(k.knurl(hx, 0, 4.5, HOUSING[0] + 1.5, HOUSING[0] + 5.5, 22, P), { tone: "faint" }));
  out.push(S(slab({ x: s + 5, y: -5, w: 10.5, d: 10, r: 1 }, HOUSING[1], 3, 3, 0.4), { tone: "mid" }));
  out.push(S(slab({ x: s + 5, y: -6, w: 4.4, d: 12, r: 1 }, HOUSING[1] + 3, BEAM_Z + BEAM_H + 1 - HOUSING[1] - 3, 3, 0.4), { tone: "mid" }));
  out.push(D([at([s + 7.2, -3.6, BEAM_Z + BEAM_H + 1]), at([s + 7.2, 3.6, BEAM_Z + BEAM_H + 1])], { size: 0.42 }));
  return out.join("");
}

// ── Carro con la carpeta (construido en x = 0) ───────────────────────────
function carriage() {
  const out = [`<path class="iso-halo" d="${k.haloOf(k.insetPlan(CAR, 3), CAR_Z, 0.1, P)}" style="filter:blur(4px)"/>`];
  const bushings = byDepth([
    [-15, -6.5],
    [15, -6.5],
    [-15, 6.5],
    [15, 6.5],
  ]);
  for (const [x, y] of bushings) {
    out.push(S(slab({ x: x - 5, y: y - 3.5, w: 10, d: 7, r: 1.2 }, 6, CAR_Z - 6, 3), { tone: "lo" }));
  }
  out.push(S(slab(CAR, CAR_Z, CAR_TOP - CAR_Z, 4, 0.6), { tone: "mid" }));
  out.push(D([-15, -5, 5, 15].map((x) => at([x, CAR.y + CAR.d - 1.6, CAR_TOP])), { size: 0.38, tone: "lo" }));
  out.push(S(slab({ x: CAR.x + CAR.w, y: -3, w: 1, d: 6, r: 0.4 }, CAR_Z + 0.4, 2.2, 2), { tone: "lo", crease: "none" }));

  const pages = [11.9, 12.5, 13.1].map((z) => L(k.sideSeam(FOLDER, z, P, 3), { tone: "faint" })).join("");
  out.push(S(slab(FOLDER, CAR_TOP, FOLD_TOP - CAR_TOP, 3, 0.5), { tone: "hi", lit: true, inner: pages }));
  for (const x of SLOT_X) {
    out.push(L(k.ring(x, 0, SEAL_R + 0.5, FOLD_TOP, P, 28), { tone: "faint" }));
  }
  SLOT_X.forEach((x, slot) => {
    const ok = L(k.ring(x, 0, SEAL_R, FOLD_TOP, P, 28) + k.ring(x, 0, 1.4, FOLD_TOP, P, 20), { tone: "lit" });
    const na = L(k.ring(x, 0, SEAL_R, FOLD_TOP, P, 28), { tone: "mid", dashed: true });
    const c = SEAL_R * Math.SQRT1_2;
    const cross = L(k.ring(x, 0, SEAL_R, FOLD_TOP, P, 28) + k.lineOnTop([x - c, -c], [x + c, c], FOLD_TOP, P) + k.lineOnTop([x - c, c], [x + c, -c], FOLD_TOP, P), { tone: "lit" });
    out.push(`<g class="ca-mark" data-slot="${slot}"><g data-kind="ok">${ok}</g><g data-kind="na">${na}</g><g data-kind="x">${cross}</g></g>`);
  });

  out.push(S(slab({ x: CAR.x + 1, y: -12, w: 3, d: 24, r: 0.8 }, CAR_TOP, 3.4, 2, 0.3), { tone: "mid" }));
  out.push(D([at([CAR.x + 2.5, -8, CAR_TOP + 3.4]), at([CAR.x + 2.5, 8, CAR_TOP + 3.4])], { size: 0.4 }));

  const knob = [8, CAR.y + CAR.d + 3.2];
  out.push(S(slab({ x: knob[0] - 1.4, y: CAR.y + CAR.d - 0.4, w: 2.8, d: 2.4, r: 0.6 }, CAR_Z + 0.6, 2, 2), { tone: "mid", crease: "none" }));
  out.push(S(cyl(knob[0], knob[1], 2.2, CAR_Z, 4, 18), { tone: "mid" }));
  out.push(L(k.knurl(knob[0], knob[1], 2.2, CAR_Z, CAR_Z + 4, 16, P), { tone: "lo" }));
  return out.join("");
}

// ── Ensamble ──────────────────────────────────────────────────────────────
const slots = ST.map((s, i) => `<g data-slot-back="${i}">${backOf(s)}</g><g data-slot-front="${i}">${frontOf(s, i)}</g>`).join("");

const svg = k.figureSvg({
  width: WIDTH,
  height: HEIGHT,
  label:
    "Una línea de sellado sobre una base: un carro lleva una carpeta por un riel y se detiene bajo cuatro pórticos, almacén, revisor, gerencia y dirección general. Cada pórtico tiene un tope que retiene el carro y un cabezal que sella la carpeta cuando su nivel aprueba.",
  body: [
    `<g data-layer="base">${base()}${rail()}${endStop(END_A)}${bumper(END_A.x + END_A.w, DOCK_A - CAR.w / 2)}${pedestal(DOCK_A, -32, "a")}${pedestal(DOCK_B, -32, "b")}</g>`,
    `<g data-layer="stations">${slots}</g>`,
    `<g data-layer="end">${bumper(END_B.x, DOCK_B + CAR.w / 2 + 1)}${endStop(END_B)}</g>`,
  ].join(""),
});

const carriageSvg = `<g data-part="carriage" transform="${k.translateAlong(P, [DOCK_A, 0, 0])}">${carriage()}</g>`;
const figure = svg.replace('<g data-layer="stations">', `<g data-layer="stations">${carriageSvg}`);

// ── Comportamiento ────────────────────────────────────────────────────────
const live = `
const P = ${JSON.stringify(P)};
const ST = ${JSON.stringify(ST)}, STOP = ${JSON.stringify(STOP)}, PIN = ${JSON.stringify(PIN)};
const DOCK_A = ${DOCK_A}, DOCK_B = ${DOCK_B}, HALF = ${CAR.w / 2}, PIN_R = ${PIN_R}, PIN_UP = ${PIN_UP};
const PIN_Z = ${BED_TOP + 0.35}, PARK = ${PARK}, STROKE = ${STROKE};
${LIVE}
`;

const controls = `<div class="ca-controls" role="group" aria-label="Respuestas del nivel">
<button type="button" class="ca-btn" data-act="approve"><span class="ca-lamp" aria-hidden="true"></span><span data-label>Enviar</span></button>
<button type="button" class="ca-btn" data-act="return">Devolver</button>
<button type="button" class="ca-btn" data-act="cancel">Cancelar</button>
<span class="ca-sep" aria-hidden="true"></span>
<button type="button" class="ca-toggle" data-toggle="material" aria-pressed="true">Material</button>
<button type="button" class="ca-toggle" data-toggle="authorizer" aria-pressed="true">Con autorizador</button>
</div><span class="ca-live" aria-live="polite" data-live></span>`;

const plate = k.plateHtml({
  fig: "Fig 1",
  title: "Cadena de aprobación",
  hint: "Espacio aprueba · D devuelve · C cancela",
  readout: "borrador · espera al solicitante",
  keys: [
    { mark: "lit", label: "La requisición: una carpeta que recibe un sello por nivel" },
    { mark: "raised", label: "Pórticos, de izquierda a derecha: almacén, revisor, gerencia y DG" },
    { mark: "dashed", label: "Firma N/A: el nivel no existe en la cadena y el estado se registra solo" },
  ],
  caption:
    "La requisición viaja por su cadena como una carpeta en un carro. El tope de cada pórtico retiene el carro hasta que el nivel responde: aprobar sella la carpeta y baja el tope; devolver la regresa al solicitante, que vuelve a enviarla desde el principio; cancelar la sella con una cruz y termina el flujo. Los servicios no pasan por almacén. Si la cadena no tiene autorizador, el cabezal de DG queda estacionado: la carpeta pasa sola y «aprobado por DG» se registra con firma N/A.",
  body: `<div class="iso-stage ca-stage" tabindex="0" role="group" aria-label="Cadena de aprobación. Espacio aprueba o envía, D devuelve, C cancela, M cambia material o servicio, N quita o pone el autorizador.">${figure}</div>`,
}).replace("<figcaption", `${controls}<figcaption`);

const CSS = `<style>
.ca-mark>g{opacity:0;transition:opacity 420ms var(--anatomy-ease)}
.ca-mark[data-show="ok"]>[data-kind="ok"],.ca-mark[data-show="na"]>[data-kind="na"],.ca-mark[data-show="x"]>[data-kind="x"]{opacity:1;transition-duration:60ms}
.ca-stage{outline:none;touch-action:pan-y}
.ca-stage:focus-visible{outline:1px solid var(--anatomy-muted);outline-offset:6px}
[data-lamp] circle{transition:opacity 300ms var(--anatomy-ease)}
[data-lamp]:not([data-on]) circle{opacity:.12}
[data-lamp][data-on] circle{animation:ca-blink 1400ms var(--anatomy-ease) infinite}
@keyframes ca-blink{0%,100%{opacity:1}50%{opacity:.25}}
.ca-controls{display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-top:14px;font-family:var(--anatomy-mono);font-size:10.5px;letter-spacing:.1em;text-transform:uppercase}
.ca-btn,.ca-toggle{display:inline-flex;align-items:center;gap:8px;height:28px;padding:0 13px;border:0;border-radius:999px;background:var(--anatomy-face);color:var(--anatomy-strong);font:inherit;letter-spacing:.12em;text-transform:uppercase;cursor:pointer;box-shadow:inset 0 0 0 1px var(--anatomy-faint);transition:background 200ms var(--anatomy-ease),color 200ms var(--anatomy-ease),opacity 200ms var(--anatomy-ease),transform 160ms var(--anatomy-ease)}
.ca-btn:hover,.ca-toggle:hover{box-shadow:inset 0 0 0 1px var(--anatomy-lo)}
.ca-btn:active,.ca-toggle:active{transform:scale(.97)}
.ca-btn:focus-visible,.ca-toggle:focus-visible{outline:1px solid var(--anatomy-muted);outline-offset:3px}
.ca-btn[disabled]{opacity:.35;cursor:default;transform:none}
.ca-toggle{background:transparent;color:var(--anatomy-muted)}
.ca-toggle[aria-pressed="false"]{color:var(--anatomy-text);box-shadow:inset 0 0 0 1px var(--anatomy-lo)}
.ca-lamp{width:7px;height:7px;border-radius:50%;background:var(--anatomy-lo)}
.ca-btn[data-ready] .ca-lamp{background:var(--anatomy-lit)}
.ca-sep{width:1px;height:18px;background:var(--anatomy-faint);margin:0 4px}
.ca-live{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap}
@media (max-width:560px){.iso-plate{overflow:hidden;padding-bottom:52px}.iso-plate .ca-stage .iso-svg{width:114%;max-width:none;margin:0 0 0 -7%}.iso-plate-corner[data-corner="hint"]{display:none}.ca-sep{display:none}}
@media (prefers-reduced-motion:reduce){[data-lamp][data-on] circle{animation:none}.ca-mark>g{transition:none}}
</style>`;

const file = theme === "light" ? "cadena-aprobacion-light.html" : "cadena-aprobacion.html";
writeFileSync(join(HERE, file), k.pageHtml({ title: "Cadena de aprobación", theme, body: CSS + plate, script: kitScript() + live, width: 720 }).replace('<html lang="en">', '<html lang="es">'));
console.log("wrote", file);
