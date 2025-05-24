<?php

namespace Modules\Authentication\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOTPRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'one_time_password'  => 'required|min:6',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'one_time_password.required'   =>   __('authentication::dashboard.login.validations.password.required'),
            'one_time_password.min'        =>   __('authentication::dashboard.login.validations.password.min'),
        ];

        return $v;
    }
}
