// Captura pantallas reales del flujo "crear requisición" del panel Compras.
// Autenticación: inyecta las cookies de sesión (jar generado con curl vía /id/199 + /empresa/2).
// Uso: node my-video/assets/screens/capture.mjs   (desde la raíz del proyecto)
import puppeteer from 'puppeteer';
import fs from 'fs';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

const __dirname = dirname(fileURLToPath(import.meta.url));
const BASE = 'http://satech-migrate.org';
const HOST = 'satech-migrate.org';
const OUT = __dirname;
const JAR = join(OUT, 'cookies.txt');

const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

// Parsea un cookie jar Netscape (el de curl) a formato Puppeteer.
function parseJar(path) {
  const cookies = [];
  for (let line of fs.readFileSync(path, 'utf8').split(/\r?\n/)) {
    let httpOnly = false;
    if (line.startsWith('#HttpOnly_')) { httpOnly = true; line = line.slice(10); }
    else if (line.startsWith('#') || !line.trim()) continue;
    const p = line.split('\t');
    if (p.length < 7) continue;
    const name = p[5];
    const value = p[6];
    if (!name) continue;
    cookies.push({ name, value, url: BASE });
  }
  return cookies;
}

async function go(page, path) {
  await page.goto(BASE + path, { waitUntil: 'networkidle2', timeout: 60000 });
  await sleep(1300); // fuentes + animaciones de entrada
}

async function clickByText(page, text) {
  const ok = await page.evaluate((t) => {
    const els = [...document.querySelectorAll('button,a,[role="tab"]')];
    const el = els.find((e) => e.textContent.trim().toLowerCase().includes(t.toLowerCase()));
    if (el) { el.scrollIntoView({ block: 'center' }); el.click(); return true; }
    return false;
  }, text);
  await sleep(1000);
  return ok;
}

async function shot(page, name) {
  await page.screenshot({ path: join(OUT, name), fullPage: false });
  console.log('OK ->', name, '| url:', page.url());
}

const browser = await puppeteer.launch({
  headless: 'new',
  args: ['--no-sandbox', '--disable-dev-shm-usage', '--hide-scrollbars'],
  defaultViewport: { width: 1920, height: 1080, deviceScaleFactor: 2 },
});

try {
  const page = await browser.newPage();
  page.setDefaultTimeout(60000);

  const cookies = parseJar(JAR);
  await page.setCookie(...cookies);
  console.log('Cookies inyectadas:', cookies.map((c) => c.name).join(', '));

  // 1) Inicio (dashboard)
  await go(page, '/compras');
  await shot(page, '01-inicio.png');

  // 2) Lista "Mis requisiciones" (badge + botón Crear)
  await go(page, '/compras/mis-requisiciones');
  await shot(page, '02-lista.png');

  // 3) Formulario nuevo — Información general
  await go(page, '/compras/mis-requisiciones/create');
  await shot(page, '03-form-general.png');

  // 4) Pestaña Flujo de aprobación
  await clickByText(page, 'Flujo de aprobación');
  await shot(page, '04-form-flujo.png');

  // 5) Pestaña Fichas técnicas
  await clickByText(page, 'Fichas técnicas');
  await shot(page, '05-form-fichas.png');

  // 6) Pestaña Observación
  await clickByText(page, 'Observación');
  await shot(page, '06-form-observacion.png');

  // 7) Ver requisición existente (folio + estatus + datos)
  await go(page, '/compras/mis-requisiciones/927');
  await shot(page, '07-ver-folio.png');

  // 8) Editar — formulario + botón "Enviar a revisión"
  await go(page, '/compras/mis-requisiciones/927/edit');
  await shot(page, '08-editar.png');

  // 9) Scroll a la tabla de Partidas
  await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
  await sleep(900);
  await shot(page, '09-partidas.png');

  console.log('LISTO');
} catch (e) {
  console.error('ERROR:', e.message);
  process.exitCode = 1;
} finally {
  await browser.close();
}
