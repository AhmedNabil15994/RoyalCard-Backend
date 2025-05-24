<?php

namespace Modules\Order\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray($request)
    {
        $request->merge(['country_id'=>$this->country_id]);
        $method = $this->orderStatus->success_status ? $this->transactions()->whereIn('result',['paid','CAPTURED'])->first()?->method : '';
        $order = $this->generateQr();
        return [
            'id'                        => $this->id * 34567,
            'order_id'                 => $this->id,
            'user_id'           => $this->user_id,
            'subtotal'           => $this->subtotal,
            'discount'           => $this->discount,
            'country_id'        => $this->country_id,
            'country'           => $this->country?->title ?? '',
            'currency'          => $this->country?->currency?->code ?? '',
           'total'              => $this->total,
           'items'             => InvoiceOrderProductResource::collection($this->orderItems()->groupBy('product_id')->get() ?? []),
            'html'              =>  view('order::dashboard.orders.invoice',['order'=>$this])->render(),
           'order_status'       => __('order::dashboard.order_statuses.status.'.$this->orderStatus->title),
            'transaction'       => __('order::dashboard.order_statuses.payments.'.$method),
           'created_at'         => date('d-m-Y H:i A' , strtotime($this->created_at)),
       ];
    }
}
