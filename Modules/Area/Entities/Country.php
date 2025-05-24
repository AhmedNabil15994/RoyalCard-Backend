<?php

namespace Modules\Area\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasTranslations;

class Country extends Model
{
    use CrudModel,SoftDeletes, HasTranslations;

    protected $fillable = ['status','title',];
    public $translatable = ['title',];

    public function currency()
    {
        return $this->hasOne(CurrencyCode::class,'country_id','id');
    }

}
