<?php

namespace App\Providers\Filament;

use App\Filament\Resources\RoleResource;
use App\Http\Middleware\CompanySession;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Hugomyb\FilamentErrorMailer\FilamentErrorMailerPlugin;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Vite;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PurchasesPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('compras')
            ->path('compras')
            ->defaultThemeMode(ThemeMode::Light)
            // ->databaseNotifications()
            ->maxContentWidth(Width::Full)
            ->sidebarFullyCollapsibleOnDesktop()
            // ->unsavedChangesAlerts()
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->spaUrlExceptions([
                '*/empresa/*',
            ])
            ->homeUrl('/home')
            ->globalSearch(false)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->bootUsing(function (Panel $panel) {})
            ->discoverResources(in: app_path('Filament/Purchases/Resources'), for: 'App\\Filament\\Purchases\\Resources')
            ->resources([
                RoleResource::class,
            ])
            ->discoverPages(in: app_path('Filament/Purchases/Pages'), for: 'App\\Filament\\Purchases\\Pages')
            ->pages([])
            ->discoverWidgets(in: app_path('Filament/Purchases/Widgets'), for: 'App\\Filament\\Purchases\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->userMenuItems([
                'logout' => MenuItem::make()
                    ->label('Salir')
                    ->url(fn (): string => route('logout'))
                    ->icon('heroicon-o-arrow-left-start-on-rectangle'),
            ])
            ->renderHook(
                PanelsRenderHook::USER_MENU_BEFORE,
                fn (): View => view('hooks.topbar-menu'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_START,
                fn (): View => view('hooks.impersonation-banner'),
            )
            ->renderHook(
                PanelsRenderHook::SCRIPTS_AFTER,
                fn (): Htmlable => app(Vite::class)('resources/js/progress-approval.js'),
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                CompanySession::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentErrorMailerPlugin::make(),
                FilamentShieldPlugin::make(),
            ]);
    }
}
