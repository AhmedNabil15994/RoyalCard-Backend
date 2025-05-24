<?php

namespace Modules\Catalog\Repositories\Api;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Product;
use Modules\Category\Entities\Category;

class ProductRepository
{

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAll($request){
        $query = $this->model->active();

        if(isset($request->category_id) && !empty($request->category_id)){
            $query = $query->whereHas('productCategories',function ($q) use ($request){
                $q->where('category_id',$request->category_id);
            });
        }

        $query = $query->where(function ($q) use ($request){
                if (isset($request->search) && !empty($request->search)) {
                    $q->where(DB::raw('lower(title)'),'LIKE','%'.strtolower($request->search).'%');
                }
            })
            ->when(auth('sanctum')->user(), fn($query) => $query->isFavourite(auth('sanctum')->id()));

        if(isset($request->is_favorite) && $request->is_favorite){
            $query = $query->whereHas('favorites',function ($where){
                $where->where('user_id',auth('sanctum')->id());
            });
        }

        if(isset($request->is_my_orders) && $request->is_my_orders){
            $query = $query->whereHas('orderItems',function ($where){
                $where->whereUserId(auth('sanctum')->id())
                    ->notExpired()
                    ->successPay();
            });
        }

        return $query->orderBy('order','desc')->paginate(15);
    }

    public function getById($id){
        $id = (int) $id;
        return  $this->model->active()->when(auth('sanctum')->user(), function ($query){
            $query->isFavourite(auth('sanctum')->id());
        })->find($id);
    }

    public function getByCategory($category_id,$id=null){
        return $this->model->whereIn('id',$category_id)->where('qty','>=',1)->get();
    }

    public function userProducts(){
        return $this->model
            ->when(auth('sanctum')->user(), fn ($q) => $q->subscribed(auth('sanctum')->id()))
            ->withCount('orderItems')
            ->whereHas(
                'orderItems',
                fn ($q) => $q
                    ->whereUserId(auth('sanctum')->id())
                    ->notExpired()
                    ->successPay()
            )->orderBy('order','asc')->get();
    }

}
