<?php

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

if (! function_exists('moneyFormatter')) {
    function moneyFormatter($value, $currency, $decimals = 4)
    {
        $localeOptions = ['MXN' => 'es_MX', 'USD' => 'en_US',];
        $locale = $localeOptions[$currency];
        // Se utiliza por ejemplo para imprimir en una vista blade, PDF
        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
        $numberFormatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $decimals); // Mínimo $decimals decimales
        $numberFormatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $decimals); // Máximo 4 decimales
        return $moneyFormatter->format($value);
    }
}
