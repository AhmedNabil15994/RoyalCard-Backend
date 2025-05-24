<?php

namespace Modules\Area\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasTranslations;

class CurrencyCode extends Model
{
    //
    use CrudModel, HasTranslations;
    public $translatable = ['name',];

    public $table = 'currencies';
}
