<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Area\Entities\Country;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\ScopesTrait;

class ProductOffer extends Model
{
    use ScopesTrait;
    use CrudModel;

    protected $fillable = ['product_id','country_id', 'start_at', 'end_at', 'price', 'status', 'percentage'];

    public function scopeUnexpired($query)
    {
        return $query->where('start_at', '<=', date('Y-m-d'))->where('end_at', '>', date('Y-m-d'));
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

}
