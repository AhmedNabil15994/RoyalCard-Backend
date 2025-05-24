<?php

namespace Modules\User\Entities;

use Modules\Catalog\Entities\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasCompositePrimaryKey;

class Favorite extends Model
{
    use HasCompositePrimaryKey;

    protected $fillable = ["user_id", "product_id"];

    protected $primaryKey = ["product_id", "user_id"];


    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

}


