<?php

namespace App\Filament\Purchases\Pages;

use App\Services\GuideCatalog;
use Filament\Pages\Page;

class Guides extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected string $view = 'filament.purchases.pages.guides';

    protected static ?string $navigationLabel = 'Guías de uso';

    protected static ?string $title = 'Guías de uso';

    protected static ?int $navigationSort = 1;

    /**
     * Guías que se listan en la página.
     *
     * La lista vive en GuideCatalog porque la comparte con la invitación por
     * correo que se envía desde la ficha del usuario. Aquí se muestran todas:
     * el filtro por rol existe en `GuideCatalog::forUser()` y por ahora solo lo
     * usa la invitación para premarcar las que le tocan a cada quien.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getGuides(): array
    {
        return app(GuideCatalog::class)->all();
    }
}
