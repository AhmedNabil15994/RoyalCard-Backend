<?php

namespace Modules\Order\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Area\Entities\Country;
use Modules\Area\Entities\CurrencyCode;
use Modules\Cart\Traits\CartTrait;
use Illuminate\Support\Facades\Mail;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\ProductItem;
use Modules\Catalog\Repositories\Api\ProductRepository;
use Modules\Order\Entities\OrderItem;
use Modules\Order\Entities\OrderStatus;
use Modules\Order\Events\SupportOrder;
use Modules\Order\Transformers\Api\InvoiceResource;
use Modules\Order\Transformers\Api\OrderResource;
use Modules\Transaction\Services\MoyasarPaymentService;
use Modules\Transaction\Traits\PaymentTrait;
use Modules\Transaction\Services\PaymentService;
use Modules\Authentication\Foundation\Authentication;
use Modules\Order\Repositories\Api\OrderRepository as Order;
use Modules\Authentication\Repositories\Api\AuthenticationRepository;
use Modules\Transaction\Services\MyFatoorahPaymentService;
use Modules\Transaction\Services\TapPaymentService;
use Modules\User\Entities\User;


class OrderController extends ApiController
{
    use Authentication;
    use CartTrait;
    use PaymentTrait;


    public function __construct(
        public Order $order,
        public PaymentService $payment,
        public ProductRepository $product,
        public AuthenticationRepository $auth
    ){}

    public function index() {
        $orders = auth('sanctum')->user()->orders()
            ->whereHas('orderStatus', fn($q) => $q->successPayment())
            ->orderBy('id','DESC')->paginate(15);
        return $this->responsePaginationWithData(OrderResource::collection($orders));
    }

    public function show($id) {
        $orders = auth('sanctum')->user()->orders()
            ->where('id',$id)->with(['orderItems'])
            ->whereHas('orderStatus', fn($q) => $q->successPayment())->orderBy('id','DESC')->first();
        if(!$orders){
            return  $this->error(__('order::api.invalid_order'));
        }

        return $this->response(new OrderResource($orders));
    }

    public function create(Request $request)
    {
        $cart = $this->getCartContent();
        if (count($cart) > 0) {
            $cartCurrency = CurrencyCode::whereCountryId(($request->country_id ?? ($_SERVER['HTTP_COUNTRY'] ?? setting('default_country'))))->first()?->code ?? '';;
            foreach ($cart as $key => $item) {
                $productCurrency = $item->attributes->product['currency'];
                $currentProduct = Product::find($item->attributes->product['id']);
                if (is_null($currentProduct) || $productCurrency != $cartCurrency) {
                    $this->removeItem($item->attributes->product['id'], 'product');
                }
            }
            if (count($this->getCartContent()) > 0) {
                return $this->addOrder($request);
            }else{
                return $this->error(__('cart::api.cart.empty_cart'));
            }
        }
        return $this->error(__('cart::api.cart.empty_cart'));

    }

    public function addOrder($data)
    {
        $user = $data->user();
        $data['user_id'] = $user->id;
        $data['country_id'] = $data['country_id'] ?? ($_SERVER['HTTP_COUNTRY'] ?? null) ;
        $countryObj = Country::find($data['country_id']);
        if(!$data['country_id'] || !$countryObj){
            return $this->error(__('cart::api.cart.invalid_country_id'));
        }

        $paymentGetaway = getPaymentGateway($countryObj->id);
        $payment = $this->getPaymentGateway($paymentGetaway);

        $payWithWallet = isset($data['pay_with']) ? $data['pay_with'] == 'wallet' : false;
        $order =  $this->order->create($data);

        $balance = 0;
        $total = $order->total;
        $walletObj = null;
        $request = new Request();
        if($payWithWallet){
            $walletObj = auth('sanctum')->user()->getCountryWallet($countryObj);
            $balance = floatval($walletObj?->balance);

            if($balance){
                $request->merge([
                    'OrderID' => $order->id,
                    'Result'  => 'CAPTURED',
                    'PostDate' => date('Y-m-d H:i:s'),
                ]);

                if($balance >= $total){
                    $walletObj->decrement('balance', $total);
                    return  $this->success($request,'wallet',$total,$walletObj->id);
                }

                $total-= $balance;
            }
        }

        $redirect = $payment->send($order, 'orders',$data->user_token,'api',$total);

        if (isset($redirect['status'])) {
            if ($redirect['status'] == true) {
                if($balance && $walletObj){
                    $walletObj->decrement('balance', $balance);
                    $this->payment->setTransactions($request,$order,'wallet',$balance,$walletObj->id);
                }

                return $this->response([
                    'payment_ur' => $redirect['url'],
                    'order_id'  => $order->id,
                ]);
            } else {
                return $this->error(__('cart::api.cart.invalid_payment'));
            }
        }

        return $this->error('failed');
    }

    public function success(Request $request,$type=null,$total=null,$wallet_id=null)
    {
        $order = $this->order->findById($request['OrderID']);
        if (!$order) {
            return false;
        }
        $this->payment->setTransactions($request,$order,$type,$total,$wallet_id);
        $this->order->update($request['OrderID'], true);

        $this->sendNotifications($request['OrderID']);

        $this->clearCart($order->user_id ?? null);

        if($type != 'wallet'){
            $this->calcCashBack($order,$order->country);
        }

        $order = $order->generateQr();
        return $this->response([
            'order' => new OrderResource($order),
            'html'  => view('order::dashboard.orders.invoice',['order'=>$order])->render(),
        ], __('cart::api.cart.success_payment'));
    }

    public function cancel(Request $request,$id)
    {
        $id = (int) $id;
        $order = $this->order->findById($id);
        if(!$order){
            return $this->error( __('cart::api.cart.invalid_order'));
        }

        $this->clearItemReservations($order,2);

        return $this->response([], __('cart::api.cart.order_cancelled'));
    }

    public function sendNotifications($order_id)
    {
        $order = $this->order->findById($order_id);
        if (!$order) {
            return false;
        }

        try {
            if($order->order_status_id == 5){
                //Send Here
                event(new SupportOrder($order));

            }
        }catch (\Exception $e){}
    }

    public function webhooks(Request $request)
    {
        $order = $this->order->findById($request['OrderID']);
        if (!$order) {
            return false;
        }

        $this->clearItemReservations($order,2);
    }

    public function failed(Request $request)
    {
        $order = $this->order->findById($request['OrderID']);
        if (!$order) {
            return false;
        }

        $this->clearItemReservations($order,2);

        return $this->error(__('cart::api.cart.failed_payment'));
    }

    public function successUpayment(Request $request)
    {
        if ($request->Result == 'CAPTURED') {
            return $this->success($request,'upayment');
        }
        return $this->failed($request);
    }

    public function failedUpayment(Request $request)
    {
        return $this->failed($request);
    }

    public function successKnet(Request $request)
    {
        dd($request->all());
        if ($request->Result == 'CAPTURED') {
            return $this->success($request,'knet');
        }
        return $this->failed($request);
    }

    public function failedKnet(Request $request)
    {
        dd($request->all());
        return $this->failed($request);
    }

    public function successMoyasar(Request $request)
    {
        $request['OrderID'] = decryptOrderId($request->transaction);
        if ($request->message == 'APPROVED') {
            $order = $this->order->findById($request['OrderID']);
            if (!$order) {
                return false;
            }
            $this->payment->setMoyasarTransactions($request,$order);
            $this->order->update($request['OrderID'], true);
            $this->sendNotifications($request['OrderID']);
            $this->clearCart($order->user_id ?? null);
            if($request['total'] == $order->total){
                $cashback = $this->calcCashBack($order,$order->country);
            }

            $order = $order->generateQr();
            return $this->response([
                'order' => new OrderResource($order),
                'html'  => view('order::dashboard.orders.invoice',['order'=>$order])->render(),
            ], __('cart::api.cart.success_payment'));
        }

        return $this->failed($request);
    }

    public function failedMoyasar(Request $request)
    {
        $request['OrderID'] = decryptOrderId($request->transaction);
        return $this->failed($request);
    }

    public function callbackMoyasar(Request $request)
    {
        dd($request->all());

    }

    ############## Start: MyFatoorah Functions ############
    public function successMyfatoorah(Request $request)
    {
        $response = $this->getMyFatoorahTransactionDetails($request);
        if ($response['status'] == 'PAID') {
            $order = $this->order->findById($response['orderId']);
            if (!$order) {
                return false;
            }

            $total = $response['transactionsData']->TransationValue ?? '';

            $requestArr = [
                'Result' => 'paid' ?? '',
                'OrderID' => $response['orderId'],
                'Auth' => $response['transactionsData']->AuthorizationId ?? '',
                'TranID' => $response['transactionsData']->TransactionId ?? '',
                'PostDate' => $response['transactionsData']->TransactionDate ?? '',
                'Ref' => $response['transactionsData']->ReferenceId ?? '',
                'TrackID' => $response['transactionsData']->TrackId ?? '',
                'PaymentID' => $response['transactionsData']->PaymentId ?? '',
            ];

            $this->payment->setTransactions($requestArr,$order,'myfatoorah', $total ?? $order->total);
            $this->order->update($order->id, true);
            $this->sendNotifications($order->id);
            $this->clearCart($order->user_id ?? null);

            if($total == $order->total){
                $this->calcCashBack($order,$order->country);
            }

            $order = $order->generateQr();
            return $this->response([
                'order' => new OrderResource($order),
                'html'  => view('order::dashboard.orders.invoice',['order'=>$order])->render(),
            ], __('cart::api.cart.success_payment'));
        }
    }

    public function failedMyfatoorah(Request $request)
    {
        $payment = $this->getPaymentGateway('myfatoorah');
        $response = $payment->getTransactionDetails($request['paymentId'],'PaymentId');
        $request['OrderID'] = $response['CustomerReference'];
        return $this->failed($request);
    }

    private function getMyFatoorahTransactionDetails($request)
    {
        // Get transaction details
        $payment = $this->getPaymentGateway('myfatoorah');
        $response = $payment->getTransactionDetails($request['paymentId'],'PaymentId');
        $status = strtoupper($response['InvoiceStatus']);
        $orderId = $response['CustomerReference'];
        $transactionsData = $response['InvoiceTransactions'][0] ?? [];
        return [
            'status' => $status,
            'orderId' => $orderId,
            'transactionsData' => $transactionsData,
        ];
    }
    ############## End: MyFatoorah Functions ############

    public function clearItemReservations($order,$status)
    {
        $order->update(['order_status_id'=>$status]);

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

    public function invoices(Request $request) {
        $orders = auth('sanctum')->user()->orders()
            ->where(function ($q) use ($request){
                if(isset($request['search']) && !empty($request['search'])){
                    $q->where('id',(int) $request['search'] / 34567);
                }
            })
            ->whereHas('orderStatus', fn($q) => $q->successPayment())
            ->orderBy('id','DESC')->paginate(15);
        return $this->responsePaginationWithData(InvoiceResource::collection($orders));
    }

    public function showInvoice($id) {
//        34567
        $orders = auth('sanctum')->user()->orders()
            ->where('id',(int) $id / 34567)->with(['orderItems'])
            ->whereHas('orderStatus', fn($q) => $q->successPayment())->orderBy('id','DESC')->first();
        if(!$orders){
            return  $this->error(__('order::api.invalid_invoice'));
        }

        return $this->response(new InvoiceResource($orders));
    }

    public function calcCashBack($order,$countryObj)
    {
        $cashback = 0;
        $products = $order->orderItems;
        foreach($products as $item){
            $orderProductsSum = $item->total;
            $product = $item->product;
            $rates = isset($product->cashback_rates['discount_percentage']) ? $product->cashback_rates : [];
            if($rates){
                $countryCashBack = floatval($rates['discount_type'][$countryObj->id] == 'value' ?
                    $rates['discount_value'][$countryObj->id] : (floatval( $rates['discount_percentage'][$countryObj->id] * floatval($orderProductsSum) / 100)));
//                if(count($category->start_at_dates) && $category->start_at_dates[$countryObj->id] && count($category->expired_at_dates) && $category->expired_at_dates[$countryObj->id]){
//                    if($category->start_at_dates[$countryObj->id] > date('Y-m-d') || $category->expired_at_dates[$countryObj->id] < date('Y-m-d')){
//                        $countryCashBack = 0;
//                    }
//                }
                $cashback += $countryCashBack;
            }
        }

        if($cashback){
            $walletObj = $order->user->getCountryWallet($order);
            if(!$walletObj){
                $walletObj = $order->user->wallets()->firstOrCreate([
                    'country_id' => $order->country_id,
                    'user_id'    =>  $order->user_id,
                    'balance'    => 0,
                ]);
            }
            $walletObj->update(['status'=>1]);
            $walletObj->increment('balance', $cashback);
            //Create Transaction with cashback
            $walletObj->transactions()->create([
                'method'    => 'cashback',
                'auth' => $request['Auth'] ?? '',
                'tran_id' => $request['TranID'] ?? '',
                'result' => 'CAPTURED',
                'post_date' => $request['PostDate'] ?? '',
                'ref' => $request['Ref'] ?? '',
                'track_id' => $request['TrackID'] ?? '',
                'payment_id' => $request['PaymentID'] ?? '',
                'recharge_balance'  => $cashback
            ]);
        }
        return $cashback;
    }
}
