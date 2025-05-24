<?php

namespace Modules\Catalog\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Modules\Core\Traits\Dashboard\CrudModel;

class ProductCategory extends Model
{
    use CrudModel;

    protected $guarded = ['id'];
    protected $table = 'products_categories';


    public function category(){
       return $this->hasOne(Category::class,'id','category_id');
    }

    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }
}
