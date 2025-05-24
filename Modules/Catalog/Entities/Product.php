<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Area\Entities\CurrencyCode;
use Modules\Category\Entities\Category;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\ScopesTrait;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderItem;
use Modules\User\Entities\User;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Modules\Core\Traits\HasTranslations;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Product extends Model  implements HasMedia
{
    use  SoftDeletes,CrudModel, ScopesTrait,InteractsWithMedia;
    use SchemalessAttributesTrait;
    use CrudModel;

    use HasJsonRelationships,HasTranslations {
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
    public $translatable = ['title','description'];
    protected $appends = ['cashback_rates'];
    public $schemalessAttributes = ['cashback_rate'];

    public function favorites()
    {
        return $this->belongsToMany(User::class, "favorites", "product_id", "user_id")
            ->withTimestamps();
    }

    public function ratings()
    {
        return $this->belongsToMany(User::class, "ratings", "product_id", "user_id")
            ->withPivot(['rate']);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, "order_items", "product_id", "order_id");
    }

    public function productCategories() {
        return $this->hasMany(ProductCategory::class,'product_id','id');
    }

    public function items() {
        return $this->hasMany(ProductItem::class,'product_id','id');
    }

    public function activeItems()
    {
        return $this->items()->whereStatus(1);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, "products_categories", "product_id", "category_id")
            ->withTimestamps();
    }

    public function scopeIsFavourite($query, $user_id)
    {
        return $query->withCount([
            "favorites as is_favorite" => function ($query) use ($user_id) {
                $query->select(\DB::raw("count(favorites.product_id) > 0 "))
                    ->whereRaw("users.id = ?", $user_id);
            }
        ]);
    }

    public function scopeIsRated($query, $user_id)
    {
        return $query->with([
            "ratings" => function ($query) use ($user_id) {
                $query->select(\DB::raw("count(ratings.product_id) > 0 "));
                if($user_id){
                    $query = $query->whereRaw("users.id = ?", $user_id);
                }
            }
        ]);
    }

    public function offers()
    {
        return $this->hasMany(ProductOffer::class, 'product_id');
    }

    public function servers()
    {
        $related = $this->hasMany(Server::class);
        $related->setQuery(
            Server::whereIn('id', $this->available_servers != null ?  json_decode($this->available_servers) : [])->getQuery()
        );
        return $related;
    }


    public function getPrice($request)
    {
        $country_id = $request->country_id ?? ($_SERVER['HTTP_COUNTRY'] ?? setting('default_country')) ;
        $code = CurrencyCode::whereCountryId($country_id)->first()?->code;
        return isset(json_decode($this->prices,true)[$country_id]) ?
            ([json_decode($this->prices,true)[$country_id] , $code]) : [0,$code];
    }

    public function getOffer($request)
    {
        $country_id = $request->country_id ?? ($_SERVER['HTTP_COUNTRY'] ?? setting('default_country')) ;
        $offer = $this->offers()->active()->Unexpired()->whereCountryId($country_id)->first();
        $dataObj = null;
        if($offer){
            $priceArr = $offer->product?->getPrice($request);
            $dataObj = new \stdClass();
            $price = 0;
            $dataObj->price_after_discount = number_format(0,3);
            if($priceArr && $priceArr[0]){
                $price= $priceArr[0];
                $dataObj->price_after_discount = number_format($price - ( $offer->price ? $offer->price : (round($price * $offer->percentage / 100,2))),3);
            }
            $dataObj->price_after_discount = str_replace(',','',$dataObj->price_after_discount);
            $dataObj->id = $offer->id;
            $dataObj->start_at = $offer->start_at;
            $dataObj->end_at = $offer->end_at;
            $dataObj->value = $offer->price ?? $offer->percentage;
            $dataObj->type  = $offer->price ? 'value' : 'percentage';
        }
        return $dataObj;
    }

    public function getCashBackRatesAttribute()
    {
        return $this->cashback_rate?->all() ?? [];
    }

    public function calcCashBack($request,$quantity=1)
    {
        $country_id = $data['country_id'] ?? ($_SERVER['HTTP_COUNTRY'] ?? null) ;
        $cashback = 0;
        $productPrice = 0;
        $price = $this->getPrice($request);
        if(count($price) && $price[0]){
            $productPrice = floatval($price[0]) * intval($quantity);
        }
        $rates = isset($this->cashback_rates['discount_percentage']) ? $this->cashback_rates : [];
        if($rates && isset($rates['discount_type'][$country_id])){
            $cashback += floatval($rates['discount_type'][$country_id] == 'value' ?
            $rates['discount_value'][$country_id] : (floatval( $rates['discount_percentage'][$country_id] * floatval($productPrice) / 100)));
        }
        return $cashback ? (string) number_format($cashback, 3) : null;
    }
}
