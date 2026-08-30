<?php

namespace App\Filament\Purchases\Pages;

use App\Services\StalledOrderService;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

/**
 * Reporte de antigüedad de las órdenes de compra detenidas.
 *
 * Separa a propósito dos cosas que se confunden al mirar una bandeja llena:
 * las órdenes que esperan la firma de alguien y las que están en cancha del
 * comprador. Solo las primeras significan que el flujo está atorado.
 *
 * Toda la lógica vive en StalledOrderService, que es lo mismo que usa
 * `php artisan orders:report-stalled`.
 */
class StalledOrders extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clock';

    protected string $view = 'filament.purchases.pages.stalled-orders';

    protected static ?string $navigationLabel = 'Órdenes detenidas';

    protected static ?string $title = 'Antigüedad de órdenes detenidas';

    protected static string|\UnitEnum|null $navigationGroup = 'Administración';

    protected static ?int $navigationSort = 101;

    public bool $soloEsperandoDecision = false;

    public bool $soloConProblema = false;

    public static function canAccess(): bool
    {
        $user = auth()->user();

        return $user?->hasRole('gerente_compras')
            || $user?->hasRole('administrador_compras')
            || $user?->hasRole('super_admin')
            || false;
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function getFilas(): Collection
    {
        $filas = app(StalledOrderService::class)->stalled(session()->get('company_id'));

        if ($this->soloEsperandoDecision) {
            $filas = $filas->where('esperando_decision', true);
        }

        if ($this->soloConProblema) {
            $filas = $filas->whereNotNull('problema');
        }

        return $filas->values();
    }

    /**
     * @return array<string, int>
     */
    public function getResumen(): array
    {
        $todas = app(StalledOrderService::class)->stalled(session()->get('company_id'));

        return [
            'total' => $todas->count(),
            'esperando' => $todas->where('esperando_decision', true)->count(),
            'comprador' => $todas->where('esperando_decision', false)->count(),
            'problema' => $todas->whereNotNull('problema')->count(),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $problema = app(StalledOrderService::class)
            ->stalled(session()->get('company_id'))
            ->whereNotNull('problema')
            ->count();

        return $problema > 0 ? (string) $problema : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}
