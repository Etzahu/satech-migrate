<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;

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
        Gate::define('see-sent-emails', function (User $user,) {
            return $user->hasRole('super_admin');
        });
            // Mail::alwaysTo('ahernandezm@gptservices.com');
        // if ($this->app->environment('local')) {
        //     Mail::alwaysTo('ahernandezm@gptservices.com');
        // }
        FilamentView::registerRenderHook(
            PanelsRenderHook::USER_MENU_BEFORE  ,
            fn (): View => view('hooks.topbar-menu'),
        );
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_START,
            fn (): View => view('hooks.impersonation-banner'),
        );
    }
}
