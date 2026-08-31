# Plan — Flujos de aprobación de órdenes de compra

Implementación de los cambios solicitados por Operaciones en el hilo de correo
*"Re: Flujos de aprobación SATECH | Operaciones"* (12–19 ago 2026).

- **Solicita:** Jorge Ojeda (Gerente de Compras), a partir de la propuesta de Alan Anaya
- **Acuerdo final:** confirmado por Denise Reyes el 19 ago 2026
- **Datos de este documento:** verificados contra la base de datos el 28-ago-2026
- **Alcance de la liberación:** **global** — aplica a toda la empresa, no solo a
  los 5 departamentos operativos (confirmado por Etzahu el 27-ago-2026). Cierra
  la pregunta que bloqueaba la Fase B.
- **Rama:** `main`

---

## 1. Objetivo

El correo pide cuatro cosas sobre las **órdenes de compra**:

| # | Requerimiento | Texto del correo |
|---|---|---|
| 1 | **Nivel informativo** | Solo permisos de visualización de la OC, más notificación por correo cuando la orden se libera. |
| 2 | **Nivel de liberación** | Un nivel adicional que exija *en todo momento* la liberación de Denise Reyes. |
| 3 | **Condición de monto** | No sustituye la regla vigente: arriba de 15,000 USD pasa además por Alejandro Allier, **como última aprobación**. *La ruta especial queda exenta por decisión del área — §11.11.* |
| 4 | **Informativo a Jennifer** | Requisiciones y OC de servicios de Manufactura (PND, maquinados externos) deben llegarle a nivel informativo. |

La aclaración final de Jorge, confirmada por Denise:

> Alan Anaya **aprobará**, Sergio Ordaz **autorizará** y Denise Reyes **liberará**.
> En caso de que la OC cumpla la condición de los 15K USD, pasará como última aprobación por Alejandro Allier.

### Cadena objetivo

```
Comprador → Revisa (Jorge) → [Informativo] → Aprueba (Alan) → Autoriza (Sergio)
         → Libera (Denise) → [si > 15K USD: Allier] → autorizada para proveedor
```

El **informativo** no aprueba: solo ve la orden y recibe el correo de liberación.

---

## 2. Lo que se tiene hoy

### 2.1 Flujo actual

Definido en `app/StateMachines/PurchaseOrderStateMachine.php`.

```
borrador
  → revisión gerente de compras        (comprador envía)
  → aprobado por gerente de compras    (N1)
  → aprobado por gerente solicitante   (N2)
  → aprobado por DG nivel 1            (N3)
  → [si supera el límite] N4 → autorizada para proveedor
  → [si no] autorizada para proveedor  (automático desde N3)
```

Ruta paralela: si el proveedor tiene `approval_chain = 'especial'`, la orden va de
`borrador` a `revision por dirección general` y Denise autoriza directo.

### 2.2 Quién resuelve cada nivel

| Nivel | Pantalla | Permiso de acceso | Quién actúa | Estado destino |
|---|---|---|---|---|
| N1 · Revisa | `AdminResource` | `view_approve-level-1_…` | rol `gerente_compras` → Jorge Ojeda | `aprobado por gerente de compras` |
| N2 · Aprueba | `ReviewResource` | *(ahora por cadena)* | `chain.approver` | `aprobado por gerente solicitante` |
| N3 · Autoriza | `ApproveResource` | *(ahora por cadena)* | `chain.authorizer` | `aprobado por DG nivel 1` |
| N4 · Monto | `AuthorizeResource` | `view_approve_level-4_…` | rol `autoriza_nivel-2-orden_compra` | `autorizada para proveedor` |
| Especial | `ApproveSpecialResource` | `auth()->id() == 106` | Denise (ID fijo) | `autorizada para proveedor` |

### 2.3 Condición de monto

`app/Services/OrderCalculationService.php` → `isOrderTotalBetweenLimits()`

- **USD:** 1 – 15,000
- **MXN:** 1 – 300,000
- Proveedores exentos del nivel de monto: **427, 425, 332**

La evaluación vive hoy en la pantalla de N3
(`ApproveResource/Pages/ViewOrder.php`): al aprobar, si el total está dentro de
límites, transiciona sola a `autorizada para proveedor`.

### 2.4 Cadena de aprobación

Tabla `purchase_requisition_approval_chains`, cuatro columnas, todas `NOT NULL`:

```
requester_id · reviewer_id · approver_id · authorizer_id · archived_at
```

La orden de compra **reutiliza la cadena de su requisición**. No existe una cadena
propia de OC.

### 2.5 Configuración verificada en producción

**Ya está listo:**

- **Alejandro Allier** — usuario **ID 355**, activo, único miembro de
  `autoriza_nivel-2-orden_compra`. Carlos Alonso (315, inactivo) ya salió del rol.
- **Cadenas de requisición de los 5 departamentos** — coinciden con la tabla del correo:

  | Departamento | Cadenas | Revisa | Aprueba | Autoriza |
  |---|---|---|---|---|
  | Mtto. Especializado | 147–151 | Luis Godínez | Allan Vázquez | Alan Anaya |
  | Ingeniería | 91, 97, 107, 112, 114, 116 | Jennifer Jarquín | Jennifer Jarquín | Alan Anaya |
  | Ingeniería ⁽²⁾ | **90, 113** | Jennifer Jarquín | **Alan Anaya** | Alan Anaya |
  | Soldadura | 9, 67 | Martín Paes | Jesús Becerra | Alan Anaya ⁽¹⁾ |
  | Manufactura | 117 | Eddie S. Ordoñez | Eddie S. Ordoñez | Alan Anaya |
  | Manufactura ⁽²⁾ | **104, 115** | Eddie S. Ordoñez | **Alan Anaya** | Alan Anaya |
  | Servicios Técnicos | 5, 10, 17, 27, 31, 102 | Miguel Orduña | Iván Ponce | Alan Anaya ⁽¹⁾ |

  ⁽¹⁾ El correo pide "N/A". Como `authorizer_id` es `NOT NULL`, Jorge puso a Alan
  Anaya como sustituto temporal.

  ⁽²⁾ **Corrección (27-ago-2026).** En estas cuatro cadenas Alan Anaya ocupa los
  dos niveles consecutivos —aprueba *y* autoriza—, con 233 órdenes encima
  (90: 133, 104: 43, 113: 18, 115: 39). Importa para la Fase D: la receta de
  §8.4 dice "`informed_id` = el aprobador actual", y aquí el aprobador actual es
  Alan, que en el flujo nuevo es el `po_approver`. En estas cuatro el informativo
  sale de `reviewer_id` (Jennifer / Eddie), no de `approver_id`.

  La cadena **111 está archivada** (`archived_at = 2026-08-18`); Manufactura son
  104, 115 y 117.

  **Sergio Ordaz** sí participa como `authorizer_id` en las cadenas vivas 59, 65,
  96, 144, 157 y 158, y tiene el rol `autoriza_nivel-1-orden_compra`. La Fase D
  no lo introduce al sistema, solo lo extiende a los 5 departamentos.

### 2.6 Volumen actual

| Métrica | Valor |
|---|---|
| Órdenes en `autorizada para proveedor` | 2,098 |
| Transiciones históricas a `autorizada para proveedor` | 2,343 |
| En `aprobado por DG nivel 1` | 12 — de ellas **2** son de los 5 departamentos (1107 y 2297, cadena 67) |
| Transiciones históricas a `aprobado por DG nivel 2` | **0** (contra 12 de `devuelto por DG nivel 2`) |
| Proveedores en ruta especial (`approval_chain = 'especial'`) | 20 |
| Detenidas en la cadena 85 (Guillermo Gutiérrez, inactivo) | 6 |

---

## 3. Lo que ya se aplicó

### Fase A — La cadena como única fuente de verdad ✅

**Problema encontrado:** en N2 y N3, *quién debe actuar* se decidía por la cadena,
pero *quién podía actuar* se decidía por un rol. Cuando el participante de la
cadena no tenía el rol, la sección no le aparecía — y como el listado filtra por
su propio ID, ningún otro usuario veía esa orden. Afectaba a 28 cadenas activas
(565 requisiciones), incluidas las de Alan Anaya e Iván Ponce.

Bajo el flujo nuevo Alan aprueba los cinco departamentos, así que sin esta
corrección se habrían atorado todos.

**Cambios aplicados:**

| Archivo | Cambio |
|---|---|
| `app/Models/PurchaseOrder.php` | `chainRoleFor()`, `isChainApprover()`, `isChainAuthorizer()` |
| `…/PurchaseOrder/ReviewResource.php` | `canAccess()` → `approverChainsPR()->notArchived()->exists()` |
| `…/ReviewResource/Pages/ViewOrder.php` | botón → `isChainApprover()` |
| `…/PurchaseOrder/ApproveResource.php` | `canAccess()` → `authorizerChainsPR()->notArchived()->exists()` |
| `…/ApproveResource/Pages/ViewOrder.php` | botón → `isChainAuthorizer()` |
| `app/Policies/PurchaseOrderPolicy.php` | `view()` acepta al participante de la cadena; se eliminaron 4 métodos muertos |

**Verificado:** Iván Ponce opera correctamente **sin** el permiso base
`view_purchase::order::purchaser`. Jorge Ojeda no ve botón en órdenes ajenas.

**Consecuencia:** ya no hace falta repartir `gerente_solicitante_orden_compra`.

**Decisión tomada:** las 6 órdenes detenidas de la cadena 85 (Guillermo Gutiérrez,
inactivo) **no se destraban** — son antiguas y Compras nunca las reclamó.

### Fase B — Liberación de Denise + Allier al final ✅

Aplicada el 27-ago-2026, con la liberación resuelta **por rol** (alcance global).

**Nuevos**

| Archivo | Contenido |
|---|---|
| `database/migrations/2026_08_27_120000_create_release_purchase_order_role.php` | Rol `libera_orden_compra`, permiso `view_release_purchase::order::purchaser`, asignación a Denise y a los dos `super_admin`. Idempotente. |
| `app/Services/PurchaseOrderFlowService.php` | `requiresAmountApproval()` y `advanceAfterRelease()` |
| `…/PurchaseOrder/ReleaseResource.php` + `Pages/{ListPurchaseOrders,ViewOrder}.php` | Pantalla *Liberar* |

**Modificados**

| Archivo | Cambio |
|---|---|
| `PurchaseOrderStateMachine.php` | Estado `liberado por dirección administrativa`; devoluciones `devuelto`/`cancelado por liberación`; el aviso de `aprobado por DG nivel 1` pasa a quien libera y el de monto se mueve al nuevo estado |
| `PurchaseOrder.php` | `scopeRelease()`; `scopeAuthorize()` apunta al estado nuevo; paso `releaser` en las firmas; acceso seguro a los roles; `scopeApprove()` con `notArchived()` |
| `ApproveResource/Pages/ViewOrder.php` | Se le quitó la regla de monto: el nivel 3 solo aprueba |
| `AuthorizeResource/Pages/ViewOrder.php` | Aprueba pasando por `aprobado por DG nivel 2`; se eliminó el bloque muerto |
| `PurchaserResource.php` | Prefijo `view_release` para Shield |
| `ProcessFlow.php` | Nodo `liberada` + `dev_liberacion` / `can_liberacion` y sus aristas |
| `ApproveResource`, `AuthorizeResource`, `ApproveSpecialResource` | `navigationSort` renumerado: el menú vuelve a seguir el flujo |

**Verificado en la base de datos** (transacciones revertidas):

- Desde `aprobado por DG nivel 1` ya **no** se puede saltar a `autorizada para
  proveedor` ni a `aprobado por DG nivel 2`; solo liberar, devolver o cancelar.
- Recorrido sobre el límite: liberar → Allier aprueba → **`aprobado por DG nivel 2`
  queda registrado** → cierra. Es el bug de §4.1, corregido.
- Recorrido bajo el límite (proveedor exento): liberar → `advanceAfterRelease()`
  cierra sola, sin Allier, y el PDF oculta la firma de monto.
- Devolución desde liberación reingresa al flujo y reinicia el ciclo de fechas.
- Cancelación desde liberación es terminal.
- Ruta especial sin cambios.
- Firmas del PDF: las órdenes históricas ya autorizadas **ocultan** el paso
  *Libera*; las que siguen en curso lo muestran.

**Dos instrucciones del plan resultaron innecesarias:**

- `PurchaseOrderController.php` §6.8 — los `$stages[]` que pedía renumerar se
  pasan a la vista pero **nunca se leen**: `content.blade.php` pinta las firmas
  desde `$data->progress`. Solo `purchase-requisition.blade.php` usa `$stages`.
- `CheckUserOrders.php` §6.9 — filtra por `aprobado por gerente de compras` y
  `aprobado por gerente solicitante`, los dos niveles que resuelve la cadena, y
  ninguno cambió. La liberación no es por cadena, así que no cabe en una página
  que responde "¿esta persona está atorando órdenes por sus cadenas?".

---

### Correcciones posteriores ✅

Aplicadas el 28-ago-2026, después de la Fase B.

**`chainRolesFor()` — el bug que escondía el botón de firma.**
`chainRoleFor()` recorría `PurchaseRequisitionApprovalChain::ROLES` y devolvía
el **primer** rol que casaba. Como una misma persona ocupa dos casillas con
frecuencia, los niveles posteriores quedaban invisibles: la orden aparecía en el
listado del responsable, pero sin botón para responder.

| Caso | Cadenas | Órdenes |
|---|---|---|
| El aprobador es además solicitante o revisor | 16 | 543 |
| El autorizador es además solicitante, revisor o aprobador | 18 | 379 |

Incluía las cuatro cadenas donde Alan Anaya aprueba y autoriza (90, 104, 113,
115), que con el flujo nuevo se habrían atorado en el nivel 3.

- `PurchaseOrder::chainRolesFor()` devuelve **todos** los roles que casan y
  descarta los `null` (necesario para el `authorizer_id` nullable de la Fase D)
- `isChainApprover()` / `isChainAuthorizer()` preguntan por su rol en esa lista
- `participatesInChain()` reemplaza al viejo `chainRoleFor(...) !== null` en la
  policy
- `tests/Unit/PurchaseOrderChainRolesTest.php` — 7 casos, sin tocar la base

**`firstUserWithRole()` — el rol inexistente que tumbaba el PDF.**
La guarda `User::role('...')->first()?->name` que se puso en la Fase B **no
guardaba nada**: el scope `role()` de Spatie lanza `RoleDoesNotExist` antes de
devolver una colección, así que el `?->` nunca llega a evaluarse. Se comprobó de
la peor forma: al reponer la base sin la migración del nivel de liberación, el
PDF y la ficha de la requisición devolvían 500.

- `PurchaseOrder::firstUserWithRole()` resuelve con `whereHas`, que ante un rol
  inexistente devuelve vacío en vez de lanzar
- `User::scopeWithRole()` hace lo mismo para los hooks de correo de la máquina
  de estados

**Pendiente de la misma familia:** `OrderService::getUserForEmailFinish()` sigue
usando `User::role('gerente_compras')->first()->email` sin guarda, en el correo
de cierre. Va en la Fase E.

---

### Fase C — Nivel informativo ✅

Aplicada el 28-ago-2026. Entrega los puntos 1 y 4 del correo.

**Nuevos**

| Archivo | Contenido |
|---|---|
| `database/migrations/2026_08_28_120000_create_management_informed_rules_table.php` | Tabla `management_informed_rules` + sembrado: 5 reglas base desde `management.responsible_id` y la regla `MAN + servicio → Jennifer`. Idempotente. |
| `database/migrations/2026_08_28_120100_create_informed_purchases_role.php` | Rol `informativo_compras`, permisos `view_informed_purchase::{order::purchaser,requisition::requester}`, asignación a los cinco y **retiro** de `visor_ordenes` / `visor_requisiciones` a Jennifer. Idempotente, con `down()` que los repone. |
| `app/Models/ManagementInformedRule.php` | Modelo + `scopeMatching()` |
| `app/Services/PurchaseInformedService.php` | Fuente única: `usersFor()`, `emailsFor()`, `isInformed()`, `applyOrderScope()`, `applyRequisitionScope()` |
| `…/ManagementResource/RelationManagers/InformedRulesRelationManager.php` | Mantenimiento sin despliegue |

**Modificados**

| Archivo | Cambio |
|---|---|
| `Management.php` | Relación `informedRules()` |
| `PurchaseOrder/HistoryResource.php` + `…/Pages/ManagePR.php` | `canAccess()` y pestaña *Informativo* |
| `PurchaseRequisition/HistoryResource.php` + `…/Pages/ManagePR.php` | Ídem |
| `PurchaseOrderPolicy.php` | `view()` acepta al informativo |
| `PurchaseRequisitionPolicy.php` | `view()` sale temprano si es informativo |
| `OrderService::getUserForEmailFinish()` | Aviso al informativo en el cierre de la orden (§11.7, corregido el 30-ago) |
| `PurchaserResource.php` | Prefijo `view_informed` para Shield |
| `ManagementResource.php` | Registra el relation manager |

**Verificado contra la base (28-ago-2026):**

- 6 reglas sembradas; los cinco tienen el rol; Jennifer ya **no** tiene los `visor_`.
- `usersFor()` de una requisición **MAN + servicio** devuelve **Jennifer y Eddie**;
  de una **MAN + proveeduría**, solo Eddie. Es el punto 4 del correo, literal.
- Bandejas: Allan 105 órdenes / 84 requisiciones · Jennifer 474 / 407 ·
  Jesús 189 / 150 · Eddie 148 / 127 · Iván 115 / 114.
  Jennifer = 378 de ING + 29 servicios de MAN, exacto.
- Un usuario sin reglas —y `null`— obtienen **0**, no la tabla completa.
- `isInformed()` no filtra de más: da `false` para Iván en una orden de ING.
- `emailsFor(null)` devuelve `[]` sin reventar.

**El paso C0 resultó innecesario.** Las 7 cadenas con solicitante sin
`management_id` tienen todas al solicitante **dado de baja** (`active = 0`) y
ninguna pertenece a las cinco gerencias; `scopeSelectable()` ya las excluye de
las requisiciones nuevas. Sus 108 documentos históricos simplemente no resuelven
informativo, que es el resultado correcto.

**Observación preexistente, no introducida aquí:** `view_purchase::order::purchaser`
—que trae `gerente_solicitante_orden_compra`— ya permite abrir cualquier orden a
13 usuarios. El filtro real del nivel informativo es la **bandeja**, no la policy.
Si Operaciones quiere que "solo visualización" signifique además "solo las mías",
eso es un cambio aparte sobre ese permiso.

---

### Fase D1 — Actores de la OC por rol ✅

Aplicada el 28-ago-2026. Entrega el punto 6 del correo.

**La decisión de alcance (pregunta 8), resuelta.** Se optó por **la gerencia**,
no por "las cadenas donde Alan autoriza hoy", que era autorreferencial: cualquier
cadena nueva habría nacido fuera del flujo sin que nadie lo notara. Y para que la
decisión no quedara congelada en código, se añadió una **excepción por cadena**,
que nace vacía: si Operaciones decide que alguna debe conservar su aprobador, se
marca desde la pantalla de cadenas.

Eso desbloquea también las preguntas 9 y 10: la 144 y las siete que rutean a
Contratos se resuelven marcando la casilla, sin despliegue.

**Nuevos**

| Archivo | Contenido |
|---|---|
| `…/2026_08_28_140000_add_purchase_order_flow_scope.php` | `management.purchase_order_flow` (true en 5, 8, 9, 10, 13) y `…approval_chains.po_flow_excluded` (vacía) |
| `…/2026_08_28_140100_create_purchase_order_actor_roles.php` | Roles `aprueba_orden_compra` (Alan, 341) y `autoriza_orden_compra` (Sergio, 168) + permisos |
| `app/Services/PurchaseOrderChainResolver.php` | Fuente única de los niveles 2 y 3 de la orden |
| `tests/Unit/PurchaseOrderChainResolverTest.php` | 10 casos en memoria, sin tocar la base |

**Modificados**

| Archivo | Cambio |
|---|---|
| `PurchaseOrder.php` | `scopeReviewManagement()` y `scopeApprove()` pasan por el resolver |
| `ReviewResource` / `ApproveResource` | `canAccess()` por resolver |
| Sus dos `Pages/ViewOrder.php` | El botón pregunta al resolver |
| `PurchaseOrderPolicy.php` | `view()` acepta a quien responde por rol |
| `PurchaseOrderStateMachine.php` | Los avisos de nivel 2 y 3 van a quien resuelve el resolver |
| `OrderService::getUserForEmailFinish()` | CC con los actores reales; se blindaron los `User::role()` y se sustituyó el `User::find(106)` por el rol de liberación |
| `HistoryResource` + `ManagePR` | Pestañas *Revisiones* y *Autorizaciones* por resolver; acceso para los dos roles nuevos |
| `ManagementResource.php` | Toggle del alcance |
| `ChainResource.php` | Toggle de la excepción, visible solo si la gerencia usa el flujo |
| `Management.php`, `PurchaseRequisitionApprovalChain.php` | `$fillable` y casts de las columnas nuevas |

**Verificado contra la base (28-ago-2026):**

- Alcance: 5 gerencias marcadas · **1,012 órdenes** dentro del flujo por rol,
  1,241 fuera, de 2,253.
- Órdenes pendientes de nivel 2: las dos de los departamentos operativos
  (`G331/26` de ING y `T670/26` de ST) pasan a **Alan**; la de QHSE sigue con
  Denise por cadena. Las 6 de la cadena 85 siguen sin responsable — es el caso
  de Guillermo Gutiérrez, fuera de alcance por decisión del área.
- Órdenes pendientes de nivel 3: GCON y SG siguen resolviéndose por cadena.
- Sobre una orden de la cadena 128 (ST, Kevin aprueba): con el flujo nuevo
  responde **Alan** y el correo va a `aanaya@`; al marcar `po_flow_excluded`
  vuelve a responder **Kevin** y el correo a `kperez@`. Probado en transacción
  revertida; no quedó ninguna cadena marcada.
- Suite: `PurchaseOrderChainResolverTest` 10/10 y `PurchaseOrderChainRolesTest`
  7/7. Los 15 fallos de `RrhhWebhookTest` / `RrhhUsersApiTest` son previos y
  ajenos: falta correr la migración de `rrhh_employee_id`.

**Pendiente menor:** `ProcessFlow` describe el nivel 2 como "gerente
solicitante", que en las cinco gerencias ya no es exacto. Es texto, no lógica;
va con el resto de la documentación en la Fase E.

---

### Fase D2 — El "N/A" de las requisiciones ✅

Aplicada el 28-ago-2026. Entrega el punto 5 del correo.

`authorizer_id` era `NOT NULL`, así que el "N/A" de la tabla del correo era
inexpresable y Jorge había puesto a Alan Anaya de sustituto temporal. Ahora la
casilla puede quedar vacía y la requisición avanza sola por ese paso.

**Se hizo en cuatro pasos, en este orden** — poner el nulo antes del blindaje
habría tumbado el PDF y los correos:

| Paso | Entrega |
|---|---|
| **a** | Blindaje: 14 accesos a `->authorizer` sin guarda, `ROLES` partido en obligatorios y opcionales, `ChainResource` con el nivel opcional |
| **b** | `…150000_make_authorizer_id_nullable…` — quita el `NOT NULL` con SQL crudo; el `down()` se niega si alguna cadena quedó vacía |
| **c** | `PurchaseRequisitionFlowService::advanceAfterManagementApproval()`, llamado desde `ApproverResource/Pages/ViewPR.php` — mismo patrón que `advanceAfterRelease()` |
| **d** | `…150100_remove_authorizer_from_welding_and_technical_services_chains` — vacía las 8 cadenas del sustituto |

**Qué se vació y qué no**

| | Cadenas | Antes |
|---|---|---|
| Vaciadas | 9, 67 (ISW) · 5, 10, 17, 27, 31, 102 (ST) | Alan Anaya, el sustituto temporal |
| **Intactas** | 125, 126, 128, 129 (ST) | Sergio Ordaz, por ruteo a Contratos |

Las cuatro últimas no son el caso del sustituto y vaciarlas sería una decisión
de negocio que el correo no pide. Ahora que el campo es opcional, Compras las
puede vaciar desde la pantalla.

**El estado `aprobado por DG` se sigue registrando**, no se salta: el avance
automático lo transiciona igual, para que el histórico, `getRevisionDates()` y
las fechas del PDF sigan cuadrando. Lo único que cambia es que la firma se
imprime como *N/A*.

**Regresión de la Fase D1, encontrada y corregida.** `getProgressAttribute()` de
la orden resolvía las firmas de los niveles 2 y 3 **en vivo desde la cadena**.
Con D1 esos niveles ya no los ocupa la cadena, así que el PDF de las 1,012
órdenes del flujo por rol nombraba a la persona equivocada. Ahora se leen de
`state_histories.responsible_id` —quien firmó de verdad— con el resolver como
respaldo para los niveles todavía pendientes. Es el hallazgo 12 de §11, aplicado
**solo a esos dos niveles**; el resto sigue pendiente para la Fase E.

**Verificado contra la base (28-ago-2026):**

- Las 8 cadenas muestran *N/A* y **siguen siendo seleccionables**:
  `isSelectable()` es true y `getInactiveUsers()` devuelve vacío. Las 56
  seleccionables de la empresa no bajaron.
- Recorrido real, en transacciones revertidas: en la cadena 67 (sin autorizador)
  `aprobado por gerencia` avanza solo a **`aprobado por DG`**; en la 91 (con
  autorizador) se queda esperando la firma.
- La ficha y el infolist de una requisición sin autorizador pintan *N/A* en
  lugar de reventar.
- La orden histórica `T815/25` (cadena 128) sigue mostrando a **Kevin Pérez**
  en *Aprueba* —quien firmó de verdad— y no a Alan.
- `PurchaseRequisitionFlowServiceTest` 4/4 y el resto de la suite de unidad,
  22/22. Los 15 fallos de RRHH siguen siendo previos y ajenos.

**De paso se cerraron** dos `User::role(...)->first()->email` sin guarda en
`PurchaseRequisitionCreationService` y el `User::find(106)` del hook de
reapertura, que ahora se resuelve por el rol de liberación.

---

### Fase E — Limpieza, firmas y reporte de antigüedad ✅

Aplicada el 28-ago-2026.

**Los 7 ids cableados que quedaban.** Ya no hay ninguno. Se separaron por lo que
significan, no por quién los ocupa hoy:

| Antes | Ahora | Por qué |
|---|---|---|
| `auth()->user()->id == 106` en la ruta especial y su correo | rol **`aprueba_orden_especial`** (migración nueva) | Saltarse la cadena entera es una autoridad distinta de liberar; un suplente de liberación no debe heredarla |
| `id == 106` en las cuatro pestañas *Todas* y los reportes | `hasRole('libera_orden_compra')` | Quien libera necesita ver todo |
| `106`, `199`, `306` sueltos en `PurchaseRequisitionPolicy` | roles `libera_orden_compra`, `super_admin`, `administrador_compras` | 199 y 306 eran las cuentas de sistemas |
| Literal `'Denise Marisol Reyes Ramírez'` en `getProgressSpecialAttribute()` | quien firmó según el histórico, con el rol de respaldo | — |

**Firmas del PDF, completadas.** Los tres niveles que faltaban —revisa, libera y
monto— pasan a leerse del histórico igual que los dos de la Fase D2, con el rol
vigente como respaldo. `signerOf()` se convirtió en `signersOf()`: una sola
consulta para los cinco niveles en vez de una por nivel.

Con esto queda cerrado el hallazgo 12 de §11 **del lado de la orden**. Medido:

| Nivel | Firmas | Divergían de la configuración vigente |
|---|---|---|
| Aprueba (nivel 2) | 2,273 | **880** |
| Autoriza (nivel 3) | 2,237 | **573** |
| Revisa (gte. de compras) | 2,351 | 0 — siempre fue Jorge |
| Libera · Monto | 0 | — sin histórico todavía |

Es decir: la corrección visible ya había aterrizado con la Fase D2; lo de ahora
no cambia ningún PDF existente. **La ficha de la requisición sigue resolviendo
sus cuatro firmas en vivo desde la cadena** — mismo defecto, otro documento, y
queda pendiente.

**`User::role()` fuera del código.** 23 usos reemplazados por `User::withRole()`,
que ahora acepta uno o varios roles. Tres de ellos hacían `->first()->email` y
reventaban con el rol vacío: la máquina de requisiciones, la de proveedores y
`CheckUserOrders`.

**Código muerto borrado**, con las referencias verificadas en cero:
`PurchaseRequisitionChainService` (además consultaba una columna `approver` que
no existe), `OrderService::getManagement()`, `User::scopeApprovers()`,
`User::managementResponsible()` y `'depto'` del `$fillable` de `Management`.

**Documentación.** `ProcessFlow` ya no llama "gerente solicitante" al nivel 2 sin
matizar, y menciona el aviso al informativo; `Guides` muestra las guías de orden
a los cuatro roles nuevos.

**Reporte de antigüedad — lo nuevo de esta fase**

| Archivo | Contenido |
|---|---|
| `app/Services/StalledOrderService.php` | Umbral por estado, días desde la **última transición** (`state_histories`, no `updated_at`), y quién debe responder resuelto con el mismo resolver del flujo |
| `app/Console/Commands/ReportStalledOrders.php` | `php artisan orders:report-stalled`, con `--esperando` y `--problemas`; sale con código de error si alguna no tiene quien la responda |
| `…/Pages/StalledOrders.php` + su blade | Página en Administración, con distintivo rojo en el menú |

Separa a propósito **esperando una decisión** de **en cancha del comprador**:
solo lo primero significa que el flujo está atorado.

**Lo que encontró en su primera corrida:** 6 órdenes de QHSE detenidas entre 112
y 212 días en `aprobado por gerente de compras`, todas con el mismo diagnóstico
—*"Quien debe responder está dado de baja: Guillermo Gutiérrez Melo"*—. Es la
cadena 85, la que el área decidió no destrabar (§3). Ahora al menos se ve.

**Pendiente reconocido:** `StalledOrderService` no tiene pruebas; clasificar
estados exige órdenes con histórico y no hay factories. Va con el resto de las
pruebas de flujo.

---


## 4. Lo que falta

| # | Punto del correo | Estado | Entrega |
|---|---|---|---|
| 1 | Nivel informativo: ver la OC + correo al liberarse | ✅ **Aplicada** | Fase C — el aviso va en el cierre; cubre también la ruta especial (§11.7) |
| 2 | Denise libera siempre (alcance global) | ✅ **Aplicada** | Fase B — en la ruta especial ella firma como autorización, no liberación |
| 3 | Allier al final, solo arriba del límite | ✅ **Aplicada** | Fase B — la ruta especial queda exenta por regla del área (§11.11) |
| 4 | Jennifer informativa en servicios de Manufactura | ✅ **Aplicada** | Fase C |
| 5 | Quitar el último nivel de autorización en Soldadura y ST | ✅ **Aplicada** | Fase D2 |
| 6 | En OC: aprueba Alan, autoriza Sergio | ✅ **Aplicada** | Fase D1 |

### 4.1 Hallazgos que hay que corregir en el camino

✅ **Resueltos en la Fase B** los dos primeros hallazgos de esta sección.

**El estado `aprobado por DG nivel 2` nunca se registra.** La pantalla de N4
transiciona directo a `autorizada para proveedor`. Hay 0 registros de ese estado
sobre 2,302 órdenes autorizadas, aunque sí hay 12 devoluciones del mismo nivel.
Consecuencia: en el PDF, la firma del nivel de monto siempre aparece como
*Sin respuesta* en órdenes que superan el límite.

**`getProgressAttribute()` resuelve el nombre con `->first()->name`** sin
comprobar que exista. Hoy funciona porque Allier es el único del rol; si el rol
queda vacío, revienta con 500 en el PDF y en el infolist. Eran **dos**
ocurrencias, no una (`gerente_compras` y `autoriza_nivel-2-orden_compra`).

**La regla del monto estaba escrita tres veces**, no una: el hook de
`aprobado por DG nivel 1` en la máquina de estados tenía su propia copia de los
límites y de la lista de exentos, además de la pantalla de N3 y del armado de
firmas. `PurchaseOrderFlowService` absorbió las tres.

**`scopeApprove()` leía `authorizerChainsPR` como propiedad**, sin
`notArchived()`, mientras `canAccess()` sí filtraba: un usuario con una cadena
archivada y otra activa veía órdenes de la archivada. Corregido.

**El ID 106 de Denise está cableado en 8 lugares:**

```
app/Filament/Purchases/Resources/PurchaseOrder/ApproveSpecialResource.php:34
app/Filament/Purchases/Resources/PurchaseOrder/HistoryResource.php:156
app/Filament/Purchases/Resources/PurchaseOrder/HistoryResource/Pages/ManagePR.php:74
app/Filament/Purchases/Resources/PurchaseRequisition/HistoryResource.php:170
app/Filament/Purchases/Resources/PurchaseRequisition/HistoryResource/Pages/ManagePR.php:88
app/Policies/PurchaseRequisitionPolicy.php:53
app/Services/OrderService.php:117
app/StateMachines/PurchaseOrderStateMachine.php:203, 316
```

Más el nombre literal `'Denise Marisol Reyes Ramírez'` en
`getProgressSpecialAttribute()`.

---

## 5. Decisión de arquitectura

### El conflicto

Al cruzar la tabla del correo con las cadenas reales aparece lo que en realidad
se está pidiendo: **los "informativos" del correo son quienes hoy aprueban la OC**
(salvo en las cuatro cadenas donde ese lugar lo ocupa Alan Anaya).

La **requisición** sigue necesitando `approver` = Allan / Jennifer / Jesús /
Eddie / Iván y `authorizer` = Alan Anaya. La **OC** necesita, sobre las mismas
cadenas, `approver` = Alan Anaya y `authorizer` = Sergio Ordaz.

### Lo que se evaluó (28-ago-2026)

Se compararon tres formas de modelar el informativo y los actores de OC, con un
panel de tres jueces (corrección funcional, costo de mantenimiento, integridad
histórica). Los tres eligieron **híbrido**, por unanimidad.

| Opción | Por qué no basta |
|---|---|
| **A · Todo en la cadena** (`informed_id`, `po_approver_id`, `po_authorizer_id`) | Guarda el mismo par repetido 24-34 veces, y **no puede expresar el requisito 4**: la categoría es por requisición, no por cadena — las cadenas vivas de Manufactura mezclan servicio y proveeduría (104: 19/27, 115: 6/23, 117: 3/52) |
| **B · Todo en la gerencia** (`management.responsible_id`) | El responsable de Manufactura es Eddie Ordoñez, no Jennifer; el correo pide a Jennifer **además**. Dos informativos simultáneos no caben en un escalar |
| **C · Híbrido** | La elegida |

Sobre la gerencia, verificado: `management.responsible_id` sí reproduce los
cinco informativos del correo (MTTOESP→Allan, ING→Jennifer, ISW→Jesús,
MAN→Eddie, ST→Iván) y las 34 cadenas de esas gerencias agrupan limpio por
`requester.management_id`. Pero la gerencia **hoy no participa en el flujo de
OC** —`OrderService::getManagement()` no tiene llamadores y el folio de la orden
se arma con el acrónimo de la empresa—, así que sirve como **eje de agrupación y
de alcance**, no como el dato.

### La decisión

1. **El informativo es una lista, no un campo.** Tabla de reglas
   `gerencia + categoría opcional → usuario`, resuelta por un único servicio.
2. **Los actores de OC son roles, no columnas.** Alan y Sergio son los mismos
   para las cinco gerencias: lo que varía es el **alcance**, y ése se marca con
   una bandera en `management`.
3. **La liberación se resuelve por rol** (ya aplicado en la Fase B).

Ventaja frente al plan original: cero columnas nuevas en la cadena para la OC,
cero `COALESCE` en los scopes, y ninguna cadena nueva que nazca mal configurada.

### Regla de diseño heredada de la Fase A

> Los tres puntos de un nivel —listado, acceso a la sección y botón de respuesta—
> deben leer **la misma fuente de verdad**. O los tres la cadena, o los tres el
> rol. Nunca mezclados.

Con el híbrido eso obliga a que exista **un solo servicio** por nivel:
`PurchaseOrderInformedService` y `PurchaseOrderChainResolver`.

---

## 6. Fase B — Nivel de liberación y reordenamiento del monto

**Es el corazón del encargo.** Entrega los puntos 2 y 3 del correo.

### 6.1 Rol y permiso

**Crear:** `database/migrations/XXXX_create_release_purchase_order_role.php`

Migración idempotente (no seeder — los seeders no corren en producción):

- Rol `libera_orden_compra`
- Permiso `view_release_purchase::order::purchaser`
- Asignar el permiso al rol, y el rol a `super_admin` / `super_admin_sg`
- Asignar el rol a Denise Reyes

### 6.2 Máquina de estados

**Modificar:** `app/StateMachines/PurchaseOrderStateMachine.php`

Estado nuevo: `liberado por dirección administrativa`
Devoluciones nuevas: `devuelto por liberación`, `cancelado por liberación`

```php
// Antes
'aprobado por DG nivel 1' => ['aprobado por DG nivel 2', 'devuelto por DG nivel 2',
                              'cancelado por DG nivel 2', 'autorizada para proveedor'],
'aprobado por DG nivel 2' => ['autorizada para proveedor'],

// Después
'aprobado por DG nivel 1' => ['liberado por dirección administrativa',
                              'devuelto por liberación', 'cancelado por liberación'],
'liberado por dirección administrativa' => ['aprobado por DG nivel 2',
                              'autorizada para proveedor',
                              'devuelto por DG nivel 2', 'cancelado por DG nivel 2'],
'aprobado por DG nivel 2' => ['autorizada para proveedor'],
'devuelto por liberación' => ['revisión gerente de compras', 'revision por dirección general'],
```

Hooks nuevos:

- `aprobado por DG nivel 1` → notificar al rol `libera_orden_compra` (hoy notifica
  al nivel de monto; ese aviso se mueve).
- `liberado por dirección administrativa` → si supera el límite, notificar a
  Allier; si no, transición automática.
- `devuelto por liberación` / `cancelado por liberación` → notificar al comprador.

### 6.3 Servicio de flujo

**Crear:** `app/Services/PurchaseOrderFlowService.php`

La lógica del monto está hoy embebida en la pantalla de N3 y se necesitará en dos
sitios más. Se extrae:

```php
public const PROVEEDORES_EXENTOS = [427, 425, 332];

public function requiresAmountApproval(PurchaseOrder $order): bool
{
    if (in_array($order->provider_id, self::PROVEEDORES_EXENTOS)) {
        return false;
    }

    return ! (new OrderCalculationService($order->id))->isOrderTotalBetweenLimits();
}

public function advanceAfterRelease(PurchaseOrder $order): void
{
    if ($this->requiresAmountApproval($order)) {
        return; // queda esperando a Allier
    }

    $order->status()->transitionTo('autorizada para proveedor');
}
```

### 6.4 Scopes

**Modificar:** `app/Models/PurchaseOrder.php`

```php
// Nuevo: bandeja de Denise
public function scopeRelease(Builder $query)
{
    return $query->where('status', 'aprobado por DG nivel 1')
        ->where('company_id', session()->get('company_id'))
        ->orderBy('id', 'desc');
}

// Modificado: bandeja de Allier, ahora después de la liberación
public function scopeAuthorize(Builder $query)
{
    return $query->where('status', 'liberado por dirección administrativa')
        ->where('company_id', session()->get('company_id'))
        ->orderBy('id', 'desc');
}
```

### 6.5 Pantalla de liberación

**Crear:**

```
app/Filament/Purchases/Resources/PurchaseOrder/ReleaseResource.php
app/Filament/Purchases/Resources/PurchaseOrder/ReleaseResource/Pages/ListPurchaseOrders.php
app/Filament/Purchases/Resources/PurchaseOrder/ReleaseResource/Pages/ViewOrder.php
```

Copia de `AuthorizeResource`, con:

- `navigationLabel = 'Liberar'`, `slug = 'ordenes/liberar'`, `navigationSort = 5`
- `canAccess()` → `hasRole('libera_orden_compra')` — el scope no ata a persona,
  así que aquí el rol **es** la fuente de verdad, y los tres puntos la usan igual
- Botón con las opciones: Liberar / Devolver / Cancelar
- Al liberar: `transitionTo('liberado por dirección administrativa')` y después
  `PurchaseOrderFlowService::advanceAfterRelease()`

### 6.6 Pantalla de monto (Allier)

**Modificar:** `…/AuthorizeResource/Pages/ViewOrder.php`

Hoy transiciona directo a `autorizada para proveedor`, por eso
`aprobado por DG nivel 2` nunca se registra. Debe pasar por el estado:

```php
$this->record->status()->transitionTo('aprobado por DG nivel 2', [...]);
$this->record->status()->transitionTo('autorizada para proveedor');
```

También hay que quitar el bloque muerto `if ($data['response'] == 'aprobado por DG nivel 1')`,
que nunca se cumple porque el select no ofrece esa opción.

### 6.7 Pantalla de N3

**Modificar:** `…/ApproveResource/Pages/ViewOrder.php`

Quitar la evaluación del monto y el salto automático a
`autorizada para proveedor`. El nivel 3 ahora solo aprueba y pasa a liberación.

### 6.8 Firmas del PDF y trazas

**Modificar:** `app/Models/PurchaseOrder.php`

- `getRevisionDates()` → agregar `liberado por dirección administrativa` a
  `$revisions`, y `devuelto por liberación` a la lista que reinicia el ciclo
- `getProgressAttribute()` → paso nuevo `releaser` antes de `authorizer-2`;
  resolver el nombre de Allier con acceso seguro
- Ocultar el paso *Libera* en órdenes anteriores al cambio (sin registro histórico)

**Modificar:** `app/Http/Controllers/PurchaseOrderController.php`

```php
$stages[5] = $data->status()->snapshotWhen('liberado por dirección administrativa');
$stages[6] = $data->status()->snapshotWhen('aprobado por DG nivel 2');
```

### 6.9 Documentación del flujo

**Modificar:** `app/Filament/Purchases/Pages/ProcessFlow.php` — nodos nuevos y
descripciones actualizadas del orden de aprobación.

**Modificar:** `app/Filament/Purchases/Pages/CheckUserOrders.php` — la lista de
estados está quemada; agregar el nuevo.

### 6.10 Archivos de la Fase B

**Nuevos**

```
database/migrations/XXXX_create_release_purchase_order_role.php
app/Services/PurchaseOrderFlowService.php
app/Filament/Purchases/Resources/PurchaseOrder/ReleaseResource.php
app/Filament/Purchases/Resources/PurchaseOrder/ReleaseResource/Pages/ListPurchaseOrders.php
app/Filament/Purchases/Resources/PurchaseOrder/ReleaseResource/Pages/ViewOrder.php
```

**Modificados**

```
app/StateMachines/PurchaseOrderStateMachine.php
app/Models/PurchaseOrder.php
app/Filament/Purchases/Resources/PurchaseOrder/ApproveResource/Pages/ViewOrder.php
app/Filament/Purchases/Resources/PurchaseOrder/AuthorizeResource.php
app/Filament/Purchases/Resources/PurchaseOrder/AuthorizeResource/Pages/ViewOrder.php
app/Http/Controllers/PurchaseOrderController.php
app/Filament/Purchases/Pages/ProcessFlow.php
app/Filament/Purchases/Pages/CheckUserOrders.php
```

---

## 7. Fase C — Nivel informativo

Entrega los puntos 1 y 4 del correo. **`informed_id` en la cadena queda
descartado** por lo dicho en §5.

### 7.0 Decisiones cerradas (28-ago-2026, Etzahu)

Cierran las preguntas 5 y 7 de §11 y **simplifican el diseño**:

| # | Decisión | Consecuencia |
|---|---|---|
| a | El informativo aplica a **requisición y orden** para las cinco gerencias, no solo a Jennifer | **No hace falta la columna `applies_to`**: la tabla de reglas se queda con `management_id + category + user_id` |
| b | A Jennifer se le **retiran** `visor_ordenes` y `visor_requisiciones` al darle el informativo | Sin esto la regla de categoría es decorativa: hoy esos roles le muestran la pestaña *Todas*, con todas las órdenes de la empresa |
| c | Ve el documento **desde que sale de `borrador`** | Un solo filtro de estado sirve para los dos documentos. El borrador es la mesa de trabajo del comprador |

**Por qué (b) es imprescindible.** Verificado en producción: de los cinco
informativos del correo, solo Jennifer (191) ve algo hoy —y ve *todo*, vía
`visor_ordenes` / `visor_requisiciones`, que abren la pestaña *Todas* en
`ManagePR`—. Los otros cuatro no ven nada. El nivel informativo está mal por los
dos lados: demasiado ancho para una persona, nulo para las otras cuatro.

| Informativo | Gerencia | Hoy ve |
|---|---|---|
| Allan Alejandro Vázquez Rocha (348) | MTTOESP (13) | nada |
| Jennifer Martínez Jarquín (191) | ING (9) | **todo**, sin filtro |
| Jesús Becerra Yebra (14) | ISW (8) | nada |
| Eddie Santiago Ordoñez Sánchez (333) | MAN (5) | nada |
| Iván Ponce Reyes (22) | ST (10) | nada |

`management.responsible_id` reproduce **exactamente** esos cinco, así que el
sembrado sale de ahí sin capturar nada a mano.

### 7.1 Tabla de reglas

**Crear:** `database/migrations/XXXX_create_management_informed_rules_table.php`

```
management_informed_rules
  management_id  FK management.id
  category       enum('servicio','proveeduria') nullable   -- NULL = todas
  user_id        FK users.id
  unique(management_id, category, user_id)
```

**Resolución:** dado un documento de gerencia `G` y categoría `C`, son
informativos todas las reglas donde
`management_id = G AND (category IS NULL OR category = C)`.
En Manufactura + servicio devuelve **dos** —Eddie y Jennifer—, que es
literalmente lo que pide el correo: que le lleguen a Jennifer *además*.

**Sembrado inicial:** 5 reglas base con `category = NULL`, una por gerencia,
copiadas de `management.responsible_id` (5, 8, 9, 10, 13) + 1 regla especial
`MAN + servicio → Jennifer (191)`.

**Datos verificados el 28-ago-2026:**

- `purchase_requisitions.category` es `enum('servicio','proveeduria')` **nullable**,
  y viene nula en 200 requisiciones: ING 83, ISW 52, ST 38, MTTOESP 27.
  **No rompe nada**: la regla base tiene `category = NULL` y las captura igual.
  Solo una regla *con* categoría se saltaría un documento sin categoría — y
  Manufactura, la única gerencia con regla por categoría, tiene **0 nulos**
  (29 servicio / 119 proveeduría).
- `purchase_requisitions` **no tiene** `user_id` ni `management_id`: la gerencia
  del documento se resuelve por
  `requisition.approvalChain.requester.management_id`.
- `approval_chain_id` es nullable pero **0 de 2,340** requisiciones lo tienen nulo.
- `users.management_id` es nullable: **7 de 114 cadenas** tienen un solicitante
  sin gerencia. Sus documentos no resuelven informativo — ver §7.7.

**Volumen histórico que abre cada bandeja:**

| Gerencia | Requisiciones | Órdenes |
|---|---|---|
| ING | 399 | 472 |
| ISW | 179 | 194 |
| MAN | 148 | 156 |
| ST | 150 | 118 |
| MTTOESP | 92 | 107 |

De las de MAN, Jennifer ve además las 29 requisiciones / 21 órdenes de servicio.

### 7.2 Modelo y servicio

**Crear:** `app/Models/ManagementInformedRule.php` y
`app/Services/PurchaseInformedService.php` — nombre sin `Order` porque ahora
cubre los dos documentos. Única fuente de verdad:

- `usersFor(PurchaseRequisition $r): Collection`
- `emailsFor(PurchaseRequisition $r): array`
- `isInformed(User $u, PurchaseRequisition $r): bool`
- `applyScope(Builder $q, User $u): Builder` — el mismo filtro para las dos bandejas

Es la regla de diseño de §5: listado, acceso y detalle leen de aquí, o se
contradicen entre sí.

### 7.3 Rol, permiso y pantallas

- Migración idempotente con el patrón de la Fase B: rol `informativo_compras`
  (uno solo, cubre los dos documentos) + permisos
  `view_informed_purchase::order::purchaser` y
  `view_informed_purchase::requisition::requester`
- Asignar el rol a los cinco (348, 191, 14, 333, 22) y **retirar**
  `visor_ordenes` / `visor_requisiciones` a Jennifer (191), con `down()` que los
  reponga
- `'view_informed'` en `getPermissionPrefixes()` de `PurchaserResource` y del
  recurso equivalente de requisición
- **Pestaña "Informativo"** en las dos `HistoryResource` (`ManagePR` de orden y de
  requisición), siguiendo el patrón de una pestaña por rol que ya existe ahí.
  Se prefiere a un recurso nuevo para no duplicar dos veces la definición de la
  tabla, sus columnas y sus filtros
- `canAccess()` de las dos `HistoryResource` += `informativo_compras`
- La pestaña *Todas* y el header action *Generar reporte* **no** deben abrirse
  para el rol nuevo
- Filtro de estado de la pestaña: todo menos `borrador`

### 7.4 Correos

- **Orden:** el aviso va en `getUserForEmailFinish()`, o sea en el hook de
  `autorizada para proveedor`. "Liberada" aquí significa que la orden salió al
  proveedor, no la firma de Dirección Administrativa (§11.7). Por venir del
  cierre cubre también la ruta de proveedores especiales, que no tiene nivel de
  liberación pero sí termina en ese estado.
- **Requisición:** solo bandeja, **sin correo**. El correo explícito se pide
  únicamente para la orden; un aviso por cada requisición de la gerencia es
  ruido. Confirmable con Jorge.
- Blindar `OrderService::getUserForEmailFinish()` de paso: hoy hace
  `User::role('gerente_compras')->first()->email` sin guarda (§9, punto 1.b).

### 7.5 Policies

`PurchaseOrderPolicy::view()` y `PurchaseRequisitionPolicy::view()` necesitan la
rama del informativo, resuelta con `PurchaseInformedService::isInformed()`: sin
eso la bandeja lista los documentos pero abrir el detalle da 403.

### 7.6 Mantenimiento

Relation manager colgado de `ManagementResource`, para que Compras mantenga las
reglas sin tocar código. Debe copiar el patrón de `ChainResource`: filtrar
usuarios activos y marcar en rojo los dados de baja.

### 7.7 Datos que hay que limpiar antes de sembrar

- **7 cadenas con solicitante sin `management_id`.** Sus documentos no resuelven
  informativo. Listarlas y asignar gerencia antes del despliegue.
- **QHSE (6) y DNT (12) tienen `responsible_id` inactivo** —Guillermo Gutiérrez y
  Omar Alvarado—. No afecta a las cinco gerencias del correo, pero corregirlo
  antes de que el informativo se extienda a otras áreas (§9.1).
---

## 8. Fase D — Actores de OC por rol y alcance

Entrega el punto 6 del correo (Alan aprueba, Sergio autoriza) y el punto 5
(el "N/A" de Soldadura y Servicios Técnicos). Se parte en dos porque **solo D2
toca el esquema de la cadena**.

### 8.1 Fase D1 — la OC, sin migración de esquema

**Crear:**

- Migración con roles `aprueba_orden_compra` (Alan, 341) y
  `autoriza_orden_compra` (Sergio, 168), patrón de la Fase B
- Migración `purchase_order_flow` (boolean) en `management`, en true para las
  gerencias 5, 8, 9, 10 y 13
- `app/Services/PurchaseOrderChainResolver.php` — única fuente de verdad de los
  niveles 2 y 3 de la OC

**Modificar:** `PurchaseOrder` (`scopeReviewManagement`, `scopeApprove`,
`isChainApprover`, `isChainAuthorizer`), `canAccess()` de `ReviewResource` y
`ApproveResource`, `PurchaseOrderPolicy::view()`, los dos hooks de correo de la
máquina de estados, el CC de `getUserForEmailFinish()`, `HistoryResource` y
`ManagementResource` (toggle del alcance).

**Nota sobre Sergio:** hoy entra a *Aprobar* por casualidad, porque es
`authorizer_id` en 26 cadenas ajenas a las cinco gerencias. Con el diseño por
rol deja de depender de esa coincidencia.

### 8.2 Fase D2 — el "N/A" de las requisiciones

**Corrección al plan original:** el `->default(106)` de la migración de 2024
**nunca llegó a la base**. Se encadenó después de `->constrained()`, así que
aplicó al `ForeignKeyDefinition`; `SHOW CREATE TABLE` confirma `NOT NULL` sin
DEFAULT. Solo hay que quitar el `NOT NULL`.

- Migración `authorizer_id` nullable
- Partir `ROLES` en obligatorios y opcionales — la usan `getInactiveUsers()` y
  `scopeFullyActive()`
- Guardar ~12 accesos sin protección a `->authorizer->email` / `->authorizer->name`
  (máquina de estados de requisiciones, `OrderService`,
  `PurchaseRequisitionCreationService`, `PRInfolistService`, `CheckUserRequisitions`,
  `PurchaseRequisition::getProgressAttribute()`)
- `ChainResource`: quitar el `required` del autorizador y ajustar la validación
  de duplicados
- Máquina de estados de requisiciones: sin autorizador, avanzar sola en vez de
  mandar correo a `null`

`chainRolesFor()` ya descarta los `null`, así que por ese lado la Fase D2 no
tiene sorpresas.

---

## 9. Fase E — Limpieza y pruebas

1. Reemplazar los **9** usos cableados del ID 106 por consultas al rol, más el
   literal `'Denise Marisol Reyes Ramírez'` de `getProgressSpecialAttribute()`.
   (El décimo hallazgo del grep es un falso positivo: en `PurchaserResource` el
   106 es la cuenta contable "106 - Comunicaciones telefónicas".)
1.b **Blindar el resto de los `User::role(...)`**, empezando por
   `OrderService::getUserForEmailFinish()`, que hace
   `User::role('gerente_compras')->first()->email` sin guarda en el correo de
   cierre: revienta si el rol falta o queda vacío. Usar `User::withRole()`.
1.c **Borrar código muerto verificado:** `PurchaseRequisitionChainService`
   (sin referencias y además roto — consulta una columna `approver` que no
   existe), `OrderService::getManagement()`, `User::scopeApprovers()`,
   `User::managementResponsible()`, y `'depto'` del `$fillable` de `Management`
   (esa columna no existe en la tabla).
2. **Crear** `tests/Feature/PurchaseOrderFlowTest.php`: recorrido completo bajo y
   sobre el límite, devoluciones desde liberación, proveedor exento, y que el
   informativo no pueda transicionar nada. **Ojo con el costo:** no hay factories
   para `User`, `PurchaseOrder`, `PurchaseRequisition` ni la cadena, y los tests
   corren contra la misma base con `DatabaseTransactions`. Un test de flujo
   completo exige crear factories primero; los de lógica pura se pueden armar en
   memoria, como `tests/Unit/PurchaseOrderChainRolesTest.php`.
3. Regenerar un PDF de cada caso y verificar el bloque de firmas.
4. Actualizar la guía del solicitante y la página *Flujo del proceso*.
5. **Reporte de antigüedad** — `app/Console/Commands/ReportStalledOrders.php` más
   una página en Administración. Mide días desde la última transición
   (`state_histories`, no `updated_at`), separa "esperando decisión" de "en cancha
   del comprador", marca responsable inactivo o rol vacío, y usa umbrales por
   estado. Va al final: medir antigüedad contra estados que están por cambiar no
   sirve de nada.

### 9.1 Backlog operativo (no es código)

Destapado al auditar el padrón el 28-ago-2026, y verificado contra el CSV de
RRHH: la base y el padrón están sincronizados (77 activos), así que **estos casos
son bajas reales**, no flags mal puestos.

- **53 de 109 cadenas vivas no se pueden seleccionar** para una requisición
  nueva, porque `scopeSelectable()` exige que los cuatro participantes estén
  activos. Reasignar con `app/Console/Commands/ReplaceUserInChains.php`.

  | Gerencia | Vivas | Seleccionables |
  |---|---|---|
  | Almacén | 11 | **1** |
  | DNT · sin gerencia | 3 · 5 | **0 · 0** |
  | GCON | 17 | 6 |
  | QHSE | 24 | 11 |

- **`management.responsible_id` de QHSE y DNT** apunta a gente que ya salió
  (Guillermo Gutiérrez, Omar Alvarado): 237 órdenes. Hay que corregirlo antes de
  sembrar las reglas de la Fase C desde ese campo.
- **Tres nombres con tabulador literal** en `users.name` (ids 337, 340, 345), más
  dos con espacios dobles: romperán cualquier cotejo por nombre exacto, incluida
  la sincronización de RRHH.

---

## 10. Riesgos

| Riesgo | Magnitud | Mitigación |
|---|---|---|
| Órdenes en `aprobado por DG nivel 1` pasan a requerir liberación de Denise | 11 órdenes | Es lo deseado. Avisarle antes del despliegue. Solo una es de los 5 departamentos. |
| Bajar de nivel a los cinco aprobadores actuales sin avisarles | 5 personas | Coordinar el corte con Jorge y comunicarlo a Allan, Jennifer, Jesús, Santiago e Iván. |
| Órdenes ya autorizadas cuyo PDF se regenere | 2,302 | Los pasos se pintan por fecha del histórico; los inexistentes quedan vacíos. Ocultar *Libera* cuando no hay registro. |
| `getProgressAttribute()` revienta si el rol de monto queda vacío | Bloqueante | Acceso seguro **antes** de tocar roles en producción. Primero de la Fase B. |
| Fase D toca la cadena, que usan requisiciones y órdenes | Alto | Fallback con `COALESCE`; ningún dato existente cambia de significado. |
| Órdenes de Guillermo Gutiérrez | 6 órdenes | **Fuera de alcance por decisión del área.** |

---

## 11. Preguntas abiertas

### Resueltas

1. ~~¿La liberación de Denise es global o solo los 5 departamentos?~~
   **Global** (27-ago-2026). El nivel se resuelve por rol.
6. ~~¿El informativo es por cadena o por departamento?~~ **Por gerencia**, con
   una tabla de reglas que además admite el matiz de categoría (§5).

### Decisiones tomadas al implementar, confirmables con Jorge

2. **Denise puede devolver y cancelar**, no solo liberar.
3. El límite se dejó en 15,000 USD **o** 300,000 MXN. El correo solo menciona los
   USD; se conservó el equivalente en pesos que ya existía.
4. **Se conservaron** la ruta especial y la exención de los proveedores 427, 425
   y 332.

### Abiertas — bloquean la Fase C

*(Ninguna. Las que bloqueaban la Fase C se cerraron el 28-ago-2026; ver abajo.)*

### Resueltas el 28-ago-2026 — desbloquean la Fase C

5. ~~¿El informativo ve la OC desde que se genera, o solo al liberarse?~~
   **Desde que sale de `borrador`.** El "únicamente" de Jorge restringe el *tipo*
   de permiso —ver, no aprobar—, no el momento; y el propósito de Jennifer
   ("evitar triangular información") se pierde si solo lo ve al final.
7. ~~¿Qué correo dispara el aviso al informativo?~~ **El del cierre**, dentro de
   `getUserForEmailFinish()`. *Corregido el 30-ago-2026 por Etzahu, revirtiendo
   la decisión del 28-ago.* "Liberar" en el vocabulario de la casa significa que
   la orden **salió al proveedor** —la pestaña *Liberadas* de asignación filtra
   por `cerrada`—, no la firma de Dirección Administrativa; y cuando Jorge
   escribió "la notificación de la liberación de la orden", ese nivel todavía no
   existía: lo pedía en el punto siguiente del mismo correo.

   La decisión anterior colgaba el aviso de `liberado por dirección
   administrativa` para que no se retrasara arriba de 15K USD. El argumento se
   da vuelta: enterarse tarde de algo que ya ocurrió es mejor que enterarse
   pronto de una orden que Dirección General todavía puede devolver.

   **Cierra de paso el hueco de la ruta especial** (§11.11): esas órdenes no
   tienen nivel de liberación pero sí llegan a `autorizada para proveedor`, así
   que el informativo pasa a recibirlas sin código adicional. Verificado con el
   arnés: 46 de 46 casos del flujo normal y las dos corridas de la ruta especial.

   En requisición, **sin correo**: solo bandeja.
13. ~~¿El informativo es solo de OC o también de requisición?~~ **Las dos, para
    las cinco gerencias.** El correo de Jorge solo menciona la OC y el de Alan
    pide las dos para Jennifer; Etzahu extendió el alcance a los cinco. Elimina
    la columna `applies_to` del diseño.
14. ~~¿Se le retiran a Jennifer `visor_ordenes` / `visor_requisiciones`?~~ **Sí.**
    Sin eso la regla por categoría es decorativa: esos roles le abren la pestaña
    *Todas*, con todas las órdenes de la empresa.

### Resueltas al implementar la Fase D

8. ~~**¿El alcance son 24 o 34 cadenas?**~~ **Las 34** — todas las cadenas vivas
   de las cinco gerencias. El alcance se marca en `management.purchase_order_flow`
   y no en la lista de cadenas donde Alan autoriza hoy, que era autorreferencial:
   así cualquier cadena nueva de esas gerencias nace dentro del flujo. La
   excepción por cadena (`po_flow_excluded`) existe para lo que Compras decida
   sacar, y nace vacía.
9. ~~**La cadena 144.**~~ **Se queda dentro** (30-ago-2026, Etzahu). Que Alan
   solicite, revise y apruebe la misma requisición no es un defecto: **hay
   cadenas donde el mismo usuario ocupa varios eslabones y así lo pidió
   Compras.** El código ya lo contempla — `chainRolesFor()` devuelve **todos** los
   eslabones que ocupa un usuario, no solo el primero que casa, y cada nivel se
   evalúa por separado, con pruebas en
   `tests/Unit/PurchaseOrderChainRolesTest.php`.
10. ~~**¿Las otras 8 gerencias quedan fuera?**~~ **Sí, quedan fuera.** Son 1,231
    órdenes. Incluirlas desplazaría a Kevin Pérez (GCON, 434 OC, que ya corre el
    patrón Kevin→Sergio) y sacaría a Denise del nivel 1 en ALM, SG, ADM, COM y
    DNT. Por eso la bandera de alcance en `management`.

### Fuera del alcance implementado — requieren decisión del área

11. **La ruta especial: exenta del nivel de monto, por regla del área.**
    Confirmado por Etzahu el **30-ago-2026**: los proveedores especiales **no
    respetan el límite de monto y no pasan por Allier**, y la lista la define el
    gerente de compras. Quién entra a esa lista es decisión suya: el giro del
    proveedor —material, aduana, flete, intercompañía— **no es criterio** y no
    debe usarse para cuestionar la marca.

    Los 20 proveedores con `approval_chain = 'especial'` van de `borrador` a
    `revision por dirección general` y de ahí directo a `autorizada para
    proveedor`, con Denise como actora. **Es el comportamiento correcto.**

    Medido el 30-ago-2026, para dimensionar y no para cuestionarlo: 140 órdenes
    recorrieron la ruta; en 16 de ellas la regla general de monto habría pedido
    a Dirección General, y correctamente no se les pidió. Cuatro siguen abiertas.

    Nota de implementación: `requiresAmountApproval()` devuelve `true` para esas
    órdenes, pero la ruta nunca lo consulta, así que no cambia el
    comportamiento. `getProgressSpecialAttribute()` es consistente: no pinta la
    firma de monto en estas órdenes.

    **El aviso al informativo ya está resuelto.** Estuvo abierto unas horas: el
    aviso colgaba del nivel de liberación, que esta ruta no tiene, así que el
    informativo no recibía nada de estas órdenes. Al mover el aviso al cierre
    (§11.7) quedó cubierto sin código específico, porque estas órdenes sí llegan
    a `autorizada para proveedor`. Verificado con el arnés sobre Manufactura
    categoría servicio: Jennifer y Eddie ahora sí aparecen entre los
    destinatarios.

    Queda **escrito en la página *Flujo del proceso***.
12. **El PDF ya imprime el firmante equivocado.** `getProgressAttribute()`
    resuelve el nombre en vivo desde la cadena, mientras `state_histories.responsible_id`
    guarda quién firmó de verdad: difieren en **880 de 2,268** aprobaciones (38.8%)
    y **853 de 2,232** autorizaciones (38.2%). Cada edición de una cadena reescribe
    la historia de sus PDFs. Arreglarlo cambia visiblemente el PDF de ~880 órdenes
    históricas —corrigiéndolo—, así que conviene avisarlo antes.

---

## 12. Orden de ejecución

| Fase | Entrega | Depende de |
|---|---|---|
| ~~A~~ | ~~Gates por cadena~~ | ✅ Aplicada |
| ~~B~~ | ~~Liberación de Denise + Allier al final~~ | ✅ Aplicada |
| ~~—~~ | ~~`chainRolesFor()` y `firstUserWithRole()`~~ | ✅ Aplicadas |
| ~~C~~ | ~~Nivel informativo (puntos 1 y 4)~~ | ✅ Aplicada (28-ago) |
| ~~D1~~ | ~~Alan aprueba / Sergio autoriza (punto 6)~~ | ✅ Aplicada (28-ago) |
| ~~D2~~ | ~~"N/A" en Soldadura y ST (punto 5)~~ | ✅ Aplicada (28-ago) |
| ~~E~~ | ~~Limpieza, pruebas, reporte de antigüedad~~ | ✅ Aplicada (28-ago) |

C y D1 son independientes entre sí: se pueden hacer en paralelo, y cada una
desbloquea preguntas distintas. C es lo que Jorge ve primero; D1 es lo que cierra
el mapeo exacto de la tabla del correo. **Las cinco fases están aplicadas.** Lo
que queda son los dos pendientes de §11: las firmas en vivo de la ficha de la
requisición y las pruebas de flujo completo, que exigen factories.

### Orden interno de la Fase C

| Paso | Entrega | Nota |
|---|---|---|
| C0 | Limpiar las 7 cadenas sin `management_id` (§7.7) | Antes de sembrar |
| C1 | Migración `management_informed_rules` + sembrado | §7.1 |
| C2 | Migración de rol `informativo_compras`, asignación a los 5 y retiro de los `visor_` a Jennifer | §7.3 |
| C3 | `ManagementInformedRule` + `PurchaseInformedService` | §7.2 — fuente única |
| C4 | Pestaña *Informativo* en las dos `HistoryResource` | §7.3 |
| C5 | Rama del informativo en las dos policies | §7.5 — sin esto, 403 |
| C6 | Correo al informativo en el cierre de la orden | §7.4 |
| C7 | Relation manager en `ManagementResource` | §7.6 |

C3 antes que C4 y C5: las dos bandejas y las dos policies deben leer del mismo
servicio, o se repite el desfase de la Fase A.

### Antes de desplegar la Fase B

1. Avisar a **Denise**: las 12 órdenes en `aprobado por DG nivel 1` pasan a su
   bandeja *Liberar* al desplegar. Dos son de los 5 departamentos.
2. Avisar a **Allier**: su bandeja *Autorizar* queda vacía hasta que Denise
   libere; su nivel ahora corre al final.
3. La cola de migraciones de esta base no es utilizable (viene importada, con
   objetos ya existentes). La migración del rol se corre sola:
   `php artisan migrate --path=database/migrations/2026_08_27_120000_create_release_purchase_order_role.php`
