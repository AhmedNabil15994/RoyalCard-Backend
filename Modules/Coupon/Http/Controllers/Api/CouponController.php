<?php

namespace Modules\Coupon\Http\Controllers\Api;

use Carbon\Carbon;
use Cart;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Cart\Traits\CartTrait;
use Modules\Catalog\Entities\Product;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Http\Requests\Api\CouponRequest;

class CouponController extends ApiController
{
    use CartTrait;

    public function checkCouponOld(CouponRequest $request)
    {
        if ($this->getCartSubTotal($request->user_token) <= 0)
            return $this->error(__('coupon::api.coupons.validation.cart_is_empty'), [], 401);

        $coupon = Coupon::where('code', $request->code)->active()->first();
        if ($coupon) {
            if ($coupon->start_at > Carbon::now()->format('Y-m-d') || $coupon->expired_at < Carbon::now()->format('Y-m-d'))
                return $this->error(__('coupon::api.coupons.validation.code.expired'), [], 401);

            // Check if coupon is used before by this user
            $couponCondition = getCartConditionByName($request->user_token, 'coupon_discount');

            if (!is_null($couponCondition))
                return $this->error(__('coupon::api.coupons.validation.coupon_is_used'), [], 401);

            $discount_value = 0;
            if ($coupon->discount_type == "value")
                $discount_value = $coupon->discount_value;
            elseif ($coupon->discount_type == "percentage") {
                $discount_percentage_value = (getCartSubTotal($request->user_token) * $coupon->discount_percentage) / 100;

                if ($discount_percentage_value > $coupon->max_discount_percentage_value)
                    $discount_value = $coupon->max_discount_percentage_value;
                else
                    $discount_value = $discount_percentage_value;
            }

            // $subTotal = getCartSubTotal($request->user_token) - $discount_value;
            // Save Coupon Discount Condition
            $resultCheck = $this->discountCouponCondition($coupon, $discount_value, $request);
            if (!$resultCheck)
                return $this->error(__('coupon::api.coupons.validation.condition_error'), [], 401);

            $data = [
                'discount_value' => $discount_value,
                'subTotal' => $this->cartSubTotal($request),
                'total' => $this->cartTotal($request),
            ];
            return $this->response($data);
        } else {
            return $this->error(__('coupon::api.coupons.validation.code.not_found'), [], 401);
        }
    }

    /*
     *** Start - Check Api Coupon
     */
    public function check_coupon(CouponRequest $request)
    {
        if ($this->cartSubTotal($request) <= 0)
            return $this->error(__('coupon::api.coupons.validation.cart_is_empty'), [], 401);

        $coupon = Coupon::where('code', $request->code)->active()->first();
        $country_id =  $_SERVER['HTTP_COUNTRY'] ;
        if ($coupon) {
            if (
                (count($coupon->start_at_dates) && $coupon->start_at_dates[$country_id] && count($coupon->expired_at_dates) && $coupon->expired_at_dates[$country_id])
                &&
                ($coupon->start_at_dates[$country_id] > Carbon::now()->format('Y-m-d 00:00:00') || $coupon->expired_at_dates[$country_id] < Carbon::now()->format('Y-m-d'))
            ){
                return $this->error(__('coupon::api.coupons.validation.code.expired'), [], 401);
            }

            // Remove Old General Coupon Condition
            $this->removeConditionByName( $request,'coupon_discount');
            $userToken = $request->user_token;

            $cartItems = $this->getCartContent();

            $conditionValue = $this->addProductCouponCondition($request,$cartItems, $coupon, $userToken, []);

            if(!$conditionValue){
                return $this->error(__('coupon::api.coupons.validation.code.invalid'), [], 401);
            }

            $data = [
                'discount_value' => $conditionValue > 0 ? number_format($conditionValue, 2) : 0,
                'subTotal' => number_format($this->cartSubTotal($request), 2),
                'total' => number_format($this->cartTotal($request), 2),
            ];

            return $this->response($data);
        } else {
            return $this->error(__('coupon::api.coupons.validation.code.not_found'), [], 401);
        }
    }

    protected function getProductsList($coupon, $flag = 'products')
    {
//        $coupon_vendors = $coupon->vendors ? $coupon->vendors->pluck('id')->toArray() : [];
//        $coupon_categories = $coupon->categories ? $coupon->categories->pluck('id')->toArray() : [];
        $coupon_products = $coupon->products ? $coupon->products->pluck('id')->toArray() : [];

        $products = Product::active();
        if ($flag == 'products') {
            $products = $products->whereIn('id', $coupon_products);
        }

//        if ($flag == 'categories') {
//            $products = $products->whereHas('categories', function ($query) use ($coupon_categories) {
//                $query->whereIn('categories.id', $coupon_categories);
//            });
//        }

        return $products->pluck('id')->toArray();
    }

    private function addProductCouponCondition($request,$cartItems, $coupon, $userToken, $prdListIds = [])
    {
        $totalValue = 0;
        $couponProducts = $this->getProductsList($coupon,'products');
        $country_id =  $_SERVER['HTTP_COUNTRY'] ;
        $types=  $coupon->types ?? [];
        $values=  $coupon->values ?? [];
        $percentages=  $coupon->percentages ?? [];

        $totals = [$country_id => [
            'total' => 0,
            'products'  => [],
        ]];

        foreach ($cartItems as $cartItem) {
            if ($cartItem->attributes->type == 'product') {
                $prdId = $cartItem->attributes->product['id'];
                $cartKey = $cartItem->id;
            } else {
                $prdId = $cartItem->attributes->product->product->id;
                $cartKey = $cartItem->id;
            }

            if((in_array($prdId,$couponProducts) && $coupon->products) || !$coupon->products){
                $totals[$country_id]['products'][$prdId]= [
                    'qty'   => intval($cartItem->quantity),
                    'price' =>   $cartItem->price,
                    'total' =>   intval($cartItem->quantity) * $cartItem->price,
                    'cartKey'   => $cartKey,
                ];

                $totals[$country_id]['total']+= intval($cartItem->quantity) *  $cartItem->price;
                if (isset($coupon->types[$country_id]) && $coupon->types[$country_id] == 'value') {
                    $totalValue += $coupon->values[$country_id] ?? 0;
                } else if (isset($coupon->types[$country_id]) && $coupon->types[$country_id] == 'percentage') {
                    $totalValue += ($coupon->percentages[$country_id] ?? 0) * intval($cartItem->quantity) * $cartItem->price/ 100;
                }
            }
        }

        $productsCount = count($totals[$country_id]['products']);
        foreach($totals[$country_id]['products'] as $key => $product){
            $discount_value = 0;
            if(isset($coupon->types[$country_id]) && $coupon->types[$country_id] == 'value'){
                $discount_value+= ($coupon->values[$country_id] ?? 0) / $productsCount / $product['qty'];
            }else if(isset($coupon->types[$country_id]) && $coupon->types[$country_id] == 'percentage'){
                $discount_value+= ($coupon->percentages[$country_id] ?? 0) * $product['price'] / 100;
            }

            // Remove Old General Coupon Condition
//            $this->removeConditionByName($request, 'product_coupon');

            if($discount_value){
                $prdCoupon = new CartCondition(array(
                    'name' => 'product_coupon',
                    'type' => 'product_coupon',
                    'value' => number_format($discount_value * -1, 3),
                ));

                Cart::session($userToken)->addItemCondition($product['cartKey'],$prdCoupon);
            }
        }

        $this->saveEmptyDiscountCouponCondition((object)[
            'id'    => $coupon->id,
            'code'    => $coupon->code,
            'discount_type'    => $types[$country_id] ?? '',
            'discount_value'    => $values[$country_id] ?? '',
            'discount_percentage'    => $percentages[$country_id] ?? '',
        ], $userToken,number_format($totalValue,3)); // to use it to check coupon in order
        return number_format($totalValue,3);
    }

    /*
     *** End - Check Api Coupon
     */

}
