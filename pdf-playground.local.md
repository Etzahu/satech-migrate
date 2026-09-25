---
brand:
  name: "SA-TECH"
  tagline: "Sistema de Compras · GPT Services"
  website: "https://app.gptsatech.com"
  email: "soporte-ti@gptservices.com"

colors:
  primary: "#D0112B"      # Rojo corporativo, muestreado de logotipo_GPT.png
  secondary: "#162d4d"    # Azul de los encabezados en las notificaciones del sistema
  accent: "#F7BE07"       # Amarillo corporativo, muestreado de logotipo_GPT.png
  background: "#FFFFFF"
  text: "#343a40"         # Texto de los correos del sistema
  muted: "#6c6c6c"

fonts:
  heading: "Playfair Display"
  body: "Source Sans 3"

style:
  headingCase: "sentence"
  useOxfordComma: false
---

# Notas de marca

No existe un manual de identidad en el repositorio. Los colores de arriba se
muestrearon directamente de los archivos de logotipo, que son la única fuente
autorizada que hay.

## Dónde se aplica esta configuración

Las guías de uso del sistema de compras se generan con este diseño:

| | |
|---|---|
| Hoja de estilos | `resources/views/pdf/guides/_estilos.blade.php` |
| Vistas de las guías | `resources/views/pdf/guides/*.blade.php` |
| Tipografías | `resources/fonts/*.woff2` |
| Comando | `php artisan guias:pdf` |

Las tipografías se guardan en el repositorio y se incrustan en el documento como
data URI. Chrome headless no espera a que Google Fonts responda, así que un
`<link>` deja el PDF en Arial; además, así el documento se ve igual sin conexión.

Cada fuente variable se declara con el rango real de su eje `wght`
—Playfair Display 400–900, Source Sans 3 200–900—. Si se declara un rango más
corto, Chrome usa la instancia por omisión en lugar de mapear el peso pedido.

El subconjunto latino de estas fuentes no trae flecha `→` ni círculo `◉`. En su
lugar se usa `›` para las rutas de menú y un círculo dibujado con CSS.

## Colores corporativos

`public/images/logo/logotipo_GPT.png` — logotipo de **GPT Services**, la marca
del grupo. Dos tintas:

| Color | Hex | Uso |
|---|---|---|
| Rojo corporativo | `#D0112B` | Isotipo y palabra «GPT» |
| Amarillo corporativo | `#F7BE07` | Palabra «SERVICES» |

Es la pareja que explica por qué el panel de Filament usa ámbar como color
primario.

## Rojos en circulación (pendiente de unificar)

El sistema arrastra cuatro rojos distintos. Mientras no se unifiquen, los
documentos nuevos usan el corporativo:

| Hex | Dónde vive |
|---|---|
| `#D0112B` | Logotipo de GPT Services · **el corporativo** |
| `#E3173E` | Logotipo de SA-TECH (`public/images/logo-app.png`) |
| `#cc2647` | Fondo de todas las plantillas de correo del sistema |
| `#C8102E` | Encabezado del PDF de la orden de compra |

## Logotipos disponibles

| Archivo | Qué es |
|---|---|
| `public/images/logo-app.png` | Marca denominativa SA-TECH, horizontal, negro y rojo sobre transparente |
| `public/images/logo/logotipo_GPT.png` | Logotipo de GPT Services, rojo y amarillo |
| `public/images/logo/companies/G.jpg` | Logotipo de GPT Ingeniería y Manufactura |
| `public/images/logo/companies/T.png` | Logotipo de Tech Energy Control |

Sobre fondos oscuros, el logotipo de SA-TECH necesita una placa blanca detrás:
la palabra «TECH» y el descriptivo son negros y desaparecen.

## Voz y tono

Las guías se dirigen a personal operativo que usa el sistema todos los días, no
a técnicos. Se escribe en segunda persona, en español de México, sin anglicismos
innecesarios. Se explica **por qué** el sistema se comporta como lo hace, no solo
qué botón apretar: la mayoría de los reportes de soporte vienen de reglas que
nadie explicó.

## Requisitos específicos

- Español de México. Comillas angulares «» para citar mensajes del sistema.
- No se usa la coma de Oxford.
- Los nombres de campos, botones y estados se escriben tal como aparecen en
  pantalla, en negritas o con su chip de color.
- Los roles técnicos (`solicita_requisicion_compra`) van en monoespaciada.
- Las cifras de dinero llevan signo y separador de miles: $300,000 MXN.
