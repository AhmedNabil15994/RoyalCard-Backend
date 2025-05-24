<?php

namespace Modules\Cart\Traits;

use Cart;
use Darryldecode\Cart\CartCondition;
use Illuminate\Support\Str;
use Modules\Area\Entities\CurrencyCode;
use Modules\Cart\Entities\DatabaseStorageModel;
use Modules\Catalog\Entities\Product;
trait CartTrait
{
    public $authUserGuard;

    public function getCart($user_id = null)
    {
        return Cart::session($user_id ?? $this->userToken());
    }

    public function cartDetails($data)
    {
        $cart = $this->getCart($data['user_token']);
        $cartCurrency = CurrencyCode::whereCountryId(($request->country_id ?? ($_SERVER['HTTP_COUNTRY'] ?? setting('default_country'))))->first()?->code ?? '';;
        $items = [];
        foreach ($cart->getContent() as $key => $item) {
            $productCurrency = $item->attributes->product['currency'];
            $currentProduct = Product::find($item->attributes->product['id']);
            if (is_null($currentProduct) || $productCurrency != $cartCurrency) {
                $this->removeItem($item->attributes->product['id'], 'product');
            }else{
                $item['category_id']  = $currentProduct->categories()->pluck('categories.id')->toArray();
                $items[] = $item;
            }
        }
        return $items;
    }

    public function getCartConditions($request)
    {
        $cart = $this->getCart($request['user_token']);
        $res = [];
        if (count($cart->getConditions()->toArray()) > 0) {
            $i = 0;
            foreach ($cart->getConditions() as $k => $condition) {
                $res[$i]['target'] = $condition->getTarget(); // the target of which the condition was applied
                $res[$i]['name'] = $condition->getName(); // the name of the condition
                $res[$i]['type'] = $condition->getType(); // the type
                $res[$i]['value'] = $condition->getValue(); // the value of the condition
                $res[$i]['order'] = $condition->getOrder(); // the order of the condition
                $res[$i]['attributes'] = $condition->getAttributes(); // the attributes of the condition, returns an empty [] if no attributes added
                $res[$i]['attributes']['delivery_time_note'] = $condition->getAttributes()['delivery_time_note'][locale()] ?? null;

                $i++;
            }
        }
        return $res;
    }

    public function getCartContent()
    {
        return Cart::session($this->userToken())->getContent();
    }

    public function getCondition($request, $name)
    {
        $cart = $this->getCart($request['user_token']);
        $condition = $cart->getCondition($name);
        return $condition;
    }

    public function getConditionByName($userToken, $name)
    {
        $cart = $this->getCart($userToken);
        $condition = $cart->getCondition($name);
        return $condition;
    }

    public function removeConditionByName($request, $name)
    {
        $cart = $this->getCart($request['user_token']);
        if ($name == 'coupon_discount') {
            $couponCondition = $this->getConditionByName($request['user_token'], 'coupon_discount');

            if (!is_null($couponCondition)) {
                $cartIds = array_keys($this->getCartContent()->toArray() ?? []) ?? [];
                if (!empty($cartIds)) {
                    foreach ($cartIds as $id) {
                        $cart->removeItemCondition($id, 'product_coupon');
                    }
                }
            }
        }
        $cart->removeCartCondition($name);
        return true;
    }

    public function userToken()
    {

        if (request()->user_token){

            $cartKey = request()->user_token;

        }elseif (request()->user()){

            $cartKey = request()->user()->id;

        }
        else {
            if (is_null(get_cookie_value(config('core.config.constants.CART_KEY')))) {
                $cartKey = Str::random(30);
                set_cookie_value(config('core.config.constants.CART_KEY',''), $cartKey);
            } else {
                $cartKey = get_cookie_value(config('core.config.constants.CART_KEY'));
            }
            request()->merge(['user_token' => $cartKey]);
            session()->put('user_token',$cartKey);
        }

        return $cartKey;
    }

    public function addToCart($item, $type, $quantity = 1)
    {
        $inCart = $this->findItemById($item, $type);

        if (!is_null($inCart)) {
            if(!$quantity){
                $this->removeItem($item['id'],$type);
                return true;
            }
            $this->updateItemInCart($item, $type);
        }

        if($quantity){
            $this->addItemToCart($item, $type, $quantity);
        }

        return true;
    }

    public function findItemById($item, $type)
    {
        return $this->getCartContent()->get($item['id'] . '-' . $type);
    }

    public function addItemToCart($item, $type, $quantity = 1)
    {
        $cart = $this->getCart();
        $cart->add([
            'id' => $item['id'] . '-' . $type,
            'name' => $item['title'],
            'price' => doubleval(str_replace(',','',$item['offer']?->price_after_discount ?? $item['price'])),
            'quantity' => $quantity ?? 1,
            'attributes' => [
                'item_id' => $item['id'],
                'account_id' => request()->account_id,
                'selected_server' => request()->selected_server,
                'offer_id' => $item['offer']?->id ?? '',
                'type' => $type,
                'image' => isset($item['main_image']) ? url($item['main_image']) : url($item['image']),
                'product' => $item,
            ]
        ]);

        return true;
    }

    public function updateItemInCart($item, $type)
    {
        $cart = $this->getCart();
        $cart->update($item['id'] . '-' . $type, [
            'quantity' => [
                'relative' => false,
                'value' => 0,
            ]
        ]);
        return true;
    }

    public function removeItem($id, $type)
    {
        $cart = $this->getCart();
        return $cart->remove($id . '-' . $type);
    }

    public function clearCart($user_id = null)
    {
        $cart = $this->getCart($user_id);
        $cart->clear();
        $cart->clearCartConditions();
        return true;
    }

    public function cartTotal()
    {
        $cart = $this->getCart();
        return $cart->getTotal();
    }

    public function updateCartKey($userToken, $newUserId)
    {
        DatabaseStorageModel::where('id', $newUserId . '_cart_conditions')->delete();
        DatabaseStorageModel::where('id', $newUserId . '_cart_items')->delete();
        DatabaseStorageModel::where('id', $userToken . '_cart_conditions')->update(['id' => $newUserId . '_cart_conditions']);
        DatabaseStorageModel::where('id', $userToken . '_cart_items')->update(['id' => $newUserId . '_cart_items']);
        return true;
    }

    public function cartSubTotal($data)
    {
        $cart = $this->getCart($data['user_token']);
        return $cart->getSubTotal();
    }

    public function cartCount($data)
    {
        $cart = $this->getCart($data['user_token']);
        return $cart->getContent()->count();
    }

    public function saveEmptyDiscountCouponCondition($coupon, $userToken = null,$value=0)
    {
        $coupon_discount = new CartCondition([
            'name' => 'coupon_discount',
            'type' => 'coupon_discount',
            'target' => 'subTotal',
            // 'target' => 'total',
            'value' => (string) $value,
            'attributes' => [
                'coupon' => $coupon,
            ],
        ]);

        return Cart::session($userToken)->condition([$coupon_discount]);
    }

    public function getCartItemsCouponValue($userToken = null)
    {
        $value = null;
        $items = $this->getCartContent($userToken);
        if (!$items->isEmpty()) {
            foreach ($items as $item) {
                foreach ($item->getConditions() as $condition) {
                    if ($condition->getName() == 'product_coupon') {
                        $value += round(intval($item->quantity) * abs($condition->getValue()),2);
                    }
                }
            }
        }
        return $value;
    }
}
