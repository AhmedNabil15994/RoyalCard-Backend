<?php

namespace Modules\Catalog\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Transformers\Api\CategoryResource;

class ProductCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $price = $this->getPrice($request);
        $offer = $this->getOffer($request);
        $cashBack = $this->calcCashBack($request);

        return [
            'id'            => $this->id,
            'title'        => $this->title,
            'description'        => $this->description,
            'price'        =>  str_replace(',','',number_format($price[0] ?? 0,3)),
            'currency'        => $price[1] ?? '',
            'offer'        => $offer ?? null,
            'type'        => $this->product_type,
            'user_max_uses' => $this->user_max_uses,
            'qty'       =>  $this->product_type == 'support' ? null : $this->activeItems()->count(),
            'image'         => $this->getFirstMediaUrl('images'),
            'available_servers'         => $this->available_servers ? json_decode($this->available_servers) : [],
            'category'        => $this->categories()->pluck('title')->toArray(),
            'cash_back'     => $cashBack,
       ];
    }
}
