<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;

class Server extends Model
{
    use SoftDeletes,HasTranslations,ScopesTrait;
    use CrudModel;

    protected $guarded = ['id'];
    protected $table = 'servers';
    public $translatable = ['title'];



}
