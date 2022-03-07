<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Enums\CurrencyEnum;
use Illuminate\Foundation\Http\FormRequest;

class GetCurrencyConversionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'source_currency' => ['required', Rule::in(CurrencyEnum::getKeys())],
            'target_currency' => ['required', Rule::in(CurrencyEnum::getKeys())],
            'amount'          => ['required', 'numeric', 'regex:/^\d*(\.\d{1,2})?$/', 'min:0']
        ];
    }
}
