<?php

namespace Modules\User\Entities;

use Illuminate\Support\Carbon;
use Modules\Catalog\Entities\Product;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Note;
use Modules\DeviceToken\Entities\PersonalAccessToken;
use Modules\Exam\Entities\UserExam;
use Modules\Offer\Entities\Offer;
use Modules\Order\Entities\Address;
use Modules\Order\Entities\NoteOrder;
use Modules\Order\Entities\Order;
use Modules\Package\Entities\Package;
use Modules\Trainer\Entities\Trainer;
use Modules\Trainer\Entities\TrainerProfile;
use Modules\Transaction\Entities\Transaction;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Traits\ScopesTrait;
use Spatie\Permission\Traits\HasRoles;
use Modules\Order\Entities\OrderItem;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\DeviceToken\Traits\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Staudenmeir\EloquentJsonRelations\Relations\Postgres\HasOne;

class User extends Authenticatable implements HasMedia,\Tocaan\FcmFirebase\Contracts\IFcmFirebaseDevice
{
    use CrudModel{
        __construct as private CrudConstruct;
    }

    use Notifiable , HasRoles , InteractsWithMedia,HasApiTokens;
    use \Tocaan\FcmFirebase\Traits\FcmDeviceTrait;

    use SoftDeletes {
      restore as private restoreB;
    }
    protected $guard_name = 'web';
    protected $appends = ['image_file'];
    protected $dates = [
      'deleted_at'
    ];

    protected $fillable = [
        'name', 'email', 'password', 'mobile' , 'image','code_verified','verification_expire_at','calling_code','status','two_factor','google_2fa','otp_verified'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setLogAttributes(['name', 'email', 'password', 'mobile' , 'image']);

    }

    public function setImageAttribute($value)
    {
        if (!$value) {
            $this->attributes['image'] = '/uploads/users/user.png';
        }
        $this->attributes['image'] = $this->getImageFileAttribute();
    }

    public function getImageFileAttribute()
    {
        return $this->hasMedia('images') ? $this->getFirstMediaUrl('images') : '/uploads/users/user.png';
    }

      public function setPasswordAttribute($value)
    {
        if ($value === null || !is_string($value)) {
            return;
        }
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    public function restore()
    {
        $this->restoreB();
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'user_id','id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class,'user_id');
    }
    public function fcmTokens()
    {
        return $this->hasMany(FirebaseToken::class);
    }

    public function userFavorites()
    {
        return $this->belongsToMany(Product::class, "favorites", "user_id", "product_id")
            ->withTimestamps();
    }

    public function getPhone()
    {
        return $this->calling_code . $this->mobile;
    }

    public function userRatings()
    {
        return $this->belongsToMany(Product::class, "ratings", "user_id", "product_id")
            ->withPivot(['rate']);
    }

    public function tokens()
    {
        return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    }

    public function wallets()
    {
        return $this->hasMany(UserWallet::class,'user_id','id');
    }

    public function getCountryWallet($request)
    {
        $country_id = $request->country_id ?? ($_SERVER['HTTP_COUNTRY'] ?? setting('default_country')) ;
        return $this->wallets()->active()->where('country_id', $country_id)->first();
    }

    public function transactions($request)
    {
        $country_id = $request->country_id ?? ($_SERVER['HTTP_COUNTRY'] ?? setting('default_country')) ;
        $user_id = $this->id;

        $transactions = Transaction::where(function ($q) use($user_id,$country_id){
            $q->where('method','wallet')->whereHas('order',function ($q) use ($user_id,$country_id) {
                $q->where([['user_id',$user_id],['country_id',$country_id]]);
            });
        })->orWhere(function ($q2) use ($user_id,$country_id) {
            $q2->where('method','cashback')->whereHas('wallet',function ($q) use ($user_id,$country_id) {
                $q->where([['user_id',$user_id],['country_id',$country_id]]);
            });
        })->orWhere(function ($q2) use ($user_id,$country_id) {
            $q2->whereHas('wallet',function ($q) use ($user_id,$country_id) {
                $q->where([['user_id',$user_id],['country_id',$country_id]]);
            });
        })->orderBy('id','DESC')->get();

        return $transactions;
    }
}
