<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Enums\CurrencyEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
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
     * @param Request $request 參數驗證
     *
     * @return GetCurrencyConversionResource|JsonResponse
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
     *          description="display exchange rate and price"
     *      )
     * )
     */
    public function getCurrencyConversion(Request $request)
    {
        // TODO: 改傳入GetCurrencyConversionRequest並修正failedValidation的response
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data   = $validator->validated();
        $result = $this->service->exchangeCurrency($data['source_currency'], $data['target_currency'], $data['amount']);

        return new GetCurrencyConversionResource($result);
    }

    private function rules(): array
    {
        return [
            'source_currency' => ['required', Rule::in(CurrencyEnum::getKeys())],
            'target_currency' => ['required', Rule::in(CurrencyEnum::getKeys())],
            'amount'          => ['required', 'numeric', 'regex:/^\d*(\.\d{1,2})?$/', 'min:0']
        ];
    }
}
