<?php

namespace Modules\User\Repositories\Dashboard;

use Modules\Transaction\Entities\Transaction;
use Modules\Transaction\Repositories\Dashboard\TransactionRepository;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\RepositorySetterAndGetter;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class UserRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(User::class);
        $this->transaction = new Transaction();
        $this->statusAttribute = ['two_factor','status'];
    }


    public function userCreatedStatistics()
    {
        $data['userDate'] = $this->model
            ->doesnthave('roles')
            ->select(DB::raw("DATE_FORMAT(created_at,'%Y-%m') as date"))
            ->groupBy('date')
            ->pluck('date');

        $userCounter = $this->model
            ->doesnthave('roles')
            ->select(DB::raw('count(id) as countDate'))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $data['countDate'] = json_encode(array_pluck($userCounter, 'countDate'));

        return $data;
    }

    public function countUsers($order = 'id', $sort = 'desc')
    {
        $users = $this->model->doesnthave('roles')->count();

        return $users;
    }


    /*
    * Find Object By ID
    */
    public function findById($id)
    {
        $user = $this->model->withDeleted()->find($id);

        return $user;
    }

    /*
    * Find Object By ID
    */
    public function findByEmail($email)
    {
        $user = $this->model->where('email', $email)->first();

        return $user;
    }

    public function getSellers(){
        return $this->model->getSellers();
    }

    public function getCustomers() {
        return $this->model->doesntHave('roles.permissions')->whereHas('orders.orderStatus', fn($q) => $q->successPayment())->orderBy('id','DESC')->get();
    }
    /*
    * Generate Datatable
    */
    public function QueryTable($request)
    {
        $query = $this->model->doesntHave('roles.permissions')->where('id', '!=', auth()->id())->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('name', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function QueryWalletsTransactionsTable($request)
    {
        $query =  $this->transaction;

        $query = $query->where(function ($q) use ($request){
            $q->where(function ($q) use ($request){
                $q->where('method','wallet')->whereHas('order',function ($q2) use ($request){
                    if(isset($request['req']['user_id']) && !empty($request['req']['user_id'])){
                        $q2->where('user_id',$request['req']['user_id']);
                    }

                    if(isset($request['req']['country_id']) && !empty($request['req']['country_id'])){
                        $q2->where('country_id',$request['req']['country_id']);
                    }
                });

            })->orWhere(function ($q3) use ($request) {
                $q3->where('method','cashback')->whereHas('wallet',function ($q4) use ($request){
                    if(isset($request['req']['user_id']) && !empty($request['req']['user_id'])){
                        $q4->where('user_id',$request['req']['user_id']);
                    }

                    if(isset($request['req']['country_id']) && !empty($request['req']['country_id'])){
                        $q4->where('country_id',$request['req']['country_id']);
                    }
                });
            })->orWhere(function ($q5) use ($request){
                $q5->whereHas('wallet',function ($q6) use ($request){
                    if(isset($request['req']['user_id']) && !empty($request['req']['user_id'])){
                        $q6->where('user_id',$request['req']['user_id']);
                    }

                    if(isset($request['req']['country_id']) && !empty($request['req']['country_id'])){
                        $q6->where('country_id',$request['req']['country_id']);
                    }
                });
            });
        });

        if (isset($request['req']['from']) && $request['req']['from'] != '' && isset($request['req']['to']) && $request['req']['to'] != '') {
            $query = $query->whereDate('created_at',  '>=',$request['req']['from']." 00:00:00")->whereDate('created_at','<=',$request['req']['to']." 23:59:59");
        }

        if(isset($request['search']['value']) && !empty($request['search']['value'])){
            $query = $query->where('id',$request['search']['value']);
        }

        if(isset($request['wallet']) && !empty($request['wallet'])){
            $query = $query->where(function ($q) use ($request){
                $q->where('wallet_id',$request['wallet']);
            })->orWhere(function ($q) use ($request){
                $q->whereHas('wallet',function ($q4) use ($request){
                    $q4->where('id',$request['wallet']);
                });
            });
        }

        $query = $this->filterDataTable($query, $request);


        return $query;
    }

    public function orders($id) {
        $user = $this->model->find($id);
        if(!$user){
            abort(404);
        }
        return $user->orders()->orderBy('id','DESC')->get();
    }



    public function transactions($id) {
        $user = $this->model->find($id);
        if(!$user){
            abort(404);
        }
        return $this->transaction->whereHas('order',function ($q) use ($id) {
            $q->where('user_id',$id);
        })->orderBy('id','DESC')->get();
    }

    public function wallets($id) {
        $user = $this->model->find($id);
        if(!$user){
            abort(404);
        }
        return $user->wallets()->active()->orderBy('id','DESC')->get();
    }

    public function walletsTransactions($id) {
        $user = $this->model->find($id);
        if(!$user){
            abort(404);
        }
        return $this->transaction->where(function ($q) use($id){
            $q->where('method','wallet')->whereHas('order',function ($q) use ($id) {
                $q->where('user_id',$id);
            });
        })->orWhere(function ($q2) use ($id) {
            $q2->where('method','cashback')->whereHas('wallet',function ($q) use ($id) {
                $q->where('user_id',$id);
            });
        })->orWhere(function ($q2) use ($id) {
            $q2->whereHas('wallet',function ($q) use ($id) {
                $q->where('user_id',$id);
            });
        })->orderBy('id','DESC')->get();
    }

}
