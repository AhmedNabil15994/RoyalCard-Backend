<?php

namespace Modules\Slider\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slider extends Model implements HasMedia
{
    use SoftDeletes ;
    use ScopesTrait ;
    use InteractsWithMedia;
    use HasTranslations;
    use CrudModel;

    protected $fillable = [
        'title',
        'description',
        'order',
        'type',
        'link',
        'status',
    ];
    public $translatable  = [ 'title','description' ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
