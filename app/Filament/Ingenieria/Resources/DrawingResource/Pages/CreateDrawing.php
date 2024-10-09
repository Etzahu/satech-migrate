<?php

namespace App\Filament\Ingenieria\Resources\DrawingResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Ingenieria\Resources\DrawingResource;

class CreateDrawing extends CreateRecord
{
    protected static string $resource = DrawingResource::class;
   
}
