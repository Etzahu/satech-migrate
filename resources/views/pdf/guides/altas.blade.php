<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Alta de productos, servicios y proyectos</title>
    @include('pdf.guides._estilos')
</head>

<body>

{{-- ══════════════════════════════════════════════════════════════════════
     PORTADA
══════════════════════════════════════════════════════════════════════ --}}
<div class="page cover">
    <header class="cover-header">
        <div class="cover-logo-plate"><img src="{{ $logo }}" alt="SA-TECH"></div>
        <div class="cover-date">Versión 2.0<br>{{ $fecha }}</div>
    </header>

    <div class="cover-main">
        <div class="cover-eyebrow">Guía de uso · Módulo de altas</div>
        <h1 class="cover-title">Alta de productos,<br>servicios y proyectos</h1>
        <div class="cover-rule"></div>
        <p class="cover-subtitle">Guía del usuario solicitante</p>
        <p class="cover-lead">Qué hacer cuando lo que necesitas pedir todavía no existe en el sistema: cómo solicitar
            que se agregue al catálogo, qué documentación acelera la aprobación, cómo influye la
            empresa que tengas seleccionada y qué avisos vas a recibir.</p>
    </div>

    <footer class="cover-footer">
        <div><span class="cover-meta-k">Sistema</span><span class="cover-meta-v">SA-TECH · Compras</span></div>
        <div><span class="cover-meta-k">Dirigida a</span><span class="cover-meta-v">Rol solicitante</span></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     1. QUÉ ES UN ALTA
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Alta de productos, servicios y proyectos · Guía del solicitante</div>
        <div class="page-header-right">Apartado 1</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Qué es un alta y cuándo se usa</h2>

        <p class="lead-text">El puente entre lo que necesitas pedir y lo que el sistema te deja pedir.</p>

    <p>
        Una requisición solo admite <strong>productos y servicios que ya estén en el catálogo</strong>
        y <strong>proyectos que ya estén registrados</strong>. No hay forma de escribir a mano un
        producto que no existe. Cuando te falta alguno de los dos, lo que se hace es solicitar su
        <strong>alta</strong>: un trámite corto que revisa y aprueba el equipo de Compras, y que deja
        el elemento disponible para todos.
    </p>

    <div class="duo">
            <div class="duo-card">
                <div class="duo-title">Alta de producto o servicio</div>
                <div class="duo-sub">Menú lateral › Altas › Producto/Servicio</div>
                <ul>
                    <li>Para lo que vas a comprar o contratar.</li>
                    <li>La aprueba el gerente o el administrador de compras.</li>
                    <li>Al aprobarla se le asigna código y clasificación.</li>
                    <li><strong>No se puede editar</strong> una vez enviada.</li>
                </ul>
            </div>
            <div class="duo-card alt">
                <div class="duo-title">Alta de proyecto</div>
                <div class="duo-sub">Menú lateral › Altas › Proyectos</div>
                <ul>
                    <li>Para el proyecto al que se carga el gasto.</li>
                    <li>Requiere documentación de respaldo para Dirección General.</li>
                    <li>El código lo capturas tú, con el prefijo de tu empresa.</li>
                    <li><strong>Sí se puede editar</strong> después de enviarla.</li>
                </ul>
            </div>
        </div>

    <div class="note">
        <span class="note-title">No sustituyas un producto por otro parecido</span>
        <p>
            Es tentador elegir del catálogo «algo que se parece» para no esperar la aprobación. El
            problema llega después: el comprador cotiza lo que dice la requisición, el proveedor
            surte eso y lo recibido no sirve. Solicita el alta correcta y espera a que esté aprobada
            antes de levantar la requisición.
        </p>
    </div>

    <h3>Conceptos que conviene tener claros</h3>

    <table class="data">
        <thead>
            <tr>
                <th style="width:24%">Término</th>
                <th>Qué significa en el sistema</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Producto (proveeduría)</strong></td>
                <td>Artículo físico que se compra: refacciones, materiales, herramienta, consumibles.</td>
            </tr>
            <tr>
                <td><strong>Servicio</strong></td>
                <td>Trabajo que se contrata: mantenimiento, maquilado, consultoría, transporte, calibración.</td>
            </tr>
            <tr>
                <td><strong>Catálogo</strong></td>
                <td>La lista de productos y servicios <strong>aprobados</strong> que aparecen al cargar partidas en una requisición.</td>
            </tr>
            <tr>
                <td><strong>Proyecto</strong></td>
                <td>Identificador al que se carga el gasto. Toda requisición debe apuntar a un proyecto activo.</td>
            </tr>
            <tr>
                <td><strong>Unidad de medida</strong></td>
                <td>Cómo se mide o se compra el elemento: pieza, metro, litro, kilo, servicio. La administra Compras.</td>
            </tr>
            <tr>
                <td><strong>Código</strong></td>
                <td>Identificador del elemento en el catálogo. En productos y servicios <strong>lo asigna el administrador al aprobar</strong>; en proyectos lo capturas tú.</td>
            </tr>
        </tbody>
    </table>

    <div class="note info">
        <span class="note-title">Solo ves tus propias altas</span>
        <p>
            Las dos pantallas de <strong>Altas</strong> listan únicamente las solicitudes que
            registraste tú. No verás las de tus compañeros, aunque sean de tu misma área.
        </p>
    </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     2. LA EMPRESA
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Alta de productos, servicios y proyectos · Guía del solicitante</div>
        <div class="page-header-right">Apartado 2</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">La empresa decide a qué catálogo entra</h2>

        <p class="lead-text">Lo primero que hay que revisar, igual que al crear una requisición.</p>

    <p>
        El sistema opera dos razones sociales y cada una tiene su propio catálogo y su propia lista
        de proyectos. En la <strong>barra superior</strong> está el selector
        <strong>«Empresa actual»</strong>: lo que esté ahí seleccionado es la empresa a la que va a
        pertenecer todo lo que des de alta.
    </p>

    <table class="data">
        <thead>
            <tr>
                <th style="width:28%">Qué depende de la empresa</th>
                <th>Cómo te afecta</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>El catálogo destino</strong></td>
                <td>Un producto aprobado en GPT Ingeniería y Manufactura <strong>no aparece</strong> en las requisiciones de Tech Energy Control, ni al revés. Si lo necesitas en las dos, hay que darlo de alta dos veces.</td>
            </tr>
            <tr>
                <td><strong>El listado de tus altas</strong></td>
                <td>Las pantallas de Altas filtran por la empresa seleccionada. Si una solicitud «desaparece», casi siempre está en la otra empresa.</td>
            </tr>
            <tr>
                <td><strong>El prefijo del código de proyecto</strong></td>
                <td>GPT Ingeniería y Manufactura usa <code>NP-</code> y Tech Energy Control usa <code>DN-</code>. El sistema rechaza el prefijo que no corresponde a la empresa activa.</td>
            </tr>
        </tbody>
    </table>

    <div class="note">
        <span class="note-title">Revisa la empresa antes de capturar</span>
        <p>
            La empresa se graba en el alta en el momento en que la creas y el formulario no tiene un
            campo para corregirla después. Si te equivocas, el elemento termina en el catálogo
            equivocado y no sirve para la requisición que querías levantar.
        </p>
    </div>

    <h3>Antes de solicitar un alta, descarta lo obvio</h3>

    <p>
        La mayoría de las altas que se rechazan son de cosas que ya existían. Antes de capturar:
    </p>

    <ol class="steps">
        <li>Confirma que la <strong>empresa</strong> del selector superior es la correcta.</li>
        <li>Busca en el catálogo con <strong>varias palabras distintas</strong>: por material, por medida, por marca. Muchos productos están registrados con un nombre que no es el que tú usas de forma coloquial.</li>
        <li>Si es un proyecto, búscalo por <strong>código</strong> y también por <strong>nombre</strong>.</li>
        <li>Si de plano no aparece, entonces sí solicita el alta.</li>
    </ol>

    <div class="note warn">
        <span class="note-title">Ojo con los proyectos inactivos</span>
        <p>
            Un proyecto puede existir y aun así no aparecerte al crear una requisición, porque está
            <strong>inactivo</strong> o porque tu gerencia tiene una restricción configurada para él.
            En ese caso no hace falta un alta nueva: el alta duplicada se va a rechazar por código
            repetido. Lo que hay que hacer es pedirle al administrador que revise el estatus del
            proyecto o la restricción de tu gerencia.
        </p>
    </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     3. ALTA DE PRODUCTO O SERVICIO
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Alta de productos, servicios y proyectos · Guía del solicitante</div>
        <div class="page-header-right">Apartado 3</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Alta de producto o servicio</h2>

        <p class="lead-text">Menú lateral › Altas › Producto/Servicio › botón de nuevo registro.</p>

    <h3>Cuándo solicitarla</h3>

    <ul class="bullets">
        <li>Vas a levantar una requisición y el producto no aparece al buscarlo en el catálogo.</li>
        <li>Necesitas contratar un servicio que no está registrado.</li>
        <li>El administrador te indicó que hay que registrarlo antes de poder pedirlo.</li>
    </ul>

    <h3>Los tres campos del formulario</h3>

    <table class="data">
        <thead>
            <tr>
                <th style="width:22%">Campo</th>
                <th style="width:20%">Formato</th>
                <th>Qué debes saber</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Descripción del producto/servicio</strong><br><span class="muted">Obligatorio</span></td>
                <td>Texto libre, máx. 600 caracteres</td>
                <td>Es el campo que decide si tu alta se aprueba rápido o se atora. El sistema le quita los espacios sobrantes y <strong>lo guarda todo en minúsculas</strong>; no te preocupes por las mayúsculas.</td>
            </tr>
            <tr>
                <td><strong>Unidad de medida</strong><br><span class="muted">Obligatorio</span></td>
                <td>Lista desplegable con buscador</td>
                <td>Cómo se compra el elemento: pieza, metro, litro, kilo, servicio. Si la unidad que necesitas no está en la lista, pídesela al administrador antes de enviar el alta.</td>
            </tr>
            <tr>
                <td><strong>Tipo de elemento</strong><br><span class="muted">Obligatorio</span></td>
                <td>Producto · Servicio</td>
                <td>Determina en qué categoría de requisición podrá usarse. Un elemento registrado como Servicio no aparecerá en una requisición de proveeduría de Tech Energy Control.</td>
            </tr>
        </tbody>
    </table>

    <div class="note ok">
        <span class="note-title">Escribe la descripción como si el otro no supiera qué necesitas</span>
        <p>
            Porque efectivamente no lo sabe. En lugar de <em>«cable»</em>, escribe
            <em>«cable eléctrico calibre 14 AWG color rojo, rollo de 100 m»</em>. En lugar de
            <em>«mantenimiento»</em>, escribe <em>«mantenimiento preventivo semestral a compresor
            de tornillo 50 HP»</em>. Incluye marca, modelo, medida y material cuando los conozcas:
            es lo que va a cotizar el comprador.
        </p>
    </div>

    <h3>Documentación</h3>

    <p>
        La sección <strong>Documentación</strong> acepta uno o varios archivos <strong>PDF</strong>.
        Es opcional, pero adjuntar algo acelera notablemente la aprobación porque le ahorra al
        administrador tener que preguntarte:
    </p>

    <ul class="bullets">
        <li><strong>Ficha técnica</strong> del fabricante con las especificaciones.</li>
        <li><strong>Catálogo del proveedor</strong> donde aparezca el elemento.</li>
        <li><strong>Cotización previa</strong>, si ya tienes una.</li>
    </ul>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     4. DESPUÉS DE ENVIAR (PRODUCTO)
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Alta de productos, servicios y proyectos · Guía del solicitante</div>
        <div class="page-header-right">Apartado 3</div>
    </header>
    <div class="page-body">
    <div class="continues">3 · Alta de producto o servicio <span style="float:right">qué pasa después</span></div>

    <h3>El recorrido de tu solicitud</h3>

    <ol class="steps">
        <li>Al guardar, la solicitud queda en estado <span class="chip c-yellow">Pendiente</span> y con el código provisional <em>«Sin código asignado»</em>.</li>
        <li>El sistema manda un correo automático al <strong>gerente de compras</strong> y al <strong>administrador de compras</strong>.</li>
        <li>El administrador revisa la descripción y los documentos que adjuntaste.</li>
        <li>Si la aprueba, le asigna el <strong>código definitivo</strong>, la <strong>categoría</strong>, la <strong>familia</strong> y la <strong>marca</strong>, y puede ajustar el nombre o la unidad si hace falta afinarlos.</li>
        <li>El elemento pasa a <span class="chip c-green">Aprobado</span> y desde ese momento aparece en el catálogo al cargar partidas.</li>
    </ol>

    <div class="note ok">
        <span class="note-title">El sistema te avisa: no tienes que estar revisando</span>
        <p>
            Cuando tu alta se aprueba o se rechaza, <strong>recibes un correo automático</strong>.
            No hace falta que entres a consultar el estatus todos los días. Lo que el correo
            <strong>no</strong> trae es el motivo de un rechazo: para eso hay que preguntarle al
            administrador de compras.
        </p>
    </div>

    <div class="note">
        <span class="note-title">Un alta de producto no se puede editar ni borrar</span>
        <p>
            Una vez enviada, la pantalla solo te deja consultarla. Si te diste cuenta de que
            capturaste mal la descripción o elegiste la unidad equivocada, contacta al administrador
            de compras para que la rechace y captura una nueva con los datos corregidos.
        </p>
    </div>

    <h3>Qué ves en el listado</h3>

    <table class="data">
        <thead>
            <tr>
                <th style="width:24%">Columna</th>
                <th>Detalle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Código</strong></td>
                <td>Dice «Sin código asignado» mientras la solicitud está pendiente. El código real aparece cuando se aprueba.</td>
            </tr>
            <tr>
                <td><strong>Descripción</strong></td>
                <td>Lo que capturaste, en minúsculas.</td>
            </tr>
            <tr>
                <td><strong>Unidad de medida</strong></td>
                <td>La que seleccionaste. Puede cambiarla el administrador al aprobar.</td>
            </tr>
            <tr>
                <td><strong>Tipo</strong></td>
                <td>Producto o Servicio.</td>
            </tr>
            <tr>
                <td><strong>Estatus</strong></td>
                <td>Pendiente, Aprobado o Rechazado.</td>
            </tr>
            <tr>
                <td><strong>Fecha de creación</strong></td>
                <td>Cuándo enviaste la solicitud. Útil para saber cuánto lleva esperando.</td>
            </tr>
        </tbody>
    </table>

    <p>
        Con el icono de <strong>Ver</strong> abres el detalle, donde también puedes descargar en un
        ZIP los documentos que adjuntaste.
    </p>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     5. ALTA DE PROYECTO
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Alta de productos, servicios y proyectos · Guía del solicitante</div>
        <div class="page-header-right">Apartado 4</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Alta de proyecto</h2>

        <p class="lead-text">Menú lateral › Altas › Proyectos › botón de nuevo registro.</p>

    <h3>Cuándo solicitarla</h3>

    <ul class="bullets">
        <li>Vas a levantar una requisición y el proyecto al que se carga no existe en el sistema.</li>
        <li>Arrancó un proyecto nuevo en tu área y hay que registrarlo para poder cargarle gasto.</li>
    </ul>

    <h3>Los dos campos del formulario</h3>

    <table class="data">
        <thead>
            <tr>
                <th style="width:22%">Campo</th>
                <th style="width:24%">Formato</th>
                <th>Qué debes saber</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Código</strong><br><span class="muted">Obligatorio</span></td>
                <td><code>NP-001/25</code> en GPT Ingeniería y Manufactura<br><code>DN-001/25</code> en Tech Energy Control</td>
                <td>Debe ser único en todo el sistema. El campo trae abajo un recordatorio con el prefijo que corresponde a la empresa que tienes seleccionada.</td>
            </tr>
            <tr>
                <td><strong>Nombre completo del proyecto</strong><br><span class="muted">Obligatorio</span></td>
                <td>Texto, máx. 255 caracteres</td>
                <td>También debe ser único. Escribe el nombre formal con el que se conoce el proyecto, no una abreviatura interna.</td>
            </tr>
        </tbody>
    </table>

    <div class="note warn">
        <span class="note-title">Qué valida el sistema y qué no</span>
        <p>
            El sistema revisa dos cosas: que el código <strong>empiece con el prefijo</strong> de tu
            empresa (<code>NP-</code> o <code>DN-</code>) y que ni el código ni el nombre estén ya
            registrados. El resto del formato —los tres dígitos y el año— <strong>no se valida</strong>:
            si escribes <code>NP-1/2025</code> el sistema lo acepta, pero el proyecto va a quedar
            fuera del orden que usa el resto de la empresa. Respeta el patrón
            <code>NP-001/25</code> aunque nadie te lo exija.
        </p>
    </div>

    <h3>Documentación para aprobación por Dirección General</h3>

    <p>
        Los proyectos se respaldan con tres documentos, cada uno en su propio campo y en formato
        <strong>PDF</strong>. Técnicamente son opcionales, pero sin ellos la aprobación se detiene:
    </p>

    <table class="data">
        <thead>
            <tr>
                <th style="width:26%">Documento</th>
                <th>Qué es</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Ficha de proyecto</strong></td>
                <td>El documento formal con la descripción, el alcance y los objetivos.</td>
            </tr>
            <tr>
                <td><strong>Cotización de cliente</strong></td>
                <td>La propuesta o el contrato que se le presentó al cliente.</td>
            </tr>
            <tr>
                <td><strong>Pedido</strong></td>
                <td>La orden de compra o el pedido formal que emitió el cliente.</td>
            </tr>
        </tbody>
    </table>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     6. DESPUÉS DE ENVIAR (PROYECTO)
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Alta de productos, servicios y proyectos · Guía del solicitante</div>
        <div class="page-header-right">Apartado 4</div>
    </header>
    <div class="page-body">
    <div class="continues">4 · Alta de proyecto <span style="float:right">qué pasa después</span></div>

    <h3>El recorrido de tu solicitud</h3>

    <ol class="steps">
        <li>Al guardar, el proyecto pasa automáticamente a <span class="chip c-yellow">Pendiente</span>.</li>
        <li>El sistema manda un correo al <strong>gerente de compras</strong> y al <strong>administrador de compras</strong>.</li>
        <li>Se revisa la solicitud junto con los documentos de respaldo.</li>
        <li>Si se aprueba, el proyecto pasa a <span class="chip c-green">Activo</span> y aparece en el campo <em>Proyecto</em> al crear requisiciones.</li>
        <li>Si más adelante se inactiva, seguirá visible en las requisiciones que ya lo usan, pero no se podrá elegir en las nuevas.</li>
    </ol>

    <div class="note ok">
        <span class="note-title">También aquí el sistema te avisa</span>
        <p>
            Recibes correo cuando tu proyecto queda activo y cuando se rechaza. Igual que con los
            productos, el correo no incluye el motivo del rechazo.
        </p>
    </div>

    <h3>Una diferencia importante con los productos</h3>

    <div class="note info">
        <span class="note-title">Un alta de proyecto sí se puede corregir</span>
        <p>
            Desde el listado abre el proyecto con <strong>Ver</strong> y ahí encontrarás el botón
            <strong>Editar</strong>. Puedes ajustar el código, el nombre y los documentos adjuntos
            sin tener que volver a capturar. Es la diferencia con las altas de producto, que una vez
            enviadas quedan en solo lectura.
        </p>
    </div>

    <h3>Estados de un proyecto</h3>

    <table class="data">
        <thead>
            <tr>
                <th style="width:22%">Estado</th>
                <th>Qué significa</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span class="chip c-gray">Borrador</span></td>
                <td>Estado interno por el que pasa el registro al crearse. Tu solicitud no se queda aquí: el sistema la envía sola a Pendiente.</td>
            </tr>
            <tr>
                <td><span class="chip c-yellow">Pendiente</span></td>
                <td>Enviada y en espera de revisión.</td>
            </tr>
            <tr>
                <td><span class="chip c-green">Activo</span></td>
                <td>Aprobado. Ya puede usarse en requisiciones.</td>
            </tr>
            <tr>
                <td><span class="chip c-red">Rechazado</span></td>
                <td>No se aprobó. Puede volver a enviarse a revisión una vez corregido.</td>
            </tr>
            <tr>
                <td><span class="chip c-gray">Inactivo</span></td>
                <td>Se desactivó. No se puede elegir en requisiciones nuevas, pero sigue visible en las que ya lo usaban.</td>
            </tr>
        </tbody>
    </table>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     7. CORREOS Y SEGUIMIENTO
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Alta de productos, servicios y proyectos · Guía del solicitante</div>
        <div class="page-header-right">Apartado 5</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Correos y seguimiento</h2>

        <p class="lead-text">Qué avisos manda el sistema y dónde consultar el estatus.</p>

    <table class="data">
        <thead>
            <tr>
                <th style="width:28%">Cuándo</th>
                <th style="width:28%">Quién lo recibe</th>
                <th>Contenido</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Envías un alta de <strong>producto o servicio</strong></td>
                <td>Gerente y administrador de compras</td>
                <td>Aviso de que hay una solicitud nueva por revisar, con la descripción, la unidad y el tipo.</td>
            </tr>
            <tr>
                <td>Envías un alta de <strong>proyecto</strong></td>
                <td>Gerente y administrador de compras</td>
                <td>Aviso de que hay un proyecto nuevo por revisar.</td>
            </tr>
            <tr>
                <td>Tu producto o servicio queda <strong>aprobado</strong></td>
                <td><strong>Tú</strong></td>
                <td>Aviso con el estatus actualizado. Desde ese momento ya puedes usarlo en una requisición.</td>
            </tr>
            <tr>
                <td>Tu producto o servicio es <strong>rechazado</strong></td>
                <td><strong>Tú</strong></td>
                <td>Aviso del rechazo. <strong>Sin motivo</strong>: hay que preguntarlo al administrador.</td>
            </tr>
            <tr>
                <td>Tu proyecto queda <strong>activo</strong></td>
                <td><strong>Tú</strong></td>
                <td>Aviso de que el proyecto ya puede usarse.</td>
            </tr>
            <tr>
                <td>Tu proyecto es <strong>rechazado</strong></td>
                <td><strong>Tú</strong></td>
                <td>Aviso del rechazo, también sin motivo.</td>
            </tr>
        </tbody>
    </table>

    <div class="note warn">
        <span class="note-title">Si el correo no llega, el sistema manda</span>
        <p>
            Revisa primero la carpeta de correo no deseado. El estatus real siempre está en el
            sistema: entra a <strong>Altas › Producto/Servicio</strong> o
            <strong>Altas › Proyectos</strong> y míralo en la columna <em>Estatus</em>. El correo
            es un aviso, no la fuente de la verdad.
        </p>
    </div>

    <h3>Cuánto tarda y qué hacer mientras tanto</h3>

    <p>
        No hay un plazo configurado en el sistema: depende de la carga del equipo de Compras. Lo que
        sí puedes hacer para que avance rápido:
    </p>

    <ul class="bullets">
        <li><strong>Adjunta documentación.</strong> Un alta con ficha técnica se aprueba sin ida y vuelta.</li>
        <li><strong>No mandes duplicados.</strong> Si ya solicitaste algo y sigue pendiente, volver a capturarlo no lo acelera; genera dos registros que alguien tendrá que depurar.</li>
        <li><strong>Avisa si es urgente.</strong> El sistema no tiene campo de prioridad en las altas: si tu requisición depende de este registro, dilo por el canal que uses con Compras.</li>
    </ul>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     8. PROBLEMAS FRECUENTES
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Alta de productos, servicios y proyectos · Guía del solicitante</div>
        <div class="page-header-right">Apartado 6</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Problemas frecuentes</h2>

        <p class="lead-text">Síntoma, causa y qué hacer.</p>

    <table class="data">
        <thead>
            <tr>
                <th style="width:28%">Lo que ves</th>
                <th style="width:30%">Por qué pasa</th>
                <th>Qué hacer</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>El producto que solicité no aparece en el catálogo de la requisición.</td>
                <td>La solicitud sigue en Pendiente, o se aprobó en la otra empresa.</td>
                <td>Revisa el estatus en Altas › Producto/Servicio y confirma que la empresa del selector superior sea la misma.</td>
            </tr>
            <tr>
                <td>Aparece en el catálogo pero no en mi requisición de servicio.</td>
                <td>Se registró como Producto y no como Servicio. En Tech Energy Control el catálogo se filtra por la categoría de la requisición.</td>
                <td>Solicita al administrador que corrija el tipo del elemento.</td>
            </tr>
            <tr>
                <td>«El código ya está registrado» al dar de alta un proyecto.</td>
                <td>Ese código ya existe, aunque el proyecto esté inactivo o sea de la otra empresa.</td>
                <td>Búscalo primero. Si existe pero no lo puedes usar, pide al administrador que lo reactive o que revise la restricción de tu gerencia.</td>
            </tr>
            <tr>
                <td>«El código debe comenzar con NP-» o «con DN-».</td>
                <td>El prefijo no corresponde a la empresa que tienes seleccionada.</td>
                <td>Verifica la empresa en la barra superior. Si es la correcta, corrige el prefijo.</td>
            </tr>
            <tr>
                <td>Me equivoqué en la descripción de un producto ya enviado.</td>
                <td>Las altas de producto no son editables.</td>
                <td>Pide al administrador que la rechace y captura una nueva con la descripción corregida.</td>
            </tr>
            <tr>
                <td>Mi alta fue rechazada y no sé por qué.</td>
                <td>El correo de rechazo no incluye el motivo.</td>
                <td>Pregúntale al administrador de compras. Después captura una solicitud nueva con la información corregida.</td>
            </tr>
            <tr>
                <td>Necesito una unidad de medida que no está en la lista.</td>
                <td>Las unidades las administra el equipo de compras.</td>
                <td>Solicita que la agreguen antes de enviar tu alta; así el registro nace con la unidad correcta.</td>
            </tr>
            <tr>
                <td>No veo la sección Altas en el menú.</td>
                <td>Falta el rol <code>solicita_requisicion_compra</code>.</td>
                <td>Solicítalo al administrador del sistema.</td>
            </tr>
            <tr>
                <td>Di de alta un producto y ahora lo necesito en la otra empresa.</td>
                <td>Cada razón social tiene su propio catálogo.</td>
                <td>Cambia de empresa y captura el alta otra vez. No es un duplicado: son dos catálogos distintos.</td>
            </tr>
        </tbody>
    </table>

    <div class="closing">
        <strong>SA-TECH · Sistema de Compras</strong> — Guía del solicitante, alta de productos,
        servicios y proyectos. Versión 2.0, {{ $fecha }}.<br>
        Las guías de <em>requisiciones</em> y <em>flujos de aprobación</em> están disponibles en la
        sección <strong>Guías de uso</strong> del menú lateral. Para dudas sobre el estatus de una
        solicitud, contacta al administrador de compras.
    </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

</body>

</html>
