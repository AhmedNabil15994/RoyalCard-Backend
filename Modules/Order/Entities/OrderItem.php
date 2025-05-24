<?php

namespace Modules\Order\Entities;

use Carbon\Carbon;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\ProductItem;
use Modules\Catalog\Entities\ProductOffer;
use Modules\Catalog\Entities\Server;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'qty',
        'total',
        'product_id',
        'product_item_id',
        'order_id',
        'user_id',
        'account_id',
        'selected_server',
        'offer_id',
        'code'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function productItem()
    {
        return $this->belongsTo(ProductItem::class)->withTrashed();
    }

    public function offer()
    {
        return $this->belongsTo(ProductOffer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function server()
    {
        return $this->belongsTo(Server::class,'selected_server','id')->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    function scopeSuccessPay($q)
    {
        $q->whereHas(
            'order',
            fn ($q) => $q->whereHas(
                'orderStatus',
                fn ($q) => $q->successPayment()
            )
        );
    }
}
