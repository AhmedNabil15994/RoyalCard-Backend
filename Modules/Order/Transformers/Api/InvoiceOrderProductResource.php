<?php

namespace Modules\Order\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Entities\Server;
use Modules\Catalog\Transformers\Api\InvoiceProductResource;
use Modules\Catalog\Transformers\Dashboard\ServerResource;

class InvoiceOrderProductResource extends JsonResource
{
    public function toArray($request)
    {
        $orderItems = $this->where([['product_id',$this->product_id],['order_id',$this->order_id]]);
        $qty = $orderItems->sum('qty');
        $codes = $orderItems->get();
        $items = [];
        foreach ($codes as $myItem){
            if($myItem->code){
                $items[] = [
                    'code'  => $myItem->code ?? '',
                    'reserved_at' => $myItem?->productItem?->reserved_at ?? '',
                    'bought_at' => $myItem?->productItem?->bought_at ?? '',
                ];
            }
        }

        return [
            'product'              => (new InvoiceProductResource($this->product,$this->order->country_id))->jsonSerialize(),
            'qty'                => $qty,
            'total'              => number_format($this->total * $qty , 3),
            'order_id'           => $this->order_id,
            'codes'                 => $items,
            'account_id'            => $this->account_id,
            'selected_server'       => $this->server ? new ServerResource($this->server) : null,
       ];
    }
}
