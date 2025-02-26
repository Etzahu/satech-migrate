<?php

namespace App\Filament\Purchases\Resources;

use Vormkracht10\FilamentMails\Resources\MailResource;

class MailCustomResource extends MailResource
{

    // Si comento estas lineas no sale el error Call to a member function keyBy() on null
    public static function canAccess(): bool
    {
        if (config('app.env') === 'local' && config('app.debug') === true) {
            return true;
        } else {
            return  auth()->user()->hasRole('super_admin');
        }
    }

    protected static bool $shouldRegisterNavigation = true;
}
