<?php

namespace Modules\Order\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\ProductItem;
use Modules\Core\Traits\RepositorySetterAndGetter;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderItem;
use Modules\User\Entities\User;

class ReportRepository
{
    use RepositorySetterAndGetter;

    public function __construct(Order $order,OrderItem $orderItem, User $user , Product $product)
    {
        $this->order = $order;
        $this->orderItem = $orderItem;
        $this->user = $user;
        $this->product = $product;
    }

    public function QueryCustomers($request)
    {
        $query = $this->user->doesnthave('roles');
        $countryId = $request['req']['country_id'] ?? setting('default_country');

        if(isset($request['req']['user_id']) && !empty($request['req']['user_id'])){
            $query = $query->where('id',$request['req']['user_id']);
        }

        if (isset($request['search']['value']) && !empty($request['search']['value'])) {
            $query = $query->where(DB::raw('lower(name)'),'LIKE','%'.strtolower($request['search']['value']).'%');
        }

        $query = $query
            ->whereHas('orders',function ($q) use ($countryId,$request){
                $q->whereHas('orderStatus',fn($q) => $q->successPayment())->where('country_id',$countryId);
            })
            ->with(['orders'=> function ($q) use ($countryId,$request) {
                $q->whereHas('orderStatus',fn($q) => $q->successPayment())->where('country_id',$countryId);
            }])
//            ->whereHas('orders.orderStatus', fn($q) => $q->successPayment())
           ->withCount(['orders' => function ($q) use ($request,$countryId) {
                $q->whereHas('orderStatus',fn($q) => $q->successPayment())->where('country_id',$countryId);
            }])
            ->withSum(['orders' => function ($q) use ($request,$countryId) {
                $q->whereHas('orderStatus',fn($q) => $q->successPayment())->where('country_id',$countryId);
            }],'total');

        return $query;
    }

    public function QueryProducts($request)
    {
//        $query = $this->product->where('id',4)->with(['orders' => function ($q) use ($request) {
//            $q->with('country.currency')->whereHas('orderStatus', fn($q) => $q->successPayment())->groupBy('country_id');
//        }])->first();
//        dd($query);


        $query = $this->product;
        $countryId = $request['req']['country_id'] ?? setting('default_country');

        if(isset($request['req']['product_id']) && !empty($request['req']['product_id'])){
            $query = $query->where('id',$request['req']['product_id']);
        }

        $query = $query
            ->whereHas('orders.orderStatus', fn($q) => $q->successPayment())
            ->with(['orders.country.currency','orders.orderItems','orders' => function ($q) use ($request){
                $q->whereHas('orderStatus', fn($q) => $q->successPayment());
                if(isset($request['req']['country_id']) && !empty($request['req']['country_id'])){
                    $q->where('orders.country_id',$request['req']['country_id']);
                }

                if (isset($request['req']['from']) && $request['req']['from'] != '') {
                    $q->whereDate('orders.created_at', '>=', $request['req']['from']);
                }
            }])->groupBy('products.id');

        return $query;
    }

    public function QueryPayments($request)
    {
        $query = $this->product;
        if(isset($request['req']['product_id']) && !empty($request['req']['product_id'])){
            $query = $query->where('id',$request['req']['product_id']);
        }

        $country_id = null;

        if(isset($request['country_id']) && !empty($request['country_id'])){
            $country_id = $request['country_id'];
        }

        if(isset($request['req']['country_id']) && !empty($request['req']['country_id'])){
            $country_id = $request['req']['country_id'];
        }

        $query = $query
            ->whereHas('orders.orderStatus', fn($q) => $q->successPayment())
            ->with(['orders.country.currency','orders.orderItems','orders' => function ($q) use ($request,$country_id){
                $q->whereHas('orderStatus', fn($q) => $q->successPayment());
                if($country_id){
                    $request->country_id = $country_id;
                    $q->where('orders.country_id',$country_id);
                }

                if (isset($request['req']['from']) && $request['req']['from'] != '') {
                    $q->whereDate('orders.created_at', '>=', $request['req']['from']);
                }
            }])->groupBy('products.id');

        return $query;
    }
}

