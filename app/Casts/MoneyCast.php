<?php

namespace App\Casts;

use Brick\Money\Money;
use Money\MoneyParser;
use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Brick\Money\Context\CustomContext;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class MoneyCast implements CastsAttributes
{

    private $scale = 4;
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_null($value)) {
            return null;
        }

        // return BigDecimal::of($value)->dividedBy(10000, 4)->toFloat();
        return BigDecimal::of($value)->dividedBy(10000, 4)->toBigDecimal();
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_null($value)) {
            return 0;
        }
        $value = BigDecimal::of($value)->toScale(4);
        return  $value->multipliedBy(10000)->toInt(); // 1234567
    }
}
