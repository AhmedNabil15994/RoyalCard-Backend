<?php

namespace Modules\Catalog\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Entities\Category;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Order\Entities\OrderItem;

class ProductItem extends Model
{

    use SoftDeletes;
    use CrudModel;

    protected $guarded = ['id'];
    protected $table = 'product_items';


    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class,'product_item_id','id');
    }
}
