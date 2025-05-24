<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;

use Modules\Catalog\Transformers\Api\ProductResource;
use Modules\User\Http\Requests\Api\RateProductRequest;
use Modules\User\Http\Requests\Api\StoreFavouriteRequest;
use Modules\User\Repositories\Api\UserRepository as User;

class UserRatingsController extends ApiController
{
    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function list()
    {
        $ratingsProducts = auth()->user()->userRatings()->orderBy('id','DESC')->paginate(15);
        return $this->responsePaginationWithData(ProductResource::collection($ratingsProducts));
    }

    public function rate(RateProductRequest $request)
    {
        $rating = $this->user->findRating(auth()->user()->id, $request->product_id);
        if (!$rating){
            $this->user->createRating(auth()->user()->id, $request->product_id,$request->rate);
            return $this->response([], __('user::api.ratings.index.alert.success'));
        }else{
            return $this->response([], __('user::api.ratings.index.alert.rated_before'));
        }
    }


}
