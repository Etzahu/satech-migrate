// Comportamiento en vivo de la cadena de aprobación. Se incrusta en la página
// después del kit, así que usa cylinder(), solidSvg() y translateAlong().
// Las constantes de geometría (P, ST, STOP, PIN, …) las escribe build.mjs.

const LEVELS = [
  { ok: "revisión", back: "devuelto por almacén", cancel: null, who: "a almacén", name: "almacén" },
  { ok: "aprobado por revisor", back: "devuelto por revisor", cancel: "cancelado por revisor", who: "al revisor", name: "revisor" },
  { ok: "aprobado por gerencia", back: "devuelto por gerencia", cancel: "cancelado por gerencia", who: "a gerencia", name: "gerencia" },
  { ok: "aprobado por DG", back: "devuelto por DG", cancel: "cancelado por DG", who: "a DG", name: "DG" },
];
const PRESS = { rise: 0.16, hold: 0.3, fall: 0.62 };

const stage = document.querySelector(".ca-stage");
const svg = stage.querySelector("svg");
const layer = svg.querySelector('[data-layer="stations"]');
const car = svg.querySelector('[data-part="carriage"]');
const order = ST.flatMap((_, i) => [layer.querySelector(`[data-slot-back="${i}"]`), layer.querySelector(`[data-slot-front="${i}"]`)]);
const pins = ST.map((_, i) => svg.querySelector(`[data-pin="${i}"]`));
const heads = ST.map((_, i) => svg.querySelector(`[data-head="${i}"]`));
const stamps = heads.map((head) => head.querySelector("[data-stamp]"));
const marks = [...svg.querySelectorAll(".ca-mark")];
const lamps = new Map([...svg.querySelectorAll("[data-lamp]")].map((lamp) => [lamp.dataset.lamp, lamp]));
const readout = document.querySelector("[data-readout]");
const announcer = document.querySelector("[data-live]");
const buttons = Object.fromEntries([...document.querySelectorAll("[data-act]")].map((button) => [button.dataset.act, button]));
const toggles = Object.fromEntries([...document.querySelectorAll("[data-toggle]")].map((button) => [button.dataset.toggle, button]));
const approveLabel = buttons.approve.querySelector("[data-label]");
const still = matchMedia("(prefers-reduced-motion: reduce)");

const FRONT = HALF + 1;
const config = { material: true, authorizer: true };
const flow = { status: "borrador", at: -1, finished: false, resetting: false, detail: "", marks: [null, null, null, null] };
const carX = { x: DOCK_A };
const pinH = PIN.map(() => PIN_UP);
const pinOpen = PIN.map(() => false);
const headY = ST.map(() => 0);
const press = ST.map(() => null);
let trip = null;

/** ¿El nivel existe en esta cadena? Almacén solo para materiales; DG solo con autorizador. */
const active = (level) => (level === 0 ? config.material : level === 3 ? config.authorizer : true);
const nextActive = (level) => {
  let next = level;
  while (next <= 3 && !active(next)) next++;
  return next;
};
const destOf = (level) => (level === -1 ? DOCK_A : level === 4 ? DOCK_B : STOP[level]);
const smootherstep = (t) => (t <= 0 ? 0 : t >= 1 ? 1 : t * t * t * (t * (t * 6 - 15) + 10));
const smoothstep = (t) => (t <= 0 ? 0 : t >= 1 ? 1 : t * t * (3 - 2 * t));
const busy = () => trip !== null || press.some(Boolean);

function setStatus(status, detail = "") {
  if (flow.status !== status) {
    announcer.textContent = status;
  }
  flow.status = status;
  flow.detail = detail;
}

// ── Viajes del carro ──────────────────────────────────────────────────────
function travel(level, arrive) {
  const dest = destOf(level);
  const from = carX.x;
  const dir = Math.sign(dest - from);
  const passing = new Set(
    PIN.map((_, i) => i).filter((i) =>
      dir > 0 ? PIN[i] > from + FRONT && PIN[i] < dest + FRONT + PIN_R + 1 : PIN[i] < from - HALF && PIN[i] > dest - HALF - PIN_R - 1,
    ),
  );
  passing.forEach((i) => (pinOpen[i] = true));
  const span = Math.abs(dest - from);
  trip = { level, from, dest, dir, passing, arrive, age: 0, time: Math.min(2.4, 0.55 + span / 150), started: false };
}

function stepTrip(dt, calm) {
  if (!trip) return;
  const hold = [...trip.passing].some((i) => pinH[i] > 0.15);
  if (!trip.started && hold && !calm) return;
  trip.started = true;
  trip.age += dt;
  const share = calm ? 1 : smootherstep(trip.age / trip.time);
  carX.x = trip.from + (trip.dest - trip.from) * share;
  for (const i of [...trip.passing]) {
    const gone = trip.dir > 0 ? carX.x - HALF > PIN[i] + PIN_R + 0.6 : carX.x + FRONT < PIN[i] - PIN_R - 0.6;
    if (gone || share >= 1) {
      pinOpen[i] = false;
      trip.passing.delete(i);
    }
  }
  // Sin autorizador el nivel de DG no existe: al cruzar su pórtico la requisición
  // queda «aprobado por DG» sola y la firma se imprime como N/A.
  if (trip.dir > 0 && trip.dest >= DOCK_B && !active(3) && !flow.marks[3] && carX.x >= STOP[3]) {
    flow.marks[3] = "na";
    setStatus("aprobado por DG", "firma N/A");
  }
  if (share >= 1) {
    const { level, arrive } = trip;
    trip = null;
    flow.at = level;
    if (arrive) arrive();
  }
}

// ── Prensa del sello ──────────────────────────────────────────────────────
function stamp(level, kind, then) {
  press[level] = { age: 0, kind, then, inked: false };
}

function pressEnvelope(age) {
  if (age < PRESS.rise) return smoothstep(age / PRESS.rise);
  if (age < PRESS.hold) return 1;
  return 1 - smoothstep((age - PRESS.hold) / (PRESS.fall - PRESS.hold));
}

function stepPress(dt, calm) {
  press.forEach((job, level) => {
    if (!job) return;
    job.age = calm ? PRESS.fall : job.age + dt;
    if (!job.inked && job.age >= PRESS.rise * 0.92) {
      job.inked = true;
      flow.marks[level] = job.kind;
    }
    if (job.age >= PRESS.fall) {
      press[level] = null;
      job.then();
    }
  });
}

// ── Respuestas de cada nivel (PurchaseRequisitionStateMachine) ───────────
function approve() {
  if (busy()) return;
  if (flow.finished) return restart();
  if (flow.at === -1) {
    const first = nextActive(0);
    setStatus(first === 0 ? "revisión por almacén" : "revisión");
    return travel(first);
  }
  if (flow.at === 4) {
    if (flow.status === "aprobado por DG") {
      setStatus("comprador asignado");
      flow.finished = true;
    }
    return;
  }
  const level = flow.at;
  stamp(level, "ok", () => {
    setStatus(LEVELS[level].ok);
    travel(nextActive(level + 1));
  });
}

function giveBack() {
  if (busy() || flow.finished || flow.at === -1) return;
  setStatus(flow.at === 4 ? "devuelto por gerente de compras" : LEVELS[flow.at].back);
  travel(-1, () => flow.marks.fill(null));
}

function cancel() {
  if (busy() || flow.finished || flow.at < 1 || flow.at > 3) return;
  const level = flow.at;
  stamp(level, "x", () => {
    setStatus(LEVELS[level].cancel);
    flow.finished = true;
  });
}

function restart() {
  flow.resetting = true;
  travel(-1, () => {
    flow.marks.fill(null);
    flow.finished = false;
    flow.resetting = false;
    setStatus("borrador");
  });
}

/** Deja la línea lista para una requisición nueva, esté donde esté. */
function home() {
  if (busy()) return;
  const fresh = flow.at === -1 && !flow.finished && flow.status === "borrador" && flow.marks.every((mark) => !mark);
  if (!fresh) restart();
}

function setConfig(name, value) {
  if (busy() || config[name] === value) return;
  config[name] = value;
  // Si el carro espera en un nivel que deja de existir, avanza solo.
  if (!flow.finished && flow.at >= 0 && flow.at <= 3 && !active(flow.at)) {
    const level = flow.at;
    if (level === 0) setStatus("revisión");
    travel(nextActive(level + 1));
  }
}

// ── Dibujo ────────────────────────────────────────────────────────────────
let slotAt = -1;
const drawn = { pins: PIN.map(() => -1), heads: ST.map(() => 0), stamps: ST.map(() => 0), car: null };

function placeCarriage() {
  let slot = 0;
  ST.forEach((s, i) => {
    if (carX.x > s - 30) slot = 2 * i + 1;
    if (carX.x > s + 32) slot = 2 * i + 2;
  });
  if (slot === slotAt) return;
  slotAt = slot;
  layer.insertBefore(car, order[slot] || null);
}

function detailOf() {
  if (trip) {
    if (trip.dir <= 0) return flow.resetting ? "nueva requisición" : "regresa al solicitante";
    if (flow.detail) return flow.detail;
    return trip.level === 4 ? "va a compras" : `va ${LEVELS[trip.level].who}`;
  }
  if (press.some(Boolean)) return "sellando";
  if (flow.finished) return "fin del flujo";
  if (flow.at === -1) return "espera al solicitante";
  if (flow.at === 4) return "espera a compras";
  return `espera ${LEVELS[flow.at].who}`;
}

function draw() {
  const moved = drawn.car !== carX.x;
  if (moved) {
    drawn.car = carX.x;
    car.setAttribute("transform", translateAlong(P, [carX.x, 0, 0]));
    placeCarriage();
  }
  pins.forEach((pin, i) => {
    const h = Math.round(pinH[i] * 50) / 50;
    if (h === drawn.pins[i]) return;
    drawn.pins[i] = h;
    pin.innerHTML = h < 0.05 ? "" : solidSvg(cylinder(PIN[i], 0, PIN_R, PIN_Z, h, P, 20, Math.min(0.3, h / 3)), { tone: "hi" });
  });
  heads.forEach((head, i) => {
    if (headY[i] === drawn.heads[i]) return;
    drawn.heads[i] = headY[i];
    head.setAttribute("transform", translateAlong(P, [0, headY[i], 0]));
  });
  stamps.forEach((group, i) => {
    const down = press[i] ? pressEnvelope(press[i].age) : 0;
    if (down === drawn.stamps[i]) return;
    drawn.stamps[i] = down;
    if (down) group.setAttribute("transform", translateAlong(P, [0, 0, -STROKE * down]));
    else group.removeAttribute("transform");
  });
  marks.forEach((mark, slot) => {
    const show = flow.marks[slot] || "";
    if (mark.dataset.show !== show) mark.dataset.show = show;
  });

  const idle = !busy();
  const waiting = flow.finished ? null : flow.at === -1 ? "a" : flow.at === 4 ? (flow.status === "aprobado por DG" ? "b" : null) : String(flow.at);
  lamps.forEach((lamp, key) => {
    const on = idle && key === waiting;
    if (on !== lamp.hasAttribute("data-on")) lamp.toggleAttribute("data-on", on);
  });

  const text = `${flow.status} · ${detailOf()}`;
  if (readout.textContent !== text) readout.textContent = text;

  const label = flow.finished ? "Nueva" : flow.at === -1 ? "Enviar" : flow.at === 4 ? "Asignar comprador" : "Aprobar";
  if (approveLabel.textContent !== label) approveLabel.textContent = label;
  const can = {
    approve: idle && !(flow.at === 4 && !flow.finished && flow.status !== "aprobado por DG"),
    return: idle && !flow.finished && flow.at !== -1,
    cancel: idle && !flow.finished && flow.at >= 1 && flow.at <= 3,
  };
  for (const [name, button] of Object.entries(buttons)) {
    if (button.disabled === !can[name]) continue;
    button.disabled = !can[name];
  }
  buttons.approve.toggleAttribute("data-ready", can.approve);
  for (const [name, button] of Object.entries(toggles)) {
    const pressed = String(config[name]);
    if (button.getAttribute("aria-pressed") !== pressed) {
      button.setAttribute("aria-pressed", pressed);
      button.textContent = name === "material" ? (config.material ? "Material" : "Servicio") : config.authorizer ? "Con autorizador" : "Sin autorizador";
    }
    button.disabled = !idle;
  }
}

// ── Recorrido automático ──────────────────────────────────────────────────
const TOUR = [
  ["home"],
  ["set", { material: true, authorizer: true }],
  ["approve"], ["approve"], ["approve"], ["approve"], ["approve"], ["approve"], ["approve"],
  ["set", { material: false, authorizer: false }],
  ["approve"], ["approve"], ["approve"], ["approve"], ["approve"],
  ["set", { material: true, authorizer: true }],
  ["approve"], ["approve"], ["return"],
  ["approve"], ["approve"], ["approve"], ["cancel"], ["approve"],
];
const ACTIONS = { approve, return: giveBack, cancel, home };
let touring = !still.matches;
let tourStep = 0;
let quiet = 0;
let hovering = false;
let idleTimer = 0;

function stepTour(dt) {
  if (!touring || hovering) return;
  if (busy()) {
    quiet = 0;
    return;
  }
  quiet += dt;
  const [name, value] = TOUR[tourStep];
  const wait = tourStep === 0 ? 1.4 : name === "set" ? 0.8 : 1.15;
  if (quiet < wait) return;
  quiet = 0;
  if (name === "set") {
    for (const [key, setting] of Object.entries(value)) setConfig(key, setting);
  } else {
    ACTIONS[name]();
  }
  tourStep = (tourStep + 1) % TOUR.length;
}

function takeOver() {
  touring = false;
  clearTimeout(idleTimer);
  idleTimer = setTimeout(() => {
    if (still.matches) return;
    // El recorrido retoma desde el inicio: primero regresa la carpeta.
    tourStep = 0;
    touring = true;
    quiet = 0;
    run();
  }, 9000);
}

// ── Bucle ─────────────────────────────────────────────────────────────────
let frame = 0;
let last = 0;
let visible = false;

function tick(now) {
  const dt = last ? Math.min((now - last) / 1000, 1 / 30) : 1 / 60;
  last = now;
  const calm = still.matches;
  stepTour(dt);
  stepPress(dt, calm);
  stepTrip(dt, calm);
  let settling = false;
  PIN.forEach((x, i) => {
    const under = carX.x + FRONT > x - PIN_R - 0.1 && carX.x - HALF < x + PIN_R + 0.1;
    const want = active(i) && !pinOpen[i] && !under ? PIN_UP : 0;
    pinH[i] = calm ? want : pinH[i] + (want - pinH[i]) * (1 - Math.exp(-dt / 0.06));
    if (Math.abs(want - pinH[i]) < 0.01) pinH[i] = want;
    if (pinH[i] !== want) settling = true;
  });
  ST.forEach((_, i) => {
    const want = active(i) ? 0 : PARK;
    headY[i] = calm ? want : headY[i] + (want - headY[i]) * (1 - Math.exp(-dt / 0.22));
    if (Math.abs(want - headY[i]) < 0.01) headY[i] = want;
    if (headY[i] !== want) settling = true;
  });
  draw();
  const rest = (!touring || hovering) && !busy() && !settling;
  frame = visible && !rest ? requestAnimationFrame(tick) : 0;
}

function run() {
  if (!frame && visible) {
    last = 0;
    frame = requestAnimationFrame(tick);
  }
}

function act(name, value) {
  takeOver();
  if (name === "toggle") setConfig(value, !config[value]);
  else ACTIONS[name]();
  run();
}

new IntersectionObserver((entries) => {
  visible = entries[entries.length - 1].isIntersecting;
  if (visible) run();
}, { rootMargin: "120px 0px" }).observe(stage);

for (const [name, button] of Object.entries(buttons)) button.addEventListener("click", () => act(name));
for (const [name, button] of Object.entries(toggles)) button.addEventListener("click", () => act("toggle", name));
stage.addEventListener("pointerenter", () => { hovering = true; });
stage.addEventListener("pointerleave", () => { hovering = false; run(); });
stage.addEventListener("click", () => act("approve"));
stage.addEventListener("keydown", (event) => {
  const key = event.key.toLowerCase();
  const map = { " ": ["approve"], enter: ["approve"], d: ["return"], c: ["cancel"], m: ["toggle", "material"], n: ["toggle", "authorizer"] };
  if (!map[key]) return;
  event.preventDefault();
  act(...map[key]);
});
stage.addEventListener("focus", () => {
  announcer.textContent = `${flow.status} · ${detailOf()}`;
});
still.addEventListener("change", () => {
  touring = !still.matches;
  run();
});
draw();
