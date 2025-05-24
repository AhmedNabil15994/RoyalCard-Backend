<?php

namespace Modules\User\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Core\Traits\DataTable;
use Modules\User\Entities\UserWallet;
use Modules\User\Transformers\Api\WalletTransactionResource;

class UserController extends Controller
{
    use CrudDashboardController;
    public function show($id) {
        $model = $this->repository->findById($id);
        $userData['orders'] = $this->repository->orders($id);
//        $userData['transactions'] = $this->repository->transactions($id);
        $userData['wallets'] = $this->repository->wallets($id);
//        $userData['wallets_transactions'] = $this->repository->walletsTransactions($id);
        return view('user::dashboard.users.show',compact('model','userData'));
    }

    public function addWalletBalance(Request $request)
    {
        DB::beginTransaction();
        try {
            $wallet = UserWallet::find($request['wallet_id']);
            if (!$wallet) {
                return false;
            }
            $wallet->increment('balance', $request['balance']);
            $wallet->transactions()->create([
                'method'    => 'admin',
                'auth' => $request['Auth'] ?? '',
                'tran_id' => $request['TranID'] ?? '',
                'result' => 'CAPTURED',
                'post_date' => $request['PostDate'] ?? '',
                'ref' => $request['Ref'] ?? '',
                'track_id' => $request['TrackID'] ?? '',
                'payment_id' => $request['PaymentID'] ?? '',
                'recharge_balance'  => $request['balance']
            ]);

            DB::commit();
            return Response()->json([true, __('apps::dashboard.messages.updated')]);
        } catch (\Exception $e) {
            DB::rollback();
            return Response()->json([false, __('apps::dashboard.messages.failed')]);
        }
    }
}
