<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Brick\Money\Money as BrickMoney;

class OrderCalculationService
{
    public $order;

    public $localeOptions = ['MXN' => 'es_MX', 'USD' => 'en_US'];

    public $locale;

    public function __construct($id = null)
    {
        if (filled($id)) {
            $this->order = PurchaseOrder::with(['items'])->find($id);
            $this->locale = $this->localeOptions[$this->order->currency];
        }
    }

    /**
     * Formatea un valor para mostrar en vistas/PDF.
     * Internamente los montos se almacenan con 4 decimales (entero × 10000).
     * Este método convierte y muestra con 2 decimales.
     */
    public function brickFormatter($value)
    {
        if (! $value instanceof BigDecimal) {
            $value = BigDecimal::of($value)->dividedBy(10000, 4);
            $value = $value->toScale(2, RoundingMode::CEILING);
        }

        $amount = BrickMoney::of($value->__toString(), $this->order->currency);

        return $amount->formatTo($this->locale);
    }

    public function getSubtotalItems($formatter = false)
    {
        $subtotal = 0;
        foreach ($this->order->items as $item) {
            $subtotal += $item->sub_total;
        }

        $subtotal = BigDecimal::of($subtotal)->dividedBy(10000, 4, RoundingMode::CEILING);
        $subtotal = $subtotal->toScale(2, RoundingMode::CEILING);

        return $formatter ? $this->brickFormatter($subtotal) : $subtotal;
    }

    public function getDiscountProvider($formatter = false)
    {
        $total = BigDecimal::of($this->order->discount)->dividedBy(10000, 4, RoundingMode::CEILING);
        $total = $total->toScale(2, RoundingMode::CEILING);

        return $formatter ? $this->brickFormatter($total) : $total;
    }

    public function subtotalDiscount($formatter = false)
    {
        $total = $this->getSubtotalItems()->minus($this->getDiscountProvider());

        return $formatter ? $this->brickFormatter($total) : $total;
    }

    public function getTaxIva($formatter = false)
    {
        $result = $this->subtotalDiscount()->multipliedBy($this->order->tax_iva / 100);
        $result = $result->toScale(2, RoundingMode::CEILING);

        return $formatter ? $this->brickFormatter($result) : $result;
    }

    public function getRetentionIva($formatter = false)
    {
        $result = $this->subtotalDiscount()->multipliedBy($this->order->retention_iva / 100);
        $result = $result->toScale(2, RoundingMode::CEILING);

        return $formatter ? $this->brickFormatter($result) : $result;
    }

    public function getRetentionIsr($formatter = false)
    {
        $result = $this->subtotalDiscount()->multipliedBy($this->order->retention_isr / 100);
        $result = $result->toScale(2, RoundingMode::CEILING);

        return $formatter ? $this->brickFormatter($result) : $result;
    }

    public function getTotal($formatter = false)
    {
        $total = $this->subtotalDiscount()
            ->plus($this->getTaxIva())
            ->minus($this->getRetentionIva())
            ->minus($this->getRetentionIsr());

        return $formatter ? $this->brickFormatter($total) : $total;
    }

    public function isOrderTotalBetweenLimits(): bool
    {
        [$minAmount, $maxAmount] = match ($this->order->currency) {
            'USD' => [1, 15000],
            'MXN' => [1, 300000],
            default => [0, 0],
        };

        $total = $this->getTotal();

        return $total->isGreaterThanOrEqualTo($minAmount) && $total->isLessThanOrEqualTo($maxAmount);
    }
}
