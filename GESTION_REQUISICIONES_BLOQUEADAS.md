# Gestión de Requisiciones Bloqueadas

## Problema

Cuando un usuario que forma parte de una cadena de aprobación renuncia o es dado de baja (soft delete), las requisiciones de compra que están pendientes de su revisión/aprobación quedan bloqueadas indefinidamente.

## Solución Implementada

Se han agregado herramientas para detectar y reasignar requisiciones bloqueadas:

### 1. Métodos en el Modelo PurchaseRequisition

#### `isBlockedByInactiveUser(): bool`

Verifica si la requisición está bloqueada por un usuario inactivo.

```php
$requisition = PurchaseRequisition::find(1);
if ($requisition->isBlockedByInactiveUser()) {
    // La requisición está bloqueada
}
```

#### `getCurrentApprover(): ?User`

Obtiene el usuario que actualmente debería aprobar la requisición según su estado.

```php
$requisition = PurchaseRequisition::find(1);
$approver = $requisition->getCurrentApprover();
```

#### `reassignApprovalChain(int $newApprovalChainId, bool $resetToStart = false): bool`

Reasigna la requisición a una nueva cadena de aprobación.

```php
// Solo reasignar cadena, mantener estado actual
$requisition->reassignApprovalChain(5);

// Reasignar cadena Y regresar al inicio
$requisition->reassignApprovalChain(5, true);
```

#### `reassignAndReset(int $newApprovalChainId): bool`

Método de conveniencia que reasigna y resetea en un solo paso.

```php
// Reasignar cadena y regresar al estado inicial
$requisition->reassignAndReset(5);
```

#### `resetToInitialState(): void`

Regresa la requisición al estado inicial según su categoría.

```php
$requisition->resetToInitialState();
$requisition->save();
```

#### Scope `scopeBlockedByInactiveUsers()`

Filtra requisiciones bloqueadas por usuarios inactivos.

```php
$blocked = PurchaseRequisition::blockedByInactiveUsers()->get();
```

### 2. Métodos en PurchaseRequisitionApprovalChain

#### `updateApprovalRole(string $role, int $newUserId): bool`

Actualiza un rol específico en la cadena de aprobación.

```php
$chain = PurchaseRequisitionApprovalChain::find(1);
$chain->updateApprovalRole('reviewer', 10); // Nuevo reviewer ID 10
```

#### `getInactiveUsers(): array`

Devuelve un array con los roles que tienen usuarios inactivos.

```php
$chain = PurchaseRequisitionApprovalChain::find(1);
$inactive = $chain->getInactiveUsers();
// ['reviewer' => 5, 'approver' => 8]
```

#### `getPendingRequisitionsCount(): int`

Cuenta las requisiciones pendientes para esta cadena.

```php
$count = $chain->getPendingRequisitionsCount();
```

## Comandos Artisan

### 1. Detectar Requisiciones Bloqueadas

```bash
# Detectar todas las requisiciones bloqueadas
php artisan requisitions:detect-blocked

# Detectar por compañía específica
php artisan requisitions:detect-blocked --company-id=1

# Exportar resultados a CSV
php artisan requisitions:detect-blocked --export
```

**Salida del comando:**

-   Lista de requisiciones bloqueadas con detalles
-   Resumen agrupado por cadena de aprobación
-   Comandos sugeridos para reasignar
-   Archivo CSV (opcional)

### 2. Reasignar Requisiciones

```bash
# Reasignar y REGRESAR al inicio del proceso (recomendado)
php artisan requisitions:reassign \
    --user-id=5 \
    --role=reviewer \
    --new-user-id=10 \
    --reset

# Reasignar SIN regresar al inicio (mantener estado actual)
php artisan requisitions:reassign \
    --user-id=5 \
    --role=reviewer \
    --new-user-id=10

# Reasignar una cadena específica y resetear
php artisan requisitions:reassign \
    --user-id=5 \
    --role=reviewer \
    --new-user-id=10 \
    --chain-id=3 \
    --reset

# Modo dry-run (simular sin guardar cambios)
php artisan requisitions:reassign \
    --user-id=5 \
    --role=reviewer \
    --new-user-id=10 \
    --reset \
    --dry-run
```

**Parámetros:**

-   `--user-id`: ID del usuario que está inactivo
-   `--role`: Rol a reasignar (`reviewer`, `approver`, `authorizer`)
-   `--new-user-id`: ID del nuevo usuario asignado
-   `--chain-id`: (Opcional) ID de cadena específica
-   `--reset`: **NUEVO** - Regresa las requisiciones al estado inicial
-   `--dry-run`: Simular sin hacer cambios

## Flujo de Trabajo Recomendado

### Cuando un Usuario Renuncia

1. **Detectar impacto:**

```bash
php artisan requisitions:detect-blocked --export
```

2. **Revisar el reporte** para identificar:

    - Requisiciones afectadas
    - Cadenas de aprobación involucradas
    - Días que llevan bloqueadas

3. **Reasignar requisiciones:**

```bash
# Primero en modo dry-run para verificar
php artisan requisitions:reassign \
    --user-id=5 \
    --role=reviewer \
    --new-user-id=10 \
    --reset \
    --dry-run

# Si todo está correcto, ejecutar sin dry-run
# Con --reset las requisiciones vuelven al inicio para nueva revisión completa
php artisan requisitions:reassign \
    --user-id=5 \
    --role=reviewer \
    --new-user-id=10 \
    --reset
```

4. **Verificar** que las requisiciones se procesaron:

```bash
php artisan requisitions:detect-blocked
```

## Uso Programático

### En un Controlador o Servicio

```php
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionApprovalChain;

// Detectar requisiciones bloqueadas
$blocked = PurchaseRequisition::blockedByInactiveUsers()
    ->with('approvalChain.reviewer', 'approvalChain.approver', 'approvalChain.authorizer')
    ->get();

foreach ($blocked as $requisition) {
    $currentApprover = $requisition->getCurrentApprover();

    // Notificar al administrador
    // Registrar en log
    // Enviar alerta
}

// Reasignar una cadena completa y resetear requisiciones
$chain = PurchaseRequisitionApprovalChain::find(1);
$chain->updateApprovalRole('reviewer', 10);
$chain->updateApprovalRole('approver', 11);

// Resetear todas las requisiciones pendientes de esa cadena
$chain->requisitions()
    ->whereIn('status', ['revisión', 'aprobado por revisor'])
    ->each(function ($requisition) {
        $requisition->resetToInitialState();
        $requisition->save();
    });

// O usar el método de conveniencia en cada requisición
$requisition = PurchaseRequisition::find(1);
$requisition->reassignAndReset(5); // Nueva cadena y reset en un paso
```

### Crear un Job Programado

En `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Detectar requisiciones bloqueadas cada día
    $schedule->command('requisitions:detect-blocked --export')
             ->daily()
             ->at('08:00');
}
```

## Consideraciones Importantes

1. **Soft Deletes**: Asegúrate de que el modelo `User` tenga soft deletes habilitado
2. **Permisos**: Solo usuarios con permisos administrativos deberían ejecutar estos comandos
3. **Notificaciones**: Considera notificar a los solicitantes cuando sus requisiciones sean reasignadas
4. **Auditoría**: Los cambios en las cadenas de aprobación quedan registrados en el modelo
5. **Reseteo de Estado**: Usar `--reset` regresa la requisición al inicio:
    - Para **servicios** (compañía 2): regresa a `revisión`
    - Para **proveeduría** y otros: regresa a `revisión por almacén`
    - Esto permite que el nuevo aprobador revise desde cero

## Prevención

Para evitar este problema en el futuro:

1. **Antes de dar de baja un usuario**, ejecutar:

```bash
php artisan requisitions:detect-blocked
```

2. **Reasignar proactivamente** las requisiciones pendientes

3. **Validar** que el usuario no tenga requisiciones pendientes antes del soft delete

4. **Monitoreo continuo** con el comando programado
