<?php

namespace Modules\Cart\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use IlluminateAgnostic\Collection\Support\Carbon;
use Modules\Catalog\Entities\Product;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $mainOffer = Product::find(str_replace('-product','',$this['id']));
         return [
            'id' => $this['id'],
            'name' => $mainOffer?->title,
            'quantity'  => (int) $this['quantity'],
             'price'    =>  str_replace(',','',number_format($this['price'],3)),
            'attributes' => [
                'item_id' => $this['attributes']['item_id'],
                'account_id' => $this['attributes']['account_id'],
                'selected_server' => $this['attributes']['selected_server'],
                'offer_id' => $this['attributes']['offer_id'],
                'type' => $this['attributes']['type'],
                'image' => $this['attributes']['image'],
                'title' => $this['attributes']['product']['title']['desc'][locale()] ?? $this['attributes']['product']['title'] ,
                'category' => $this['attributes']['product']['category'],
            ],
        ];
    }
}
