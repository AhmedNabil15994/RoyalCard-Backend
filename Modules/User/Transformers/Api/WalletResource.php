<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'balance'         => str_replace(',','',$this->balance),
            'currency'          => $this->country->currency->code,
            'country_id'        => $this->country_id,
            'transactions'      => WalletTransactionResource::collection($this->user->transactions($request)),
       ];
    }
}
