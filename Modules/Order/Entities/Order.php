<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use IlluminateAgnostic\Collection\Support\Carbon;
use Modules\Area\Entities\Country;
use Modules\Catalog\Entities\Product;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\ScopesTrait;
use Modules\Transaction\Entities\Transaction;

class Order extends Model
{
    use SoftDeletes ;
    use ScopesTrait;
    use CrudModel;

    protected $fillable = [
        'total',
        'unread',
        'subtotal',
        'discount',
        'user_id',
        'address_id',
        'is_holding',
        'country_id',
        'order_status_id',
        'support_status_id',
        'period',
    ];

    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderItem::class, 'order_id', 'id', 'id', 'product_id');
    }

    public function coupon()
    {
        return $this->hasOne(OrderCoupon::class, 'order_id');
    }

    public function scopeUserAccess($query, $userId, $pivot_table = 'order_courses')
    {
        return $query->where(function ($q) use($userId, $pivot_table){
            $q->where(['orders.user_id' => $userId])->whereHas('orderStatus', fn($q) => $q->successPayment());


            if(in_array($pivot_table,['order_items'])) {
                $q->orWhereHas('orderItems', function ($whereQuery) use($userId){
                    $whereQuery->where('seller_id',$userId);
                });
            }
        });
    }

    public function scopePaid($query)
    {
        return $query->where(function ($q){
            $q->whereHas('orderStatus', fn($q) => $q->successPayment());
        });
    }

    public function scopeSupport($query)
    {
        return $query->where('order_status_id',5);
    }

    public function scopePayment($query)
    {
        return $query->where('order_status_id',1);
    }


    public function transactions()
    {
        return $this->morphOne(Transaction::class, 'transaction');
    }

    public function allTransactions()
    {
        return $this->morphMany(Transaction::class, 'transaction');
    }

    public function generateQr()
    {
        if($this->country_id == 195){
            $vat = 0;
            $qr = zatca()
                ->sellerName('Royal Card')
                ->vatRegistrationNumber(setting('tax_number')[$this->country_id] ?? '')
                ->timestamp(date('Y-m-dTH:i:sZ',strtotime($this->created_at)))
                ->totalWithVat($this->total)
                ->vatTotal($vat)
                ->toQrCode(
                    qrCodeOptions()
                        ->format("svg")
                        ->size(200)
                );
            $this->qr = $qr;
        }
        return $this;
    }
}
