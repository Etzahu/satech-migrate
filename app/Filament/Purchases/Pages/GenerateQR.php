<?php

namespace App\Filament\Purchases\Pages;

use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas;
use Filament\Schemas\Schema;
use LaraZeus\Qr\Facades\Qr;

class GenerateQR extends Page implements HasForms
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-m-qr-code';

    protected string $view = 'filament.purchases.pages.generate-q-r';

    protected static ?int $navigationSort = 2;

    public ?array $data = [];

    protected static ?string $navigationLabel = 'QR';

    protected static ?string $title = 'QR';

    public string $qrcode;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->statePath('data')
            ->schema([
                Schemas\Components\Section::make()
                    ->schema([
                        ...Qr::getFormSchema(
                            statePath: 'enlace',
                            optionsStatePath: 'text-options'
                        ),
                    ]),
            ]);
    }
}
