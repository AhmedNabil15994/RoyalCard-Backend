<?php

namespace Modules\Order\Repositories\Api;

use Modules\Catalog\Entities\ProductItem;
use Modules\Order\Entities\OrderItem;
use Modules\Order\Traits\OrderCalculationTrait;
use Modules\Order\Entities\OrderStatus;
use Modules\Order\Entities\Order;
use Modules\User\Entities\User;
use Carbon\Carbon;
use Auth;
use DB;

class OrderRepository
{
    use OrderCalculationTrait;

    public function __construct(Order $order, OrderStatus $status, User $user)
    {
        $this->user      = $user;
        $this->order     = $order;
        $this->status    = $status;
    }

    public function getAllByUser()
    {
        return $this->order->where('user_id', auth()->id())->get();
    }

    public function findById($id)
    {
        return $this->order->where('id', $id)->first();
    }

    public function rateOrder($request)
    {
        $order = $this->findById($request['order_id']);

        $order->rate()->updateOrCreate(
            [
            'order_id'  => $request['order_id']
        ],
            [
            'order_rate'     => $request['order_rate'],
            'service_rate'   => $request['service_rate'],
            'vendor_rate'    => $request['vendor_rate'],
            'delivery_rate'  => $request['delivery_rate'],
        ]
        );

        return true;
    }

    public function create($request, $status = true)
    {
        DB::beginTransaction();

        try {
            $data = $this->calculateTheOrder($request);

            $status = $this->statusOfOrder(3);

            $user =  $this->user->find($request['user_token']);
            if(auth('sanctum')->check()){
                $user = auth('sanctum')->user();
            }

            $coupon_data = $data['coupon'];

            $order = $this->order->create([
                'is_holding'        => false,
                'subtotal'          => $data['subtotal'],
                'discount'          => $data['discount'],
                'country_id'          => $data['country_id'],
                'total'             => $data['total'],
                'user_id'           => $user ? $user['id'] : 1,
                'order_status_id'   => $status->id,
            ]);

            if($coupon_data){
                $order->coupon()->create([
                    'coupon_id' => $coupon_data['id'],
                    'code' => $coupon_data['code'],
                    'discount_type' => $coupon_data['type'],
                    'discount_percentage' => $coupon_data['discount_percentage'],
                    'discount_value' => $coupon_data['discount_value'],
                ]);
            }else{
                $order->coupon()->delete();
            }

            $this->orderProducts($order, $data);

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function orderProducts($order, $data)
    {
        foreach ($data['order_items'] as $key => $orderItem) {
            $product = $orderItem['product'];
            $count = $orderItem['quantity'];
            $availableItems = ProductItem::where('product_id',$product->id)->where('status',1)->orderBy('status','asc')->take($count)->get();
            if($product['product_type'] != 'support' && count($availableItems) < $count){
                return false;
            }

            $price = $orderItem['total'];
            if($order->coupon){
                $price = (calcDiscount(($orderItem['total'] * $orderItem['quantity']),$order->coupon)['price_after_discount']) / $orderItem['quantity'];
            }

            if($product['product_type'] != 'support'){
                foreach ($availableItems as $availableItem){
                    $order->orderItems()->create([
                        'product_id'    => $product->id,
                        'product_item_id'    => $availableItem->id,
                        'qty'        => 1,
                        'total'        => $price,
                        'user_id'      => auth('sanctum')->id(),
                        'code'          => $availableItem->code,
                        'offer_id'     => $orderItem['offer_id'],
                    ]);

                    $availableItem->update([
                        'status'=>2,
                        'reserved_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }else{
                for ($i = 0; $i < $count; $i++) {
                    $order->orderItems()->create([
                        'product_id'    => $product->id,
                        'product_item_id'    => null,
                        'qty'        => 1,
                        'total'        => $price,
                        'user_id'      => auth('sanctum')->id(),
                        'code'          => null,
                        'account_id'    => $orderItem['account_id'],
                        'selected_server'   => $orderItem['selected_server'],
                        'offer_id'     => $orderItem['offer_id'],
                    ]);
                }
            }
        }
    }

    public function orderAddress($order, $data)
    {
        $order->address()->create([
            'floor'         => $data['address']['floor'],
            'building'      => $data['address']['building'],
            'door'          => $data['address']['door'],
            'street'        => $data['address']['street'],
            'address'       => $data['address']['address'],
            'area_id'       => $data['address']['area_id'],
            'username'      => $data['address']['username'],
            'mobile'        => $data['address']['mobile'],
            'email'         => $data['address']['email'],
        ]);
    }

    public function updateOrder($request)
    {
        $order = $this->findById($request['OrderID']);

        $status = ($request['Result'] == 'CAPTURED') ? $this->statusOfOrder(true) : $this->statusOfOrder(false);

        $order->update([
          'order_status_id' => $status['id'],
          'is_holding'      => false
        ]);

        $order->transactions()->updateOrCreate(
            [
            'transaction_id'  => $request['OrderID']
          ],
            [
            'auth'          => $request['Auth'],
            'tran_id'       => $request['TranID'],
            'result'        => $request['Result'],
            'post_date'     => $request['PostDate'],
            'ref'           => $request['Ref'],
            'track_id'      => $request['TrackID'],
            'payment_id'    => $request['PaymentID'],
        ]
        );

        return ($request['Result'] == 'CAPTURED') ? true : false;
    }

    public function statusOfOrder($type)
    {
        if ($type == 1) {
            $status = $this->status->successPayment()->first();
        }else if($type == 2){
            $status = $this->status->failedOrderStatus()->first();
        }else if ($type == 3) {
            $status = $this->status->pendingOrderStatus()->first();
        }
        return $status;
    }

    public function update($id, $boolean)
    {
        $order = $this->findById($id);

        $status = $this->statusOfOrder($boolean);

        $status =  ($status['id'] == 1 ? ($order->products()?->where('product_type','support')->count() ? 5 : 1) : $status['id']);

        $order->update([
            'is_hold' => false,
            'order_status_id' => $status,
        ]);

        if(in_array($boolean,[1,4])){
            foreach($order->products as $item ){
                if($item->product_type != 'support' && ($item->qty - 1)){
                    $item->update(['qty' => $item->qty - 1]);
                }
            }
        }

        $ids = $order->orderItems()->pluck('product_item_id')->toArray();
        ProductItem::whereIn('id',$ids)->update([
            'status'    => 3,
            'bought_at'=> date('Y-m-d H:i:s'),
        ]);

        return $order;
    }

    private function notify(OrderItem $orderItem): void
    {
        // $orderCourse->user->notify(new NewCourseEnrollmentNotification($orderItem->offer));
    }
}
