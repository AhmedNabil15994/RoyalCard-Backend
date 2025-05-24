<?php

namespace Modules\User\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Transaction\Repositories\Dashboard\TransactionRepository;
use Modules\Transaction\Services\MoyasarPaymentService;
use Modules\Transaction\Services\PaymentService;
use Modules\Transaction\Traits\PaymentTrait;
use Modules\User\Repositories\Dashboard\UserRepository;
use Modules\User\Transformers\Dashboard\WalletTransactionResource;

class UserWalletController extends Controller
{
    use PaymentTrait;
    function __construct(UserRepository $user,TransactionRepository $transaction)
    {
        $this->user = $user;
        $this->transaction = $transaction;
    }

    public function index()
    {
        $clients = $this->user->getCustomers();
        return view('user::dashboard.users.wallets.transactions',compact('clients'));
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->user->QueryWalletsTransactionsTable($request));
        $datatable['data'] = WalletTransactionResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function show($id) {
        $transaction = $this->transaction->findById($id);
        $transactionDetails = null;
        if($transaction->method == 'moyasar'){
            $transactionDetails = (new MoyasarPaymentService())->getPaymentDetails($transaction['tran_id']);
            $transactionDetails = json_decode(json_encode($transactionDetails),true);
        }

        return view('user::dashboard.users.wallets.show',compact('transaction','transactionDetails'));
    }

}
