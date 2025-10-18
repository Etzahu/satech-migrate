# Copilot Instructions for Satech Purchase Management System

## Architecture Overview

This is a **Laravel 11 + Filament 3** purchase management system with multi-panel architecture and state machine workflows.

### Core Panels & Structure

-   **Multiple Filament Panels**: `compras` (purchases), `ingenieria`, `admin`, `warehouse`
-   **Multi-Company Support**: Session-based company switching via `CompanySession` middleware
-   **State Machine Workflows**: Purchase orders and requisitions use `asantibanez/laravel-eloquent-state-machines`
-   **Money Handling**: Uses `brick/money` with custom `MoneyCast` storing amounts as integers (multiply by 10000)

## Key Patterns & Conventions

### State Machines (`app/StateMachines/`)

-   Spanish state names: `'borrador'`, `'revisión gerente de compras'`, `'aprobado por gerente de compras'`
-   Email notifications triggered in `afterTransitionHooks()` using `OrderService::generateDataEmail()`
-   Currency-based approval limits: USD $15,000 / MXN $300,000 for escalation

### Services Layer (`app/Services/`)

-   **OrderService**: Folio generation, PDF creation, email data preparation
-   **OrderCalculationService**: Money calculations with multi-currency support
-   **PurchaseRequisitionChainService**: Approval chain management

### Money Handling

-   Use `MoneyCast` for database storage (stores as integers × 10000)
-   Helper function: `moneyFormatter($value, $currency, $decimals)` for display
-   Currencies: `'MXN'`, `'USD'` with locale-specific formatting

### Filament Resources

-   Panel-specific resources in `app/Filament/{PanelName}/Resources/`
-   Role-based access control: `canAccess()` checks roles like `'gerente_compras'`
-   Navigation badges show pending counts: `getNavigationBadge()`

### Authentication & Authorization

-   Google OAuth integration via Laravel Socialite
-   Spatie Permission roles: `super_admin`, `gerente_compras`, `administrador_compras`
-   Company session management for multi-tenant behavior

## Development Workflows

### State Machine Transitions

```php
// Add new state transitions in StateMachine classes
'new_state' => ['next_state_1', 'next_state_2'],

// Add email notifications in afterTransitionHooks
'new_state' => [function ($to, $model) {
    $service = new OrderService();
    $data = $service->generateDataEmail($model->id, 'estado_type');
    // Send notifications
}]
```

### Adding Money Fields

```php
// In migrations
$table->unsignedBigInteger('amount')->default(0);

// In models
protected $casts = ['amount' => MoneyCast::class];

// In views/PDFs
{!! moneyFormatter($model->amount, $model->currency, 2) !!}
```

### PDF Generation

-   Uses `spatie/laravel-pdf` with Browsershot
-   Templates in `resources/views/pdf/`
-   Generate via `OrderService::generatePdf($model)`

### Testing

-   Run tests: `php artisan test`
-   Test database: SQLite for local development

## Critical Dependencies

-   **Filament Admin Panel**: UI framework with custom panels
-   **State Machines**: Business process workflows
-   **Money/Currency**: Brick\Money for precision calculations
-   **Media Library**: Spatie for file attachments
-   **Auditing**: OwenIt for change tracking
-   **Role/Permissions**: Spatie for access control

## File Organization

-   **Models**: Standard Eloquent with state machine traits
-   **Filament**: Panel-specific organization in subdirectories
-   **Mail**: Notification classes per business process
-   **Helpers**: `helpers_money.php` autoloaded for currency formatting
