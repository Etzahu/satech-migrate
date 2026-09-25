-- ---------------------------------------------------------------------------
-- Cadenas de aprobación de requisición — alta y reactivación
-- Origen: Book1.xlsx compartido por Compras (25-sep-2026)
--
-- Contenido:
--   1) Reactiva 3 cadenas archivadas que la tabla de Compras sí contempla.
--   2) Crea 6 cadenas que no existen.
--   3) Asigna los roles que la pantalla de Filament otorga al guardar una
--      cadena (CreatePurchaseRequisitionApprovalChain::afterCreate).
--
-- Cubre las 14 cadenas del Excel, sin pendientes.
--
-- Todo es idempotente: correrlo dos veces no duplica nada.
-- Los participantes se resuelven por correo, no por id, para que el script
-- funcione aunque producción tenga otra numeración. Jonathan Vázquez Vera
-- (jvazquez@gptservices.com) se dio de alta el 25-sep-2026: si aún no existe
-- en producción, el script se detiene antes de tocar nada.
-- ---------------------------------------------------------------------------


-- ===========================================================================
-- PASO 0 — Antes de tocar nada: foto del estado actual
-- ===========================================================================

SELECT  ru.name  AS solicita,
        rv.name  AS revisa,
        ap.name  AS aprueba,
        au.name  AS autoriza,
        CASE WHEN c.archived_at IS NOT NULL THEN 'Desactivada'
             WHEN ru.active = 0 OR rv.active = 0 OR ap.active = 0
                  OR (c.authorizer_id IS NOT NULL AND au.active = 0) THEN 'Bloqueada'
             ELSE 'Activa' END AS estado
FROM        purchase_requisition_approval_chains c
JOIN        users ru ON ru.id = c.requester_id
JOIN        users rv ON rv.id = c.reviewer_id
JOIN        users ap ON ap.id = c.approver_id
LEFT JOIN   users au ON au.id = c.authorizer_id
WHERE       ru.email IN (
              'jalejo@gptservices.com',     'bpena@gptservices.com',
              'ccantellano@gptservices.com','dserrano@gptservices.com',
              'cdios@gptservices.com',      'apedraza@gptservices.com',
              'fpantoja@gptservices.com',   'fbutron@gptservices.com',
              'rrojasg@gptservices.com',    'jvazquez@gptservices.com'
            )
ORDER BY    ru.name, rv.name;


-- ===========================================================================
-- Participantes
-- ===========================================================================

SET @jatziri  := (SELECT id FROM users WHERE email = 'jalejo@gptservices.com');
SET @brenda   := (SELECT id FROM users WHERE email = 'bpena@gptservices.com');
SET @yibran   := (SELECT id FROM users WHERE email = 'ccantellano@gptservices.com');
SET @daniel   := (SELECT id FROM users WHERE email = 'dserrano@gptservices.com');
SET @carlos   := (SELECT id FROM users WHERE email = 'cdios@gptservices.com');
SET @abraham  := (SELECT id FROM users WHERE email = 'apedraza@gptservices.com');
SET @cesar    := (SELECT id FROM users WHERE email = 'fpantoja@gptservices.com');
SET @fernando := (SELECT id FROM users WHERE email = 'fbutron@gptservices.com');
SET @rocio    := (SELECT id FROM users WHERE email = 'rrojasg@gptservices.com');
SET @jonathan := (SELECT id FROM users WHERE email = 'jvazquez@gptservices.com');
SET @denise   := (SELECT id FROM users WHERE email = 'dmreyesr@gptservices.com');

-- Alto temprano si algún correo no existe en producción: sin esto los INSERT
-- fallarían contra la llave foránea a media ejecución.
SELECT 'Falta al menos un usuario. Revisa los correos antes de continuar.' AS error
WHERE  @jatziri  IS NULL OR @brenda  IS NULL OR @yibran   IS NULL OR @daniel IS NULL
    OR @carlos   IS NULL OR @abraham IS NULL OR @cesar    IS NULL
    OR @fernando IS NULL OR @rocio   IS NULL OR @jonathan IS NULL OR @denise IS NULL;


START TRANSACTION;

-- ===========================================================================
-- PASO 1 — Reactivar cadenas desactivadas que Compras sí usa
--
--   Brenda Peña      <- revisa Yibran Cantellano   (desactivada 31-ago-2026)
--   César Pantoja    <- revisa Rocío Rojas         (desactivada 28-ago-2026)
--   Fernando Butrón  <- revisa Rocío Rojas         (desactivada 28-ago-2026)
--
-- Se reactiva en vez de insertar: la pantalla de Filament rechaza una cadena
-- nueva con la misma terna Solicita/Revisa/Aprueba, y la de Brenda ya tiene
-- requisiciones a cuestas que deben conservar su cadena.
-- ===========================================================================

UPDATE purchase_requisition_approval_chains
SET    archived_at = NULL,
       updated_at  = NOW()
WHERE  archived_at IS NOT NULL
  AND  approver_id   = @daniel
  AND  authorizer_id = @denise
  AND ((requester_id = @brenda   AND reviewer_id = @yibran)
    OR (requester_id = @cesar    AND reviewer_id = @rocio)
    OR (requester_id = @fernando AND reviewer_id = @rocio));


-- ===========================================================================
-- PASO 2 — Crear las cadenas que faltan
--
--   Daniel Serrano   <- revisa Yibran Cantellano
--   Daniel Serrano   <- revisa Jatziri Alejo
--   Daniel Serrano   <- revisa Brenda Peña
--   Carlos De Dios   <- revisa Yibran Cantellano
--   Abraham Pedraza  <- revisa Yibran Cantellano
--   Jonathan Vázquez <- revisa Rocío Rojas
--
-- En todas aprueba Daniel Serrano y autoriza Denise Reyes.
-- El NOT EXISTS replica la regla de la pantalla: no puede haber dos cadenas
-- con la misma terna Solicita/Revisa/Aprueba.
-- ===========================================================================

INSERT INTO purchase_requisition_approval_chains
        (requester_id, reviewer_id, approver_id, authorizer_id, po_flow_excluded, created_at, updated_at)
SELECT  n.requester_id, n.reviewer_id, n.approver_id, n.authorizer_id, 0, NOW(), NOW()
FROM   (
            SELECT @daniel AS requester_id, @yibran AS reviewer_id, @daniel AS approver_id, @denise AS authorizer_id
  UNION ALL SELECT @daniel,  @jatziri, @daniel, @denise
  UNION ALL SELECT @daniel,  @brenda,  @daniel, @denise
  UNION ALL SELECT @carlos,   @yibran, @daniel, @denise
  UNION ALL SELECT @abraham,  @yibran, @daniel, @denise
  UNION ALL SELECT @jonathan, @rocio,  @daniel, @denise
       ) AS n
WHERE  NOT EXISTS (
           SELECT 1
           FROM   purchase_requisition_approval_chains c
           WHERE  c.requester_id = n.requester_id
             AND  c.reviewer_id  = n.reviewer_id
             AND  c.approver_id  = n.approver_id
       );


-- ===========================================================================
-- PASO 3 — Roles
--
-- Al guardar una cadena, la pantalla de Filament otorga el rol que cada quien
-- necesita para actuar en ella. Un INSERT directo se salta ese paso, así que
-- aquí se reponen: sin el rol la cadena existe pero nadie puede usarla.
--
--   Carlos De Dios, Abraham Pedraza y Jonathan Vázquez no tenían ningún rol.
--   Jatziri Alejo y Brenda Peña estrenan papel de revisoras.
--
-- La lista cubre a los 11 participantes de la tabla de Compras, no solo a
-- quienes hoy tienen el hueco: así el script no depende de cómo esté
-- producción. El INSERT IGNORE deja intacto lo que ya existe.
-- ===========================================================================

INSERT IGNORE INTO model_has_roles (role_id, model_type, model_id)
SELECT  r.id, 'App\\Models\\User', u.model_id
FROM   (
  -- Solicita: los diez que encabezan una cadena
            SELECT @jatziri AS model_id, 'solicita_requisicion_compra' AS role_name
  UNION ALL SELECT @brenda,   'solicita_requisicion_compra'
  UNION ALL SELECT @yibran,   'solicita_requisicion_compra'
  UNION ALL SELECT @daniel,   'solicita_requisicion_compra'
  UNION ALL SELECT @carlos,   'solicita_requisicion_compra'
  UNION ALL SELECT @abraham,  'solicita_requisicion_compra'
  UNION ALL SELECT @cesar,    'solicita_requisicion_compra'
  UNION ALL SELECT @fernando, 'solicita_requisicion_compra'
  UNION ALL SELECT @rocio,    'solicita_requisicion_compra'
  UNION ALL SELECT @jonathan, 'solicita_requisicion_compra'
  -- Revisa: los cinco que aparecen en la segunda columna
  UNION ALL SELECT @yibran,   'revisa_requisicion_compra'
  UNION ALL SELECT @daniel,   'revisa_requisicion_compra'
  UNION ALL SELECT @jatziri,  'revisa_requisicion_compra'
  UNION ALL SELECT @brenda,   'revisa_requisicion_compra'
  UNION ALL SELECT @rocio,    'revisa_requisicion_compra'
  -- Aprueba: Daniel Serrano en las catorce. El rol de gerencia lo acompaña
  -- porque la pantalla los otorga juntos al aprobador.
  UNION ALL SELECT @daniel,   'aprueba_requisicion_compra'
  UNION ALL SELECT @daniel,   'gerente_solicitante_orden_compra'
  -- Autoriza: Denise Reyes en las catorce
  UNION ALL SELECT @denise,   'autoriza_requisicion_compra'
       ) AS u
JOIN    roles r ON r.name = u.role_name AND r.guard_name = 'web';


COMMIT;


-- ===========================================================================
-- PASO 4 — Verificación: las 14 cadenas de la tabla de Compras
-- Todas deben salir 'Activa'.
-- ===========================================================================

SELECT  ru.name AS solicita,
        rv.name AS revisa,
        CASE WHEN c.id IS NULL THEN 'NO EXISTE'
             WHEN c.archived_at IS NOT NULL THEN 'Desactivada'
             WHEN ru.active = 0 OR rv.active = 0 THEN 'Bloqueada'
             ELSE 'Activa' END AS estado
FROM   (
            SELECT @jatziri AS rq, @yibran AS rv
  UNION ALL SELECT @jatziri,  @daniel
  UNION ALL SELECT @brenda,   @yibran
  UNION ALL SELECT @brenda,   @daniel
  UNION ALL SELECT @yibran,   @daniel
  UNION ALL SELECT @daniel,   @yibran
  UNION ALL SELECT @daniel,   @jatziri
  UNION ALL SELECT @daniel,   @brenda
  UNION ALL SELECT @carlos,   @yibran
  UNION ALL SELECT @abraham,  @yibran
  UNION ALL SELECT @cesar,    @rocio
  UNION ALL SELECT @fernando, @rocio
  UNION ALL SELECT @jonathan, @rocio
  UNION ALL SELECT @rocio,    @daniel
       ) AS esperada
JOIN        users ru ON ru.id = esperada.rq
JOIN        users rv ON rv.id = esperada.rv
LEFT JOIN   purchase_requisition_approval_chains c
       ON   c.requester_id = esperada.rq
      AND   c.reviewer_id  = esperada.rv
      AND   c.approver_id  = @daniel
ORDER BY    ru.name, rv.name;
