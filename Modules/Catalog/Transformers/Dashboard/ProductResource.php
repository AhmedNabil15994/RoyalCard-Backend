<?php

namespace Modules\Catalog\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id'            => $this->id,
            'title'        => $this->title,
            'categories'    => $this->categories()->pluck('title')->toArray(),
            'description'        => $this->description,
            'prices'        => json_decode($this->prices),
            'qty'       =>  $this->product_type == 'support' ? null : $this->activeItems()->count(),
            'sku'        => $this->sku,
            'type'        => $this->product_type,
            'image'         => $this->getFirstMediaUrl('images'),
            'product_type'        => __('catalog::dashboard.products.form.product_type.'.$this->product_type),
            'codes'        => $this->codes,
            'status'        => $this->status,
            'deleted_at'    => $this->deleted_at,
            'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
