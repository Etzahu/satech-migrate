<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use App\Http\Middleware\CompanySession;
use Filament\Navigation\NavigationItem;
use Shanerbaner82\PanelRoles\PanelRoles;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Hugomyb\FilamentErrorMailer\FilamentErrorMailerPlugin;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;


class PurchasesPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('compras')
            ->path('compras')
            // ->databaseNotifications()
            ->sidebarFullyCollapsibleOnDesktop()
            // ->unsavedChangesAlerts()
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->spaUrlExceptions([
                '*/empresa/*',
            ])
            ->globalSearch(false)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->bootUsing(function (Panel $panel) {})
            ->discoverResources(in: app_path('Filament/Purchases/Resources'), for: 'App\\Filament\\Purchases\\Resources')
            ->discoverPages(in: app_path('Filament/Purchases/Pages'), for: 'App\\Filament\\Purchases\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Purchases/Widgets'), for: 'App\\Filament\\Purchases\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->userMenuItems([
                'logout' => MenuItem::make()
                    ->label('Salir')
                    ->url(fn(): string => route('logout'))
                    ->icon('heroicon-o-arrow-left-start-on-rectangle'),
            ])
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
                CompanySession::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentErrorMailerPlugin::make(),
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
                PanelRoles::make()
                    ->restrictedRoles([
                        'super_admin',
                        'gerente_compras',
                        'solicita_requisicion_compra',
                        'revisa_almacen_requisicion_compra',
                        'revisa_requisicion_compra',
                        'aprueba_requisicion_compra',
                        'autoriza_requisicion_compra',
                        'comprador',
                        'gerente_solicitante_orden_compra',
                        'autoriza_nivel-1-orden_compra',
                        'autoriza_nivel-2-orden_compra'
                    ]),
            ]);
    }
}
