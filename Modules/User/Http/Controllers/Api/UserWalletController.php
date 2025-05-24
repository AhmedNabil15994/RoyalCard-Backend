<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Area\Entities\Country;
use Modules\Transaction\Services\PaymentService;
use Modules\Transaction\Traits\PaymentTrait;
use Modules\User\Http\Requests\Api\UserWalletRequest;
use Modules\User\Repositories\Api\UserRepository as User;
use Modules\Apps\Http\Controllers\Api\ApiController;

class UserWalletController extends ApiController
{
    use PaymentTrait;
    function __construct(User $user,PaymentService $paymentService)
    {
        $this->user = $user;
        $this->paymentService = $paymentService;
    }

    public function chargeWallet(UserWalletRequest $request)
    {
        $user =  $this->user->findById(auth()->id());
        $balance = floatval($request->balance);
        $country_id = $request->country_id ?? ($_SERVER['HTTP_COUNTRY'] ?? setting('default_country')) ;

        $countryObj = Country::find($country_id);
        if(!$country_id || !$countryObj){
            return $this->error(__('cart::api.cart.invalid_country_id'));
        }

        $walletObj = $user->wallets()->where([['country_id', $country_id],['status',1]])->first();
        if(!$walletObj){
            $walletObj = $user->wallets()->firstOrCreate([
                'balance' => '0.000',
                'country_id' => $country_id,
            ]);
        }

        $maxRecharge = setting('recharge_max_balance')[$countryObj?->id] ?? 0;
        $maxRecharge = str_replace(',','',number_format(floatval($maxRecharge) , 3));

        $minRecharge = setting('wallet_min_balance')[$countryObj?->id] ?? 0;
        $minRecharge = str_replace(',','',number_format(floatval($minRecharge) , 3));

        $maxBalance = setting('wallet_max_balance')[$countryObj?->id] ?? 0;
        $maxBalance = str_replace(',','',number_format(floatval($maxBalance) , 3));

        if($minRecharge > $balance){
            return $this->error(__('cart::api.cart.low_balance',['country'=> $countryObj->title,'limit' => $minRecharge]));
        }

        if($maxRecharge < $balance){
            return $this->error(__('cart::api.cart.max_balance_exceed',['country'=> $countryObj->title,'limit' => $maxRecharge]));
        }

        if($maxBalance < $balance + floatval($walletObj->balance)){
            return $this->error(__('cart::api.cart.wallet_balance_exceed',['country'=> $countryObj->title,'limit' => $maxBalance]));
        }

        DB::beginTransaction();
        try {

            $order = ['id' => $walletObj->id, 'total' => $balance];
            $paymentGetaway = getPaymentGateway($countryObj->id);
            $payment = $this->getPaymentGateway($paymentGetaway);
            $redirect = $payment->send($order, 'wallets',$user->id,'wallet');

            if (isset($redirect['status'])) {
                if ($redirect['status'] == true) {
                    DB::commit();
                    return $this->response([
                        'payment_url' => $redirect['url'],
                        'wallet_id'  => $order['id'],
                    ]);
                } else {
                    return $this->error(__('cart::api.cart.invalid_payment'));
                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function successMoyasar(Request $request)
    {
        $request['wallet_id'] = decryptOrderId($request->transaction);
        $total = $request->total ;
        if ($request->message == 'APPROVED') {

            DB::beginTransaction();
            try {
                $wallet = $this->user->findWalletById($request['wallet_id']);
                if (!$wallet) {
                    return false;
                }
                $wallet->update(['status'=>1]);
                $wallet->increment('balance', $total);
                $this->paymentService->setWalletTransactions($request,$wallet,$total,'moyasar');

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

            return $this->response([], __('cart::api.cart.success_payment'));
        }
        return $this->failed($request);
    }

    public function failedMoyasar(Request $request)
    {
        return $this->error(__('cart::api.cart.failed_payment'));
    }

    public function successUpayment(Request $request)
    {
        $request['wallet_id'] = decryptOrderId($request->transaction);
        $total = $request->total ;

        if ($request->Result == 'CAPTURED') {
            DB::beginTransaction();
            try {
                $wallet = $this->user->findWalletById($request['wallet_id']);
                if (!$wallet) {
                    return false;
                }
                $wallet->update(['status'=>1]);
                $wallet->increment('balance', $total);
                $this->paymentService->setWalletTransactions($request,$wallet,$total,'upayment');

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

            return $this->response([], __('cart::api.cart.success_payment'));
        }
        return $this->failed($request);
    }
    public function failedUpayment(Request $request)
    {
        return $this->error(__('cart::api.cart.failed_payment'));
    }

    public function successMyfatoorah(Request $request)
    {
        $payment = $this->getPaymentGateway('myfatoorah');
        $response = $payment->getTransactionDetails($request['paymentId'],'PaymentId');
        if ($response['InvoiceStatus'] == 'Paid') {
            $response['wallet_id'] = $response['CustomerReference'];
            $total = $response['InvoiceValue'];

            DB::beginTransaction();
            try {
                $wallet = $this->user->findWalletById($response['wallet_id']);
                if (!$wallet) {
                    return false;
                }

                $wallet->update(['status'=>1]);
                $wallet->increment('balance', $total);
                $this->paymentService->setWalletTransactions($response,$wallet,$total,'myfatoorah');

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

            return $this->response([], __('cart::api.cart.success_payment'));
        }
        return $this->failed($request);
    }

    public function failedMyfatoorah(Request $request)
    {
        return $this->error(__('cart::api.cart.failed_payment'));
    }
}
