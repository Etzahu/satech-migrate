<?php

use Vormkracht10\FilamentMails\Resources\EventResource;
// use Vormkracht10\FilamentMails\Resources\MailResource;
use App\Filament\Purchases\Resources\MailCustomResource;
use Vormkracht10\FilamentMails\Resources\SuppressionResource;

return [
    'resources' => [
        'mail' => MailCustomResource::class,
        'event' => EventResource::class,
        'suppressions' => SuppressionResource::class,
    ],
];
