<?php

namespace App\Services;

use Money\Currency;
use App\Models\Company;
use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use Money\Currencies\ISOCurrencies;
use Brick\Money\Context\CashContext;
use Brick\Money\Money as BrickMoney;
use Brick\Money\Context\CustomContext;
use Money\Formatter\IntlMoneyFormatter;

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
    // public function moneyFormatter($value)
    // {
    //     // Se utiliza por ejemplo para imprimir en una vista blade, PDF
    //     $currencies = new ISOCurrencies();
    //     $numberFormatter = new \NumberFormatter($this->locale, \NumberFormatter::CURRENCY);
    //     $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
    //     $numberFormatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, 4); // Mínimo 4 decimales
    //     $numberFormatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 4); // Máximo 4 decimales
    //     return $moneyFormatter->format($value);
    // }
    // public function getSubtotalItems($formatter = false)
    // {
    //     $items = $this->order->items;
    //     $subtotal =  new Money(0, new Currency($this->order->currency));
    //     foreach ($items as $item) {
    //         $subtotal = $subtotal->add(new Money($item->sub_total, new Currency($this->order->currency)));
    //     }
    //     // $total =  $subtotal->subtract($this->getDiscountProvider());
    //     $total =  $subtotal;
    //     return $formatter ? $this->moneyFormatter($total) : $total;
    // }

    // public function subtotalDiscount($formatter = false)
    // {
    //     $subtotal = $this->getSubtotalItems();
    //     $total = $subtotal->subtract($this->getDiscountProvider());

    //     return $formatter ? $this->moneyFormatter($total) : $total;
    // }

    // public function getTaxIva($formatter = false)
    // {
    //     $subtotal = $this->subtotalDiscount();
    //     $result = $subtotal->multiply((string) ($this->order->tax_iva / 100));
    //     return $formatter ? $this->moneyFormatter($result) : $result;
    // }

    // public function getRetentionIva($formatter = false)
    // {
    //     $subtotal =  $subtotal = $this->subtotalDiscount();
    //     $result = $subtotal->multiply((string) ($this->order->retention_iva / 100));
    //     return $formatter ? $this->moneyFormatter($result) : $result;
    // }

    // public function getRetentionIsr($formatter = false)
    // {
    //     $subtotal =  $subtotal = $this->subtotalDiscount();
    //     $result = $subtotal->multiply((string) ($this->order->retention_isr / 100));

    //     return $formatter ? $this->moneyFormatter($result) : $result;
    // }

    // public function getDiscountProvider($formatter = false)
    // {
    //     $result = new Money($this->order->discount, new Currency($this->order->currency));
    //     return $formatter ? $this->moneyFormatter($result) : $result;
    // }
    // public function getTotal($formatter = false)
    // {
    //     $subtotal =  $subtotal = $this->subtotalDiscount();
    //     $total = $subtotal->add($this->getTaxIva());
    //     $total = $total->subtract($this->getRetentionIva(), $this->getRetentionIsr());
    //     // $test = $formatter ? $this->moneyFormatter($total) : $total;
    //     // dd($test);
    //     return $formatter ? $this->moneyFormatter($total) : $total;
    // }
    public function brickFormatter($value)
    {
        if (!$value instanceof BigDecimal) {
            $value = BigDecimal::of($value)->dividedBy(10000, 4);
            // Redondear hacia arriba a 2 decimales
            $value = $value->toScale(2, RoundingMode::CEILING);
        }

        $amount = BrickMoney::of($value->__toString(), 'MXN');
        return $amount->formatTo('es_MX'); // Salida: $100.57
        // return $value;
    }
    public function getSubtotalItems($formatter = false)
    {
        $items = $this->order->items;
        $subtotal =   0;
        foreach ($items as $item) {
            $subtotal = $subtotal + $item->sub_total;
        }
        $subtotal = BigDecimal::of($subtotal)->dividedBy(10000, 4, RoundingMode::UP);
        // Redondear hacia arriba a 2 decimales
        $subtotal = $subtotal->toScale(2, RoundingMode::CEILING);
        if ($formatter) {
            return $this->brickFormatter($subtotal);
        }
        return $subtotal;
    }

    public function subtotalDiscount($formatter = false)
    {
        $subtotal = $this->getSubtotalItems();

        $total = $subtotal->minus($this->getDiscountProvider());

        if ($formatter) {
            return $this->brickFormatter($total);
        }
        return $total;
    }

    public function getDiscountProvider($formatter = false)
    {
        $total = BigDecimal::of($this->order->discount)->dividedBy(10000, 4, RoundingMode::UP);
        // Redondear hacia arriba a 2 decimales
        $total = $total->toScale(2, RoundingMode::CEILING);
        if ($formatter) {
            return $this->brickFormatter($total);
        }
        return $total;
    }

    public function getTaxIva($formatter = false)
    {
        $subtotal = $this->subtotalDiscount();
        $iva = $this->order->tax_iva / 100;
        $result = $subtotal->multipliedBy($iva);
        $result = $result->toScale(2, RoundingMode::CEILING);

        if ($formatter) {
            return $this->brickFormatter($result);
        }
        return  $result;
    }

    public function getRetentionIva($formatter = false)
    {
        $subtotal =  $subtotal = $this->subtotalDiscount();

        $tax = $this->order->retention_iva / 100;

        $result = $subtotal->multipliedBy($tax);
        $result = $result->toScale(2, RoundingMode::CEILING);
        if ($formatter) {
            return $this->brickFormatter($result);
        }

        return  $result;
    }

    public function getRetentionIsr($formatter = false)
    {
        $subtotal =  $subtotal = $this->subtotalDiscount();
        $tax = $this->order->retention_isr / 100;

        $result = $subtotal->multipliedBy($tax);
        $result = $result->toScale(2, RoundingMode::CEILING);
        // dd($tax,$result, $this->brickFormatter($result));
        if ($formatter) {
            return $this->brickFormatter($result);
        }
        return $result;
    }

    public function getTotal($formatter = false)
    {
        $subtotal =   $this->subtotalDiscount();
        $total = $subtotal->plus($this->getTaxIva());

        $total = $total->minus($this->getRetentionIva());
        $total = $total->minus($this->getRetentionIsr());

        if ($formatter) {
            return $this->brickFormatter($total);
        }

        return  $total;
    }

    public function isOrderTotalBetweenLimits()
    {
        $minAmount = 0;
        $maxAmount = 0;
        if ($this->order->currency == 'USD') {
            // $minAmount = Money::USD(1);
            // $maxAmount = Money::USD(1500000);
            $minAmount = 1; //$1;
            $maxAmount = 15000; //$15,000
        }
        if ($this->order->currency == 'MXN') {
            $minAmount = 1; //$1;
            $maxAmount = 300000; //$300,000;
        }

        $total = $this->getTotal();

        logger($this->getTotal());

        if ($total->isGreaterThanOrEqualTo($minAmount) && $total->isLessThanOrEqualTo($maxAmount)) {
            return true;
        }
        return false;
    }
}
