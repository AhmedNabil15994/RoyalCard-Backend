<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;

use Modules\Catalog\Transformers\Api\ProductResource;
use Modules\User\Http\Requests\Api\StoreFavouriteRequest;
use Modules\User\Repositories\Api\UserRepository as User;

class UserFavouritesController extends ApiController
{
    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function list()
    {
        $favouritesProducts = auth()->user()->userFavorites()->isFavourite(auth()->user()->id)->orderBy('id','DESC')->paginate(15);
        return $this->responsePaginationWithData(ProductResource::collection($favouritesProducts));
    }

    public function toggleFav(StoreFavouriteRequest $request)
    {
        $favourite = $this->user->findFavourite(auth()->user()->id, $request->product_id);

        if (!$favourite){
            $check = $this->user->createFavourite(auth()->user()->id, $request->product_id);
        }else{
            $check = $favourite->delete();

            if ($check)
                return $this->response([], __('user::api.favourites.index.alert.delete'));
        }

        if ($check) {
            $data = [
                "favouritesCount" => auth()->user()->userFavorites()->count(),
            ];
            return $this->response($data, __('user::api.favourites.index.alert.success'));
        }

        return $this->error(__('user::api.favourites.index.alert.error'));
    }


}
