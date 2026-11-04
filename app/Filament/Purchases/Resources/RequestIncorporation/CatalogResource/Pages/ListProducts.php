<?php

namespace App\Filament\Purchases\Resources\RequestIncorporation\CatalogResource\Pages;

use App\Filament\Purchases\Resources\RequestIncorporation\CatalogResource;
use App\Imports\CatalogProductImport;
use App\Mail\CatalogBulkNotification;
use App\Models\Product;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ListProducts extends ListRecords
{
    protected static string $resource = CatalogResource::class;

    /**
     * Errores que caben en la notificación; el resto se resume en un conteo.
     */
    private const VISIBLE_IMPORT_ERRORS = 10;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Solicitar'),
            $this->importFromExcelAction(),
        ];
    }

    private function importFromExcelAction(): Actions\Action
    {
        return Actions\Action::make('importFromExcel')
            ->label('Importar desde Excel')
            ->icon(Heroicon::OutlinedArrowUpTray)
            ->color('gray')
            ->visible(fn (): bool => CatalogResource::canCreate())
            ->modalHeading('Solicitar altas desde Excel')
            ->modalDescription('Descarga la plantilla, captura un producto o servicio por fila (máximo '.CatalogProductImport::MAX_ROWS.') y súbela. Si alguna fila tiene un error no se registra ninguna, para que corrijas y vuelvas a subir el mismo archivo.')
            ->modalSubmitActionLabel('Importar')
            ->schema([
                FileUpload::make('file')
                    ->label('Archivo de Excel (.xlsx)')
                    ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                    ->storeFiles(false)
                    ->required(),
            ])
            ->extraModalFooterActions([
                Actions\Action::make('downloadTemplate')
                    ->label('Descargar plantilla')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->color('gray')
                    ->action(fn (): StreamedResponse => (new CatalogProductImport)->downloadTemplate()),
            ])
            ->action(function (array $data, Actions\Action $action): void {
                $result = (new CatalogProductImport)->import(
                    $data['file'],
                    (int) session()->get('company_id'),
                    auth()->id(),
                );

                if ($result['errors'] !== []) {
                    Notification::make()
                        ->danger()
                        ->title('No se registró ningún elemento')
                        ->body($this->importErrorsSummary($result['errors']))
                        ->persistent()
                        ->send();

                    $action->halt();
                }

                $count = $result['products']->count();
                $purchasingWasNotified = $this->notifyPurchasing($result['products']);

                Notification::make()
                    ->success()
                    ->title($count === 1 ? 'Se registró 1 elemento' : "Se registraron {$count} elementos")
                    ->body($purchasingWasNotified
                        ? 'Quedaron pendientes de aprobación por Compras.'
                        : 'Quedaron pendientes de aprobación, pero no se pudo enviar el aviso por correo a Compras.')
                    ->send();
            });
    }

    /**
     * Un solo correo a Compras con todo lo importado, a los mismos roles que
     * avisa el alta individual.
     *
     * @param  Collection<int, Product>  $products
     */
    private function notifyPurchasing(Collection $products): bool
    {
        $recipients = User::withRole(['gerente_compras', 'administrador_compras'])
            ->pluck('email')
            ->filter()
            ->unique()
            ->values()
            ->all();

        if ($recipients === []) {
            return true;
        }

        try {
            Mail::to($recipients)->send(new CatalogBulkNotification($products->load('company', 'requester', 'unit')));
        } catch (Throwable $exception) {
            report($exception);

            return false;
        }

        return true;
    }

    /**
     * @param  list<string>  $errors
     */
    private function importErrorsSummary(array $errors): string
    {
        $visibleErrors = array_map(e(...), array_slice($errors, 0, self::VISIBLE_IMPORT_ERRORS));
        $hiddenErrorCount = count($errors) - count($visibleErrors);

        if ($hiddenErrorCount > 0) {
            $visibleErrors[] = $hiddenErrorCount === 1 ? '… y 1 error más.' : "… y {$hiddenErrorCount} errores más.";
        }

        return implode('<br>', $visibleErrors);
    }
}
