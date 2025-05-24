<?php

namespace Modules\Catalog\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Entities\Product;
use Modules\Category\Transformers\Api\CategoryResource;

class InvoiceProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public $resource;
    public $country_id;
    public function __construct($resource,$country_id)
    {
        parent::__construct($resource);
        $this->country_id = $country_id;
    }

    public function toArray($request)
    {
        $request['country_id'] = $this->country_id;
        $price = $this->getPrice($request);
        $offer = $this->getOffer($request);

        return [
            'id'            => $this->id,
            'title'        => $this->title,
            'description'        => $this->description,
            'price'        =>  str_replace(',','',number_format($price[0] ?? 0,3)),
            'currency'        => $price[1] ?? '',
            'offer'        => $offer ?? null,
            'is_support_product'    => $this->product_type == 'support' ?? false,
            'image'         => $this->getFirstMediaUrl('images'),
            'categories'        => CategoryResource::collection($this->categories()->get()->makeHidden('pivot')),
       ];
    }
}
