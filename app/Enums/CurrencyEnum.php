<?php

namespace App\Http\Enums;

use BenSampo\Enum\Enum;

/**
 * CurrencyEnum
 * 幣別
 * 1: 台幣
 * 2: 日幣
 * 3: 美金
 */
final class CurrencyEnum extends Enum
{
    const TWD = 1;
    const JPY = 2;
    const USD = 3;
}
