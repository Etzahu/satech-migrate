---
name: presentacion-brand-colors
description: Aplicar paleta de colores institucional cada vez que se generen presentaciones de PowerPoint, slides o decks visuales.
---

# 🎨 Guía de colores institucionales para presentaciones

Esta skill define la paleta de colores oficial que debe usarse en **todas las presentaciones** (PowerPoint, Google Slides, decks HTML/CSS, etc.).

---

## 🟥 Primary (Rojo intenso)

**Color principal** para botones, acentos, títulos destacados, links y elementos interactivos.

| Token | Código HEX | Uso en Tailwind |
|---|---|---|
| Primary | `#C8102E` | `bg-[#C8102E]`, `text-[#C8102E]`, `border-[#C8102E]` |
| Primary-dark | `#A50D26` | `bg-[#A50D26]`, `text-[#A50D26]` → hover/active states |
| Primary-light | `#E53E50` | `bg-[#E53E50]`, `text-[#E53E50]` → fondos suaves |

**Cuándo usarlo:**
- Botones de acción principales
- Títulos de sección (slide titles)
- Links e hipervínculos
- Íconos clave y bullets destacados
- Barras decorativas o separadores
- Fondos de slides de apertura/cierre

---

## 🟡 Accent / Secondary (Amarillo dorado)

**Color de apoyo** para highlights, advertencias (warnings), y calls-to-action secundarias.

| Token | Código HEX | Uso en Tailwind |
|---|---|---|
| Accent | `#F6BE00` | `bg-[#F6BE00]`, `text-[#F6BE00]`, `border-[#F6BE00]` |

**Cuándo usarlo:**
- Badges y etiquetas de aviso/alerta
- Destacar cifras o datos clave (highlights)
- CTAs secundarios
- Elementos que requieren atención pero no son acción primaria
- Íconos de advertencia o precaución

---

## ⬛ Neutral-dark (Gris oscuro)

**Color base** para textos principales, fondos oscuros y tipografía de cuerpo.

| Token | Código HEX | Uso en Tailwind |
|---|---|---|
| Neutral-dark | `#5B5754` | `text-[#5B5754]`, `bg-[#5B5754]` |

**Cuándo usarlo:**
- Texto de cuerpo (párrafos, bullets)
- Fondos de secciones oscuras
- Títulos cuando no se usa el primary
- Barras de navegación o footers

---

## ⬜ Neutral-muted (Gris medio)

**Color secundario** para textos menos relevantes, bordes y elementos deshabilitados.

| Token | Código HEX | Uso en Tailwind |
|---|---|---|
| Neutral-muted | `#747576` | `text-[#747576]`, `border-[#747576]`, `bg-[#747576]` |

**Cuándo usarlo:**
- Textos secundarios, footnotes, leyendas
- Bordes de tarjetas y contenedores
- Separadores sutiles (líneas, hr)
- Estados deshabilitados (disabled)
- Iconografía secundaria

---

## 📋 Reglas de aplicación obligatorias

### ✅ Para presentaciones HTML/Tailwind

- Usar siempre las clases con corchetes: `bg-[#C8102E]`, `text-[#5B5754]`, etc.
- No usar colores genéricos como `bg-red-500` o `text-gray-600`.
- Asegurar **contraste suficiente**: texto claro sobre fondos oscuros y viceversa.
- Mantener consistencia cromática entre slides.

### ✅ Para archivos .pptx / Google Slides

- Aplicar los códigos HEX exactos en:
  - Fondos de slide
  - Color de fuente
  - Relleno de formas
  - Bordes y líneas
  - Sombras y efectos
- Usar el **Theme Colors** del master slide cuando sea posible para mantener consistencia automática.

### ✅ Jerarquía visual recomendada

| Elemento | Color |
|---|---|
| Título principal del slide | `#C8102E` (Primary) |
| Subtítulos | `#5B5754` (Neutral-dark) |
| Texto de cuerpo | `#5B5754` (Neutral-dark) |
| Texto secundario / notas | `#747576` (Neutral-muted) |
| Botones de acción | `#C8102E` bg + texto blanco |
| Highlights / alertas | `#F6BE00` (Accent) |
| Fondos de slide claros | Blanco o `#E53E50` con opacidad baja |
| Fondos de slide oscuros | `#5B5754` |

---

## 🎯 Resumen rápido de códigos
