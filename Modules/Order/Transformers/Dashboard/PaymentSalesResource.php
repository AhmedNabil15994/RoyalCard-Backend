<?php

namespace Modules\Order\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Area\Entities\Country;

class PaymentSalesResource extends JsonResource
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

        $base = [
            'id'                   => $this->id,
            'title'                => $this->title,
            'type'        => $this->product_type,
            'price'       => number_format(($price[0] ?? 0) ,3),
            'categories'    => $this->categories()->pluck('title')->toArray(),
            'qty'   => 0,
            'discount'  => 0,
            'total_before_discount' => 0,
            'tax'   => 0,
            'profit'    => 0,
            'totals'    => 0,
            'currency'  => '',
        ];

        foreach (Country::whereIn('id',setting('supported_countries'))->get() as $country){
            if (collect(($request['req']['country_id'] ?? $request['country_id']) ?? setting('default_country'))->contains($country->id)){
                $arr = [ ['orders.country_id',$country->id], ];

                if(isset($request['req']['from']) && !empty($request['req']['from'])){
                    $arr[] = ['orders.created_at','>=',$request['req']['from']];
                }

                if(isset($request['req']['to']) && !empty($request['req']['to'])){
                    $arr[] = ['orders.created_at','<=',$request['req']['to']];
                }

                $base['currency'] = $country?->currency?->code;
                $base['qty']    = (int) $this->orders()->where($arr)->paid()->sum('order_items.qty') ?? 0;

                $base['total_before_discount'] = number_format($base['qty'] * $price[0],3);
                $base['total_before_discount'] = str_replace(',','',$base['total_before_discount']);

                $base['discount'] = number_format($base['total_before_discount'] - ($this->orders()->paid()->where($arr)->sum('order_items.total') ?? 0),3) ;
                $base['discount'] = str_replace(',','',$base['discount']);

                $base['tax'] = number_format((($base['total_before_discount'] - $base['discount']) * ( setting('taxes_rates')[$country->id] ?? 0 )  ) / 100,3);
                $base['tax'] = str_replace(',','',$base['tax']);

                $base['profit'] = number_format(($base['total_before_discount'] - $base['discount']) - $base['tax'],3);
                $base['profit'] = str_replace(',','',$base['profit']);

                $base['totals'] = number_format(($base['total_before_discount'] - $base['discount']),3);
                $base['totals'] = str_replace(',','',$base['totals']);
            }
        }

        return $base;
    }
}
