<?php

namespace Modules\Order\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Area\Entities\Country;

class ProductSalesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $base = [
            'id'                   => $this->id,
            'title'                => $this->title,
        ];

        $extra = [
            'counts'    => [],
            'totals'    => [],
        ];

        foreach (Country::whereIn('id',setting('supported_countries'))->get() as $country){
            if (collect(setting('supported_countries'))->contains($country->id)){
                $extra['counts'][$country->getTranslations('title')['en']] = $this->orders()->paid()->where('country_id',$country->id)->sum('order_items.qty') ?? 0;
                $extra['totals'][$country->getTranslations('title')['en']] = ($this->orders()->paid()->where('country_id',$country->id)->sum('order_items.total') ?? 0) . " " . $country->currency->code;
            }
        }

        return array_merge($base,$extra);
    }
}
