<?php

namespace Modules\Order\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerSalesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'orders_sum_total'    => $this->orders_sum_total ?? [],
            'orders_count'        => $this->orders_count ?? [],
            'currency'            => $this->orders[0]?->country?->currency?->code ?? '',
       ];
    }
}
