<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetCurrencyConversionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'currency'        => $this->currency,
            'exchange_amount' => $this->exchange_amount,
            'exchange_rate'   => $this->exchange_rate
        ];
    }
}
