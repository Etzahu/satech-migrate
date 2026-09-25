<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Cadenas de aprobación de requisiciones</title>
    @include('pdf.guides._estilos')
    <style>
        /* Las cuatro casillas de una cadena, dibujadas como la ve el administrador. */
        .chain-demo { width: 100%; border-collapse: collapse; margin: 0.1in 0 0.14in; font-size: 9pt; }
        .chain-demo th {
            background: var(--navy); color: var(--white); padding: 0.05in 0.09in;
            font-size: 8pt; letter-spacing: 0.06em; text-transform: uppercase; text-align: left;
        }
        .chain-demo td { border: 1px solid var(--gray-200); padding: 0.09in; vertical-align: top; }
        .chain-demo .slot {
            display: block; font-size: 7.5pt; text-transform: uppercase;
            letter-spacing: 0.08em; color: var(--gray-400); margin-bottom: 0.02in;
        }
    </style>
</head>

<body>

{{-- ══════════════════════════════════════════════════════════════════════
     PORTADA
══════════════════════════════════════════════════════════════════════ --}}
<div class="page cover">
    <header class="cover-header">
        <div class="cover-logo-plate"><img src="{{ $logo }}" alt="SA-TECH"></div>
        <div class="cover-date">Versión 1.0<br>{{ $fecha }}</div>
    </header>

    <div class="cover-main">
        <div class="cover-eyebrow">Guía de administración · Requisiciones</div>
        <h1 class="cover-title">Cadenas de<br>aprobación</h1>
        <div class="cover-rule"></div>
        <p class="cover-subtitle">Administración de requisiciones de compra</p>
        <p class="cover-lead">Sin una cadena de aprobación, un solicitante no puede generar ni una sola requisición.
            Esta guía explica cómo armarlas, cuándo dejar vacío el nivel de autorización, qué hacer
            cuando alguien deja la empresa y cómo destrabar las requisiciones que quedaron esperando
            a un usuario que ya no entra al sistema.</p>
    </div>

    <footer class="cover-footer">
        <div><span class="cover-meta-k">Sistema</span><span class="cover-meta-v">SA-TECH · Compras</span></div>
        <div><span class="cover-meta-k">Dirigida a</span><span class="cover-meta-v">Administración de compras</span></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     1. QUÉ ES UNA CADENA
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Cadenas de aprobación · Guía del administrador</div>
        <div class="page-header-right">Apartado 1</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Qué es una cadena y por qué es indispensable</h2>

        <p class="lead-text">Administración › Cadena requisición.</p>

    <p>
        Una <strong>cadena de aprobación</strong> es un registro con cuatro casillas que define, para
        un solicitante concreto, quién revisa, quién aprueba y quién autoriza sus requisiciones. No
        es una configuración global ni por gerencia: <strong>es por persona</strong>.
    </p>

    <table class="chain-demo">
        <thead>
            <tr>
                <th style="width:25%">Solicita</th>
                <th style="width:25%">Revisa</th>
                <th style="width:25%">Aprueba</th>
                <th style="width:25%">Autoriza</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <span class="slot">Dueño de la cadena</span>
                    Quien levanta la requisición
                </td>
                <td>
                    <span class="slot">Primer filtro</span>
                    Valida el contenido
                </td>
                <td>
                    <span class="slot">Gerencia</span>
                    Aprueba el gasto
                </td>
                <td>
                    <span class="slot">Dirección General</span>
                    Autoriza · puede ir vacío
                </td>
            </tr>
        </tbody>
    </table>

    <div class="note">
        <span class="note-title">Sin cadena no hay requisición</span>
        <p>
            Es el bloqueo que más reportes genera. El solicitante puede entrar al módulo, llenar
            todo el formulario y adjuntar archivos; al guardar, el sistema revisa si existe al menos
            una cadena a su nombre y, si no la hay, <strong>detiene el guardado con el mensaje «No
            cuenta con una cadena de aprobación asignada»</strong> y no crea nada.
        </p>
        <p style="margin-top:6px">
            El otro requisito de la misma familia es la <strong>gerencia</strong>: sin ella el
            sistema no puede armar el folio y muestra «No cuenta con una gerencia asignada». Cuando
            des de alta a un usuario nuevo que va a levantar requisiciones, revisa las dos cosas.
        </p>
    </div>

    <h3>Quién puede ocupar cada casilla</h3>

    <table class="data">
        <thead>
            <tr>
                <th style="width:17%">Casilla</th>
                <th style="width:34%">El desplegable solo lista</th>
                <th>Por qué</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Solicita</strong></td>
                <td>Usuarios con correo <code>@gptservices.com</code>. Al crear, además, solo los activos.</td>
                <td>Es el dueño de la cadena: la requisición que se cree con ella le pertenece y aparece en su bandeja.</td>
            </tr>
            <tr>
                <td><strong>Revisa</strong></td>
                <td>Usuarios con correo <code>@gptservices.com</code>. Al crear, solo los activos.</td>
                <td>La casilla no exige un rol específico, pero para que la persona pueda responder necesita el rol <code>revisa_requisicion_compra</code>.</td>
            </tr>
            <tr>
                <td><strong>Aprueba</strong></td>
                <td>Solo usuarios con el rol <code>aprueba_requisicion_compra</code>.</td>
                <td>El propio desplegable filtra por rol, así que aquí no hay forma de equivocarse.</td>
            </tr>
            <tr>
                <td><strong>Autoriza</strong></td>
                <td>Solo usuarios con el rol <code>autoriza_requisicion_compra</code>. Puede dejarse vacío.</td>
                <td>Es el único nivel opcional del sistema.</td>
            </tr>
        </tbody>
    </table>

    <div class="note warn">
        <span class="note-title">Revisa el rol de quien pones en «Revisa»</span>
        <p>
            Es la única casilla donde el sistema no filtra por rol. Si colocas a alguien que no tiene
            <code>revisa_requisicion_compra</code>, la cadena se guarda sin protestar y la
            requisición llegará hasta esa persona, pero <strong>el botón de responder no le va a
            aparecer</strong> y el documento se queda detenido sin explicación aparente.
        </p>
    </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     2. CREAR UNA CADENA
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Cadenas de aprobación · Guía del administrador</div>
        <div class="page-header-right">Apartado 2</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Crear una cadena</h2>

        <p class="lead-text">Lo que hay que decidir antes de guardar.</p>

    <ol class="steps">
        <li>Entra a <strong>Administración › Cadena requisición</strong> y presiona el botón de nuevo registro.</li>
        <li>En <strong>Solicita</strong> elige a la persona que va a levantar las requisiciones.</li>
        <li>En <strong>Revisa</strong> elige el primer filtro. Confirma aparte que tenga el rol de revisor.</li>
        <li>En <strong>Aprueba</strong> elige al gerente que autoriza el gasto del área.</li>
        <li>En <strong>Autoriza</strong> elige a quien cierra el flujo, o <strong>déjalo vacío</strong> si esa cadena no lleva ese nivel.</li>
        <li>Guarda.</li>
    </ol>

    <div class="note info">
        <span class="note-title">El nivel de autorización puede quedar vacío a propósito</span>
        <p>
            Hay áreas donde ese nivel se eliminó: la casilla aparece con la leyenda
            <em>«N/A — sin nivel de autorización»</em> y se deja en blanco. Una cadena así
            <strong>no está incompleta</strong>. Cuando la gerencia aprueba, el sistema reconoce que
            no hay autorizador y <strong>avanza la requisición solo</strong> hasta dejarla lista para
            que se le asigne comprador. El estado se registra igual, para que el histórico, las
            fechas y el PDF sigan cuadrando; lo único distinto es que esa firma se imprime como
            <em>N/A</em>.
        </p>
    </div>

    <h3>Reglas que aplica el sistema al guardar</h3>

    <table class="data">
        <thead>
            <tr>
                <th style="width:30%">Regla</th>
                <th>Qué implica</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>No se admiten cadenas duplicadas</strong></td>
                <td>No puede existir otra cadena con la misma combinación exacta de Solicita, Revisa, Aprueba y Autoriza. Si lo intentas, el sistema lo rechaza con un mensaje explícito. El nivel vacío cuenta como parte de la combinación.</td>
            </tr>
            <tr>
                <td><strong>Solicita, Revisa y Aprueba son obligatorios</strong></td>
                <td>Solo <em>Autoriza</em> admite quedarse en blanco.</td>
            </tr>
            <tr>
                <td><strong>Un mismo usuario puede repetirse</strong></td>
                <td>El sistema permite que la misma persona ocupe dos casillas de la misma cadena. Está contemplado y se usa: no es un error de captura que haya que corregir.</td>
            </tr>
        </tbody>
    </table>

    <h3>Varias cadenas para el mismo solicitante</h3>

    <p>
        Un solicitante puede tener más de una cadena. Al crear la requisición, él elige con cuál se va
        a firmar: la pestaña <strong>Flujo de aprobación</strong> le muestra una tabla con un renglón
        por cadena y las tres firmas de cada una.
    </p>

    <p>
        Es la forma de resolver los casos en que alguien trabaja para dos áreas, o en que ciertas
        compras se aprueban por una ruta distinta. Ten en cuenta el costo: si le das cinco cadenas
        parecidas, va a equivocarse al elegir. Dale las que realmente necesite.
    </p>

    <div class="note warn">
        <span class="note-title">Excluir del flujo de orden por rol</span>
        <p>
            En las cadenas de gerencias que aprueban órdenes <strong>por rol</strong> aparece un
            interruptor adicional. Márcalo solo cuando esa cadena deba conservar su propio aprobador
            y autorizador en las órdenes de compra, en lugar de usar el flujo por rol de su gerencia.
            Si no sabes que lo necesitas, déjalo apagado.
        </p>
    </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     3. ESTADOS DE UNA CADENA
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Cadenas de aprobación · Guía del administrador</div>
        <div class="page-header-right">Apartado 3</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Los tres estados de una cadena</h2>

        <p class="lead-text">La columna «Estado» del listado, y qué se puede hacer en cada caso.</p>

    <table class="data">
        <thead>
            <tr>
                <th style="width:16%">Estado</th>
                <th style="width:34%">Qué significa</th>
                <th>Qué hacer</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span class="chip c-green">Activa</span></td>
                <td>Todos sus participantes están activos y nadie la ha desactivado. Los solicitantes pueden elegirla.</td>
                <td>Nada. Es el estado normal.</td>
            </tr>
            <tr>
                <td><span class="chip c-red">Bloqueada</span></td>
                <td>Alguno de los firmantes fue dado de baja o desactivado. El nombre sale en rojo con un triángulo de advertencia.</td>
                <td>Reemplaza al participante inactivo. Mientras tanto, el solicitante no puede elegir esta cadena y ve el motivo en rojo en su formulario.</td>
            </tr>
            <tr>
                <td><span class="chip c-gray">Desactivada</span></td>
                <td>Alguien la retiró de circulación a propósito con la acción <strong>Desactivar</strong>.</td>
                <td>Si volvió a hacer falta, usa <strong>Reactivar</strong>. Las requisiciones que la usaban conservan su historial y siguen su curso.</td>
            </tr>
        </tbody>
    </table>

    <div class="note info">
        <span class="note-title">Un nivel de autorización vacío no bloquea la cadena</span>
        <p>
            El sistema distingue entre una casilla vacía a propósito y una casilla ocupada por
            alguien dado de baja. Lo primero es una cadena sin ese nivel y sigue siendo
            <strong>Activa</strong>; lo segundo la deja <strong>Bloqueada</strong>.
        </p>
    </div>

    <h3>Desactivar en lugar de borrar</h3>

    <p>
        <strong>Desactivar</strong> es la salida limpia cuando una cadena ya no debe usarse: deja de
        aparecer en el formulario del solicitante, pero el registro se conserva y con él el historial
        de las requisiciones que la recorrieron. Se puede revertir en cualquier momento.
    </p>

    <h3>Por qué algunas cadenas no se dejan editar</h3>

    <div class="note warn">
        <span class="note-title">Una cadena que ya se usó es de solo lectura</span>
        <p>
            En cuanto una cadena tiene al menos una requisición relacionada —incluidas las
            eliminadas—, el botón <strong>Editar</strong> desaparece y en su lugar queda
            <strong>Ver</strong>. No es una falla: cambiar a los participantes reescribiría el flujo
            de las requisiciones que ya pasaron por ella, y las firmas del PDF dejarían de
            corresponder con quien realmente respondió.
        </p>
        <p style="margin-top:6px">
            La columna <strong>Requisiciones relacionadas</strong> del listado te dice de inmediato
            si una cadena se puede editar: en cero, sí; con cualquier número, no.
        </p>
    </div>

    <p>
        Cuando necesitas cambiar a un participante de una cadena que ya está en uso, tienes dos
        caminos, y ninguno es editar: <strong>crear una cadena nueva</strong> con la combinación
        correcta y desactivar la anterior, o <strong>reemplazar al usuario</strong> con el comando
        que se describe en el apartado 5.
    </p>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     4. BORRAR
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Cadenas de aprobación · Guía del administrador</div>
        <div class="page-header-right">Apartado 4</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Borrar una cadena</h2>

        <p class="lead-text">Dos comportamientos distintos según tenga o no requisiciones.</p>

    <div class="duo">
            <div class="duo-card">
                <div class="duo-title">Cadena sin requisiciones</div>
                <div class="duo-sub">Borrado directo</div>
                <ul>
                    <li>Aparece la acción normal de eliminar.</li>
                    <li>Se borra y no hay nada más que decidir.</li>
                    <li>Es el caso de una cadena creada por error.</li>
                </ul>
            </div>
            <div class="duo-card">
                <div class="duo-title">Cadena con requisiciones</div>
                <div class="duo-sub">Exige cadena de reemplazo</div>
                <ul>
                    <li>Se abre un panel que muestra cuántas requisiciones dependen de ella.</li>
                    <li>Obliga a elegir una <strong>cadena de reemplazo</strong>.</li>
                    <li>Todas esas requisiciones se mueven a la nueva cadena y después se borra la anterior.</li>
                </ul>
            </div>
        </div>

    <div class="note">
        <span class="note-title">El reemplazo reescribe el historial de esas requisiciones</span>
        <p>
            Las requisiciones movidas pasan a mostrar a los firmantes de la cadena nueva, incluso las
            que ya estaban cerradas y fueron firmadas por otras personas. Es una operación pensada
            para depurar cadenas duplicadas o mal capturadas, <strong>no</strong> para dar de baja a
            alguien que se fue de la empresa. Para eso está el apartado 5.
        </p>
        <p style="margin-top:6px">
            Antes de borrar, valora si <strong>Desactivar</strong> resuelve el problema. Casi siempre
            lo resuelve, y sin tocar nada del pasado.
        </p>
    </div>

    <h3>Qué cadenas se ofrecen como reemplazo</h3>

    <p>
        El desplegable solo lista cadenas que se pueden usar de verdad: activas, sin participantes
        dados de baja y distintas de la que estás borrando. Si el desplegable sale vacío, primero hay
        que crear o destrabar una cadena válida.
    </p>

    <div class="note warn">
        <span class="note-title">Revisa que el reemplazo sea del mismo solicitante</span>
        <p>
            La lista no filtra por solicitante. Si eliges una cadena de otra persona, las
            requisiciones dejarán de pertenecer a quien las levantó y desaparecerán de su bandeja.
            Comprueba la columna <em>Solicita</em> antes de confirmar.
        </p>
    </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     5. CUANDO ALGUIEN SE VA
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Cadenas de aprobación · Guía del administrador</div>
        <div class="page-header-right">Apartado 5</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Cuando alguien deja la empresa</h2>

        <p class="lead-text">El escenario que más requisiciones detiene.</p>

    <p>
        Al desactivar a un usuario, todas las cadenas donde aparezca pasan a
        <strong>Bloqueada</strong> y sus solicitantes dejan de poder elegirlas. Peor aún: las
        requisiciones que ya iban en camino y esperaban su firma se quedan <strong>detenidas sin que
        nadie se entere</strong>, porque el correo se envió a una cuenta que ya nadie lee.
    </p>

    <h3>Qué hacer, en orden</h3>

    <ol class="steps">
        <li><strong>Localiza el daño.</strong> En el listado de cadenas, filtra o busca por el nombre del usuario: las casillas en rojo con triángulo te dicen dónde aparece.</li>
        <li><strong>Revisa qué está detenido.</strong> Entra a <strong>Administración › Verificar requisiciones</strong>, elige al usuario y el sistema te muestra en cuántas cadenas participa y qué requisiciones están esperándolo, separadas por nivel.</li>
        <li><strong>Sustitúyelo en las cadenas.</strong> Las que no tengan requisiciones se pueden editar directo. Para las que ya se usaron, usa el comando de reemplazo.</li>
        <li><strong>Destraba lo que quedó parado.</strong> Desde la misma pantalla de verificación, cada requisición detenida tiene la acción <strong>Reasignar</strong>.</li>
    </ol>

    <div class="note info">
        <span class="note-title">La pantalla «Verificar requisiciones»</span>
        <p>
            Está en <strong>Administración › Verificar requisiciones</strong> y la ven los perfiles
            de gerente y administrador de compras. Seleccionas un usuario y te dice, de un vistazo,
            en cuántas cadenas participa como revisor, aprobador y autorizador, y qué requisiciones
            tiene pendientes en cada papel. Es el punto de partida para cualquier movimiento de
            personal.
        </p>
    </div>

    <h3>Reasignar una requisición detenida</h3>

    <p>
        La acción <strong>Reasignar</strong> mueve una requisición a otra cadena del mismo
        solicitante. Al confirmarla, el documento cambia al estado
        <span class="chip c-violet">Cadena reasignada</span> y <strong>vuelve al inicio del
        flujo</strong>: todas las firmas se piden de nuevo.
    </p>

    <p>
        El solicitante recibe un correo con el asunto <strong>«CADENA REASIGNADA»</strong> que
        detalla la cadena anterior y la nueva, con los nombres de cada nivel, y la requisición
        reaparece en su pestaña de borradores lista para reenviar.
    </p>

    <div class="note warn">
        <span class="note-title">Avísale al solicitante antes de reasignar</span>
        <p>
            Desde su lado, una requisición que llevaba días avanzando aparece de golpe al principio
            del proceso. El correo automático lo explica, pero un aviso previo evita el reporte de
            «se perdió mi requisición».
        </p>
    </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     6. HERRAMIENTAS DE CONSOLA
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Cadenas de aprobación · Guía del administrador</div>
        <div class="page-header-right">Apartado 6</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Herramientas de consola</h2>

        <p class="lead-text">Para movimientos masivos que no conviene hacer a mano, uno por uno.</p>

    <p>
        Estos comandos los ejecuta el equipo técnico en el servidor. Todos aceptan
        <code>--dry-run</code>, que simula la operación y muestra qué haría <strong>sin guardar
        nada</strong>. Úsalo siempre la primera vez.
    </p>

    <h3>Detectar lo que está detenido</h3>

    <table class="data">
        <thead>
            <tr>
                <th style="width:40%">Comando</th>
                <th>Qué hace</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>requisitions:detect-blocked</code></td>
                <td>Recorre todas las cadenas, encuentra las que tienen participantes inactivos y lista las requisiciones que quedaron esperándolos. Acepta <code>--company-id</code> para acotar a una empresa y <code>--export</code> para sacar el resultado a CSV.</td>
            </tr>
        </tbody>
    </table>

    <p style="font-size:10px;color:#6b7280">
        Es el comando con el que conviene empezar cualquier depuración: no modifica nada y te dice el
        tamaño real del problema.
    </p>

    <h3>Reemplazar a una persona en todas sus cadenas</h3>

    <table class="data">
        <thead>
            <tr>
                <th style="width:40%">Opción</th>
                <th>Para qué sirve</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>--old-user-id</code></td>
                <td>El usuario que se va o quedó inactivo.</td>
            </tr>
            <tr>
                <td><code>--new-reviewer-id</code></td>
                <td>Quién lo sustituye donde aparecía como revisor.</td>
            </tr>
            <tr>
                <td><code>--new-approver-id</code></td>
                <td>Quién lo sustituye donde aparecía como aprobador.</td>
            </tr>
            <tr>
                <td><code>--new-authorizer-id</code></td>
                <td>Quién lo sustituye donde aparecía como autorizador.</td>
            </tr>
            <tr>
                <td><code>--reset</code></td>
                <td>Además de sustituirlo, regresa al inicio las requisiciones que estaban detenidas.</td>
            </tr>
        </tbody>
    </table>

    <div class="note info">
        <span class="note-title">Por qué hay tres sustitutos y no uno</span>
        <p>
            Porque una misma persona puede aparecer en distintos niveles en cadenas distintas, y no
            siempre la reemplaza la misma persona en todos. Si en tu caso es la misma, pon el mismo
            ID en las tres opciones.
        </p>
    </div>

    <h3>Reasignar por usuario y nivel</h3>

    <p>
        <code>requisitions:reassign</code> es la versión fina: trabaja sobre un usuario
        (<code>--user-id</code>) en un nivel concreto (<code>--role</code>, con valor
        <code>reviewer</code>, <code>approver</code> o <code>authorizer</code>), lo sustituye por
        <code>--new-user-id</code> y admite acotar a una sola cadena con <code>--chain-id</code>.
        También acepta <code>--reset</code> y <code>--dry-run</code>.
    </p>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     7. PROBLEMAS FRECUENTES
══════════════════════════════════════════════════════════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Cadenas de aprobación · Guía del administrador</div>
        <div class="page-header-right">Apartado 7</div>
    </header>
    <div class="page-body">
    <h2 class="section-title">Problemas frecuentes</h2>

        <p class="lead-text">Lo que reportan los solicitantes y qué revisar del lado de la cadena.</p>

    <table class="data">
        <thead>
            <tr>
                <th style="width:30%">Lo que reporta el usuario</th>
                <th style="width:30%">Causa del lado de la cadena</th>
                <th>Qué revisar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>«No me deja guardar la requisición».</td>
                <td>No tiene ninguna cadena a su nombre, o no tiene gerencia.</td>
                <td>Busca su nombre en la columna <em>Solicita</em>. Si no aparece, créale una cadena. Revisa también la gerencia en su ficha de usuario.</td>
            </tr>
            <tr>
                <td>«La tabla de flujo de aprobación me sale vacía».</td>
                <td>Lo mismo: no hay cadenas a su nombre.</td>
                <td>Créale una. El aviso que él ve ya le indica pedirlo.</td>
            </tr>
            <tr>
                <td>«Mis cadenas están en gris y no las puedo elegir».</td>
                <td>Están desactivadas, o tienen participantes inactivos.</td>
                <td>Mira la columna <em>Estado</em>. Si dice Bloqueada, sustituye al inactivo; si dice Desactivada, reactívala o crea otra.</td>
            </tr>
            <tr>
                <td>«Al guardar me pide elegir otro flujo».</td>
                <td>La cadena dejó de ser válida entre que creó el borrador y el momento de editarlo.</td>
                <td>Es el comportamiento correcto: el sistema revalida al guardar. Dale una cadena válida.</td>
            </tr>
            <tr>
                <td>«Mi requisición lleva días sin moverse».</td>
                <td>El firmante que le toca está inactivo, o no tiene el rol para responder.</td>
                <td>Corre <code>requisitions:detect-blocked</code>, o revisa al usuario en <em>Verificar requisiciones</em>. Comprueba también que tenga el rol del nivel que ocupa.</td>
            </tr>
            <tr>
                <td>«No puedo editar esta cadena».</td>
                <td>Ya tiene requisiciones relacionadas.</td>
                <td>Es intencional. Crea una cadena nueva y desactiva la anterior, o usa el comando de reemplazo.</td>
            </tr>
            <tr>
                <td>«Me dice que ya existe una cadena igual».</td>
                <td>Hay otra con la misma combinación de los cuatro niveles.</td>
                <td>Búscala con los filtros del listado. Puede estar desactivada: si es la que necesitas, reactívala en vez de duplicarla.</td>
            </tr>
            <tr>
                <td>«Mi requisición volvió al principio sola».</td>
                <td>Se le reasignó la cadena.</td>
                <td>Es el comportamiento esperado. El correo de «CADENA REASIGNADA» se lo explica.</td>
            </tr>
        </tbody>
    </table>

    <div class="note ok">
        <span class="note-title">Revisión preventiva</span>
        <p>
            Cada vez que se dé de baja a un colaborador, corre
            <code>requisitions:detect-blocked</code> antes de que los reportes empiecen a llegar. Es
            de solo lectura y toma segundos: te dice exactamente qué cadenas y qué requisiciones
            quedaron colgando de esa persona.
        </p>
    </div>

    <div class="closing">
        <strong>SA-TECH · Sistema de Compras</strong> — Guía del administrador, cadenas de
        aprobación de requisiciones. Versión 1.0, {{ $fecha }}.<br>
        Las guías de <em>requisiciones</em>, <em>alta de productos y proyectos</em> y
        <em>flujos de aprobación</em> están disponibles en la sección
        <strong>Guías de uso</strong> del menú lateral.
    </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

</body>

</html>
