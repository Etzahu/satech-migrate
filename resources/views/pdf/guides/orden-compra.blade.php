<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Orden de compra · Guía del comprador · SA-TECH</title>
    @include('pdf.guides._estilos')
</head>

<body>

{{-- ══════════════════ PORTADA ══════════════════ --}}
<div class="page cover">
    <header class="cover-header">
        <div class="cover-logo-plate"><img src="{{ $logo }}" alt="SA-TECH"></div>
        <div class="cover-date">Versión 2.0<br>{{ $fecha }}</div>
    </header>

    <div class="cover-main">
        <div class="cover-eyebrow">Guía del comprador</div>
        <h1 class="cover-title">Orden<br>de compra</h1>
        <div class="cover-rule"></div>
        <p class="cover-subtitle">Cómo capturar, enviar y dar seguimiento a una orden, de la requisición al proveedor.</p>
        <p class="cover-lead">
            Incluye los dos caminos de aprobación, el nivel de liberación de Dirección
            Administrativa, cuándo se activa la aprobación por monto y qué hacer cuando una orden
            se devuelve o hay que reabrirla.
        </p>
    </div>

    <footer class="cover-footer">
        <div><span class="cover-meta-k">Sistema</span><span class="cover-meta-v">SA-TECH · Compras</span></div>
        <div><span class="cover-meta-k">Dirigida a</span><span class="cover-meta-v">Comprador y aprobadores</span></div>
        <div><span class="cover-meta-k">Organización</span><span class="cover-meta-v">GPT Services</span></div>
    </footer>
</div>

{{-- ══════════════════ ÍNDICE ══════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">SA-TECH</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Contenido</h2>

        <div class="toc-row"><div class="toc-n">1</div><div><div class="toc-t">Qué es una orden y quién interviene</div><div class="toc-d">De dónde nace, qué rol hace qué y por qué una requisición puede dar origen a varias órdenes.</div></div></div>
        <div class="toc-row"><div class="toc-n">2</div><div><div class="toc-t">Los dos caminos de aprobación</div><div class="toc-d">Flujo normal y flujo especial. El sistema elige por ti según el proveedor.</div></div></div>
        <div class="toc-row"><div class="toc-n">3</div><div><div class="toc-t">Quién aprueba: por cadena o por rol</div><div class="toc-d">Cinco gerencias resuelven los niveles 2 y 3 por rol; el resto de la empresa, por la cadena de la requisición.</div></div></div>
        <div class="toc-row"><div class="toc-n">4</div><div><div class="toc-t">Crear la orden paso a paso</div><div class="toc-d">Las nueve pestañas del formulario, campo por campo.</div></div></div>
        <div class="toc-row"><div class="toc-n">5</div><div><div class="toc-t">Partidas y precios</div><div class="toc-d">Cómo se cargan, qué se captura y por qué sin precio no se puede enviar.</div></div></div>
        <div class="toc-row"><div class="toc-n">6</div><div><div class="toc-t">Enviar a revisión</div><div class="toc-d">Las condiciones para que aparezca el botón y qué significa que salga en rojo.</div></div></div>
        <div class="toc-row"><div class="toc-n">7</div><div><div class="toc-t">El recorrido completo</div><div class="toc-d">Los ocho pasos del flujo normal, con quién actúa en cada uno.</div></div></div>
        <div class="toc-row"><div class="toc-n">8</div><div><div class="toc-t">El nivel de monto</div><div class="toc-d">Cuándo hace falta la última aprobación de Dirección General y quién está exento.</div></div></div>
        <div class="toc-row"><div class="toc-n">9</div><div><div class="toc-t">Seguimiento y acciones</div><div class="toc-d">Descargar la orden, reabrirla, agregar partidas pendientes de la requisición.</div></div></div>
        <div class="toc-row"><div class="toc-n">10</div><div><div class="toc-t">Devoluciones y cancelaciones</div><div class="toc-d">Quién puede detener una orden, en qué punto y qué pasa después.</div></div></div>
        <div class="toc-row"><div class="toc-n">11</div><div><div class="toc-t">Diccionario de estados</div><div class="toc-d">Todos los estados posibles y qué puedes hacer en cada uno.</div></div></div>
        <div class="toc-row"><div class="toc-n">12</div><div><div class="toc-t">Problemas frecuentes</div><div class="toc-d">Síntoma, causa y solución de los bloqueos más comunes.</div></div></div>

        <div class="note info" style="margin-top:0.2in">
            <span class="note-title">Qué cambió respecto de la versión anterior</span>
            <p>
                El flujo de aprobación se modificó en agosto de 2026. Dos cambios afectan a todas
                las órdenes: se agregó el nivel obligatorio de <strong>liberación por Dirección
                Administrativa</strong>, y la <strong>aprobación por monto pasó al final</strong> del
                recorrido, después de esa liberación. Si trabajabas con la guía anterior, revisa los
                apartados 7 y 8.
            </p>
        </div>

        <div class="note warn">
            <span class="note-title">Para los diagramas, hay una versión interactiva</span>
            <p>
                En el menú lateral, la página <strong>Flujo del proceso</strong> muestra este mismo
                recorrido como diagrama navegable, con el detalle de cada estado al hacer clic.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════ 1 · QUÉ ES ══════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">Apartado 1</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Qué es una orden y quién interviene</h2>

        <p class="lead-text">El documento con el que la empresa le pide formalmente algo a un proveedor.</p>

        <p>
            Una orden de compra <strong>siempre nace de una requisición</strong> que ya recorrió sus
            aprobaciones y a la que se te asignó como comprador. Tú eliges el proveedor, negocias el
            precio y capturas las condiciones; a partir de ahí la orden recorre su propio flujo de
            firmas hasta quedar autorizada para enviarse.
        </p>

        <div class="note info">
            <span class="note-title">Una requisición puede dar varias órdenes</span>
            <p>
                No estás obligado a resolver toda la requisición con un solo proveedor. Puedes
                levantar una orden por proveedor y repartir las partidas entre ellas. El sistema
                lleva la cuenta: mientras queden partidas de la requisición sin orden, te ofrece la
                acción <strong>Agregar partidas de la requisición</strong> (apartado 9).
            </p>
        </div>

        <h3>Quién hace qué</h3>

        <table class="data">
            <thead>
                <tr><th style="width:27%">Rol</th><th>Qué le toca en la orden</th></tr>
            </thead>
            <tbody>
                <tr><td><strong>Comprador</strong><br><code>comprador</code></td><td>Crea la orden, elige proveedor, captura precios, documentos y condiciones, y la envía al flujo. Después del cierre puede descargarla y reabrirla.</td></tr>
                <tr><td><strong>Gerente de compras</strong><br><code>gerente_compras</code></td><td>Primera revisión del flujo normal. Aprueba, devuelve o cancela.</td></tr>
                <tr><td><strong>Nivel 2 · aprueba</strong><br><code>aprueba_orden_compra</code> o el aprobador de la cadena</td><td>Segunda firma. Quién es depende de la gerencia: ver el apartado 3.</td></tr>
                <tr><td><strong>Nivel 3 · autoriza</strong><br><code>autoriza_orden_compra</code> o el autorizador de la cadena</td><td>Tercera firma, la de Dirección General nivel 1.</td></tr>
                <tr><td><strong>Dirección Administrativa</strong><br><code>libera_orden_compra</code></td><td>Libera la orden. Es obligatorio en todas las órdenes del flujo normal y aplica a toda la empresa.</td></tr>
                <tr><td><strong>Dirección General · monto</strong><br><code>autoriza_nivel-2-orden_compra</code></td><td>Última aprobación, solo cuando el total supera el límite.</td></tr>
                <tr><td><strong>Dirección General · especial</strong><br><code>aprueba_orden_especial</code></td><td>Único aprobador del flujo especial.</td></tr>
                <tr><td><strong>Informativo</strong><br><code>informativo_compras</code></td><td>No firma. Recibe copia del aviso cuando la orden queda autorizada para el proveedor.</td></tr>
            </tbody>
        </table>

        <h3>Dónde se trabaja</h3>

        <p>
            En el menú lateral, grupo <strong>Orden</strong> › <strong>Mis ordenes</strong>. El
            listado tiene tres pestañas: <strong>Borradores</strong> reúne lo que está en tus manos
            —órdenes sin enviar, devueltas y reabiertas—, <strong>Reabiertas</strong> filtra solo las
            que volviste a abrir, y <strong>Liberadas</strong> las que ya están autorizadas para el
            proveedor.
        </p>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════ 2 · LOS DOS CAMINOS ══════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">Apartado 2</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Los dos caminos de aprobación</h2>

        <p class="lead-text">Tú no eliges el flujo: lo determina el proveedor que selecciones.</p>

        <div class="duo">
            <div class="duo-card">
                <div class="duo-title">Flujo normal</div>
                <div class="duo-sub">Proveedor con cadena normal</div>
                <ul>
                    <li>Es el de la gran mayoría de las órdenes.</li>
                    <li>Cinco firmas: gerente de compras, nivel 2, nivel 3, liberación y —si aplica— monto.</li>
                    <li>El botón de enviar aparece en <strong>verde</strong>.</li>
                </ul>
            </div>
            <div class="duo-card alt">
                <div class="duo-title">Flujo especial</div>
                <div class="duo-sub">Proveedor de la lista especial</div>
                <ul>
                    <li>Ruta corta: pasa directo a Dirección General.</li>
                    <li>Una sola firma. Sin gerente de compras, sin niveles 2 y 3, sin liberación.</li>
                    <li>Tampoco pasa por el nivel de monto, sin importar el total.</li>
                    <li>El botón de enviar aparece en <strong>rojo</strong>.</li>
                </ul>
            </div>
        </div>

        <div class="note">
            <span class="note-title">Cómo saber cuál te tocó</span>
            <p>
                Al presionar <strong>Enviar a revisión</strong>, el aviso de confirmación te lo dice:
                si el proveedor es especial, el texto agrega «Tu orden seguirá un proceso de
                aprobación rápido por ser un proveedor especial» y el botón cambia de verde a rojo.
                Si no ves ese aviso, tu orden va por el flujo normal.
            </p>
        </div>

        <h3>Qué hace especial a un proveedor</h3>

        <p>
            Es una marca en la ficha del proveedor —su <em>cadena de aprobación</em>— que administra
            el gerente de compras. No depende del monto, del giro ni de la urgencia: es una decisión
            del área, tomada proveedor por proveedor. Si crees que un proveedor debería estar en esa
            lista, se pide al gerente de compras; no se puede forzar desde la orden.
        </p>

        <div class="note warn">
            <span class="note-title">El flujo se decide al enviar, no al capturar</span>
            <p>
                Si cambias de proveedor mientras la orden está en borrador, el camino cambia con él.
                Lo que cuenta es el proveedor que tenga la orden en el momento en que presionas
                <strong>Enviar a revisión</strong>.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════ 3 · CADENA O ROL ══════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">Apartado 3</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Quién aprueba: por cadena o por rol</h2>

        <p class="lead-text">Dentro del flujo normal conviven dos formas de decidir quién firma los niveles 2 y 3.</p>

        <p>
            Históricamente los firmantes salían de la <strong>cadena de aprobación de la
            requisición</strong>: aprobaba su gerente y autorizaba su director. Desde agosto de 2026,
            cinco gerencias operativas resuelven esos dos niveles <strong>por rol</strong>, sin
            importar cómo esté armada la cadena.
        </p>

        <table class="data">
            <thead>
                <tr><th style="width:30%">Si la requisición viene de…</th><th style="width:33%">Nivel 2 · aprueba</th><th>Nivel 3 · autoriza</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Ingeniería, Mantenimiento Especializado, Manufactura, Servicios Técnicos o Soldadura</strong></td>
                    <td>Quien tenga el rol <code>aprueba_orden_compra</code></td>
                    <td>Quien tenga el rol <code>autoriza_orden_compra</code></td>
                </tr>
                <tr>
                    <td><strong>Cualquier otra gerencia</strong></td>
                    <td>El aprobador de la cadena de la requisición</td>
                    <td>El autorizador de la cadena de la requisición</td>
                </tr>
            </tbody>
        </table>

        <div class="note info">
            <span class="note-title">Esto no cambia nada de lo que tú capturas</span>
            <p>
                La distinción es invisible desde el formulario: el sistema la resuelve solo al mover
                la orden y le manda el correo a quien corresponda. La mencionamos porque explica por
                qué dos órdenes aparentemente iguales llegan a personas distintas.
            </p>
        </div>

        <h3>La excepción dentro de la excepción</h3>

        <p>
            Una cadena concreta de esas cinco gerencias puede quedar marcada como
            <strong>excluida del flujo por rol</strong>. En ese caso vuelve a aprobar y autorizar la
            gente de la cadena, como en el resto de la empresa. Lo configura el administrador en la
            ficha de la cadena y no hay forma de verlo desde la orden.
        </p>

        <div class="note warn">
            <span class="note-title">Si una orden no le aparece a quien debería</span>
            <p>
                Lo primero que hay que revisar es la <strong>gerencia del solicitante de la
                requisición</strong>, no la orden. De ahí sale la decisión de si firma el rol o la
                cadena. La guía de <em>Cadenas de aprobación</em> explica cómo se configura.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════ 4 · CREAR ══════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">Apartado 4</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Crear la orden paso a paso</h2>

        <p class="lead-text">Menú lateral › Orden › Mis ordenes › botón de nueva orden.</p>

        <p>
            El formulario está dividido en pestañas. Puedes guardar con lo mínimo e ir completando,
            pero la orden no se podrá enviar mientras falte algo obligatorio o alguna partida siga
            sin precio.
        </p>

        <h3>Datos generales</h3>

        <table class="data">
            <thead>
                <tr><th style="width:22%">Campo</th><th style="width:26%">Opciones</th><th>Qué debes saber</th></tr>
            </thead>
            <tbody>
                <tr><td><strong>Moneda</strong></td><td>MXN · USD<br><span class="muted">Por omisión MXN</span></td><td>Define en qué moneda se capturan los precios y con qué límite se compara el total para el nivel de monto.</td></tr>
                <tr><td><strong>Tipo de pago</strong></td><td>PUE · PPD</td><td>PUE es pago en una sola exhibición; PPD es en parcialidades o diferido. Es dato fiscal: va al CFDI del proveedor.</td></tr>
                <tr><td><strong>Forma de pago</strong></td><td>Efectivo · Transferencia</td><td>Cómo se liquidará.</td></tr>
                <tr><td><strong>Folio de cotización</strong></td><td>Texto, máx. 100 caracteres</td><td>El folio del documento que te dio el proveedor. Es lo que permite amarrar la orden con la cotización que se adjunta.</td></tr>
                <tr><td><strong>Uso de CFDI</strong></td><td>11 claves del SAT</td><td>De G01 a 108. Si dudas, G03 (gastos en general) es el más común para consumibles y servicios; 104 para equipo de cómputo, 108 para maquinaria.</td></tr>
                <tr><td><strong>Método de envío</strong></td><td>Texto libre</td><td>Cómo llega la mercancía: paquetería, flete del proveedor, recolección en planta.</td></tr>
                <tr><td><strong>IVA</strong></td><td>0 % · 8 % · 16 %</td><td>Se aplica sobre el subtotal de partidas. El 8 % corresponde a la región fronteriza.</td></tr>
                <tr><td><strong>Requisición</strong></td><td>Buscador por folio</td><td>La requisición de origen. Si entraste desde la requisición, ya viene puesta y no se muestra.</td></tr>
            </tbody>
        </table>

        <h3>Proveedor</h3>

        <p>
            Solo aparecen proveedores en estatus <strong>Aprobado</strong>. Al elegir uno, el campo
            <strong>Contacto</strong> se limpia y se vuelve a llenar con los contactos de ese
            proveedor: si no tiene ninguno registrado, hay que darlo de alta en la ficha del
            proveedor antes de poder continuar.
        </p>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">Apartado 4</div>
    </header>
    <div class="page-body">
        <div class="continues">4 · Crear la orden <span style="float:right">continuación</span></div>

        <h3>Condiciones de pago</h3>

        <p>
            Es una lista de conceptos con su porcentaje: anticipo, contra entrega, a 30 días, lo que
            se haya negociado. Agrega un renglón por cada tramo.
        </p>

        <div class="note">
            <span class="note-title">La suma tiene que dar 100 %</span>
            <p>
                Debajo de la lista hay un campo <strong>Total</strong> que se recalcula solo conforme
                capturas. Si no llega a 100, el reparto está incompleto y quien revise te va a
                devolver la orden.
            </p>
        </div>

        <h3>Soporte</h3>

        <table class="data">
            <thead>
                <tr><th style="width:34%">Documento</th><th style="width:16%">¿Obligatorio?</th><th>Qué es</th></tr>
            </thead>
            <tbody>
                <tr><td><strong>Tabla comparativa</strong><br><span class="muted">o adjudicación directa en su lugar</span></td><td><span class="chip c-red">Sí</span></td><td>La comparación de las cotizaciones que pediste, o el documento que justifica por qué se fue con un solo proveedor.</td></tr>
                <tr><td><strong>Cotización</strong></td><td><span class="chip c-red">Sí</span></td><td>La cotización del proveedor elegido, la que corresponde al folio que capturaste arriba.</td></tr>
                <tr><td><strong>Certificaciones</strong></td><td><span class="chip c-gray">No</span></td><td>Certificados de calidad, fichas técnicas o acreditaciones que respalden al proveedor.</td></tr>
            </tbody>
        </table>

        <p style="font-size:9pt;color:#5c5754">Los tres campos aceptan únicamente archivos PDF.</p>

        <h3>Retenciones y descuento</h3>

        <p>
            En <strong>Retenciones</strong> se capturan los porcentajes de <strong>IVA</strong> e
            <strong>ISR</strong> que aplican al proveedor; ambos son obligatorios y arrancan en cero,
            así que déjalos en cero cuando no haya retención. En <strong>Descuento del
            proveedor</strong> va el descuento global negociado.
        </p>

        <div class="note warn">
            <span class="note-title">El descuento se captura con cuatro decimales</span>
            <p>
                El campo exige exactamente ese formato: <code>0.0000</code>. Sin espacios, sin
                comillas y sin separador de miles. Si escribes <code>150</code> o <code>150.5</code>
                el sistema lo rechaza; hay que escribir <code>150.0000</code> y <code>150.5000</code>.
                Lo mismo aplica al precio unitario de cada partida.
            </p>
        </div>

        <h3>Entrega</h3>

        <ul class="bullets">
            <li><strong>Tiempo de entrega:</strong> días calendario contados <strong>a partir de que la orden se aprueba</strong>, no desde que la capturas.</li>
            <li><strong>Dirección de entrega:</strong> llega con el almacén de Tlalnepantla precargado; cámbiala si la entrega va a otro sitio.</li>
            <li><strong>Documentación de entrega:</strong> qué debe traer el proveedor al entregar. Viene con remisión o factura, orden de compra y certificados de calidad; puedes agregar o quitar renglones.</li>
        </ul>

        <h3>Observaciones</h3>

        <p>
            Campo obligatorio que llega con «Sin observaciones». Úsalo para lo que el proveedor o
            quien aprueba necesitan saber y no cabe en otro campo: condiciones especiales, acuerdos
            de la negociación, referencias de pedidos anteriores.
        </p>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════ 5 · PARTIDAS ══════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">Apartado 5</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Partidas y precios</h2>

        <p class="lead-text">Sin partidas, y sin precio en todas ellas, la orden no se puede enviar.</p>

        <h3>De dónde salen las partidas</h3>

        <p>
            No se capturan de cero: se traen de la requisición. La acción <strong>Agregar partidas de
            la requisición</strong> te muestra las que todavía no están en ninguna orden y te deja
            elegir cuáles incluir en esta. Aparece mientras la orden esté en
            <strong>Borrador</strong> o <strong>Reabierta para edición</strong>, y desaparece cuando
            ya no quedan partidas sueltas.
        </p>

        <h3>Qué se captura en cada partida</h3>

        <table class="data">
            <thead>
                <tr><th style="width:24%">Campo</th><th>Detalle</th></tr>
            </thead>
            <tbody>
                <tr><td><strong>Cantidad</strong></td><td>Llega con lo que pidió la requisición. Puedes ajustarla si vas a repartir la partida entre varias órdenes.</td></tr>
                <tr><td><strong>Precio unitario</strong></td><td>El precio negociado, con <strong>cuatro decimales exactos</strong>. Es el único dato que no viene de ningún lado: lo pones tú a partir de la cotización.</td></tr>
                <tr><td><strong>Importe</strong></td><td>Lo calcula el sistema: cantidad × precio unitario. No se edita.</td></tr>
                <tr><td><strong>Observaciones</strong></td><td>Detalle específico de esa partida para el proveedor.</td></tr>
            </tbody>
        </table>

        <div class="note">
            <span class="note-title">Las partidas sin precio se marcan y bloquean el envío</span>
            <p>
                Una partida con precio unitario en cero aparece resaltada en el listado, y mientras
                exista <strong>el botón de enviar a revisión no se muestra</strong>. Es la causa
                número uno de «no me aparece el botón»: casi siempre queda una partida abajo, fuera
                de la vista, sin precio.
            </p>
        </div>

        <h3>Cómo se arma el total</h3>

        <ol class="steps">
            <li>Se suman los importes de todas las partidas: ese es el <strong>subtotal</strong>.</li>
            <li>Se resta el <strong>descuento del proveedor</strong>.</li>
            <li>Se aplica el <strong>IVA</strong> que elegiste en datos generales.</li>
            <li>Se restan las <strong>retenciones</strong> de IVA e ISR.</li>
            <li>El resultado es el <strong>total</strong>, y es la cifra que el sistema compara contra el límite de monto del apartado 8.</li>
        </ol>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════ 6 · ENVIAR ══════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">Apartado 6</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Enviar a revisión</h2>

        <p class="lead-text">El momento en que la orden sale de tus manos.</p>

        <div class="note warn">
            <span class="note-title">Las tres condiciones para que aparezca el botón</span>
            <ul class="bullets" style="margin-bottom:0">
                <li>La orden tiene <strong>al menos una partida</strong>.</li>
                <li><strong>Ninguna partida tiene precio unitario en cero.</strong></li>
                <li>El estado permite enviar: borrador, devuelta, reabierta o reasignada.</li>
            </ul>
        </div>

        <ol class="steps">
            <li>Revisa que las condiciones de pago sumen 100 % y que los documentos de soporte estén cargados.</li>
            <li>Presiona <strong>Enviar a revisión</strong>.</li>
            <li>Lee el aviso de confirmación: ahí se te dice si la orden va por el flujo especial.</li>
            <li>Confirma con <strong>Sí, enviar a revisión</strong>.</li>
            <li>El sistema cambia el estado, avisa por correo a quien sigue y te regresa al listado.</li>
        </ol>

        <h3>A dónde llega según el proveedor</h3>

        <table class="data">
            <thead>
                <tr><th style="width:30%">Proveedor</th><th style="width:34%">Primer estado</th><th>Quién recibe el correo</th></tr>
            </thead>
            <tbody>
                <tr><td><strong>Cadena normal</strong></td><td><span class="chip c-yellow">Revisión gerente de compras</span></td><td>Los gerentes de compras.</td></tr>
                <tr><td><strong>Cadena especial</strong></td><td><span class="chip c-navy">Revisión por Dirección General</span></td><td>Dirección General.</td></tr>
            </tbody>
        </table>

        <div class="note info">
            <span class="note-title">Después de enviar</span>
            <p>
                La orden deja de ser editable mientras esté en curso, pero sigues pudiendo
                consultarla, ver su avance y descargar el PDF. Si alguien la devuelve, vuelve a tu
                pestaña <strong>Borradores</strong> y se edita otra vez.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════ 7 · RECORRIDO ══════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">Apartado 7</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">El recorrido completo</h2>

        <p class="lead-text">Los ocho pasos del flujo normal, de la captura al proveedor.</p>

        <div class="step-row">
            <div class="step-num">0</div>
            <div>
                <div class="step-head"><span class="step-name">Borrador</span><span class="step-who">Comprador</span></div>
                <div class="step-body"><p>Capturas la orden a partir de una requisición asignada: proveedor, partidas, precios, cotización, condiciones y documentos. El folio se genera solo.</p></div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">1</div>
            <div>
                <div class="step-head"><span class="step-name">Revisión gerente de compras</span><span class="step-who">Gerente de compras</span></div>
                <div class="step-body"><p>Revisa proveedor, precios, condiciones y documentación. Puede aprobar, devolver o cancelar.</p></div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">2</div>
            <div>
                <div class="step-head"><span class="step-name">Aprobado por gte. de compras</span><span class="step-who">Nivel 2 · rol o cadena</span></div>
                <div class="step-body"><p>La orden espera la segunda firma. En las cinco gerencias operativas la resuelve el rol; en el resto, el gerente del área solicitante según la cadena de la requisición.</p></div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">3</div>
            <div>
                <div class="step-head"><span class="step-name">Aprobado por gte. solicitante</span><span class="step-who">Nivel 3 · Dirección General</span></div>
                <div class="step-body"><p>Espera la autorización de Dirección General nivel 1, resuelta también por rol o por cadena según la gerencia.</p></div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">4</div>
            <div>
                <div class="step-head"><span class="step-name">Aprobado por DG nivel 1</span><span class="step-who">Dirección Administrativa</span></div>
                <div class="step-body"><p>Espera la <strong>liberación de Dirección Administrativa</strong>. Este paso es obligatorio en todas las órdenes y aplica a toda la empresa.</p></div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">5</div>
            <div>
                <div class="step-head"><span class="step-name">Liberado por Dir. Administrativa</span><span class="step-who">Dirección General o el sistema</span></div>
                <div class="step-body"><p>Aquí se evalúa el monto. Si el total supera el límite, falta la última aprobación de Dirección General; si no lo supera, <strong>el sistema autoriza la orden solo</strong> y salta al paso 7.</p></div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">6</div>
            <div>
                <div class="step-head"><span class="step-name">Aprobado por DG nivel 2</span><span class="step-who">Dirección General</span></div>
                <div class="step-body"><p>Última aprobación del flujo, requerida solo para las órdenes que superan el límite.</p></div>
            </div>
        </div>

        <div class="step-row">
            <div class="step-num">7</div>
            <div>
                <div class="step-head"><span class="step-name">Autorizada para proveedor</span><span class="step-who">Comprador</span></div>
                <div class="step-body">
                    <p>Estado final. La orden se puede descargar y enviar al proveedor. El sistema calcula la fecha final de entrega con los días que capturaste y genera la evaluación del proveedor.</p>
                    <p><strong>Es el aviso de que la orden se liberó:</strong> el correo va al comprador con copia a los involucrados y al nivel informativo de la gerencia.</p>
                </div>
            </div>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════ 8 · MONTO ══════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">Apartado 8</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">El nivel de monto</h2>

        <p class="lead-text">La última aprobación del flujo, y solo para órdenes grandes.</p>

        <table class="data">
            <thead>
                <tr><th style="width:18%">Moneda</th><th style="width:28%">Total de la orden</th><th>Qué pasa al liberarse</th></tr>
            </thead>
            <tbody>
                <tr><td><strong>MXN</strong></td><td>Hasta $300,000</td><td>La orden queda <strong>autorizada para el proveedor</strong> de inmediato.</td></tr>
                <tr><td><strong>MXN</strong></td><td>Más de $300,000</td><td>Pasa a la aprobación de Dirección General nivel 2.</td></tr>
                <tr><td><strong>USD</strong></td><td>Hasta $15,000</td><td>La orden queda <strong>autorizada para el proveedor</strong> de inmediato.</td></tr>
                <tr><td><strong>USD</strong></td><td>Más de $15,000</td><td>Pasa a la aprobación de Dirección General nivel 2.</td></tr>
            </tbody>
        </table>

        <div class="note">
            <span class="note-title">El momento en que se evalúa cambió</span>
            <p>
                Antes el monto se revisaba cuando Dirección General nivel 1 aprobaba, y una orden
                pequeña podía saltar directo al proveedor desde ahí. Hoy <strong>ninguna orden salta
                la liberación de Dirección Administrativa</strong>: el monto se evalúa después de
                ella, y es lo último que ocurre en el flujo.
            </p>
        </div>

        <h3>Quién no pasa por este nivel</h3>

        <table class="data">
            <thead>
                <tr><th style="width:34%">Caso</th><th>Detalle</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Órdenes del flujo especial</strong></td>
                    <td>Por decisión del área, la ruta corta no pasa por el nivel de monto aunque supere el límite.</td>
                </tr>
                <tr>
                    <td><strong>Proveedores exentos</strong></td>
                    <td>Una lista corta de proveedores, definida por el área, queda fuera del nivel de monto sin importar el total de la orden. Es una regla del negocio, no una consecuencia del giro ni del importe.</td>
                </tr>
            </tbody>
        </table>

        <div class="note info">
            <span class="note-title">El total que se compara es el total final</span>
            <p>
                No es el subtotal de partidas: es la cifra después del descuento, del IVA y de las
                retenciones. Una orden puede quedar por debajo del límite gracias al descuento, o
                cruzarlo por el IVA. Si necesitas saber de qué lado va a caer, mira el total impreso
                en el PDF de la orden.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════ 9 · SEGUIMIENTO ══════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">Apartado 9</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Seguimiento y acciones</h2>

        <p class="lead-text">Qué puedes hacer con una orden según el estado en que esté.</p>

        <table class="data">
            <thead>
                <tr><th style="width:27%">Acción</th><th style="width:25%">Cuándo aparece</th><th>Qué hace</th></tr>
            </thead>
            <tbody>
                <tr><td><strong>Enviar a revisión</strong></td><td>Borrador, devuelta o reabierta, con partidas y precios</td><td>Mete la orden al flujo de aprobación.</td></tr>
                <tr><td><strong>Agregar partidas de la requisición</strong></td><td>Borrador o reabierta, si quedan partidas sin orden</td><td>Trae a esta orden las partidas de la requisición que todavía no están en ninguna.</td></tr>
                <tr><td><strong>Editar</strong></td><td>Estados editables</td><td>Abre el formulario completo.</td></tr>
                <tr><td><strong>Eliminar</strong></td><td>Solo en borrador</td><td>Descarta la orden. Una vez enviada ya no se puede borrar.</td></tr>
                <tr><td><strong>Ver pdf</strong></td><td>Siempre</td><td>Abre el documento con el formato oficial, sus anexos y el bloque de firmas.</td></tr>
                <tr><td><strong>Descargar orden</strong></td><td>Solo cuando está autorizada para proveedor</td><td>Baja el archivo listo para mandárselo al proveedor.</td></tr>
                <tr><td><strong>Reabrir para edición</strong></td><td>Solo cuando está autorizada para proveedor</td><td>Regresa la orden a captura. Ver el aviso de abajo.</td></tr>
            </tbody>
        </table>

        <div class="note">
            <span class="note-title">Reabrir una orden no es gratis</span>
            <p>
                Al reabrirla, la orden <strong>vuelve a empezar todo el flujo de aprobación</strong>
                y se cancelan las evaluaciones de proveedor que estuvieran pendientes. Todas las
                firmas se piden de nuevo, incluida la liberación. Se avisa por correo al comprador,
                al solicitante, al autorizador, a Dirección General y al gerente de compras.
            </p>
            <p>
                Úsala cuando la orden todavía no salió al proveedor o cuando el cambio es
                inevitable. Si ya se envió, conviene acordar antes con el proveedor qué versión es
                la buena.
            </p>
        </div>

        <h3>Qué trae el PDF de la orden</h3>

        <p>
            El documento oficial incluye los datos de la empresa y del proveedor, el folio, la
            requisición de origen, las partidas con precios e importes, el desglose de subtotal,
            descuento, IVA, retenciones y total, las condiciones de pago, la documentación de
            entrega y el bloque de firmas con la fecha de cada nivel. Según la orden, se agregan los
            anexos de proveedor, de servicio y los términos y condiciones de la empresa.
        </p>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════ 10 · DEVOLUCIONES ══════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">Apartado 10</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Devoluciones y cancelaciones</h2>

        <p class="lead-text">Quién puede detener una orden y qué pasa después.</p>

        <div class="duo">
            <div class="duo-card">
                <div class="duo-title">Devolución</div>
                <div class="duo-sub">Reversible · vuelve a ti</div>
                <ul>
                    <li>Quien devuelve escribe el motivo, y queda en el historial.</li>
                    <li>La orden regresa a tu pestaña <strong>Borradores</strong> y vuelve a ser editable.</li>
                    <li>Al reenviarla, el recorrido <strong>empieza de cero</strong>.</li>
                </ul>
            </div>
            <div class="duo-card alt">
                <div class="duo-title">Cancelación</div>
                <div class="duo-sub">Definitiva</div>
                <ul>
                    <li>La orden no vuelve a ser editable ni se reactiva.</li>
                    <li>Si la compra sigue siendo necesaria, se levanta una orden nueva.</li>
                    <li>Las partidas vuelven a quedar disponibles en la requisición.</li>
                </ul>
            </div>
        </div>

        <h3>Quién puede detenerla y en qué punto</h3>

        <table class="data">
            <thead>
                <tr><th style="width:32%">Quién</th><th style="width:14%">Devolver</th><th style="width:14%">Cancelar</th><th>En qué estado</th></tr>
            </thead>
            <tbody>
                <tr><td><strong>Gerente de compras</strong></td><td class="center"><span class="chip c-red">Sí</span></td><td class="center"><span class="chip c-gray">Sí</span></td><td>Revisión gerente de compras.</td></tr>
                <tr><td><strong>Nivel 2 · gte. solicitante</strong></td><td class="center"><span class="chip c-red">Sí</span></td><td class="center"><span class="chip c-gray">Sí</span></td><td>Aprobado por gte. de compras.</td></tr>
                <tr><td><strong>Nivel 3 · DG nivel 1</strong></td><td class="center"><span class="chip c-red">Sí</span></td><td class="center"><span class="chip c-gray">Sí</span></td><td>Aprobado por gte. solicitante.</td></tr>
                <tr><td><strong>Dirección Administrativa</strong></td><td class="center"><span class="chip c-red">Sí</span></td><td class="center"><span class="chip c-gray">Sí</span></td><td>Aprobado por DG nivel 1.</td></tr>
                <tr><td><strong>DG · nivel de monto</strong></td><td class="center"><span class="chip c-red">Sí</span></td><td class="center"><span class="chip c-gray">Sí</span></td><td>Liberado por Dir. Administrativa.</td></tr>
                <tr><td><strong>DG · flujo especial</strong></td><td class="center"><span class="chip c-red">Sí</span></td><td class="center"><span class="chip c-gray">Sí</span></td><td>Revisión por Dirección General.</td></tr>
                <tr><td><strong>Administrador</strong></td><td class="center"><span class="chip c-red">Sí</span></td><td class="center"><span class="muted">No</span></td><td>Desde cualquier estado, por corrección administrativa.</td></tr>
            </tbody>
        </table>

        <div class="note warn">
            <span class="note-title">Reasignaciones</span>
            <p>
                Además de las devoluciones, una orden puede cambiar de
                <strong>requisición</strong> o de <strong>cadena</strong> por decisión del
                administrador. En ambos casos la orden vuelve al inicio del flujo y se te avisa por
                correo. No es una devolución: no hay nada que corregir de tu parte salvo reenviarla.
            </p>
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════ 11 · ESTADOS ══════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">Apartado 11</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Diccionario de estados</h2>

        <p class="lead-text">Qué significa cada estado y qué puedes hacer en él.</p>

        <table class="data">
            <thead>
                <tr><th style="width:30%">Estado</th><th style="width:47%">Significado</th><th>¿Editar?</th></tr>
            </thead>
            <tbody>
                <tr><td><span class="chip c-gray">Borrador</span></td><td>Capturada y sin enviar. Nadie más la ha visto.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-yellow">Revisión gerente de compras</span></td><td>En manos del gerente de compras.</td><td>No</td></tr>
                <tr><td><span class="chip c-navy">Aprobado por gte. de compras</span></td><td>Esperando la firma del nivel 2.</td><td>No</td></tr>
                <tr><td><span class="chip c-navy">Aprobado por gte. solicitante</span></td><td>Esperando la autorización de Dirección General nivel 1.</td><td>No</td></tr>
                <tr><td><span class="chip c-navy">Aprobado por DG nivel 1</span></td><td>Esperando la liberación de Dirección Administrativa.</td><td>No</td></tr>
                <tr><td><span class="chip c-navy">Liberado por Dir. Administrativa</span></td><td>Liberada. Si supera el límite, espera la aprobación por monto; si no, el sistema la autoriza sola.</td><td>No</td></tr>
                <tr><td><span class="chip c-navy">Aprobado por DG nivel 2</span></td><td>Aprobada por monto. Pasa a autorizada.</td><td>No</td></tr>
                <tr><td><span class="chip c-green">Autorizada para proveedor</span></td><td>Estado final. Se puede descargar y enviar al proveedor.</td><td>No, pero se puede <strong>reabrir</strong></td></tr>
                <tr><td><span class="chip c-yellow">Revisión por Dirección General</span></td><td>Flujo especial: en manos de Dirección General.</td><td>No</td></tr>
                <tr><td><span class="chip c-violet">Reabierta para edición</span></td><td>Una orden autorizada que volviste a abrir. Reinicia todo el flujo.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-red">Devuelto por gte. de compras</span></td><td>El gerente de compras pidió correcciones.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-red">Devuelto por gte. solicitante</span></td><td>El nivel 2 pidió correcciones.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-red">Devuelto por DG nivel 1</span></td><td>Dirección General nivel 1 pidió correcciones.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-red">Devuelto por liberación</span></td><td>Dirección Administrativa pidió correcciones.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-red">Devuelto por DG nivel 2</span></td><td>La aprobación por monto pidió correcciones.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-red">Devuelto por Dirección General</span></td><td>Flujo especial: DG pidió correcciones.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-red">Devuelto por administrador</span></td><td>Corrección administrativa. Permite volver a tocar las partidas.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-gray">Cancelado por…</span></td><td>Cierre definitivo. El nombre indica quién la canceló.</td><td>No</td></tr>
                <tr><td><span class="chip c-violet">Requisición reasignada</span></td><td>El administrador cambió la requisición de origen. Vuelve al inicio.</td><td><strong>Sí</strong></td></tr>
                <tr><td><span class="chip c-violet">Cadena reasignada</span></td><td>El administrador cambió la cadena de aprobación. Vuelve al inicio.</td><td><strong>Sí</strong></td></tr>
            </tbody>
        </table>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

{{-- ══════════════════ 12 · PROBLEMAS ══════════════════ --}}
<div class="page content-page">
    <header class="page-header">
        <div class="page-header-left">Orden de compra · Guía del comprador</div>
        <div class="page-header-right">Apartado 12</div>
    </header>
    <div class="page-body">
        <h2 class="section-title">Problemas frecuentes</h2>

        <p class="lead-text">Síntoma, causa y qué hacer.</p>

        <table class="data">
            <thead>
                <tr><th style="width:28%">Lo que ves</th><th style="width:30%">Por qué pasa</th><th>Qué hacer</th></tr>
            </thead>
            <tbody>
                <tr><td>No aparece el botón «Enviar a revisión».</td><td>Alguna partida tiene precio unitario en cero, o la orden no tiene partidas.</td><td>Recorre el listado completo de partidas: la que falta suele quedar fuera de la vista. Captura su precio.</td></tr>
                <tr><td>«El campo no es válido» al capturar el precio o el descuento.</td><td>El formato exige exactamente cuatro decimales.</td><td>Escribe <code>1250.0000</code>, no <code>1250</code> ni <code>1,250.00</code>.</td></tr>
                <tr><td>El proveedor no aparece en la lista.</td><td>Solo se listan proveedores en estatus <strong>Aprobado</strong>.</td><td>Pide al área que complete el alta o la aprobación del proveedor.</td></tr>
                <tr><td>El proveedor aparece pero no tiene contactos.</td><td>No hay contactos registrados en su ficha.</td><td>Da de alta el contacto en la ficha del proveedor y regresa a la orden.</td></tr>
                <tr><td>El botón de enviar salió rojo y con un aviso distinto.</td><td>El proveedor tiene cadena especial.</td><td>Es normal: la orden va por la ruta corta directo a Dirección General.</td></tr>
                <tr><td>No encuentro la requisición al crear la orden.</td><td>Solo se ofrecen requisiciones autorizadas y asignadas a ti.</td><td>Confirma con el gerente de compras que la asignación ya se hizo.</td></tr>
                <tr><td>La orden lleva días detenida.</td><td>Está esperando una firma, o quien le toca no la ve por un tema de configuración.</td><td>Revisa el avance en el detalle de la orden. Si el responsable dice que no le aparece, es la configuración del apartado 3.</td></tr>
                <tr><td>Se aprobó pero no llegó a DG nivel 2.</td><td>El total no supera el límite, o el proveedor está exento.</td><td>Es el comportamiento correcto: la orden quedó autorizada al liberarse.</td></tr>
                <tr><td>Ya no quedan partidas por agregar y la acción desapareció.</td><td>Todas las partidas de la requisición ya están en alguna orden.</td><td>Es lo esperado. Si falta material, se levanta una requisición nueva.</td></tr>
                <tr><td>Reabrí una orden y volvió al principio.</td><td>Reabrir reinicia el flujo completo.</td><td>Es el comportamiento esperado. Avisa a quienes ya habían firmado.</td></tr>
            </tbody>
        </table>

        <div class="closing">
            <strong>SA-TECH · Sistema de Compras</strong> — Guía del comprador, orden de compra.
            Versión 2.0, {{ $fecha }}.<br>
            Las guías de <em>requisiciones</em>, <em>flujos de aprobación</em>,
            <em>alta de productos y proyectos</em> y <em>cadenas de aprobación</em> están en la
            sección <strong>Guías de uso</strong> del menú lateral.
        </div>
    </div>
    <footer class="page-footer">
        <div class="footer-left">SA-TECH · Sistema de Compras</div>
        <div class="footer-page"></div>
    </footer>
</div>

</body>

</html>
