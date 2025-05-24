<?php

namespace Modules\Transaction\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Order\Entities\Order;
use Modules\User\Entities\UserWallet;

class Transaction extends Model
{
    use CrudModel;

    protected $fillable = [
      'auth',
      'method' ,
      'tran_id' ,
      'result' ,
      'post_date' ,
      'ref' ,
      'track_id' ,
      'payment_id' ,
      'transaction_type' ,
      'transaction_id',
      'recharge_balance',
      'wallet_id'
    ];

    public function transaction()
    {
        return $this->morphTo();
    }

    public function order()
    {
        return $this->hasOne(Order::class,'id','transaction_id');
    }

    public function wallet()
    {
        return $this->hasOne(UserWallet::class,'id','transaction_id');
    }

    public function getDetails()
    {
        $currency = $this?->transaction?->country?->currency ?? '';
        if($this->transaction_type == 'Modules\Order\Entities\Order'){
            $type = __('user::api.users.wallet.order');
            $title = __('user::api.users.wallet.withdraw_balance');
            $description = __('user::api.users.wallet.withdraw_balance_desc',['order'=>$this->transaction_id,'balance'    => ($this->method == 'wallet' ? $this->recharge_balance : $this->order?->total) . ' ' . $currency->code]);
            $transaction_type = 'out';
        }else if($this->method == 'cashback'){
            $type = __('user::api.users.wallet.cashback');
            $title = __('user::api.users.wallet.add_balance');
            $description = __('user::api.users.wallet.add_balance_desc',['balance'=>$this->recharge_balance . ' ' . $currency->code , 'type' => $type]);
            $transaction_type = 'in';
        }else{
            $type = __('user::api.users.wallet.recharge_balance');
            $title = __('user::api.users.wallet.add_balance');
            $description = __('user::api.users.wallet.add_balance_desc',['balance'=>$this->recharge_balance . ' ' . $currency->code , 'type' => $type]);
            $transaction_type = 'in';
        }

        return [
            'type'  => $type,
            'title' => $title,
            'description' => $description,
            'transaction_type'  => $transaction_type,
        ];
    }
}
