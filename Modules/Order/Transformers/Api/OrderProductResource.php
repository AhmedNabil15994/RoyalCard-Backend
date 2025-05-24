<?php

namespace Modules\Order\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\Api\ProductResource;

class OrderProductResource extends JsonResource
{
    public function toArray($request)
    {
        $orderItems = $this->where([['product_id',$this->product_id],['order_id',$this->order_id]]);
        $qty = $orderItems->sum('qty');
        $codes = $orderItems->get();
        $items = [];
        foreach ($codes as $myItem){
            $items[] = [
                'code'  => $myItem->code,
                'reserved_at' => $myItem?->productItem?->reserved_at ?? null,
                'bought_at' => $myItem?->productItem?->bought_at ?? null,
            ];
        }

        return [
            'product'              => (new ProductResource($this->product))->jsonSerialize(),
            'qty'                => $qty,
            'total'              => number_format($this->total * $qty , 3),
            'order_id'           => $this->order_id,
            'codes'                 => $items,
       ];
    }
}
