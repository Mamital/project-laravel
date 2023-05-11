<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class LoginRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route = Route::current();
        if($route->getName() == 'auth.customer.login-confirm')
        {
            return [
                'otp' => 'required|min:6|max:6'
            ];
        }else{
        return [
            'id' => 'required|min:11|max:64|regex:/^[a-zA-Z0-9_.@\+]*$/',
            'g-recaptcha-response' => 'recaptcha'
        ];
    }
    }

    public function attributes()
    {
        return [
            'id' => 'شماره موبایل یا ایمیل',
            'otp' => 'کد تایید'
        ];
    }
}
