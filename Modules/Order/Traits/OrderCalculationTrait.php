<?php

namespace Modules\Order\Traits;

use Modules\Area\Entities\CurrencyCode;
use Modules\Cart\Traits\CartTrait;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Transformers\Api\ProductCartResource;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Note;
use Modules\Offer\Entities\Offer;
use Modules\Package\Entities\Package;
use Modules\Package\Entities\PackagePrice;

trait OrderCalculationTrait
{
    use CartTrait;

    public function calculateTheOrder($request)
    {
        $cart = $this->getCartContent();

        $subtotal = 0.000;
        $total = 0.000;

        $coupon = null;
        $items = [];


        if (!is_null($this->getCondition($request, 'coupon_discount'))) {
            $couponCondition = $this->getCondition($request, 'coupon_discount');
            $coupon['id'] = $couponCondition->getAttributes()['coupon']->id;
            $coupon['code'] = $couponCondition->getAttributes()['coupon']->code;
            $coupon['type'] = $couponCondition->getAttributes()['coupon']->discount_type;
            $coupon['discount_value'] = $couponCondition->getAttributes()['coupon']->discount_value ?? $couponCondition->getValue();
            $coupon['discount_percentage'] = $couponCondition->getAttributes()['coupon']->discount_percentage;
        }

        foreach ($cart as $key => $item) {
            switch($item['attributes']['type']){
                case 'product':
                    $orderItems['product'] = new ProductCartResource(Product::find($item['attributes']['item_id']) ?? null);
                    $orderItems['price'] = $orderItems['product']['price'];
                    $orderItems['total'] = $item['price'];
                    $orderItems['quantity'] = $item['quantity'];
                    $orderItems['account_id'] = $item['attributes']['account_id'] ?? '';
                    $orderItems['selected_server'] = $item['attributes']['selected_server'] ?? '';
                    $orderItems['offer_id'] = $item['attributes']['offer_id'] ?? '';

                    $subtotal += $orderItems['total'] * $orderItems['quantity'];
                    $total += $orderItems['total'] * $orderItems['quantity'];
                    $items[] = $orderItems;
                    break;
            }
        }

        return [
            'subtotal' => $this->cartSubTotal(['user_token'=>$this->userToken()]),
            'total' => $this->cartTotal(['user_token'=>$this->userToken()]),
            'discount'  => isset($coupon['discount_value']) ? floatval($coupon['discount_value']) : 0,
            'coupon' => $coupon,
            'country_id'    => $request->country_id,
            'currency'  => CurrencyCode::whereCountryId($request->country_id)->first()?->code ?? '',
            'order_items' => $items,
        ];
    }
}
