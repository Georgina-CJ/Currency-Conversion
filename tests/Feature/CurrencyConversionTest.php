<?php

namespace Tests\Feature;

use Tests\TestCase;

class CurrencyConversionTest extends TestCase
{
    /**
     * 測試匯率轉換
     *
     * @return void
     */
    public function testGetCurrencyConversion()
    {
        $queryAry = [
            'source_currency' => 'TWD',
            'target_currency' => 'USD',
            'amount'          => 209.95
        ];
        $response = $this->get('/api/currency_conversion?' . http_build_query($queryAry));

        $response->assertStatus(200);
    }

    /**
     * 測試匯率轉換-傳入參數錯誤
     *
     * @return void
     */
    public function testGetCurrencyConversionWithWrongRequestData()
    {
        $queryAry = [
            'source_currency' => 'GBP',
            'target_currency' => 'USD',
            'amount'          => 209.9503
        ];
        $response = $this->get('/api/currency_conversion?' . http_build_query($queryAry));

        $response->assertStatus(422);
        $response->assertJson([
            'source_currency' => ['The selected source currency is invalid.'],
            'amount'          => ['The amount format is invalid.']
        ]);
    }
}
