<?php
namespace Modules\User\Entities;
use Modules\Area\Entities\Country;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;
use Modules\Transaction\Entities\Transaction;

class UserWallet extends Model
{
    use  ScopesTrait;

    protected $fillable = ["user_id", "country_id","balance",'status'];

    public function country()
    {
        return $this->belongsTo(Country::class, "country_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transaction');
    }
}


