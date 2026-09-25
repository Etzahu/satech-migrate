<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Requisiciones de compra · Guía del solicitante · SA-TECH</title>
    @include('pdf.guides._estilos')
</head>

<body>

<!-- ══════════════════ PORTADA ══════════════════ -->
<div class="page cover">
    <header class="cover-header">
        <div class="cover-logo-plate"><img src="{{ $logo }}" alt="SA-TECH"></div>
        <div class="cover-date">Versión 2.0<br>{{ $fecha }}</div>
    </header>

    <div class="cover-main">
        <div class="cover-eyebrow">Guía del solicitante</div>
        <h1 class="cover-title">Requisiciones<br>de compra</h1>
        <div class="cover-rule"></div>
        <p class="cover-subtitle">Cómo crear, enviar y dar seguimiento a una solicitud de compra, de principio a fin.</p>
        <p class="cover-lead">
            Incluye los tres requisitos sin los cuales el sistema no te dejará generar una
            requisición, cómo influye la empresa que tengas seleccionada, el recorrido completo de
            aprobación y qué hacer cuando una requisición se te regresa.
        </p>
    </div>

    <footer class="cover-footer">
        <div><span class="cover-meta-k">Sistema</span><span class="cover-meta-v">SA-TECH · Compras</span></div>
        <div><span class="cover-meta-k">Dirigida a</span><span class="cover-meta-v">Rol solicitante</span></div>
        <div><span class="cover-meta-k">Organización</span><span class="cover-meta-v">GPT Services</span></div>
    </footer>
</div>

<!-- ══════════════════ ÍNDICE ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">SA-TECH</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Contenido</h2>

        <div class="toc-row"><div class="toc-n">1</div><div><div class="toc-t">Antes de empezar: los tres requisitos</div><div class="toc-d">Rol, gerencia y cadena de aprobación. Sin los tres, el sistema no te deja crear la requisición.</div></div></div>
        <div class="toc-row"><div class="toc-n">2</div><div><div class="toc-t">La empresa determina a dónde se carga la requisición</div><div class="toc-d">El selector de la barra superior, el folio, los proyectos, el catálogo y el flujo cambian con la empresa.</div></div></div>
        <div class="toc-row"><div class="toc-n">3</div><div><div class="toc-t">Acceso y navegación</div><div class="toc-d">Dónde está el módulo, qué significan las pestañas y el número rojo del menú.</div></div></div>
        <div class="toc-row"><div class="toc-n">4</div><div><div class="toc-t">Crear una requisición paso a paso</div><div class="toc-d">Campo por campo: información general, flujo de aprobación, fichas técnicas, soportes y observación.</div></div></div>
        <div class="toc-row"><div class="toc-n">5</div><div><div class="toc-t">Cargar las partidas</div><div class="toc-d">Qué productos aparecen en el catálogo, por qué a veces no aparece el que buscas y cómo se capturan cantidades.</div></div></div>
        <div class="toc-row"><div class="toc-n">6</div><div><div class="toc-t">Enviar a revisión</div><div class="toc-d">Las tres condiciones para que aparezca el botón y a qué paso llega la requisición según tu empresa.</div></div></div>
        <div class="toc-row"><div class="toc-n">7</div><div><div class="toc-t">El recorrido completo de la requisición</div><div class="toc-d">Paso por paso: almacén, revisor, gerencia, dirección general, gerente de compras y comprador.</div></div></div>
        <div class="toc-row"><div class="toc-n">8</div><div><div class="toc-t">Dar seguimiento</div><div class="toc-d">La pantalla de detalle, la barra de avance, el historial y las órdenes de compra generadas.</div></div></div>
        <div class="toc-row"><div class="toc-n">9</div><div><div class="toc-t">Corregir una requisición devuelta</div><div class="toc-d">En qué estados puedes editar, cómo saber el motivo y qué pasa cuando la vuelves a enviar.</div></div></div>
        <div class="toc-row"><div class="toc-n">10</div><div><div class="toc-t">Acciones adicionales</div><div class="toc-d">Replicar, ver el PDF oficial, descargar adjuntos, cambiar la categoría y eliminar un borrador.</div></div></div>
        <div class="toc-row"><div class="toc-n">11</div><div><div class="toc-t">Diccionario de estados</div><div class="toc-d">Los 18 estados posibles, qué significa cada uno y qué puedes hacer en él.</div></div></div>
        <div class="toc-row"><div class="toc-n">12</div><div><div class="toc-t">Correos que envía el sistema</div><div class="toc-d">Qué notificación llega en cada cambio de estado y a quién.</div></div></div>
        <div class="toc-row"><div class="toc-n">13</div><div><div class="toc-t">Problemas frecuentes</div><div class="toc-d">Síntoma, causa y solución de los bloqueos más comunes.</div></div></div>
        <div class="toc-row"><div class="toc-n">14</div><div><div class="toc-t">Referencia rápida</div><div class="toc-d">Resumen de una página para tener a la mano.</div></div></div>

        <div class="note info" style="margin-top:0.24in">
            <span class="note-title">Cómo leer esta guía</span>
            <p>
                Los apartados <strong>1</strong> y <strong>2</strong> explican por qué el sistema a
                veces no te deja avanzar; léelos aunque ya sepas capturar. Del <strong>3</strong> al
                <strong>6</strong> está el procedimiento normal. Del <strong>7</strong> en adelante
                es material de consulta para cuando necesites saber dónde va tu requisición o por qué
                se detuvo.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 1 · REQUISITOS ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 1</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Antes de empezar: los tres requisitos</h2>

        <p class="lead-text">
            El sistema valida tres cosas al momento de guardar. Si falta alguna, la requisición no
            se crea.
        </p>

        <p>
            Una <strong>requisición de compra</strong> es la solicitud formal con la que pides que el
            área de Compras adquiera productos o contrate servicios. No es una orden de compra: la
            requisición es el paso previo, el que recorre las aprobaciones. Una vez autorizada, un
            comprador la toma y genera a partir de ella una o varias órdenes de compra.
        </p>

        <p>
            Para que puedas generar una, tu cuenta debe cumplir tres condiciones. Las configura el
            administrador del sistema, no tú.
        </p>

        <table class="data">
            <thead>
                <tr><th style="width:24%">Requisito</th><th style="width:30%">Dónde vive</th><th>Qué pasa si falta</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>1. Rol de solicitante</strong><br><code>solicita_requisicion_compra</code></td>
                    <td>Administración › Usuarios › pestaña de roles.</td>
                    <td>El grupo <strong>Requisiciones</strong> ni siquiera aparece en el menú lateral. No hay mensaje de error: simplemente no ves la opción.</td>
                </tr>
                <tr>
                    <td><strong>2. Gerencia asignada</strong></td>
                    <td>Administración › Usuarios › campo <em>Gerencia</em>.</td>
                    <td>Al guardar aparece «No cuenta con una gerencia asignada» y la requisición no se crea. La gerencia también define las siglas de tu folio y qué proyectos puedes usar.</td>
                </tr>
                <tr>
                    <td><strong>3. Cadena de aprobación</strong></td>
                    <td>Administración › Cadena requisición.</td>
                    <td>Al guardar aparece «No cuenta con una cadena de aprobación asignada» y la requisición no se crea.</td>
                </tr>
            </tbody>
        </table>

        <div class="note">
            <span class="note-title">Sin cadena de aprobación no hay requisición</span>
            <p>
                Este es el bloqueo más común y el que más confunde. Puedes entrar al módulo, abrir el
                formulario, llenar todos los campos y adjuntar archivos: todo se ve normal. Pero al
                momento de guardar, el sistema revisa si existe al menos una cadena de aprobación a
                tu nombre y, si no la hay, <strong>detiene el guardado y no crea nada</strong>. No es
                un error tuyo de captura ni un problema del navegador.
            </p>
            <p>
                La pestaña <strong>Flujo de aprobación</strong> te lo anticipa: en lugar de la tabla
                de opciones verás el mensaje «No hay flujos de aprobación disponibles. Solicite al
                administrador que le asigne una cadena.» Si ves eso, detente ahí y pide la cadena
                antes de seguir capturando.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 1</div>
    </header>
    <div class="page-body">
        <div class="continues">Apartado 1 · continuación</div>

        <h3>Qué es una cadena de aprobación</h3>

        <p>Es la lista de personas que van a firmar tu requisición, en orden. Cada cadena es un registro con cuatro casillas:</p>

        <table class="data">
            <thead>
                <tr><th style="width:16%">Nivel</th><th style="width:28%">Quién puede ocuparlo</th><th>Qué hace</th></tr>
            </thead>
            <tbody>
                <tr><td><strong>Solicita</strong></td><td>Tú. La cadena está registrada a tu nombre.</td><td>Crea y envía la requisición. Es lo que hace que la requisición sea «tuya» y aparezca en tu lista.</td></tr>
                <tr><td><strong>Revisa</strong></td><td>Usuario con el rol <code>revisa_requisicion_compra</code>.</td><td>Primer filtro: valida que lo solicitado tenga sentido. Puede aprobar, devolver o cancelar.</td></tr>
                <tr><td><strong>Aprueba</strong></td><td>Usuario con el rol <code>aprueba_requisicion_compra</code>.</td><td>Aprobación de gerencia. Puede aprobar, devolver o cancelar.</td></tr>
                <tr><td><strong>Autoriza</strong></td><td>Usuario con el rol <code>autoriza_requisicion_compra</code>.<br><span class="muted">Puede quedar vacío a propósito.</span></td><td>Autorización de Dirección General. Puede autorizar, devolver o cancelar.</td></tr>
            </tbody>
        </table>

        <div class="note info">
            <span class="note-title">Cadenas sin nivel de autorización</span>
            <p>
                Algunas cadenas —por ejemplo las de <strong>Soldadura</strong> y <strong>Servicios
                Técnicos</strong>— no llevan el nivel <em>Autoriza</em>: la casilla aparece vacía o
                con la leyenda <em>N/A</em>. <strong>No está incompleta ni rota.</strong> En esas
                cadenas la aprobación de gerencia es el último paso: la requisición avanza sola por
                el nivel de autorización y queda lista para que se le asigne comprador. En el PDF
                oficial esa firma se imprime como <em>N/A</em>.
            </p>
        </div>

        <h3>Puedes tener más de una cadena</h3>

        <p>
            No estás limitado a una sola. Si trabajas para más de un área o hay más de una ruta
            válida de aprobación para ti, el administrador puede registrarte varias cadenas y tú
            eliges cuál usar en cada requisición. Lo que no puede existir son dos cadenas idénticas:
            el sistema rechaza duplicados con la misma combinación de Solicita / Revisa / Aprueba /
            Autoriza.
        </p>

        <div class="note warn">
            <span class="note-title">Una misma persona puede aparecer en dos niveles</span>
            <p>
                Es normal ver cadenas donde quien revisa también aprueba, o donde la misma persona
                ocupa dos casillas. Está configurado así a propósito por Compras, de modo que no
                hace falta reportarlo.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 1</div>
    </header>
    <div class="page-body">
        <div class="continues">Apartado 1 · continuación</div>

        <h3>Cadenas que existen pero no se pueden usar</h3>

        <p>
            En la pestaña <strong>Flujo de aprobación</strong> puedes encontrar renglones en gris que
            no se dejan seleccionar. Siempre traen escrito el motivo en rojo:
        </p>

        <table class="data">
            <thead>
                <tr><th style="width:28%">Lo que ves</th><th style="width:32%">Qué significa</th><th>Qué hacer</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><em>«Esta cadena fue desactivada por el administrador.»</em></td>
                    <td>La cadena se retiró de circulación sin borrarla, para conservar el historial de las requisiciones que ya la usaron.</td>
                    <td>Elige otra cadena. Si no hay ninguna disponible, pide al administrador que te asigne una nueva.</td>
                </tr>
                <tr>
                    <td><em>«Participantes inactivos en esta cadena: …»</em></td>
                    <td>Alguno de los firmantes fue dado de baja o desactivado. La requisición se quedaría atorada esperando a alguien que ya no entra al sistema.</td>
                    <td>Elige otra cadena. El administrador debe reemplazar al participante inactivo.</td>
                </tr>
                <tr>
                    <td>La tabla aparece vacía con el aviso de solicitar una cadena.</td>
                    <td>No tienes ninguna cadena registrada a tu nombre.</td>
                    <td>Solicita al administrador que te registre una cadena antes de capturar nada.</td>
                </tr>
            </tbody>
        </table>

        <div class="note warn">
            <span class="note-title">La cadena se vuelve a validar cada vez que guardas</span>
            <p>
                Una cadena puede desactivarse entre el día que creaste el borrador y el día que lo
                editas. Por eso, al guardar, el sistema la revisa otra vez. Si en ese lapso dejó de
                ser válida, verás el motivo junto al campo y tendrás que elegir otra para poder
                guardar. La requisición no se pierde: solo cambia de cadena.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 2 · EMPRESA ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 2</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">La empresa determina a dónde se carga la requisición</h2>

        <p class="lead-text">Es la decisión más importante y se toma antes de escribir el primer campo.</p>

        <p>
            El sistema opera dos razones sociales. En la <strong>barra superior</strong>, junto a tu
            nombre de usuario, hay un selector que dice <strong>«Empresa actual»</strong> con un punto
            morado parpadeante. Lo que esté seleccionado ahí es la empresa a la que se cargará todo
            lo que hagas en esa sesión.
        </p>

        <div class="duo">
            <div class="duo-card">
                <div class="duo-title">GPT Ingeniería y Manufactura</div>
                <div class="duo-sub">Sigla G</div>
                <ul>
                    <li>Folios que empiezan con <code>G-</code></li>
                    <li>Catálogo y proyectos propios</li>
                    <li>El catálogo <strong>no</strong> se filtra por categoría: en una requisición de servicio puedes ver también productos de proveeduría</li>
                </ul>
            </div>
            <div class="duo-card alt">
                <div class="duo-title">Tech Energy Control</div>
                <div class="duo-sub">Sigla T</div>
                <ul>
                    <li>Folios que empiezan con <code>T-</code></li>
                    <li>Catálogo y proyectos propios</li>
                    <li>El catálogo <strong>sí</strong> se filtra por categoría: en servicio solo ves servicios, en proveeduría solo productos</li>
                </ul>
            </div>
        </div>

        <h3>Qué cambia exactamente al cambiar de empresa</h3>

        <table class="data">
            <thead><tr><th style="width:26%">Elemento</th><th>Cómo lo afecta la empresa seleccionada</th></tr></thead>
            <tbody>
                <tr><td><strong>El folio</strong></td><td>La sigla de la empresa es lo primero que lleva el folio, y el consecutivo se lleva por empresa. Una vez generado, el folio ya no cambia.</td></tr>
                <tr><td><strong>Los proyectos</strong></td><td>El desplegable <em>Proyecto</em> solo muestra proyectos activos de la empresa seleccionada.</td></tr>
                <tr><td><strong>El catálogo de partidas</strong></td><td>Solo aparecen productos y servicios aprobados de esa empresa. Es la causa número uno de «no encuentro el producto».</td></tr>
                <tr><td><strong>Tu lista de requisiciones</strong></td><td><strong>Mis requisiciones</strong> solo muestra las de la empresa seleccionada. Si una requisición «desaparece», casi siempre está en la otra empresa.</td></tr>
                <tr><td><strong>El número rojo del menú</strong></td><td>El contador de borradores también se calcula por empresa.</td></tr>
                <tr><td><strong>El primer paso del flujo</strong></td><td>Si la requisición pasa o no por revisión de almacén depende de la combinación empresa + categoría. Ver el apartado 6.</td></tr>
                <tr><td><strong>El encabezado del PDF</strong></td><td>El PDF oficial imprime la razón social completa de la empresa a la que se cargó la requisición.</td></tr>
            </tbody>
        </table>

        <div class="note">
            <span class="note-title">Verifica la empresa antes de capturar</span>
            <p>
                La empresa se graba en la requisición <strong>en el momento en que la creas</strong>,
                tomada del selector de la barra superior. El formulario no tiene un campo «empresa»
                que puedas corregir después, y el folio ya quedó emitido con esa sigla. Si te
                equivocaste, la salida práctica es eliminar el borrador, cambiar de empresa y volver
                a capturar, o usar <strong>Replicar</strong> estando ya en la empresa correcta.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 2</div>
    </header>
    <div class="page-body">
        <div class="continues">Apartado 2 · continuación</div>

        <h3>Cómo cambiar de empresa</h3>

        <ol class="steps">
            <li>Haz clic en el bloque <strong>«Empresa actual»</strong> de la barra superior derecha.</li>
            <li>Se despliega la lista de razones sociales. La activa lleva una palomita verde.</li>
            <li>Selecciona la otra empresa. El sistema recarga y muestra el aviso «Se ha cambiado la empresa».</li>
            <li>Confirma que el nombre que aparece bajo «Empresa actual» sea el correcto antes de continuar.</li>
        </ol>

        <h3>Anatomía del folio</h3>

        <p>El folio se arma solo al crear la requisición. No se captura y no se puede editar. Está compuesto por cuatro bloques:</p>

        <div class="folio">
            <div class="folio-code"><span class="p1">T</span>-<span class="p2">GCON</span>-<span class="p3">2026</span>-<span class="p4">0248</span></div>
            <div class="folio-legend">
                <div><b>Empresa</b>Sigla de la razón social seleccionada (G o T)</div>
                <div><b>Gerencia</b>Sigla de la gerencia asignada a tu usuario</div>
                <div><b>Año</b>Año en que se creó la requisición</div>
                <div><b>Consecutivo</b>Cuatro dígitos, continúa la última del mismo prefijo</div>
            </div>
        </div>

        <table class="data">
            <thead><tr><th style="width:26%">Folio</th><th>Cómo se lee</th></tr></thead>
            <tbody>
                <tr><td><code>G-ING-2026-0127</code></td><td>Requisición número <strong>127</strong> levantada por <strong>Ingeniería</strong> y cargada a <strong>GPT Ingeniería y Manufactura</strong> durante <strong>2026</strong>.</td></tr>
                <tr><td><code>T-ST-2026-0072</code></td><td>Requisición número <strong>72</strong> de <strong>Servicios Técnicos</strong>, cargada a <strong>Tech Energy Control</strong>.</td></tr>
                <tr><td><code>T-GCON-2026-0248</code></td><td>Requisición número <strong>248</strong> de la gerencia <strong>GCON</strong>, cargada a <strong>Tech Energy Control</strong>.</td></tr>
            </tbody>
        </table>

        <div class="note info">
            <span class="note-title">El folio te dice de un vistazo a quién pertenece</span>
            <p>
                Si tu folio empieza con la sigla equivocada, la requisición está en la empresa
                equivocada y no hay forma de corregirlo desde el formulario. Acostúmbrate a revisar
                la primera letra del folio en cuanto se genere: es la comprobación más barata de
                todas.
            </p>
        </div>

        <div class="note warn">
            <span class="note-title">El consecutivo es por empresa y por gerencia</span>
            <p>
                Cada combinación de empresa y gerencia lleva su propia numeración, y se reinicia con
                el año. Por eso dos requisiciones creadas el mismo día pueden tener números muy
                distintos: no van en una sola fila, van en la fila de su gerencia.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 3 · ACCESO ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 3</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Acceso y navegación</h2>

        <p class="lead-text">Dónde está el módulo y cómo está organizada la pantalla principal.</p>

        <ol class="steps">
            <li>Entra a la dirección del sistema SA-TECH e inicia sesión con tu cuenta corporativa.</li>
            <li>Revisa en la barra superior que la <strong>empresa</strong> sea la correcta.</li>
            <li>En el menú lateral izquierdo abre el grupo <strong>Requisiciones</strong>.</li>
            <li>Entra a <strong>Mis requisiciones</strong>.</li>
        </ol>

        <div class="note warn">
            <span class="note-title">¿No ves el grupo «Requisiciones»?</span>
            <p>
                Significa que tu usuario no tiene el rol <code>solicita_requisicion_compra</code>. No
                es un problema de la pantalla ni del navegador: pide al administrador que te asigne
                el rol.
            </p>
        </div>

        <h3>Las tres pestañas de «Mis requisiciones»</h3>

        <table class="data">
            <thead><tr><th style="width:22%">Pestaña</th><th style="width:40%">Qué contiene</th><th>Para qué te sirve</th></tr></thead>
            <tbody>
                <tr><td><strong>Borradores</strong><br><span class="muted">Abre por omisión</span></td><td>Todo lo que está en tus manos: borradores sin enviar, requisiciones devueltas por cualquier paso del flujo y las que tuvieron una reasignación de cadena.</td><td>Tu bandeja de trabajo. Si algo está aquí, el sistema te está esperando a ti.</td></tr>
                <tr><td><strong>Comprador asignado</strong></td><td>Requisiciones ya autorizadas que un comprador está procesando.</td><td>Saber qué ya pasó todas las firmas y está en manos de Compras.</td></tr>
                <tr><td><strong>Cerradas</strong></td><td>Requisiciones cuyo proceso terminó.</td><td>Consulta e historial.</td></tr>
            </tbody>
        </table>

        <div class="note info">
            <span class="note-title">El número rojo junto a «Mis requisiciones»</span>
            <p>
                Es la cantidad de requisiciones que están en tu bandeja de trabajo: borradores sin
                enviar más devoluciones pendientes de corregir. Mientras ese número sea mayor a cero,
                hay algo detenido esperándote. Se calcula sobre la empresa seleccionada.
            </p>
        </div>

        <h3>Las columnas del listado</h3>

        <table class="data">
            <thead><tr><th style="width:30%">Columna</th><th>Detalle</th></tr></thead>
            <tbody>
                <tr><td><strong>Folio</strong></td><td>Identificador de la requisición. Se puede buscar y copiar con un clic.</td></tr>
                <tr><td><strong>Proyecto</strong></td><td>Proyecto al que se cargó. Se puede buscar.</td></tr>
                <tr><td><strong>Motivo</strong></td><td>La referencia que escribiste. Se puede buscar.</td></tr>
                <tr><td><strong>Estatus</strong></td><td>Estado actual. Ver el diccionario completo en el apartado 11.</td></tr>
                <tr><td><strong>Fecha deseable de entrega</strong><br><span class="muted">Oculta por omisión</span></td><td>Se activa desde el menú de columnas del listado.</td></tr>
                <tr><td><strong>Fecha de creación y de actualización</strong><br><span class="muted">Ocultas por omisión</span></td><td>Al pasar el cursor muestran hace cuánto tiempo ocurrieron.</td></tr>
            </tbody>
        </table>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 4 · CREAR ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 4</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Crear una requisición paso a paso</h2>

        <p class="lead-text">
            Desde «Mis requisiciones», botón «Nueva requisición» en la esquina superior derecha.
        </p>

        <p>
            El formulario está dividido en cinco pestañas. Conviene llenarlas en orden, porque la
            categoría que elijas en la primera condiciona lo que podrás cargar después.
        </p>

        <h3>4.1 · Información general</h3>

        <table class="data">
            <thead><tr><th style="width:21%">Campo</th><th style="width:23%">Opciones y formato</th><th>Qué debes saber</th></tr></thead>
            <tbody>
                <tr><td><strong>Categoría de requisición</strong><br><span class="muted">Obligatorio</span></td><td>Servicio · Proveeduría</td><td>Define el tipo de partidas que podrás cargar y si la requisición pasa por almacén. <strong>Una vez creada queda bloqueado</strong>; solo se cambia con la acción especial del apartado 10.</td></tr>
                <tr><td><strong>Referencia</strong><br><span class="muted">Obligatorio</span></td><td>Texto libre, máx. 600 caracteres</td><td>El motivo de la compra. Es lo que leen primero quienes aprueban. Sé específico: «Refacciones para mantenimiento de prensa 3» dice mucho más que «Material».</td></tr>
                <tr><td><strong>Prioridad</strong><br><span class="muted">Obligatorio</span></td><td>Baja · Media · Alta<br>(por omisión Baja)</td><td>Indica la urgencia a quien aprueba y al comprador. No acelera nada por sí misma, pero ordena la atención.</td></tr>
                <tr><td><strong>Tipo de requisición</strong><br><span class="muted">Obligatorio</span></td><td>Compra · Cotización</td><td><strong>Compra:</strong> ya sabes qué se necesita y de quién. <strong>Cotización:</strong> pides que el comprador busque y compare opciones.</td></tr>
                <tr><td><strong>Fecha deseable de entrega</strong><br><span class="muted">Obligatorio</span></td><td>Fecha. El sistema propone tres días a partir de hoy.</td><td>Es la fecha en que necesitas el material. Los tres días son solo una sugerencia: puedes ajustarla a lo que realmente requieras.</td></tr>
                <tr><td><strong>Dirección de entrega</strong><br><span class="muted">Obligatorio</span></td><td>Texto libre, máx. 500 caracteres</td><td>Lugar físico donde se recibe. Se imprime en el PDF oficial y es lo que el comprador traslada al proveedor: sé concreto.</td></tr>
                <tr><td><strong>Proyecto</strong><br><span class="muted">Obligatorio</span></td><td>Lista con buscador.<br>Formato <code>(CÓDIGO)Nombre</code></td><td>Proyecto al que se carga el gasto. Puedes buscar por código o por nombre.</td></tr>
            </tbody>
        </table>

        <div class="note warn">
            <span class="note-title">Por qué no ves todos los proyectos</span>
            <p>
                La lista se filtra por tres criterios a la vez: deben pertenecer a la
                <strong>empresa</strong> seleccionada, estar en estatus <strong>activo</strong> y
                pasar la <strong>restricción de tu gerencia</strong>. Algunas gerencias tienen una
                lista de proyectos para <em>limitar</em> y otras para <em>excluir</em>. Si el
                proyecto no aparece, revisa primero la empresa.
            </p>
            <p>
                Caso especial: si editas una requisición cuyo proyecto se inactivó después, el
                sistema lo sigue mostrando marcado como <strong>[Inactivo]</strong> para que no
                pierdas la selección sin darte cuenta.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 4</div>
    </header>
    <div class="page-body">
        <div class="continues">Apartado 4 · continuación</div>

        <h3>4.2 · Flujo de aprobación</h3>

        <p>
            Aquí eliges con qué cadena se va a firmar esta requisición. El campo es una
            <strong>tabla con un botón redondo a la izquierda de cada renglón</strong>: cada renglón
            es una cadena completa y muestra las tres firmas que la componen.
        </p>

        <table class="data">
            <thead><tr><th style="width:7%"></th><th style="width:31%">Revisa</th><th style="width:31%">Aprueba</th><th>Autoriza</th></tr></thead>
            <tbody>
                <tr><td class="center"><span class="radio"></span></td><td>Nombre del revisor</td><td>Nombre del aprobador</td><td>Nombre del autorizador <span class="muted">(o vacío)</span></td></tr>
            </tbody>
        </table>

        <ul class="bullets">
            <li>Puedes hacer clic en cualquier parte del renglón; no tienes que atinarle al botón redondo.</li>
            <li>El renglón seleccionado se resalta.</li>
            <li>Si solo tienes una cadena, aparecerá un único renglón: selecciónalo igual, el campo es obligatorio.</li>
            <li>Los renglones en gris con texto rojo no se pueden elegir. El texto explica el motivo.</li>
        </ul>

        <div class="note info">
            <span class="note-title">Elige bien: la cadena define todo el recorrido</span>
            <p>
                Las personas que aparezcan en ese renglón son exactamente quienes recibirán los
                correos y a quienes les tocará responder. Si eliges la cadena equivocada, la
                requisición llegará a personas que no corresponden y tendrá que devolverse.
            </p>
        </div>

        <h3>4.3 · Fichas técnicas</h3>

        <p>Pestaña opcional. Sirve para adjuntar las especificaciones técnicas de lo que estás pidiendo: planos, hojas de datos, números de parte, requisitos de material.</p>

        <ul class="bullets">
            <li><strong>Solo admite archivos PDF.</strong> Otro formato será rechazado.</li>
            <li>Puedes subir varios archivos; se cargan de uno en uno.</li>
            <li>Se descargan después en un solo ZIP desde el detalle de la requisición.</li>
        </ul>

        <h3>4.4 · Soportes</h3>

        <p>Pestaña opcional para cualquier otro respaldo: cotizaciones previas, correos de autorización, fotografías del equipo, oficios.</p>

        <ul class="bullets">
            <li>Acepta cualquier formato de archivo, no solo PDF.</li>
            <li>También admite varios archivos y se descargan en ZIP.</li>
            <li>En el PDF oficial se imprime la lista de nombres de los soportes adjuntos.</li>
        </ul>

        <div class="note ok">
            <span class="note-title">Adjuntar bien ahorra devoluciones</span>
            <p>
                La mayoría de las devoluciones por parte del revisor o de la gerencia se deben a que
                no queda claro qué se está pidiendo o por qué. Una ficha técnica o una cotización
                adjunta resuelve esa duda antes de que se convierta en una devolución.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 4</div>
    </header>
    <div class="page-body">
        <div class="continues">Apartado 4 · continuación</div>

        <h3>4.5 · Observación</h3>

        <p>
            Campo de texto de hasta 2 000 caracteres, obligatorio, que llega ya lleno con «Sin
            observaciones». Úsalo para el contexto que no cabe en la referencia: condiciones
            especiales de entrega, a quién dirigirse en sitio, antecedentes del gasto. Se imprime en
            el PDF oficial.
        </p>

        <h3>4.6 · Guardar</h3>

        <p>
            Al guardar, el sistema valida los tres requisitos del apartado 1, genera el folio, graba
            la empresa y crea la requisición en estado <span class="chip c-gray">Borrador</span>.
            Hasta este momento <strong>todavía no la ha visto nadie más</strong> y no se ha enviado
            ningún correo.
        </p>

        <div class="note">
            <span class="note-title">Guardar no es enviar</span>
            <p>
                Un error frecuente es capturar todo, guardar y suponer que la requisición ya va en
                camino. Al guardar queda en <strong>Borrador</strong>, esperando que tú cargues las
                partidas y presiones <strong>Enviar a revisión</strong>. Mientras siga en Borrador,
                nadie sabe que existe.
            </p>
        </div>

        <div class="duo">
            <div class="duo-card warnc">
                <div class="duo-title">Lo que sí hace guardar</div>
                <div class="duo-sub">En este momento</div>
                <ul>
                    <li>Emite el folio definitivo.</li>
                    <li>Graba la empresa, ya sin vuelta atrás.</li>
                    <li>Habilita la sección de partidas.</li>
                    <li>Te deja seguir editando todo.</li>
                </ul>
            </div>
            <div class="duo-card alt">
                <div class="duo-title">Lo que falta</div>
                <div class="duo-sub">Para que arranque el flujo</div>
                <ul>
                    <li>Cargar al menos una partida.</li>
                    <li>Presionar <strong>Enviar a revisión</strong>.</li>
                    <li>Confirmar en el aviso que aparece.</li>
                </ul>
            </div>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 5 · PARTIDAS ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 5</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Cargar las partidas</h2>

        <p class="lead-text">
            Cada partida es un producto o servicio con su cantidad. Sin al menos una, la requisición
            no se puede enviar.
        </p>

        <p>
            Después de guardar la información general aparece, en la parte inferior de la pantalla,
            la sección <strong>Partidas</strong>. Se titula <em>Producto</em> o <em>Servicio</em>
            según la categoría que hayas elegido.
        </p>

        <h3>Agregar una partida</h3>

        <ol class="steps">
            <li>Presiona <strong>Nueva partida</strong>. Se abre un panel lateral.</li>
            <li>Captura la <strong>Cantidad solicitada</strong>. Admite decimales y el mínimo es 1.</li>
            <li>Elige el <strong>Producto</strong> o <strong>Servicio</strong> en el buscador del catálogo.</li>
            <li>El bloque <strong>Seleccionado</strong> se llena solo con <strong>Código</strong>, <strong>Descripción</strong> y <strong>Unidad de medida</strong>. Son campos de solo lectura: úsalos para confirmar que elegiste lo correcto.</li>
            <li>Escribe una <strong>Observación</strong> si hay algo específico que aclarar. Viene con «Sin observaciones» y se puede dejar así.</li>
            <li>Guarda. La partida aparece en la tabla y puedes agregar la siguiente.</li>
        </ol>

        <div class="note info">
            <span class="note-title">Tus productos más usados aparecen primero</span>
            <p>
                El catálogo no está en orden alfabético puro: el sistema coloca al principio de la
                lista los productos que tú ya has pedido antes, del más reciente al más antiguo, y
                después el resto del catálogo. Si pides seguido lo mismo, lo encontrarás en los
                primeros renglones sin necesidad de escribir.
            </p>
        </div>

        <h3>Qué productos aparecen en el catálogo</h3>

        <p>El catálogo está filtrado. Si un producto existe pero no lo ves, es por alguno de estos tres motivos:</p>

        <table class="data">
            <thead><tr><th style="width:28%">Filtro</th><th>Cómo funciona</th></tr></thead>
            <tbody>
                <tr><td><strong>Estatus aprobado</strong></td><td>Solo se listan los productos y servicios en estatus <strong>Aprobado</strong>. Los que están en trámite de alta no aparecen todavía, aunque los hayas solicitado tú.</td></tr>
                <tr><td><strong>Empresa</strong></td><td>Solo los del catálogo de la empresa que tienes seleccionada. Un producto de la otra razón social nunca aparecerá.</td></tr>
                <tr><td><strong>Categoría</strong><br><span class="muted">Solo Tech Energy Control</span></td><td>En <strong>Tech Energy Control</strong> el catálogo se filtra además por la categoría de la requisición. En <strong>GPT Ingeniería y Manufactura</strong> este filtro no se aplica y ves el catálogo completo de la empresa.</td></tr>
            </tbody>
        </table>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 5</div>
    </header>
    <div class="page-body">
        <div class="continues">Apartado 5 · continuación</div>

        <div class="note warn">
            <span class="note-title">¿El producto no existe en el catálogo?</span>
            <p>
                No se captura a mano en la requisición. Debe darse de alta primero en el catálogo y
                ser aprobado. Ese trámite está descrito en la guía <em>«Alta de productos, servicios
                y proyectos»</em>. Mientras no esté aprobado, no podrás incluirlo.
            </p>
        </div>

        <h3>Las tres columnas de cantidad</h3>

        <p>En la tabla de partidas verás tres columnas de cantidad. Solo la primera la capturas tú:</p>

        <table class="data">
            <thead><tr><th style="width:24%">Columna</th><th style="width:17%">Quién la llena</th><th>Qué significa</th></tr></thead>
            <tbody>
                <tr><td><strong>Cantidad solicitada</strong></td><td>Tú</td><td>Lo que necesitas en total.</td></tr>
                <tr><td><strong>Cantidad en almacén</strong></td><td>Almacén</td><td>Cuánto de lo que pediste ya hay en existencia y no hace falta comprar. Mientras nadie responda, queda en cero.</td></tr>
                <tr><td><strong>Cantidad a comprar</strong></td><td>El sistema</td><td>Es el resultado de <strong>solicitada menos almacén</strong>. Al crear la partida arranca igual a la solicitada. Es la cantidad que realmente llega a la orden de compra.</td></tr>
            </tbody>
        </table>

        <div class="note info">
            <span class="note-title">Si almacén modifica tus cantidades, te enteras</span>
            <p>
                Cuando almacén reporta existencias y con eso cambian las cantidades a comprar, el
                sistema te manda un correo con el asunto <strong>«ALMACÉN EDITÓ LAS PARTIDAS»</strong>
                detallando qué partidas cambiaron. No tienes que hacer nada: es informativo, y la
                requisición sigue su curso.
            </p>
        </div>

        <h3>Buenas prácticas al capturar partidas</h3>

        <table class="data">
            <thead><tr><th style="width:28%">Recomendación</th><th>Por qué importa</th></tr></thead>
            <tbody>
                <tr><td><strong>Verifica la unidad de medida</strong></td><td>El bloque <em>Seleccionado</em> te muestra la unidad del catálogo. Si pides «10» de un producto que se maneja por caja, estás pidiendo 10 cajas. Es la causa más frecuente de compras excedidas.</td></tr>
                <tr><td><strong>Confirma el código, no solo el nombre</strong></td><td>Hay productos con nombres casi idénticos que difieren en medida, material o marca. El código es lo que el comprador va a cotizar.</td></tr>
                <tr><td><strong>Usa la observación de la partida</strong></td><td>Es el lugar para el detalle que no cabe en el catálogo: color, medida específica, equipo al que va destinado, número de parte del fabricante.</td></tr>
                <tr><td><strong>Una partida por concepto</strong></td><td>No acumules varios productos distintos en un renglón. Almacén captura existencias por partida y el comprador cotiza por partida.</td></tr>
                <tr><td><strong>Revisa la lista antes de enviar</strong></td><td>Después de enviar no puedes agregar ni quitar partidas. Si falta una, la única salida es esperar una devolución o levantar otra requisición.</td></tr>
            </tbody>
        </table>

        <p>
            Mientras la requisición esté en <strong>Borrador</strong> o devuelta, cada renglón tiene
            las acciones <strong>Editar</strong> y <strong>Eliminar</strong>. Al editar la cantidad
            solicitada, la cantidad a comprar se recalcula automáticamente.
        </p>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 6 · ENVIAR ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 6</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Enviar a revisión</h2>

        <p class="lead-text">El momento en que la requisición sale de tus manos y entra al flujo de aprobación.</p>

        <p>
            El botón <strong>Enviar a revisión</strong> es verde, tiene un icono de avión de papel y
            parpadea para que no pase desapercibido. Está arriba a la derecha, tanto en la pantalla
            de edición como en la de detalle.
        </p>

        <div class="note warn">
            <span class="note-title">¿No aparece el botón? Faltan condiciones</span>
            <p>El botón solo se muestra cuando se cumplen <strong>las tres</strong> al mismo tiempo:</p>
            <ul class="bullets" style="margin-bottom:0">
                <li>La requisición tiene <strong>al menos una partida</strong> cargada.</li>
                <li>La <strong>categoría</strong> está definida.</li>
                <li>El <strong>estado actual permite enviar</strong>: borrador, cadena reasignada o cualquiera de las devoluciones.</li>
            </ul>
        </div>

        <ol class="steps">
            <li>Revisa que la información general y las partidas estén completas.</li>
            <li>Presiona <strong>Enviar a revisión</strong>.</li>
            <li>Aparece una confirmación: «Una vez enviada, la requisición entrará al flujo de aprobación y ya no podrás editarla.»</li>
            <li>Confirma con <strong>Sí, enviar</strong>.</li>
            <li>El sistema cambia el estado, manda el correo al primer responsable y te muestra el aviso «Requisición enviada».</li>
        </ol>

        <h3>A qué paso llega según tu empresa y categoría</h3>

        <table class="data">
            <thead><tr><th style="width:24%">Empresa</th><th style="width:15%">Categoría</th><th style="width:24%">Primer estado</th><th>Qué ocurre</th></tr></thead>
            <tbody>
                <tr><td>GPT Ingeniería y Manufactura</td><td><strong>Proveeduría</strong></td><td><span class="chip c-yellow">Revisión por almacén</span></td><td>Se detiene en almacén. Nadie más la ve hasta que almacén responda.</td></tr>
                <tr><td>GPT Ingeniería y Manufactura</td><td><strong>Servicio</strong></td><td><span class="chip c-navy">Revisión</span></td><td>Almacén recibe un correo informativo, pero la requisición <strong>no se detiene</strong>: pasa de inmediato al revisor.</td></tr>
                <tr><td>Tech Energy Control</td><td><strong>Proveeduría</strong></td><td><span class="chip c-yellow">Revisión por almacén</span></td><td>Se detiene en almacén. Nadie más la ve hasta que almacén responda.</td></tr>
                <tr><td>Tech Energy Control</td><td><strong>Servicio</strong></td><td><span class="chip c-navy">Revisión</span></td><td>No pasa por almacén en absoluto: entra directo al revisor de tu cadena.</td></tr>
            </tbody>
        </table>

        <div class="note info">
            <span class="note-title">La lógica detrás</span>
            <p>
                Un servicio no se guarda en almacén, así que no tiene sentido preguntar por
                existencias. Los materiales de proveeduría sí: antes de comprarlos conviene confirmar
                que no estén ya en inventario. Por eso la categoría que eliges en el primer campo
                termina decidiendo el primer paso del recorrido.
            </p>
        </div>

        <ul class="bullets" style="margin-bottom:0">
            <li><strong>Ya no puedes editarla</strong> mientras esté en curso. El botón Editar desaparece.</li>
            <li>Sí puedes consultarla, ver su avance, su historial y descargar el PDF.</li>
            <li>Recibirás un correo en cada cambio de estado.</li>
            <li>Si alguien la devuelve, volverá a tu pestaña <strong>Borradores</strong>.</li>
        </ul>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 7 · RECORRIDO ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 7</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">El recorrido completo de la requisición</h2>

        <p class="lead-text">Quién interviene en cada paso, qué opciones tiene y a dónde se va la requisición.</p>

        <div class="step-row">
            <div class="step-num">0</div>
            <div>
                <div class="step-head"><span class="step-name">Borrador</span><span class="step-who">Tú · Solicitante</span></div>
                <div class="step-body"><p>Capturas, cargas partidas y envías. Es el único punto donde puedes cambiar libremente la información.</p></div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">1</div>
            <div>
                <div class="step-head"><span class="step-name">Revisión por almacén</span><span class="step-who">Almacén</span></div>
                <div class="step-body">
                    <p><strong>Solo en requisiciones de proveeduría.</strong> Almacén revisa cada partida y captura la <em>Cantidad en almacén</em>; el sistema recalcula sola la cantidad a comprar.</p>
                    <p><strong>Respuestas:</strong> <span class="chip c-green">Revisado</span> pasa al revisor · <span class="chip c-red">Devolver</span> regresa contigo con motivo obligatorio.</p>
                </div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">2</div>
            <div>
                <div class="step-head"><span class="step-name">Revisión</span><span class="step-who">Revisa · primer nombre de tu cadena</span></div>
                <div class="step-body">
                    <p>El revisor de tu cadena valida que lo solicitado sea correcto y esté justificado.</p>
                    <p><strong>Respuestas:</strong> <span class="chip c-green">Aprobar</span> · <span class="chip c-red">Devolver</span> · <span class="chip c-gray">Cancelar</span>. Devolver y cancelar exigen escribir una observación.</p>
                </div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">3</div>
            <div>
                <div class="step-head"><span class="step-name">Aprobado por revisor › Gerencia</span><span class="step-who">Aprueba · segundo nombre</span></div>
                <div class="step-body">
                    <p>Aprobación de gerencia sobre la pertinencia y el presupuesto del gasto.</p>
                    <p><strong>Respuestas:</strong> <span class="chip c-green">Aprobar</span> · <span class="chip c-red">Devolver</span> · <span class="chip c-gray">Cancelar</span>.</p>
                </div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">4</div>
            <div>
                <div class="step-head"><span class="step-name">Aprobado por gerencia › Dirección General</span><span class="step-who">Autoriza · tercer nombre</span></div>
                <div class="step-body">
                    <p>Autorización final de Dirección General.</p>
                    <p><strong>Si tu cadena no lleva este nivel</strong> (casilla <em>Autoriza</em> vacía), la requisición avanza sola en cuanto gerencia aprueba.</p>
                </div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">5</div>
            <div>
                <div class="step-head"><span class="step-name">Aprobado por DG › Asignación</span><span class="step-who">Gerente de compras</span></div>
                <div class="step-body">
                    <p>La requisición ya tiene todas las firmas. El gerente de compras designa qué comprador la va a atender, puede reasignarlo después, o devolverla si encuentra algo que corregir.</p>
                </div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">6</div>
            <div>
                <div class="step-head"><span class="step-name">Comprador asignado</span><span class="step-who">Comprador</span></div>
                <div class="step-body">
                    <p>El comprador cotiza, elige proveedor y genera una o varias <strong>órdenes de compra</strong>. Esas órdenes llevan su propio flujo. También puede devolver la requisición.</p>
                </div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">7</div>
            <div>
                <div class="step-head"><span class="step-name">Cerrada</span><span class="step-who">Sistema</span></div>
                <div class="step-body"><p>El proceso terminó. La requisición pasa a la pestaña <strong>Cerradas</strong> y queda como consulta histórica.</p></div>
            </div>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 7</div>
    </header>
    <div class="page-body">
        <div class="continues">Apartado 7 · continuación</div>

        <h3>Las dos salidas del flujo</h3>

        <div class="duo">
            <div class="duo-card">
                <div class="duo-title">Devolución</div>
                <div class="duo-sub">Reversible · vuelve a ti</div>
                <ul>
                    <li>La puede hacer almacén, el revisor, la gerencia, Dirección General, el gerente de compras o el comprador.</li>
                    <li>Quien devuelve <strong>debe escribir un motivo</strong>.</li>
                    <li>La requisición regresa a tu pestaña <strong>Borradores</strong> y vuelve a ser editable.</li>
                    <li>Al corregir y reenviar, el recorrido <strong>reinicia desde el principio</strong>.</li>
                </ul>
            </div>
            <div class="duo-card alt">
                <div class="duo-title">Cancelación</div>
                <div class="duo-sub">Definitiva · cierra la requisición</div>
                <ul>
                    <li>La pueden hacer el revisor, la gerencia o Dirección General.</li>
                    <li>También exige escribir un motivo.</li>
                    <li>La requisición <strong>no vuelve a ser editable</strong>.</li>
                    <li>Si el gasto sigue siendo necesario, se levanta una nueva; puedes usar <strong>Replicar</strong>.</li>
                </ul>
            </div>
        </div>

        <h3>Quién puede detener la requisición y en qué punto</h3>

        <table class="data">
            <thead><tr><th style="width:26%">Participante</th><th style="width:13%">Devolver</th><th style="width:13%">Cancelar</th><th>Momento</th></tr></thead>
            <tbody>
                <tr><td><strong>Almacén</strong></td><td class="center"><span class="chip c-red">Sí</span></td><td class="center"><span class="muted">No</span></td><td>Mientras está en revisión por almacén.</td></tr>
                <tr><td><strong>Revisor</strong></td><td class="center"><span class="chip c-red">Sí</span></td><td class="center"><span class="chip c-gray">Sí</span></td><td>Mientras está en revisión.</td></tr>
                <tr><td><strong>Gerencia</strong></td><td class="center"><span class="chip c-red">Sí</span></td><td class="center"><span class="chip c-gray">Sí</span></td><td>Después de que el revisor aprueba.</td></tr>
                <tr><td><strong>Dirección General</strong></td><td class="center"><span class="chip c-red">Sí</span></td><td class="center"><span class="chip c-gray">Sí</span></td><td>Después de que gerencia aprueba, si la cadena lleva ese nivel.</td></tr>
                <tr><td><strong>Gerente de compras</strong></td><td class="center"><span class="chip c-red">Sí</span></td><td class="center"><span class="muted">No</span></td><td>Antes de asignar comprador.</td></tr>
                <tr><td><strong>Comprador</strong></td><td class="center"><span class="chip c-red">Sí</span></td><td class="center"><span class="muted">No</span></td><td>Con la requisición ya asignada. Al devolverla se libera la asignación.</td></tr>
            </tbody>
        </table>

        <div class="note warn">
            <span class="note-title">Reasignación de cadena</span>
            <p>
                Si un firmante de tu cadena deja la empresa o se desactiva, el administrador puede
                reasignar tu requisición a otra cadena. Cuando eso pasa, el estado cambia a
                <strong>Cadena reasignada</strong>, te llega un correo con el detalle de la cadena
                anterior y la nueva, y la requisición <strong>vuelve al inicio del proceso</strong>.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 8 · SEGUIMIENTO ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 8</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Dar seguimiento</h2>

        <p class="lead-text">Desde «Mis requisiciones», menú de tres puntos › «Ver».</p>

        <p>
            La pantalla de detalle está dividida en dos columnas. La izquierda tiene el contenido de
            la requisición; la derecha, el seguimiento. El encabezado, siempre visible, muestra de un
            vistazo <strong>Folio</strong>, <strong>Estatus</strong>, <strong>Prioridad</strong>,
            <strong>Categoría</strong>, <strong>Proyecto</strong> y <strong>Creada el</strong>.
        </p>

        <h3>Columna izquierda · el contenido</h3>

        <table class="data">
            <thead><tr><th style="width:24%">Pestaña</th><th>Qué muestra</th></tr></thead>
            <tbody>
                <tr><td><strong>Datos generales</strong></td><td>Tipo de requisición, solicitante, referencia, fecha deseable de entrega, dirección de entrega y observaciones.</td></tr>
                <tr><td><strong>Partidas</strong></td><td>Cada partida con su código, descripción, cantidad en almacén, cantidad a comprar y observación. Aquí compruebas si almacén ya respondió y cuánto quedó realmente por comprar.</td></tr>
                <tr><td><strong>Adjuntos</strong><br><span class="muted">Solo si hay archivos</span></td><td>Fichas técnicas y soportes. Cada archivo tiene <strong>Ver documento</strong>, y hay botones para bajar todo en ZIP.</td></tr>
            </tbody>
        </table>

        <p>
            Debajo de las pestañas está la sección <strong>Órdenes de compra</strong>. Si todavía no
            hay ninguna, indica en qué punto del flujo se generarán. Cuando el comprador las crea,
            aparecen ahí con su propio detalle y su propio avance de aprobación.
        </p>

        <h3>Columna derecha · el seguimiento</h3>

        <table class="data">
            <thead><tr><th style="width:24%">Bloque</th><th>Qué muestra</th></tr></thead>
            <tbody>
                <tr><td><strong>Resumen</strong></td><td><strong>Comprador asignado</strong> (dice «Sin asignar» hasta que Compras lo designe) y la fecha deseable de entrega.</td></tr>
                <tr><td><strong>Flujo de aprobación</strong><br><span class="muted">Aparece al enviar</span></td><td>La barra de avance con cada paso del recorrido y la fecha en que respondió cada responsable. Los pasos sin fecha son los pendientes. Así ves exactamente con quién está detenida.</td></tr>
                <tr><td><strong>Historial</strong><br><span class="muted">Aparece al enviar</span></td><td>Bitácora cronológica de todos los cambios de estado, con la observación que escribió quien respondió. <strong>Aquí se lee el motivo de una devolución.</strong></td></tr>
            </tbody>
        </table>

        <div class="note info">
            <span class="note-title">Cómo saber dónde está detenida en 10 segundos</span>
            <p>
                Abre el detalle, ve a <strong>Flujo de aprobación</strong> en la columna derecha y
                busca el primer paso sin fecha: esa es la persona con la que está la requisición en
                este momento. Si necesitas saber por qué se regresó, cambia a
                <strong>Historial</strong> y lee la observación del último movimiento.
            </p>
        </div>

        <h3>El PDF oficial</h3>

        <p>
            Desde el menú de tres puntos, <strong>Ver pdf</strong> abre el documento oficial en una
            pestaña nueva, en formato horizontal. Contiene la razón social y el folio, la gerencia y
            el solicitante, la fecha deseable de entrega, el proyecto y la dirección de entrega, el
            detalle de partidas con cantidades y unidades, las observaciones, la lista de soportes
            adjuntos y el bloque de <strong>firmas</strong> con la fecha de cada etapa. Las etapas
            pendientes dicen «Sin respuesta» y los niveles que no existen en tu cadena aparecen como
            <em>N/A</em>.
        </p>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 9 · DEVUELTA ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 9</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Corregir una requisición devuelta</h2>

        <p class="lead-text">Qué hacer cuando te regresan una requisición para corregirla.</p>

        <p>
            Cuando alguien devuelve tu requisición recibes un correo y la requisición reaparece en la
            pestaña <strong>Borradores</strong>, sumando uno al número rojo del menú.
        </p>

        <h3>Estados en los que puedes editar</h3>

        <table class="data">
            <thead><tr><th style="width:38%">Estado</th><th>Qué lo originó</th></tr></thead>
            <tbody>
                <tr><td><span class="chip c-gray">Borrador</span></td><td>Nunca se ha enviado.</td></tr>
                <tr><td><span class="chip c-navy">Cadena reasignada</span></td><td>El administrador cambió la cadena de aprobación.</td></tr>
                <tr><td><span class="chip c-red">Devuelto por almacén</span></td><td>Almacén encontró algo que corregir en las partidas.</td></tr>
                <tr><td><span class="chip c-red">Devuelto por revisor</span></td><td>El revisor de tu cadena pidió cambios.</td></tr>
                <tr><td><span class="chip c-red">Devuelto por gerencia</span></td><td>La gerencia pidió cambios.</td></tr>
                <tr><td><span class="chip c-red">Devuelto por DG</span></td><td>Dirección General pidió cambios.</td></tr>
                <tr><td><span class="chip c-red">Devuelto por gerente de compras</span></td><td>El gerente de compras la regresó antes de asignar comprador.</td></tr>
                <tr><td><span class="chip c-red">Devuelto por comprador</span></td><td>El comprador no pudo procesarla como está.</td></tr>
            </tbody>
        </table>

        <div class="note warn">
            <span class="note-title">En cualquier otro estado el botón «Editar» no aparece</span>
            <p>
                Si la requisición está en revisión, aprobada o cancelada, no verás la opción de
                editar. El sistema la bloquea a propósito, para que nadie termine firmando algo
                distinto de lo que aprobó. Si necesitas cambiarla, pide a quien la tiene en ese
                momento que te la devuelva.
            </p>
        </div>

        <h3>Procedimiento</h3>

        <ol class="steps">
            <li>Abre el detalle y ve a <strong>Historial</strong> en la columna derecha. Lee la observación del último movimiento: ahí está el motivo exacto.</li>
            <li>Regresa al listado, abre el menú de tres puntos y elige <strong>Editar</strong>.</li>
            <li>Corrige lo que se te pidió: información general, partidas o adjuntos.</li>
            <li>Si el motivo fue que un participante de la cadena ya no está disponible, elige otra cadena en <strong>Flujo de aprobación</strong>.</li>
            <li>Presiona <strong>Enviar a revisión</strong> otra vez y confirma.</li>
        </ol>

        <div class="note">
            <span class="note-title">Al reenviar, el recorrido empieza de cero</span>
            <p>
                Una requisición devuelta y corregida <strong>vuelve al primer paso</strong>: si es de
                proveeduría pasa otra vez por almacén, y todas las firmas se piden de nuevo. Por eso
                conviene atender de una sola vez todo lo que te señalaron: cada reenvío es un
                recorrido completo más.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 10 · ACCIONES ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 10</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Acciones adicionales</h2>

        <p class="lead-text">Menú de tres puntos del listado y del detalle.</p>

        <h3>Replicar</h3>

        <p>Duplica una requisición existente para no capturar todo otra vez. Es la herramienta más útil para compras recurrentes.</p>

        <ol class="steps">
            <li>En el listado, abre el menú de tres puntos de la requisición que quieres copiar y elige <strong>Replicar</strong>.</li>
            <li>Se abre un panel lateral con todos los datos ya cargados: proyecto, prioridad, tipo, categoría, dirección de entrega, cadena de aprobación y observaciones.</li>
            <li>La referencia llega marcada con el prefijo «(replicado)»; ajústala a lo que corresponda.</li>
            <li>La fecha deseable de entrega se propone para el día siguiente; cámbiala si hace falta.</li>
            <li>Guarda. Se crea una requisición <strong>nueva</strong>, con <strong>folio nuevo</strong>, en Borrador y con <strong>todas las partidas ya copiadas</strong>.</li>
        </ol>

        <div class="note info">
            <span class="note-title">La copia hereda la empresa del original</span>
            <p>
                Una requisición replicada se carga a <strong>la misma empresa que la original</strong>,
                no a la que tengas seleccionada en ese momento. Si necesitas la misma compra en la
                otra razón social, cambia de empresa y captúrala desde cero: el folio, los proyectos
                y el catálogo son distintos.
            </p>
        </div>

        <h3>Cambiar la categoría</h3>

        <p>
            La categoría queda bloqueada al crear la requisición, pero al editar aparece junto al
            campo un enlace <strong>«Cambiar categoría»</strong>. Solo ofrece la categoría contraria a
            la actual.
        </p>

        <div class="note">
            <span class="note-title">En Tech Energy Control el cambio borra partidas</span>
            <p>
                El sistema advierte: «Al cambiar la categoría de Servicio a Proveeduría o viceversa,
                todas las partidas actuales serán eliminadas.» En <strong>Tech Energy Control</strong>
                esto ocurre de verdad, porque cada categoría tiene su propio catálogo. En <strong>GPT
                Ingeniería y Manufactura</strong>, donde el catálogo no se separa por categoría, las
                partidas se conservan. En ambos casos el cambio sí afecta el recorrido: al pasar a
                proveeduría la requisición empezará a requerir revisión de almacén.
            </p>
        </div>

        <h3>Ver pdf, descargar adjuntos y eliminar</h3>

        <p>
            <strong>Ver pdf</strong> abre el documento oficial en una pestaña nueva, disponible en
            cualquier estado. En la pestaña <strong>Adjuntos</strong> del detalle, los botones
            <strong>Descargar fichas</strong> y <strong>Descargar soportes</strong> bajan todos los
            archivos de cada tipo en un ZIP nombrado con el folio. <strong>Eliminar</strong> está en
            el menú de opciones de las pantallas de edición y detalle, para descartar un borrador que
            ya no va a proceder.
        </p>

        <div class="note warn">
            <span class="note-title">Eliminar no libera el folio</span>
            <p>
                El consecutivo ya quedó consumido: la siguiente requisición tomará el número que
                sigue, no el que borraste. Es normal que haya saltos en la numeración y no indica que
                falte información.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 11 · ESTADOS ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 11</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Diccionario de estados</h2>

        <p class="lead-text">Los 18 estados posibles, su avance en la barra de progreso y qué puedes hacer en cada uno.</p>

        <table class="data">
            <thead><tr><th style="width:23%">Estado</th><th style="width:15%">Avance</th><th style="width:38%">Significado</th><th>¿Editar?</th></tr></thead>
            <tbody>
                <tr><td><span class="chip c-gray">Borrador</span></td><td><span class="bar"><span style="width:0%"></span></span>0 %</td><td>Creada pero no enviada. Nadie más la ha visto.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-navy">Cadena reasignada</span></td><td><span class="bar"><span style="width:0%"></span></span>0 %</td><td>El administrador le cambió la cadena y volvió al inicio.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-yellow">Revisión por almacén</span></td><td><span class="bar"><span style="width:20%"></span></span>20 %</td><td>Almacén está verificando existencias de las partidas.</td><td>No</td></tr>
                <tr><td><span class="chip c-red">Devuelto por almacén</span></td><td><span class="bar"><span style="width:20%"></span></span>20 %</td><td>Almacén la regresó. El motivo está en el historial.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-navy">Revisión</span></td><td><span class="bar"><span style="width:40%"></span></span>40 %</td><td>En manos del revisor de tu cadena.</td><td>No</td></tr>
                <tr><td><span class="chip c-red">Devuelto por revisor</span></td><td><span class="bar"><span style="width:40%"></span></span>40 %</td><td>El revisor pidió correcciones.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-gray">Cancelado por revisor</span></td><td><span class="bar"><span style="width:0%"></span></span>0 %</td><td>El revisor la canceló definitivamente.</td><td>No</td></tr>
                <tr><td><span class="chip c-navy">Aprobado por revisor</span></td><td><span class="bar"><span style="width:60%"></span></span>60 %</td><td>Revisada. Esperando aprobación de gerencia.</td><td>No</td></tr>
                <tr><td><span class="chip c-red">Devuelto por gerencia</span></td><td><span class="bar"><span style="width:40%"></span></span>40 %</td><td>La gerencia pidió correcciones.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-gray">Cancelado por gerencia</span></td><td><span class="bar"><span style="width:0%"></span></span>0 %</td><td>La gerencia la canceló definitivamente.</td><td>No</td></tr>
                <tr><td><span class="chip c-navy">Aprobado por gerencia</span></td><td><span class="bar"><span style="width:80%"></span></span>80 %</td><td>Aprobada por gerencia. Esperando a Dirección General, salvo que tu cadena no lleve ese nivel.</td><td>No</td></tr>
                <tr><td><span class="chip c-red">Devuelto por DG</span></td><td><span class="bar"><span style="width:40%"></span></span>40 %</td><td>Dirección General pidió correcciones.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-gray">Cancelado por DG</span></td><td><span class="bar"><span style="width:0%"></span></span>0 %</td><td>Dirección General la canceló definitivamente.</td><td>No</td></tr>
                <tr><td><span class="chip c-green">Aprobado por DG</span></td><td><span class="bar"><span style="width:90%"></span></span>90 %</td><td>Con todas las firmas. Esperando que se le asigne comprador.</td><td>No</td></tr>
                <tr><td><span class="chip c-red">Devuelto por gte. de compras</span></td><td><span class="bar"><span style="width:40%"></span></span>40 %</td><td>El gerente de compras la regresó antes de asignar comprador.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-green">Comprador asignado</span></td><td><span class="bar"><span style="width:95%"></span></span>95 %</td><td>Un comprador la está procesando y generará las órdenes.</td><td>No</td></tr>
                <tr><td><span class="chip c-green">Comprador reasignado</span></td><td><span class="bar"><span style="width:95%"></span></span>95 %</td><td>Se cambió el comprador responsable.</td><td>No</td></tr>
                <tr><td><span class="chip c-red">Devuelto por comprador</span></td><td><span class="bar"><span style="width:40%"></span></span>40 %</td><td>El comprador no pudo procesarla. Se libera la asignación.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-green">Cerrada</span></td><td><span class="bar"><span style="width:100%"></span></span>100 %</td><td>Proceso terminado.</td><td>No</td></tr>
            </tbody>
        </table>

        <div class="note info">
            <span class="note-title">Regla rápida</span>
            <p>
                Todo estado que empiece con <strong>«Devuelto por…»</strong>, más
                <strong>Borrador</strong> y <strong>Cadena reasignada</strong>, es editable y está en
                tu bandeja. Todo estado que empiece con <strong>«Aprobado por…»</strong> o
                <strong>«Cancelado por…»</strong> no lo es.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 12 · CORREOS ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 12</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Correos que envía el sistema</h2>

        <p class="lead-text">Cada cambio de estado dispara una notificación automática. El asunto siempre termina con el folio.</p>

        <table class="data">
            <thead><tr><th style="width:32%">Asunto del correo</th><th style="width:26%">Lo recibe</th><th>Cuándo se dispara</th></tr></thead>
            <tbody>
                <tr><td><strong>REVISAR EXISTENCIA</strong></td><td>Personal de almacén</td><td>Al enviar una requisición que pasa por almacén.</td></tr>
                <tr><td><strong>REVISAR</strong></td><td>El revisor de tu cadena</td><td>Cuando la requisición entra a revisión.</td></tr>
                <tr><td><strong>ALMACÉN EDITÓ LAS PARTIDAS</strong></td><td><strong>Tú</strong></td><td>Cuando almacén reportó existencias y con eso cambiaron las cantidades a comprar.</td></tr>
                <tr><td><strong>REVISAR</strong></td><td>El aprobador de tu cadena</td><td>Cuando el revisor aprueba y pasa a gerencia.</td></tr>
                <tr><td><strong>APROBAR</strong></td><td>El autorizador de tu cadena</td><td>Cuando gerencia aprueba. No se envía si tu cadena no lleva ese nivel.</td></tr>
                <tr><td><strong>APROBADO POR DIRECCIÓN GENERAL</strong></td><td><strong>Tú</strong>, con copia a tu cadena, almacén y gerente de compras</td><td>Cuando la requisición queda totalmente autorizada.</td></tr>
                <tr><td><strong>COLOCAR ORDEN DE COMPRA</strong></td><td>El comprador, con copia a ti y a tu cadena</td><td>Cuando se asigna comprador.</td></tr>
                <tr><td><strong>COMPRADOR REASIGNADO · COLOCAR ORDEN DE COMPRA</strong></td><td>El nuevo comprador, con copia a ti y a tu cadena</td><td>Cuando se cambia el comprador responsable.</td></tr>
                <tr><td><strong>DEVUELTO POR ALMACÉN / REVISOR / GERENCIA / DIRECCIÓN GENERAL / GERENTE DE COMPRAS / COMPRADOR</strong></td><td><strong>Tú</strong></td><td>En cada devolución. Es tu aviso de que hay algo que corregir.</td></tr>
                <tr><td><strong>CANCELADO POR REVISOR / GERENCIA / DIRECCIÓN GENERAL</strong></td><td><strong>Tú</strong></td><td>Cuando la requisición se cancela definitivamente.</td></tr>
                <tr><td><strong>CADENA REASIGNADA</strong></td><td><strong>Tú</strong></td><td>Cuando el administrador cambia tu cadena. Detalla la anterior y la nueva.</td></tr>
                <tr><td><strong>CERRADA</strong></td><td><strong>Tú</strong>, con copia al gerente de compras</td><td>Al cerrarse el proceso.</td></tr>
            </tbody>
        </table>

        <div class="note info">
            <span class="note-title">Qué trae cada correo</span>
            <p>
                Además del asunto con el folio, el cuerpo incluye la empresa, la gerencia, el nombre
                del solicitante, la fecha de creación, la fecha deseable de entrega, la dirección de
                entrega, el proyecto, las observaciones y el detalle de las partidas con sus
                cantidades. Sirve como comprobante sin necesidad de entrar al sistema.
            </p>
        </div>

        <div class="note warn">
            <span class="note-title">Si no te llegan los correos</span>
            <p>
                Revisa primero la carpeta de correo no deseado. Si aun así no aparecen, el estatus
                real siempre está en el sistema: entra a <strong>Mis requisiciones</strong> y consulta
                la pestaña <strong>Historial</strong> del detalle. El correo es un aviso, no la fuente
                de la verdad.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 13 · PROBLEMAS ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 13</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Problemas frecuentes</h2>

        <p class="lead-text">Síntoma, causa y qué hacer.</p>

        <table class="data">
            <thead><tr><th style="width:28%">Lo que ves</th><th style="width:31%">Por qué pasa</th><th>Qué hacer</th></tr></thead>
            <tbody>
                <tr><td>«No cuenta con una cadena de aprobación asignada» y la requisición no se guarda.</td><td>No tienes ninguna cadena registrada a tu nombre. Es el requisito indispensable.</td><td>Solicita al administrador que te registre una cadena en Administración › Cadena requisición.</td></tr>
                <tr><td>«No cuenta con una gerencia asignada».</td><td>Tu usuario no tiene gerencia, y sin ella no se puede armar el folio.</td><td>Pide al administrador que te asigne la gerencia en tu ficha de usuario.</td></tr>
                <tr><td>La pestaña «Flujo de aprobación» aparece vacía con un aviso.</td><td>Igual que el primer caso: no hay cadenas a tu nombre.</td><td>Detente ahí. No sigas capturando: no vas a poder guardar.</td></tr>
                <tr><td>Mis cadenas aparecen en gris y no se pueden seleccionar.</td><td>Están desactivadas o alguno de sus firmantes fue dado de baja.</td><td>Elige otra cadena. Si todas están así, el administrador debe reemplazar a los participantes inactivos.</td></tr>
                <tr><td>No encuentro el grupo «Requisiciones» en el menú.</td><td>Falta el rol <code>solicita_requisicion_compra</code>.</td><td>Solicita el rol al administrador.</td></tr>
                <tr><td>Mis requisiciones «desaparecieron» del listado.</td><td>Tienes seleccionada la otra empresa.</td><td>Cambia de empresa en el selector de la barra superior.</td></tr>
                <tr><td>El proyecto que necesito no está en la lista.</td><td>O pertenece a la otra empresa, o está inactivo, o tu gerencia tiene una restricción.</td><td>Verifica la empresa. Si está bien, solicita al administrador que revise el estatus del proyecto.</td></tr>
                <tr><td>El producto no aparece en el catálogo de partidas.</td><td>No está aprobado, es de la otra empresa o —en Tech Energy— no corresponde a la categoría.</td><td>Revisa la empresa y la categoría. Si el producto no existe, tramita su alta.</td></tr>
                <tr><td>No veo el botón «Enviar a revisión».</td><td>Falta cargar partidas, falta la categoría o la requisición ya está en curso.</td><td>Agrega al menos una partida y confirma la categoría.</td></tr>
                <tr><td>No veo el botón «Editar».</td><td>La requisición está en un estado en curso, aprobado o cancelado.</td><td>Solo se edita en borrador, cadena reasignada o devuelta. Pide que te la devuelvan.</td></tr>
                <tr><td>Cambié la categoría y desaparecieron mis partidas.</td><td>En Tech Energy Control cada categoría tiene su propio catálogo.</td><td>Vuelve a cargarlas con productos de la nueva categoría.</td></tr>
                <tr><td>Mi requisición lleva días sin moverse.</td><td>Está esperando la respuesta de alguien, o el firmante que le toca ya no está activo.</td><td>Abre <strong>Flujo de aprobación</strong> y busca el primer paso sin fecha. Contacta a esa persona o pide al administrador que revise la cadena.</td></tr>
                <tr><td>Hay saltos en la numeración de mis folios.</td><td>Se eliminó algún borrador. El consecutivo no se reutiliza.</td><td>Es el comportamiento esperado, no requiere acción.</td></tr>
                <tr><td>Capturé la requisición en la empresa equivocada.</td><td>La empresa se toma del selector superior al crearla y no se puede cambiar después.</td><td>Elimina el borrador, cambia de empresa y vuelve a capturar.</td></tr>
            </tbody>
        </table>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<!-- ══════════════════ 14 · REFERENCIA ══════════════════ -->
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 14</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Referencia rápida</h2>

        <p class="lead-text">Una página para tener a la mano.</p>

        <div class="duo">
            <div class="duo-card">
                <div class="duo-title">Antes de crear</div>
                <div class="duo-sub">Revisa estos cuatro puntos</div>
                <ul>
                    <li>Tengo el rol de solicitante (veo el grupo Requisiciones).</li>
                    <li>Tengo gerencia asignada.</li>
                    <li>Tengo al menos una cadena de aprobación seleccionable.</li>
                    <li>La <strong>empresa</strong> del selector superior es la correcta.</li>
                </ul>
            </div>
            <div class="duo-card alt">
                <div class="duo-title">Secuencia de captura</div>
                <div class="duo-sub">En este orden</div>
                <ul>
                    <li>Información general (empieza por la categoría).</li>
                    <li>Flujo de aprobación: elige la cadena.</li>
                    <li>Fichas técnicas y soportes.</li>
                    <li>Observación.</li>
                    <li>Guardar › partidas › <strong>Enviar a revisión</strong>.</li>
                </ul>
            </div>
        </div>

        <div class="duo">
            <div class="duo-card">
                <div class="duo-title">Los tres bloqueos clásicos</div>
                <div class="duo-sub">Y su causa real</div>
                <ul>
                    <li><strong>No guarda:</strong> falta cadena de aprobación o gerencia.</li>
                    <li><strong>No aparece el producto o el proyecto:</strong> empresa equivocada.</li>
                    <li><strong>No aparece «Enviar a revisión»:</strong> no hay partidas cargadas.</li>
                </ul>
            </div>
            <div class="duo-card warnc">
                <div class="duo-title">Dónde está mi requisición</div>
                <div class="duo-sub">En tres clics</div>
                <ul>
                    <li>Menú de tres puntos › <strong>Ver</strong>.</li>
                    <li>Columna derecha › <strong>Flujo de aprobación</strong>.</li>
                    <li>El primer paso sin fecha es quien la tiene.</li>
                    <li>Para el motivo de una devolución › <strong>Historial</strong>.</li>
                </ul>
            </div>
        </div>

        <h3>Efecto de la categoría</h3>

        <table class="data">
            <thead><tr><th style="width:20%">Categoría</th><th style="width:32%">Pasa por almacén</th><th>Catálogo de partidas</th></tr></thead>
            <tbody>
                <tr><td><strong>Proveeduría</strong></td><td><strong>Sí</strong>, en ambas empresas. Almacén captura existencias y ajusta la cantidad a comprar.</td><td>En Tech Energy solo productos de proveeduría; en GPT IM el catálogo completo.</td></tr>
                <tr><td><strong>Servicio</strong></td><td><strong>No</strong> se detiene. En GPT IM almacén recibe un correo informativo; en Tech Energy no interviene.</td><td>En Tech Energy solo servicios; en GPT IM el catálogo completo.</td></tr>
            </tbody>
        </table>

    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Requisiciones de compra · Guía del solicitante</div>
        <div class="page-header-right">Apartado 14</div>
    </header>
    <div class="page-body">
        <div class="continues">Apartado 14 · continuación</div>

        <h3>Glosario</h3>

        <table class="data">
            <thead><tr><th style="width:26%">Término</th><th>Significado</th></tr></thead>
            <tbody>
                <tr><td><strong>Requisición</strong></td><td>Solicitud formal de compra o cotización. Recorre las aprobaciones y es el origen de las órdenes de compra.</td></tr>
                <tr><td><strong>Orden de compra</strong></td><td>Documento que se manda al proveedor. La genera el comprador a partir de una requisición autorizada.</td></tr>
                <tr><td><strong>Cadena de aprobación</strong></td><td>Conjunto de personas que firman tu requisición: quien revisa, quien aprueba y quien autoriza.</td></tr>
                <tr><td><strong>Partida</strong></td><td>Cada renglón de la requisición: un producto o servicio con su cantidad.</td></tr>
                <tr><td><strong>Categoría</strong></td><td>Servicio o proveeduría. Define el catálogo disponible y si interviene almacén.</td></tr>
                <tr><td><strong>Folio</strong></td><td>Identificador único: empresa, gerencia, año y consecutivo.</td></tr>
                <tr><td><strong>Devolución</strong></td><td>Regreso al solicitante para corregir. Reversible.</td></tr>
                <tr><td><strong>Cancelación</strong></td><td>Cierre definitivo de la requisición. No admite corrección.</td></tr>
            </tbody>
        </table>

        <div class="closing">
            <strong>SA-TECH · Sistema de Compras</strong> — Guía del usuario solicitante, módulo de
            requisiciones de compra. Versión 2.0, {{ $fecha }}.<br>
            Las guías de <em>alta de productos, servicios y proyectos</em>, <em>órdenes de compra</em>
            y <em>flujos de aprobación</em> están disponibles en la sección <strong>Guías de uso</strong>
            del menú lateral. Para dudas de configuración de tu cuenta contacta al administrador del
            sistema.
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

</body>
</html>
