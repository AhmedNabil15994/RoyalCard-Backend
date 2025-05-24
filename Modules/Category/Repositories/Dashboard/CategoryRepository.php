<?php

namespace Modules\Category\Repositories\Dashboard;

use Illuminate\Http\Request;
use Modules\Category\Entities\Category;
use DB;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class CategoryRepository extends CrudRepository
{

    public function __construct()
    {
        parent::__construct(Category::class);
        $this->fileAttribute       = ['image' => 'images','banner'=>'banners','mobile_banner' => 'mobile_banners'];
    }

    public function mainCategories($order = 'order', $sort = 'desc')
    {
        $categories = $this->model->where('type',1)->mainCategories()->active()->orderBy($order, $sort)->get();
        return $categories;
    }

    public function couponCategories($order = 'order', $sort = 'desc')
    {
        $categories = $this->model->where('type',1)->active()->where(function ($q){
            $q->where(function ($q1){
                $q1->whereCategoryId(null)->doesntHave('children');
            })->orWhere('category_id','!=',null);
        })->orderBy($order, $sort)->get();
        return $categories;
    }
}
