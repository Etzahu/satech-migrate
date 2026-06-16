<?php

namespace App\Filament\Purchases\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected string $view = 'filament.purchases.pages.dashboard';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'Inicio';

    protected static ?string $navigationLabel = 'Inicio';

    protected static ?int $navigationSort = -1;
}
