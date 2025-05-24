<?php

namespace Modules\User\Repositories\Api;

use Modules\User\Entities\Favorite;
use Modules\User\Entities\Rating;
use Modules\User\Entities\User;
use Hash;
use DB;
use Modules\User\Entities\UserWallet;

class UserRepository
{

    function __construct(User $user,Favorite $favourite,Rating $rating,UserWallet $wallet)
    {
        $this->user  = $user;
        $this->favourite = $favourite;
        $this->rating = $rating;
        $this->wallet = $wallet;
    }

    public function getAll()
    {
        return $this->user->orderBy('id','DESC')->get();
    }

    public function changePassword($request)
    {
        $user = $this->findById(auth()->id());

        if ($request['password'] == null)
            $password = $user['password'];
        else
            $password  = Hash::make($request['password']);

        DB::beginTransaction();

        try {

            $user->update([
                'password'      => $password,
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function update($request)
    {
        $user = auth()->user();

        if ($request['password'] == null)
            $password = $user['password'];
        else
            $password  = Hash::make($request['password']);

        DB::beginTransaction();

        try {

            $user->update([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
                'first_login'   => false,
                'phone_code'    => '965',
                'password'      => $password,
            ]);

            $user->refresh();
            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }


    public function userProfile()
    {
        return $this->user->where('id',auth()->id())->first();
    }

    public function findById($id)
    {
        return $this->user->find($id);
    }

    public function deleteAccount()
    {
        return $this->user->find(auth()->id());
    }

    public function findFavourite($user_id, $product_id)
    {
        return $this->favourite->where(function ($q) use ($user_id, $product_id) {
            $q->where('user_id', $user_id);
            $q->where('product_id', $product_id);
        })->first();
    }

    public function createFavourite($user_id, $product_id)
    {
        return $this->favourite->create([
            'user_id' => $user_id,
            'product_id' => $product_id,
        ]);
    }

    public function findRating($user_id,$product_id)
    {
        return $this->rating->where(function ($q) use ($user_id, $product_id) {
            $q->where('user_id', $user_id);
            $q->where('product_id', $product_id);
        })->first();
    }

    public function createRating($user_id,$product_id,$rate)
    {
        return $this->rating->create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'rate'      => $rate,
        ]);
    }

    public function findWalletById($wallet_id)
    {
        return $this->wallet->find($wallet_id);
    }
}
