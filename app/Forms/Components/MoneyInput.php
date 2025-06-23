<?php

namespace App\Forms\Components;

use Brick\Math\BigDecimal;
use Brick\Money\Context\CustomContext;
use Brick\Money\Money;
use Filament\Forms\Components\Field;
use NumberFormatter;

class MoneyInput extends Field
{
    protected string $view = 'forms.components.money-input';

    protected function setUp(): void
    {
        parent::setUp();
        $this->formatStateUsing(function ($state) {
            if (blank($state)) {
                return '0.0000';
            }
            $state = BigDecimal::of($state)->dividedBy(10000, 4);
            return (string) $state;
        });
        $this->dehydrateStateUsing(function ($state) {
            if (blank($state)) {
                return 0;
            }
            $state = str()->trim($state);

            $state = BigDecimal::of($state)->toScale(4);
            return  $state->multipliedBy(10000)->toInt();
        });
    }
}
