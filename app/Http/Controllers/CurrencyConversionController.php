<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\CurrencyConversionService;
use App\Http\Requests\GetCurrencyConversionRequest;
use App\Http\Resources\GetCurrencyConversionResource;

/**
 * @OA\Info(
 *    title="Currency Conversion",
 *    version="1.0.0",
 * )
 */
class CurrencyConversionController extends Controller
{
    /**
     * CurrencyConversionService
     *
     * @var CurrencyConversionService
     */
    private $service;

    public function __construct(
        CurrencyConversionService $service
    ) {
        $this->service = $service;
    }

    /**
     * 取得匯率轉換
     *
     * @param GetCurrencyConversionRequest $request 參數驗證
     *
     * @return GetCurrencyConversionResource
     */
    /**
     * @OA\Get(
     * path="/api/currency_conversion",
     * tags={"Currency Conversion"},
     *      @OA\Parameter(
     *          name="source_currency",
     *          in="path",
     *          required=true,
     *          description="來源幣別",
     *          @OA\Schema(
     *              type="string",
     *              enum={"TWD", "JPY", "USD"}
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="target_currency",
     *          in="path",
     *          required=true,
     *          description="⽬標幣別",
     *          @OA\Schema(
     *              type="string",
     *              enum={"TWD", "JPY", "USD"}
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="amount",
     *          in="path",
     *          required=true,
     *          description="⾦額數字",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="display exchange rate and price",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="currency",
     *                  type="string",
     *                  default="USD"
     *              ),
     *              @OA\Property(
     *                  property="exchange_amount",
     *                  type="number",
     *                  default=1.00
     *              ),
     *              @OA\Property(
     *                  property="exchange_rate",
     *                  type="number",
     *                  default=0.38
     *              )
     *         )
     *      )
     * )
     */
    public function getCurrencyConversion(GetCurrencyConversionRequest $request): GetCurrencyConversionResource
    {
        $data   = $request->validated();
        $result = $this->service->exchangeCurrency($data['source_currency'], $data['target_currency'], $data['amount']);

        return new GetCurrencyConversionResource($result);
    }
}
