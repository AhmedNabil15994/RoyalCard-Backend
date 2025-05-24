<?php

namespace Modules\DeviceToken\Http\Controllers\Api;

use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\DeviceToken\Http\Requests\Api\FCMTokenRequest;
use Modules\Notification\Traits\SendNotificationTrait;
use Modules\User\Entities\FirebaseToken;
use Modules\User\Transformers\Api\FCMTokenResource;

class FCMTokenController extends ApiController
{
    use SendNotificationTrait;
    public function store(FCMTokenRequest $request)
    {
        $data=$request->all();
        $data['user_id'] = auth('sanctum')->id();
        $data['platform'] = strtoupper($request->device_type);
        $data['device_token'] = $data['firebase_token'];
        $firebaseToken=FirebaseToken::updateOrCreate(['device_token'=>$data['device_token']], $data);
        return $this->response(new FCMTokenResource($firebaseToken));
    }
}
