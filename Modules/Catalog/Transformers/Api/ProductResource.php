<?php

namespace Modules\Catalog\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Transformers\Api\CategoryResource;

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
        $ratings = [
            'highest'   => 0,
            'max'       => 5,
            'count'     => 0,
            'avg'       => 0,
        ];

        if(count($this->ratings)){
            $count = $this->ratings()->latest('rate')->count();
            $ratings['highest'] = $this->ratings()->latest('rate')->first()?->pivot?->rate;
            $ratings['count'] = $count;
            $ratings['avg'] = $this->ratings()->sum('rate') / $count;
        }
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
            'qty'       =>  $this->product_type == 'support' ? null : $this->activeItems()->count(),
            'is_sold_out'       =>  $this->product_type == 'support' ? false : ($this->activeItems()->count() ? false : true),
            'is_support_product'    => $this->product_type == 'support' ?? false,
            'available_servers' => $this->servers()->get(['id','title'])->toArray(),
            'image'         => $this->getFirstMediaUrl('images'),
            'is_favorite'   => $this->is_favorite ? true : false,
            'categories'        => CategoryResource::collection($this->categories()->get()->makeHidden('pivot')),
            'my_rate'       => $this?->pivot?->rate ?? auth()->user()?->userRatings()->where('product_id',$this->id)->first()?->pivot?->rate,
            'ratings'       => $ratings,
            'cash_back'     => $cashBack,
       ];
    }
}
