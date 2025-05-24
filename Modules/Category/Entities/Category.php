<?php

namespace Modules\Category\Entities;

use Illuminate\Support\Collection;
use Modules\Catalog\Entities\Product;
use Modules\User\Entities\User;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\Dashboard\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Category extends Model implements HasMedia
{
    use CrudModel, SoftDeletes, InteractsWithMedia;
    use HasJsonRelationships, HasTranslations {
        HasJsonRelationships::getAttributeValue as getAttributeValueJson;
        HasTranslations::getAttributeValue as getAttributeValueTranslations;
    }
    use SchemalessAttributesTrait;

    public function getAttributeValue($key)
    {
        if (!$this->isTranslatableAttribute($key)) {
            return $this->getAttributeValueJson($key);
        }
        return $this->getAttributeValueTranslations($key);
    }
    protected $fillable = ['status', 'type', 'category_id', 'title','color','order','start_at','expired_at','banner_size','height_ratio','width_ratio'];
    public $translatable = ['title'];
    protected $with = ['children'];
    public $schemalessAttributes = [];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'options->locale_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'category_id')->active();
    }

    public function getParentsAttribute()
    {
        $parents = collect([]);
        $parent = $this->parent;
        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }
        return $parents;
    }

    public function childrenRecursive()
    {
        return $this->children()->active()->with('childrenRecursive');
    }

    public function getAllRecursiveChildren()
    {
        $category = new Collection();
        foreach ($this->children as $cat) {
            $category->push($cat);
            $category = $category->merge($cat->getAllRecursiveChildren());
        }
        return $category;
    }

    public function scopeMainCategories($query)
    {
        return $query->where('category_id', '=', null);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, "products_categories", "category_id", "product_id")
            ->withTimestamps();
    }
}
