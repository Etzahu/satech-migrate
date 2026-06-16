# Guia para grabar el Tutorial en Video con Recordly
## Sistema SA-TECH | Requisiciones de Compra

---

## ¿Que es Recordly?

Recordly es una herramienta gratuita para grabar y pulir tutoriales de pantalla. Agrega auto-zoom en los puntos clave, suaviza los movimientos del cursor y exporta en MP4 o GIF con un aspecto profesional.

---

## Instalacion rapida

```bash
# Instalar Recordly
bash scripts/install_recordly.sh

# Lanzar Recordly
bash scripts/launch_recordly.sh
```

O descarga desde: https://github.com/webadderall/Recordly/releases

---

## Preparacion antes de grabar

### 1. Configura tu entorno
- [ ] Abre el sistema SA-TECH en tu navegador (pantalla completa o 90% del monitor)
- [ ] Cierra pestanas y notificaciones innecesarias
- [ ] Si narras con microfono, prueba el audio antes
- [ ] Usa un usuario de prueba con rol `solicita_requisicion_compra` y datos de ejemplo listos

### 2. Ten a la mano
- Un usuario de prueba logueado en el sistema
- Una requisicion en borrador para demostrar edicion
- Un proyecto activo disponible en el catalogo
- Al menos 1-2 productos en el catalogo para agregar como partidas

### 3. Ajusta la resolucion
Graba en 1920x1080 (Full HD) para mejor calidad de zoom.

---

## Script del video (escenas sugeridas)

### Escena 1 — Introduccion (15-20 seg)
**Pantalla:** Logo SA-TECH / pantalla de inicio

> "Bienvenido a esta guia rapida para solicitar una requisicion de compra en el sistema SA-TECH. Vamos a ver paso a paso como crear, enviar y dar seguimiento a tus solicitudes."

---

### Escena 2 — Acceso al modulo (20-30 seg)
**Pantalla:** Menu lateral del sistema

**Accion:** Mostrar el menu lateral → clic en "Requisiciones" → clic en "Mis requisiciones"

> "Desde el menu lateral, ve a la seccion 'Requisiciones' y selecciona 'Mis requisiciones'. Aqui veras todas tus solicitudes y podras crear nuevas."

**Sugerencia Recordly:** Auto-zoom en el menu lateral al hacer clic.

---

### Escena 3 — Nueva requisicion (15 seg)
**Pantalla:** Listado de "Mis requisiciones"

**Accion:** Clic en el boton "Nueva requisicion"

> "Para crear una nueva, haz clic en el boton 'Nueva requisicion' en la esquina superior derecha."

**Sugerencia Recordly:** Auto-zoom en el boton antes del clic.

---

### Escena 4 — Informacion general (60-90 seg)
**Pantalla:** Formulario de nueva requisicion

**Acciones paso a paso:**
1. Seleccionar Categoria → "Proveeduria"
2. Escribir Referencia → "Herramientas para proyecto norte"
3. Seleccionar Prioridad → "Media"
4. Seleccionar Tipo → "Compra"
5. Elegir Fecha de entrega
6. Escribir Direccion de entrega
7. Seleccionar Proyecto de la lista

> "Llena todos los campos obligatorios: la categoria (servicio o proveeduria), la referencia que describe que necesitas, la prioridad, el tipo de requisicion, la fecha en que la necesitas y el proyecto al que se cargara."

**Sugerencia Recordly:** Pausa 1-2 segundos en cada campo antes de escribir.

---

### Escena 5 — Flujo de aprobacion (30 seg)
**Pantalla:** Pestana "Flujo de aprobacion"

**Acciones:**
1. Clic en pestana "Flujo de aprobacion"
2. Seleccionar Revisor
3. Seleccionar Aprobador

> "En la pestana de Flujo de aprobacion, elige quien revisara y quien aprobara tu requisicion. Las opciones disponibles dependen de tu area y cadena asignada."

---

### Escena 6 — Agregar partidas (60-90 seg)
**Pantalla:** Seccion "Partidas" en el formulario guardado

**Acciones:**
1. Clic en "Nueva partida"
2. Escribir cantidad → "5"
3. Buscar y seleccionar producto → escribir en el buscador, seleccionar
4. Mostrar que el codigo, descripcion y UM se llenan automaticamente
5. Escribir observacion
6. Clic en "Guardar"
7. Mostrar que la partida aparece en la tabla
8. Agregar una segunda partida (opcional, para mostrar que pueden ser varias)

> "Una vez guardada la informacion general, agrega las partidas. Cada partida es un producto o servicio que necesitas. Especifica la cantidad, selecciona el producto del catalogo y agrega una observacion si es necesario."

**Sugerencia Recordly:** Zoom en el campo de busqueda de producto y en los datos que se autocompletan.

---

### Escena 7 — Enviar la requisicion (20-30 seg)
**Pantalla:** Formulario con partidas listas

**Accion:** Mostrar el boton de envio y hacer clic

> "Con la informacion completa y las partidas agregadas, haz clic en 'Enviar' para iniciar el proceso de aprobacion. El sistema notificara automaticamente al revisor por correo."

**Sugerencia Recordly:** Zoom en el boton de envio.

---

### Escena 8 — Dar seguimiento (30-40 seg)
**Pantalla:** Detalle de una requisicion enviada

**Acciones:**
1. Volver al listado → mostrar el estatus en la tabla
2. Abrir una requisicion → clic en "Ver"
3. Mostrar pestana "Flujo de aprobacion" con la barra de progreso
4. Mostrar pestana "Historial"

> "Puedes revisar el avance de tu requisicion en cualquier momento. La pestana 'Flujo de aprobacion' muestra el progreso y el 'Historial' registra cada cambio de estado."

---

### Escena 9 — Cierre (10-15 seg)
**Pantalla:** Pantalla inicial o logo

> "Eso es todo. Ahora ya sabes como crear y dar seguimiento a tus requisiciones en SA-TECH. Si tienes dudas o problemas de acceso, contacta al administrador del sistema."

---

## Configuracion recomendada en Recordly

| Ajuste | Valor sugerido |
|--------|----------------|
| Auto-zoom | Activado, nivel medio |
| Efecto cursor | Click bounce + suavizado |
| Fondo | Color solido rojo oscuro (#A50D26) o gradiente |
| Recorte | Sin bordes negros; ajusta al area del navegador |
| Exportar | MP4, 1080p, H.264 |

---

## Publicar con Slant (efecto 3D)

Si quieres una version con perspectiva 3D para presentaciones o redes sociales:

```bash
# Abre el renderer 3D en el navegador
open scripts/slant.html
```

1. Arrastra tu MP4 al viewport
2. Elige el preset "Hero Float" o "Dramatic Tilt"
3. Ajusta el fondo al rojo institucional (#A50D26)
4. Exporta en MP4 o GIF

---

## Checklist final antes de publicar

- [ ] El video dura entre 3 y 6 minutos (ideal para tutoriales internos)
- [ ] Se escucha bien el audio (si hay narracion)
- [ ] Los zooms se ven naturales, no bruscos
- [ ] Se ven claramente todos los campos del formulario
- [ ] No hay datos sensibles reales en pantalla (usa datos de prueba)
- [ ] El logo SA-TECH es visible al inicio y al final
