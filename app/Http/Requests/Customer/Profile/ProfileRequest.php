<?php

namespace App\Http\Requests\Customer\Profile;

use App\Rules\NationalCode;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $national_code = auth()->user()->national_code;
        $email = auth()->user()->email;
        return [
            'first_name' => 'sometimes|nullable',
            'last_name' => 'sometimes|nullable',
            'email' => "sometimes|nullable|unique:users,email,{$email},email|email",
            'national_code' => ["sometimes", "nullable", new NationalCode(),"unique:users,national_code,{$national_code},national_code"],
            'mobile' => 'sometimes|nullable|unique:users,mobile|min:10|max:13'
        ];
    }
}
