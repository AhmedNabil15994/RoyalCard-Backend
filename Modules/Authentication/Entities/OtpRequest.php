<?php

namespace Modules\Authentication\Entities;

use Illuminate\Database\Eloquent\Model;
use IlluminateAgnostic\Arr\Support\Carbon;
use Modules\Core\Traits\Dashboard\CrudModel;

class OtpRequest extends Model
{
    use CrudModel;
    protected $fillable = ['otp', 'mobile'];


    public function getIsExpiredAttribute()
    {
        return Carbon::now()->gte(Carbon::parse($this->updated_at)->addMinutes(5));
    }
}
