<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Modules\Authentication\Http\Requests\Api\ChangePasswordForMobileRequest;
use Modules\Authentication\Http\Requests\Api\ForgetPasswordForMobileRequest;
use Modules\User\Transformers\Api\UserResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Http\Requests\Api\ForgetPasswordRequest;
use Modules\Authentication\Notifications\Api\ResetPasswordNotification;
use Modules\Authentication\Repositories\Api\AuthenticationRepository as Authentication;

class ForgotPasswordController extends ApiController
{
    protected $auth;

    function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $token = $this->auth->createToken($request);
        if ($token == false) {
            return $this->error(__('authentication::api.forget_password.messages.user_not_exist'));
        }
        $token['user']->notify((new ResetPasswordNotification($token))->locale(locale()));
        return $this->response([], __('authentication::api.forget_password.messages.success'));
    }

    public function forgetPasswordForMobile(ForgetPasswordForMobileRequest $request)
    {
        $columns = [
            'calling_code' => $request->calling_code ?? '965',
            'mobile' => $request->mobile,
        ];
        $user = $this->auth->findUserByMultipleColumns($columns);
        if (is_null($user))
            return $this->error(__('authentication::api.forget_password.messages.user_not_exist'));
        else {
            $this->auth->resendCode($user);
            $newUser = $this->auth->findUserByMultipleColumns($columns); // for test
            $result['user'] = new UserResource($newUser);
            return $this->response($result, __('authentication::api.forget_password.messages.user_exist'));
        }
    }

    public function changePasswordForMobile(ChangePasswordForMobileRequest $request)
    {
        $columns = [
            'calling_code' => $request->calling_code ?? '965',
            'mobile' => $request->mobile,
        ];
        $user = $this->auth->findUserByMultipleColumns($columns);
        if (is_null($user))
            return $this->error(__('authentication::api.forget_password.messages.user_not_exist'));

        /*// check current_password
        $check = Hash::check($request->current_password, $user->password);
        if ($check == false)
            return $this->error(__('user::api.users.validation.current_password.not_match'));*/

        if ($user->code_verified != $request->code)
            return $this->error(__('authentication::api.login.validation.code_verified.not_correct'));

        $this->auth->changePasswordForMobile($request, $user);
        return $this->response(new UserResource($user));
    }
}
