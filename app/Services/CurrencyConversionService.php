<?php

namespace App\Http\Services;

use Illuminate\Support\Collection;

/**
 * CurrencyConversionService
 */
class CurrencyConversionService
{
    /**
     * 換匯
     *
     * @param string $sourceCurrency 來源幣別
     * @param string $targetCurrency ⽬標幣別
     * @param string $amount         ⾦額數字
     *
     * @return Collection
     */
    public function exchangeCurrency(string $sourceCurrency, string $targetCurrency, float $amount): Collection
    {
        $result                  = new Collection();
        $exchangeRate            = $this->getExchangeRate()['currencies'][$sourceCurrency][$targetCurrency];
        $result->exchange_amount = (float)number_format($amount * $exchangeRate, 2, '.', ',');
        $result->currency        = $targetCurrency;
        $result->exchange_rate   = $exchangeRate;

        return $result;
    }

    private function getExchangeRate(): array
    {
        $filePath = storage_path('json/exchange_rate.json');
        return json_decode(file_get_contents($filePath), true);
    }
}
