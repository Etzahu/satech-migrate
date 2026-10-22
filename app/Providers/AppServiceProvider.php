<?php

namespace App\Providers;

use App\Models\PurchaseOrder;
use App\Models\User;
use App\Observers\PurchaseOrderObserver;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Form;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\FileUploadConfiguration;

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

        // El navegador conoce el mismo límite que el servidor: FilePond rechaza el
        // archivo antes de enviarlo con "El archivo es demasiado grande · El tamaño
        // máximo del archivo es 10 MB". Sin él, el archivo viajaba al servidor y
        // Livewire respondía "Subir data.supports.<uuid> ha fallado".
        FileUpload::configureUsing(fn (FileUpload $upload): FileUpload => $upload->maxSize($this->maxUploadKilobytes()));

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

    /**
     * Tamaño máximo en KB que el servidor acepta por archivo: el menor entre la
     * regla de subida temporal de Livewire, los límites de PHP y el de Media
     * Library. Se redondea a MB completos porque FilePond muestra el límite en
     * base 1000 y 10240 KB aparecería como "10.2 MB".
     */
    protected function maxUploadKilobytes(): ?int
    {
        $livewireMaxRule = collect(FileUploadConfiguration::rules())
            ->first(fn (mixed $rule): bool => is_string($rule) && str_starts_with($rule, 'max:'));

        $kilobytes = (int) collect([
            $livewireMaxRule ? (int) Str::after($livewireMaxRule, 'max:') : null,
            ini_parse_quantity(ini_get('upload_max_filesize')) / 1024,
            ini_parse_quantity(ini_get('post_max_size')) / 1024,
            config('media-library.max_file_size') / 1024,
        ])->filter()->min();

        if ($kilobytes >= 1000) {
            return intdiv($kilobytes, 1000) * 1000;
        }

        return $kilobytes ?: null;
    }
}
