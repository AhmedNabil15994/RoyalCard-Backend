<?php

namespace Modules\Catalog\Http\Controllers\Api;

use Carbon\Carbon;
use Cart;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Cart\Traits\CartTrait;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Repositories\Api\ProductRepository;
use Modules\Catalog\Transformers\Api\ProductResource;
use Modules\Coupon\Entities\Coupon;
use Modules\Offer\Entities\Offer;
use Modules\Offer\Repositories\Api\OfferRepository;
use Modules\Offer\Transformers\Api\OfferResource;
use Modules\Offer\Transformers\Api\ShowOfferResource;
use Modules\Order\Entities\OrderCoupon;

// use Modules\Coupon\Http\Requests\WebService\CouponRequest;

class ProductController extends ApiController
{
    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }
    public function index(Request $request) {
        $products = $this->product->getAll($request);
        return $this->responsePaginationWithData(ProductResource::collection($products));
    }

    public function show(Request $request,$id) {
        $product   = $this->product->getById($id);
        if(!$product){
            return $this->error(__('catalog::api.products.invalid_offer'));
        }

        $ids = [];
        foreach ($product->categories as $category){
            $data = $category->products()->where('product_id','!=',$id)->pluck('product_id')->toArray();
            $ids = array_merge($ids,$data);
        }
        $data = (new ProductResource($product))->jsonSerialize();
        return $this->response($data);
    }
}
