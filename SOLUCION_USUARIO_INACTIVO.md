# Solución Completa: Usuario que Ya No Trabaja

## 🎯 Problema

Cuando un usuario renuncia o es dado de baja, puede estar presente en **múltiples roles** dentro de las cadenas de aprobación:

-   **Reviewer** (Revisa)
-   **Approver** (Aprueba)
-   **Authorizer** (Autoriza)

Las requisiciones pendientes quedan bloqueadas en cualquiera de estos roles.

## ✅ Solución Completa en 3 Pasos

### Paso 1: Detectar el Impacto

```bash
# Ver en qué cadenas aparece el usuario y qué requisiciones están pendientes
php artisan requisitions:detect-blocked --export
```

### Paso 2: Analizar el Usuario Específico

```bash
# Opción A: Comando completo que detecta TODOS los roles
php artisan requisitions:replace-user --old-user-id=53 --dry-run

# Te mostrará:
# - En qué roles aparece (reviewer/approver/authorizer)
# - Cuántas cadenas en cada rol
# - Requisiciones pendientes por rol
```

### Paso 3: Reemplazar el Usuario

```bash
# Si el usuario aparece en los 3 roles (ejemplo: usuario 53)
php artisan requisitions:replace-user \
    --old-user-id=53 \
    --new-reviewer-id=10 \
    --new-approver-id=11 \
    --new-authorizer-id=12 \
    --reset

# Si solo aparece en algunos roles, usa solo esos parámetros
# Por ejemplo, si solo es reviewer:
php artisan requisitions:replace-user \
    --old-user-id=53 \
    --new-reviewer-id=10 \
    --reset
```

## 📋 Comando: `requisitions:replace-user`

Este nuevo comando **detecta automáticamente** en qué roles está el usuario y los reemplaza todos de una vez.

### Parámetros

| Parámetro             | Descripción                       | Obligatorio    |
| --------------------- | --------------------------------- | -------------- |
| `--old-user-id`       | ID del usuario que se va          | ✅ Sí          |
| `--new-reviewer-id`   | Nuevo usuario para rol reviewer   | Solo si aplica |
| `--new-approver-id`   | Nuevo usuario para rol approver   | Solo si aplica |
| `--new-authorizer-id` | Nuevo usuario para rol authorizer | Solo si aplica |
| `--reset`             | Regresar requisiciones al inicio  | ⭐ Recomendado |
| `--dry-run`           | Simular sin cambios               | Opcional       |

### Flujo del Comando

1. **Detecta** en qué roles aparece el usuario
2. **Muestra** resumen de cadenas y requisiciones afectadas
3. **Valida** que proporcionaste los nuevos usuarios necesarios
4. **Solicita confirmación**
5. **Ejecuta** el reemplazo en todos los roles
6. **Resetea** requisiciones al inicio (si usas `--reset`)

## 🔧 Ejemplos Prácticos

### Ejemplo 1: Usuario 53 que renuncia

```bash
# 1. Primero analizar (dry-run)
php artisan requisitions:replace-user --old-user-id=53 --dry-run

# Salida:
# Rol              | Cadenas | IDs de Cadenas
# Reviewer         | 4       | 91, 92, 97, 104
# Approver         | 2       | 45, 78
# Authorizer       | 0       | N/A
#
# ⚠ Requisiciones pendientes:
# Rol      | Estado            | Cantidad | Folios
# Reviewer | revisión          | 1        | G-MTTO-2025-0119
# Approver | aprobado por rev. | 3        | G-MTTO-2025-0115, ...

# 2. Ejecutar reemplazo
php artisan requisitions:replace-user \
    --old-user-id=53 \
    --new-reviewer-id=10 \
    --new-approver-id=11 \
    --reset
```

### Ejemplo 2: Usuario solo como Reviewer

```bash
php artisan requisitions:replace-user \
    --old-user-id=25 \
    --new-reviewer-id=30 \
    --reset
```

### Ejemplo 3: Sin Resetear (mantener estados)

```bash
# Reemplazar sin regresar al inicio
# Las requisiciones continúan en su estado actual
php artisan requisitions:replace-user \
    --old-user-id=53 \
    --new-reviewer-id=10 \
    --new-approver-id=11
```

## 🔄 ¿Cuándo Usar `--reset`?

### ✅ USA `--reset` cuando:

-   El nuevo usuario debe revisar desde cero
-   Hubo cambios en el proceso o políticas
-   Quieres asegurar revisión completa
-   **RECOMENDADO en la mayoría de casos**

### ❌ NO uses `--reset` cuando:

-   El nuevo usuario solo sustituye temporalmente
-   Ya se revisó gran parte del proceso
-   Urgencia de aprobación

## 📊 Proceso Completo Recomendado

### Antes de Dar de Baja un Usuario

```bash
# 1. Verificar impacto
php artisan requisitions:replace-user --old-user-id=53 --dry-run

# 2. Si tiene requisiciones pendientes, reasignar
php artisan requisitions:replace-user \
    --old-user-id=53 \
    --new-reviewer-id=10 \
    --new-approver-id=11 \
    --new-authorizer-id=12 \
    --reset

# 3. Verificar que no quedaron bloqueadas
php artisan requisitions:detect-blocked

# 4. Ahora sí, dar de baja al usuario
# (soft delete en la tabla users)
```

## 🛠️ Comandos Disponibles

| Comando                       | Propósito                                 | Cuándo Usar                 |
| ----------------------------- | ----------------------------------------- | --------------------------- |
| `requisitions:detect-blocked` | Detectar requisiciones bloqueadas         | Auditoría general           |
| `requisitions:replace-user`   | **Reemplazar usuario en todos sus roles** | **Usuario que renuncia** ⭐ |
| `requisitions:reassign`       | Reasignar UN rol específico               | Casos puntuales             |

## 💡 Recomendaciones

1. **Siempre usar `--dry-run` primero** para ver el impacto
2. **Usar `--reset`** para asegurar revisión completa
3. **Exportar reportes** antes de cambios importantes
4. **Notificar** a los solicitantes de las requisiciones afectadas
5. **Documentar** el cambio (quién se fue, quién lo reemplazó)

## 🔍 Monitoreo Continuo

Programar verificación periódica:

```php
// En app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Verificar requisiciones bloqueadas cada lunes
    $schedule->command('requisitions:detect-blocked --export')
             ->weeklyOn(1, '08:00');
}
```

## ⚠️ Importante

-   Los cambios en cadenas de aprobación son **permanentes**
-   Las requisiciones con `--reset` vuelven al **inicio del proceso**
-   Los **emails de notificación** se envían según la state machine
-   El **historial de auditoría** se mantiene
