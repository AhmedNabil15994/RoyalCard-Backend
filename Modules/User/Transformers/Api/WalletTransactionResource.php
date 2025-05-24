<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
{
    public function toArray($request)
    {
        $currency =  $this->transaction?->country?->currency?->code;
        $country =  $this->transaction?->country?->title;
        $details = $this->getDetails();
        return [
            'id'            => $this->id,
            'method'        => $this->method,
            'auth'          => $this->auth,
            'tran_id'       => $this->tran_id,
            'result'        => $this->result,
            'ref'           => $this->ref,
            'track_id'      => $this->track_id,
            'payment_id'    => $this->payment_id,
            'country_id'    => $country,
            'title'             => $details['title'],
            'description'       => $details['description'],
            'wallet_id'            => $this->transaction_id,
            'currency'          => $currency,
            'user_id'              => $this->transaction?->user?->name,
            'order_id'              => $this->transaction_type == 'Modules\Order\Entities\Order' ?  __('order::dashboard.orders.show.order_id') . ' ' .$this->transaction_id : '',
            'balance'         => str_replace(',','',number_format($this->recharge_balance ?? $this->order?->total,3)) . ' ' . $currency,
            'type'          => $details['transaction_type'],
            'created_at'    => date('Y-m-d H:i:s', strtotime($this->created_at)),
       ];
    }
}
