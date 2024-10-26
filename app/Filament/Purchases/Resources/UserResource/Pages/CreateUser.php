<?php

namespace App\Filament\Purchases\Resources\UserResource\Pages;

use App\Filament\Purchases\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
