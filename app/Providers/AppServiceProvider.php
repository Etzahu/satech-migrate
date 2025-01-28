<?php

namespace App\Providers;

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
            // Mail::alwaysTo('ahernandezm@gptservices.com');
        // if ($this->app->environment('local')) {
        //     Mail::alwaysTo('ahernandezm@gptservices.com');
        // }
        FilamentView::registerRenderHook(
            PanelsRenderHook::USER_MENU_BEFORE,
            fn (): View => view('hooks.topbar-company-text'),
        );
        FilamentView::registerRenderHook(
            PanelsRenderHook::USER_MENU_BEFORE  ,
            fn (): View => view('hooks.topbar-menu'),
        );
    }
}
