<?php

namespace App\Providers;

use App\Models\PurchaseOrder;
use App\Models\User;
use App\Observers\PurchaseOrderObserver;
use Filament\Schemas\Components\Form;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar Observer para PurchaseOrder
        PurchaseOrder::observe(PurchaseOrderObserver::class);

        // Sin validación nativa del navegador: si un campo inválido (un decimal en
        // un número entero, una fecha a medias) queda en un tab inactivo, Chrome no
        // puede enfocarlo y bloquea el envío en silencio ("An invalid form control
        // is not focusable"). Filament ya valida las mismas reglas en el servidor
        // y abre el tab donde está el error.
        Form::configureUsing(fn (Form $form): Form => $form->extraAttributes(['novalidate' => true], merge: true));

        Gate::define('viewLogViewer', function (?User $user) {

            return $user->hasRole('super_admin');
        });

        Gate::define('see-sent-emails', function (User $user) {

            return $user->hasRole('super_admin');
        });

        Gate::define('audit', function (User $user) {
            return $user->hasRole('super_admin');
        });
        // Mail::alwaysTo('ahernandezm@gptservices.com');
        // if ($this->app->environment('local')) {
        //     Mail::alwaysTo('ahernandezm@gptservices.com');
        // }
        // FilamentView::registerRenderHook(
        //     PanelsRenderHook::USER_MENU_BEFORE  ,
        //     fn (): View => view('hooks.topbar-menu'),
        // );
        // FilamentView::registerRenderHook(
        //     PanelsRenderHook::BODY_START,
        //     fn (): View => view('hooks.impersonation-banner'),
        // );
    }
}
