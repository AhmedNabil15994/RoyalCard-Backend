<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Catalog\Entities\ProductItem;
use Modules\Order\Entities\Order;

class ChangePendingOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Order Status if not paid in 15 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $limitation = 5; // 15 minutes
        $orders = Order::where('order_status_id',3)->where('created_at','<',Carbon::now()->subMinutes($limitation))->orderBy('id','desc')->get();
        foreach ($orders as $order){
            $order->update(['order_status_id'=>2]);
            $ids = $order->orderItems()->pluck('product_item_id')->toArray();
            ProductItem::whereIn('id',$ids)->update([
                'status'    => 1,
                'reserved_at'=> null,
            ]);

            $whereArr = [
                ['result' , 'CAPTURED'],
                ['method' , 'wallet'],
            ];

            $refundWallet = $order->transactions()->where($whereArr)->sum('recharge_balance');
            $refund = 0;
            if($refundWallet){
                $refund = $refundWallet;
                $order->transactions()->where($whereArr)->delete();
                $walletObj = $order->user->getCountryWallet($order);
                if(!$walletObj){
                    $walletObj = $order->user->wallets()->create([
                        'country_id' => $order->country_id,
                        'user_id'    =>  $order->user_id,
                        'balance'    => 0,
                        'status'     => 1,
                    ]);
                }
                $walletObj->increment('balance', $refund);
            }
        }
        return true;
    }
}
