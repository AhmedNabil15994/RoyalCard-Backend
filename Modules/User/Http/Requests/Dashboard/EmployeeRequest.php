<?php

namespace Modules\User\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod())
        {
            // handle creates
            case 'post':
            case 'POST':

                return [
                  'roles'           => 'required',
                  'name'            => 'required',
                    'mobile'          => 'required|numeric|unique:users,mobile|digits_between:8,8',
                   'seller_id'          => 'required|numeric|exists:users,id',
                  'email'           => 'required|unique:users,email',
                  'password'        => 'required|min:6|same:confirm_password',
                    'two_factor'      => 'nullable',
                    'google_2fa'      => 'nullable',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'roles'           => 'required',
                    'name'            => 'required',
                    'mobile'          => 'required|numeric|digits_between:8,8|unique:users,mobile,'.$this->seller.'',
                    'seller_id'          => 'required|numeric|exists:users,id',
                    'email'           => 'required|unique:users,email,'.$this->seller.'',
                    'password'        => 'nullable|min:6|same:confirm_password',
                    'two_factor'      => 'nullable',
                    'google_2fa'      => 'nullable',
                  ];
        }
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
            'roles.required'          => __('user::dashboard.sellers.validation.roles.required'),
            'name.required'           => __('user::dashboard.sellers.validation.name.required'),
            'email.required'          => __('user::dashboard.sellers.validation.email.required'),
            'email.unique'            => __('user::dashboard.sellers.validation.email.unique'),
            'mobile.required'         => __('user::dashboard.sellers.validation.mobile.required'),
            'mobile.unique'           => __('user::dashboard.sellers.validation.mobile.unique'),
            'mobile.numeric'          => __('user::dashboard.sellers.validation.mobile.numeric'),
            'mobile.digits_between'   => __('user::dashboard.sellers.validation.mobile.digits_between'),
            'password.required'       => __('user::dashboard.sellers.validation.password.required'),
            'password.min'            => __('user::dashboard.sellers.validation.password.min'),
            'password.same'           => __('user::dashboard.sellers.validation.password.same'),
        ];

        return $v;
    }
}
