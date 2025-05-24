<?php

namespace Modules\Cart\Http\Controllers\Api;

use Cart;
use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Area\Entities\Country;
use Modules\Area\Entities\CurrencyCode;
use Modules\Cart\Traits\CartTrait;
use Modules\Cart\Transformers\Api\CartResource;
use Modules\Catalog\Repositories\Api\ProductRepository;
use Modules\Catalog\Repositories\Dashboard\ServerRepository;
use Modules\Catalog\Transformers\Api\ProductCartResource;
use Modules\Catalog\Transformers\Dashboard\ServerResource;
use Modules\Category\Entities\Category;
use Modules\Coupon\Http\Controllers\Api\CouponController;
use Modules\Coupon\Http\Requests\Api\CouponRequest;
use Modules\User\Entities\User;

class CartController extends ApiController
{
    use CartTrait;

    protected $offer;

    public function __construct(ProductRepository $product,ServerRepository $server)
    {
        $this->product = $product;
        $this->server = $server;
    }

    public function index(Request $request)
    {
        if (is_null($request->user_token)) {
            return $this->error(__('apps::frontend.general.user_token_not_found'), [], 422);
        }
        return $this->response($this->responseData($request));
    }

    public function updateQty(Request $request , $productId)
    {
        $type = 'product';
        if(!isset($request['qty']) || empty($request['qty']) ){
            return $this->error(__('cart::api.products.invalid_qty'), [], 422);
        }

        $item = $this->getItem($productId, $type);
        $oldItem = $this->findItemById($item,$type);
        if (is_null($item) || is_null($oldItem)) {
            return $this->error(__('cart::api.products.not_found'), [], 422);
        }

        $item['account_id'] = $oldItem['attributes']['account_id'];
        $item['selected_server'] = $oldItem['attributes']['selected_server'];

        if(!is_null($item['qty']) && $request->qty > $item['qty'] ){
            return $this->error(__('cart::api.products.request_limit',['limit' => $item['qty']]), [], 422);
        }

        if($request->qty > $item['user_max_uses'] ){
            return $this->error(__('cart::api.products.request_limit',['limit' => $item['user_max_uses']]), [], 422);
        }

        $this->addToCart($item, $type, $request->qty ?? 1);

        return $this->response($this->responseData($request));
    }

    public function createOrUpdate(Request $request,$productId)
    {
        $type = 'product';
        $userToken = $request->user_token ?? null;
        // check if product single OR variable (variant)
        $item = $this->getItem($productId, $type);

        if (is_null($item)) {
            return $this->error(__('cart::api.products.not_found'), [], 422);
        }

        $item['account_id'] = $request->account_id;
        $item['selected_server'] = $request->selected_server;
        if(!is_null($item['qty']) && $request->qty > $item['qty'] ){
            return $this->error(__('cart::api.products.request_limit',['limit' => $item['qty']]), [], 422);
        }

        if($request->qty > $item['user_max_uses'] ){
            return $this->error(__('cart::api.products.request_limit',['limit' => $item['user_max_uses']]), [], 422);
        }
        if($item['type'] == 'support'){
            if(!isset($request['account_id']) || empty($request['account_id']) ){
                return $this->error(__('cart::api.products.invalid_account_id'), [], 422);
            }

            if(isset($request['selected_server']) && !empty($request['selected_server']) ){
                $server = $this->getItem($request['selected_server'], 'server');
                if(!$server || !in_array($item['selected_server'],$item['available_servers'])){
                    return $this->error(__('cart::api.products.invalid_server'), [], 422);
                }
            }
        }

        $this->addToCart($item, $type, $request->qty ?? 1);

        if(isset($request->replace)){
            $this->removeItem($productId, $type);
            $this->addToCart($item, $type, $request->qty ?? 1);
        }

        $couponDiscount = $this->getCondition($request, 'coupon_discount');
        if (!is_null($couponDiscount)) {
            $couponCode = $couponDiscount->getAttributes()['coupon']->code ?? null;
            $request->merge(['code' => $couponCode]);
            $couponRequest = CouponRequest::createFrom($request);
            (new CouponController())->check_coupon($couponRequest);
//            $this->applyCouponOnCart($request->user_token, $couponCode);
        }

        return $this->response($this->responseData($request));
    }

    private function  getItem($id, $type)
    {
        try {
            switch($type){
                case 'product':
                    $model = $this->product->getById($id);
                    $item = !is_null($model) ? (new ProductCartResource($model))->jsonSerialize() : null;
                    break;
                case 'server':
                    $model = $this->server->getById($id);
                    $item = !is_null($model) ? $model : null;
                    break;
            }
            return $item;
        } catch (\Throwable $th) {

        }
    }

    public function remove(Request $request,$id)
    {
        $this->removeItem(str_replace('-product','',$id), 'product');
        $items = $this->getCartContent();
        $couponDiscount = $this->getCondition($request, 'coupon_discount');
        if (!is_null($couponDiscount)) {
            $couponCode = $couponDiscount->getAttributes()['coupon']->code ?? null;
            $request->merge(['code' => $couponCode]);
            $couponRequest = CouponRequest::createFrom($request);
            (new CouponController())->check_coupon($couponRequest);
        }
        return $this->response($this->responseData($request));
    }


    public function clear(Request $request)
    {
        $this->clearCart();
        $items = $this->getCartContent();
        return $this->response([]);
    }

    public function removeCondition(Request $request, $name)
    {
        $check = $this->removeConditionByName($request, $name);
        return $this->response($this->responseData($request));
    }

    public function responseData($request)
    {
        $collections = collect($this->cartDetails($request));
        $data = $this->returnCustomResponse($request);

        $data['currency'] = CurrencyCode::whereCountryId(($request->country_id ?? ($_SERVER['HTTP_COUNTRY'] ?? setting('default_country'))))->first()?->code ?? '';
        $data['items'] = CartResource::collection($collections);
        $data['vendor'] = null;
        $data['coupon_value'] = null;
        $data['cash_back'] = $this->calcCashBack($data['items']);
        $couponDiscount = $this->getCondition($request, 'coupon_discount');
        if (!is_null($couponDiscount)) {
            if (!is_null($this->getCartItemsCouponValue($request->user_token)) && $this->getCartItemsCouponValue($request->user_token) > 0) {
                $data['coupon_value'] = number_format($this->getCartItemsCouponValue($request->user_token), 3);
            }
        }

        return $data;
    }

    protected function returnCustomResponse($request)
    {
        return [
            'conditions' => $this->getCartConditions($request),
            'subTotal' => number_format($this->cartSubTotal($request), 3),
            'total' => number_format($this->cartTotal($request), 3),
            'currency'  => '',
            'count' => $this->cartCount($request),
        ];
    }

    public function calcCashBack($items)
    {
        $country_id = $data['country_id'] ?? ($_SERVER['HTTP_COUNTRY'] ?? null) ;
        $cashback = 0;
        foreach ($items as $item) {
            $productObj = $this->product->getById($item['attributes']['product']['id']);
            $productPrice = $item['price'] * intval($item['quantity']);
            $rates = isset($productObj->cashback_rates['discount_percentage']) ? $productObj->cashback_rates : [];
            if($rates){
                $countryCashBack = floatval($rates['discount_type'][$country_id] == 'value' ?
                    $rates['discount_value'][$country_id] : (floatval( $rates['discount_percentage'][$country_id] * floatval($productPrice) / 100)));
//                if(count($productObj->start_at_dates) && $productObj->start_at_dates[$country_id] && count($productObj->expired_at_dates) && $productObj->expired_at_dates[$country_id]){
//                    if($productObj->start_at_dates[$country_id] > date('Y-m-d') || $productObj->expired_at_dates[$country_id] < date('Y-m-d')){
//                        $countryCashBack = 0;
//                    }
//                }
                $cashback += $countryCashBack;
            }
        }

        return $cashback ? (string) number_format($cashback, 3) : null;
    }
}
