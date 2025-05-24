<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Api\RegisterRequest;
use Modules\Authentication\Repositories\Api\AuthenticationRepository as AuthenticationRepo;
use Modules\Cart\Traits\CartTrait;
use Modules\User\Transformers\Api\UserResource;

class RegisterController extends ApiController
{
    use Authentication, CartTrait;

    protected $auth;

    public function __construct(AuthenticationRepo $auth)
    {
        $this->auth = $auth;
    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $registered = $this->auth->register($request);
            $sendSms = false;
            if ($registered) {
                if (isset($request->user_token) && !is_null($request->user_token)) {
                    $this->updateCartKey($request->user_token, $registered->id);
                }
                DB::commit();
                if ($this->auth->resendCode($registered)) {
                    return $this->response([
                        "code_verified" => config("app.env") != "production" ? $registered->code_verified : null
                    ], __('authentication::api.resend.success'));
                }
                return $this->responseData($request,$registered, $sendSms);
            } else {
                return $this->error(__('authentication::api.register.messages.failed'), [], 401);
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function responseData($request,$user = null, $sms_sent = false)
    {
        $user = $user ? $user : auth()->user();
        $token = $this->generateToken($request,$user);

        return $this->response([
            'access_token' => $token->plainTextToken,
            'user' => new UserResource($user),
            'token_type' => 'Bearer',
            'expires_at' => date('Y-m-d',strtotime('+2 months'))
        ]);
    }

}
