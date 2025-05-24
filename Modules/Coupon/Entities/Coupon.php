<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Catalog\Entities\Product;
use Modules\Category\Entities\Category;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\ScopesTrait;
use Modules\Order\Entities\OrderCoupon;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Spatie\Translatable\HasTranslations;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Coupon extends Model
{
    use HasTranslations, SoftDeletes, ScopesTrait;
    use CrudModel;
    use SchemalessAttributesTrait;

    use HasJsonRelationships, \Modules\Core\Traits\HasTranslations {
        HasJsonRelationships::getAttributeValue as getAttributeValueJson;
        HasTranslations::getAttributeValue as getAttributeValueTranslations;
    }

    public function getAttributeValue($key)
    {
        if (!$this->isTranslatableAttribute($key)) {
            return $this->getAttributeValueJson($key);
        }
        return $this->getAttributeValueTranslations($key);
    }

    protected $with = [];
    protected $guarded = ['id'];
    public $schemalessAttributes = ['discount_type','discount_value','discount_percentage','start_at','expired_at'];
    public $translatable = ['title'];
    public $appends = ['types','values','percentages','start_at_dates','expired_at_dates'];

    public function orders()
    {
        return $this->hasMany(OrderCoupon::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'coupon_categories')->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'coupon_products')->withTimestamps();
    }

    public function getTypesAttribute()
    {
        return $this->discount_type?->all() ?? [];
    }

    public function getValuesAttribute()
    {
        return $this->discount_value?->all() ?? [];
    }

    public function getPercentagesAttribute()
    {
        return $this->discount_percentage?->all() ?? [];
    }

    public function getStartAtDatesAttribute(){
        return $this->start_at?->all() ?? [];
    }

    public function getExpiredAtDatesAttribute(){
        return $this->expired_at?->all() ?? [];
    }
}
