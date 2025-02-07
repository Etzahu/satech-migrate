<?php

namespace App\Filament\Purchases\Resources;

use Vormkracht10\FilamentMails\Resources\MailResource;

class MailCustomResource extends MailResource
{
    public static function canAccess(): bool
    {
        return  auth()->user()->hasRole('super_admin');
    }

    protected static bool $shouldRegisterNavigation = true;
}
