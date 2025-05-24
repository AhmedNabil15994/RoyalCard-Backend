<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\Transformers\Api\CompanyResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $base =  [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'mobile'        => $this->mobile,
            'calling_code'        => $this->calling_code,
            'image'         => asset($this->image_file),
            'wallet' => null
        ];

        if(count($this?->wallets)){
            $base['wallet'] =  new WalletResource($this->getCountryWallet($request));
        }

        return $base;
    }
}
