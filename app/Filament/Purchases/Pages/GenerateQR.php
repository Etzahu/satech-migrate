<?php

namespace App\Filament\Purchases\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use LaraZeus\Qr\Components\Qr;
use Filament\Forms\Contracts\HasForms;
use LaraZeus\Qr\Facades\Qr as FacadeQr;
use Filament\Forms\Concerns\InteractsWithForms;

class GenerateQR extends Page implements HasForms
{

    protected static ?string $navigationIcon = 'heroicon-m-qr-code';
    protected static string $view = 'filament.purchases.pages.generate-q-r';
    protected static ?int $navigationSort = 2;
    public ?array $data = [];

    protected static ?string $navigationLabel = 'QR';

    protected static ?string $title = 'QR';

    public string $qrcode;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                       FacadeQr::getFormSchema(
                            statePath: 'enlace',
                            optionsStatePath: 'text-options'
                        ),
                    ]),
            ]);
    }
}
